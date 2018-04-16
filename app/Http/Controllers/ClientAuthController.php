<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Model\Base\User;
use App\Model\Base\UserAttribute;
use Illuminate\Support\Facades\Validator;

class ClientAuthController
{
    protected $homeappurl = '';
    protected $ssoappurl = 'https://sso.api.myrig.com/call';
    private $key = 'myrig-minerpanel-sso';
    private $secret = 'Dooch1vogoonaeGaihoh';
    private $loggedin = false;
    protected $notvalid = 0;

    public function __construct()
    {
        //$this->appurl = $_SERVER['SERVER_NAME'];
        $this->homeappurl = config('app.url') . 'sso-login';
       // var_dump($this->homeappurl); die;
    }

    /*
     * Prepare signature data for auth
     * @param (Array) $body
     * @return String
     */
    public function prepareSignature($body)
    {
        $query = [];
        $seq = mt_rand(0, pow(2, 12));
        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $timestamp = $now->format("Y-m-d\TH:i:s.u\Z");
        $query['seq'] = $seq;
        $query['timestamp'] = $timestamp;
        if (null !== $this->key && null !== $this->secret) {
            $i = (integer)round(pow(2, 45));
            //var_dump($i); die;
            $nonce = mt_rand(0, $i);
            $signature = hash_hmac(
                'sha256',
                $this->key . $timestamp . $seq . $nonce . json_encode($body),
                $this->secret,
                true
            );
            $query['key'] = $this->key;
            $query['nonce'] = $nonce;
            $query['signature'] = strtr(base64_encode($signature), '+/', '-_');
        }
        return $query;
    }

    /*
     * Login in panel.myrig
     * @return boolean
     */
    public function login(Request $request)
    {
        $sso_token = $request->get('ssotoken');
        $action = $request->get('action');

        if(isset($sso_token)){
            $data = array('procedure' => 'com.backend.sso.validatetoken', 'args' => array($sso_token, $this->homeappurl));

            $signed = $this->prepareSignature($data);

            $ch = curl_init();
            $url = $this->ssoappurl . "?" . http_build_query($signed);

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_POST,true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            $reply = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $reply = json_decode($reply, true);

            // check if we got a valid response from the SSO service
            if (isset($reply['args'][0]['reply']['username'])) {
                // user is valid, assume a successful login
                $this->loggedin = true;

                $data = $reply['args'][0]['reply'];
                $user = User::where('email', $data['email'])->first();
                if(!$user){
                    $userdata = array(
                        'password'       => $this->generatePassword(12), // обязательно
                        'name'      => $data['username'], // обязательно
                        'email'      => $data['email'],
                        'policy_id'            => '3', //
                    );
                    $user = User::create($userdata);
                    if($user){
                        $attributesdata = [
                            'user_id' => $user->id,
                            'fname' => $data['fname'],
                            'lname' => $data['lname']
                        ];
                        UserAttribute::create($attributesdata);
                    }
                } elseif (!$user->attributes){
                    $attributesdata = [
                        'user_id' => $user->id,
                        'fname' => $data['fname'],
                        'lname' => $data['lname']
                    ];
                    UserAttribute::create($attributesdata);
                }

                session()->put('client', $data['email']);
                return redirect('/');
            } else {
                echo "notvalid";

                /*echo("<pre>");
                print_r($reply);
                echo("</pre>");*/

                $this->notvalid = 1;
            }
        } elseif(isset($action)){
            switch ($action) {
                case "logout":
                    session()->forget('client');
                    return redirect('/');
                    break;
                case "somethingelse":
                    echo "i equals 1";
                    break;
                case "elsesomething":
                    echo "i equals 2";
                    break;
            }
        }
        $user = User::where('email', session()->get('client'))->first();
        if($user || $this->loggedin === true){
            return redirect('/profile');
        } else {
            $ssohomeappurl = urlencode($this->homeappurl);
            if (!$this->notvalid){
                return redirect()->away('https://panel.myrig.com/ssoappurl/'.$ssohomeappurl);
                //echo "Logged out, sign in <a href='https://panel.myrig.com/ssoappurl/$ssohomeappurl'>here</a>";
            }
        }
    }

    /*
     * Generate password
     * @param (Int) $length Password length
     * @param (Boolean) $special_chars Special chars in pass
     * @param (Boolean) $extra_special_chars Extra special chars in pass
     * @return string
     */
    public function generatePassword($length, $special_chars = false, $extra_special_chars = false)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        if ( $special_chars ){
            $chars .= '!@#$%^&*()';
        }
        if ( $extra_special_chars ){
            $chars .= '-_ []{}<>~`+=,.;:/?|';
        }
        $password = '';
        for ( $i = 0; $i < $length; $i++ ) {
            $password .= substr($chars, rand(0, strlen($chars) - 1), 1);
        }

        $password = bcrypt($password);
        return $password;
    }

    /*
     * Update client user attributes
     */
    public function updateClient(Request $request){
        $post = $request->post();

        $validator = Validator::make($post, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone' => 'numeric',
            'email' => 'required|email',
            'address' => 'max:255',
        ]);

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'messages' => json_encode($validator->errors()->messages())]);
        }

        $user = User::where('email', session()->get('client'))->first();
        $update = UserAttribute::where('user_id', $user->id)->update(['fname' => $post['first_name'], 'lname' => $post['last_name'], 'phone' => $post['phone'], 'address' => $post['address']]);

        if($update){
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
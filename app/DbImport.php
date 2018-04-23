<?php

namespace App;

use App\Model\Base\Context;
use Illuminate\Support\Facades\DB;
use App\Model\Base\Page;
use App\Model\Base\User;
use App\Model\Base\UserAttribute;
use App\Model\Shop\Product;
use App\Model\Shop\Order;
use App\Model\Shop\OrderDelivery;
use App\Model\Shop\Cart;

class DbImport
{
    protected $source;
    protected $actual;

    public $users;
    public $orders;
    public $news;
    public $products;
    public $articles;
    public $users_meta;

    public function __construct()
    {
        $this->source = DB::connection('sourcewp');
        $this->actual = DB::connection('mysql');
    }

    public function export()
    {
        $export = [];

        $this->users = $this->source->select('select id, user_login, user_pass, user_email, display_name from wpbit2_users where id  != 1');
        $this->users_meta = $this->source->select('select user_id, meta_key, meta_value from wpbit2_usermeta');
        //$this->users_meta = $this->source->select('select user_id, user_login, user_pass, display_name from wploc_users where id  != 1');
        $this->news = $this->source->select('select id, post_author, post_content, post_title, post_name from wpbit2_posts where post_type=:post_type', ['post_type' => 'post']);
        $this->orders = $this->source->select('select id, post_author, post_date, post_status from wpbit2_posts where post_type=:post_type', ['post_type' => 'shop_order']);
        $this->products = $this->source->select('select id, post_title, post_content, post_name from wpbit2_posts where post_type =:post_type', ['post_type' => 'product']);
        //$this->articles = $this->source->select('select id, post_author, post_date, post_content, post_title, post_name, ');

        //var_dump($this->news); die;

        $products = [];

        foreach ($this->products as $product){
            //var_dump($product); die;
            if($product->post_content != ''){
                $products[$product->id] = [
                    'id' => $product->id,
                    'context_id' => 2,
                    'vendor_id' => 1,
                    'page_id' => 0,
                    'product_status_id' => 1,
                    'title' => $product->post_title,
                    'articul' => $product->post_name,
                    'description' => $product->post_content,
                    'warranty' => '',
                    'active' => 1,
                    'auto_price' => 0,
                    'price' => 0
                ];
            }

        }
//var_dump($this->orders); die;
        $users = [];
/*        $users[1] = [
            'id' => 1,
            'policy_id' => 1,
            'name' => 'admin',
            'email' => 'admin@myrig.com',
            'password' => '$2y$10$ba4gmtzfXUnNC0JL95J5Aup/u/IIdULTz8kFvruLNoTQJnIM..zG2',
        ];
        $users[2] = [
            'id' => 2,
            'policy_id' => 2,
            'name' => 'manager',
            'email' => 'manager@myrig.com',
            'password' => '$2y$10$6uM5SSb10/D7NJUI43s4zuDOSJBC3Ymu2a9gPcnkqz1GBI1yx0Pqa',
        ];*/
        $user_attrs = [];
        $user_meta = [];
        //var_dump($this->users); die;
        foreach ($this->users as $user){
           // var_dump($user); die;
            $users[$user->id] = [
                'id' => $user->id,
                'policy_id' => 3,
                'name' => $user->user_login,
                'email' => $user->user_email,
                'password' => $user->user_pass,
                'remember_token' => ''
            ];
            $display_name = explode(' ', $user->display_name);
            $fname = $display_name[0];
            if(isset($display_name[1])){
                $lname = $display_name[1];
            } else{
                $lname = '';
            }
            //var_dump($display_name);// die;
            $user_attrs[$user->id] = [
                'user_id' => $user->id,
                'fname' => $fname,
                'lname' => $lname
            ];
//var_dump($this->users_meta); die;
/*            $user_name = '';
            $user_last_name = '';
            $user_phone = '';
            $user_email = '';
            $user_city = '';
            $user_country = '';
            $user_address = '';
            $user_state = '';
            foreach($this->users_meta as $meta){
                if($meta->user_id == $user->id){
                    switch ($meta->meta_key){
                        case 'billing_first_name':
                            $user_name = $meta->meta_value;
                            break;
                        case  'blling_last_name':
                            $user_last_name = $meta->meta_value;
                            break;
                        case 'billing_phone':
                            $user_phone = $meta->meta_value;
                            break;
                        case 'billing_email':
                            $user_email = $meta->meta_value;
                            break;
                        case 'billing_city':
                            $user_city = $meta->meta_value;
                            break;
                        case 'billing_country':
                            $user_country = $meta->meta_value;
                            break;
                        case 'billing_address_1':
                            $user_address = $meta->meta_value;
                            break;
                        case 'billing_state':
                            $user_state = $meta->meta_value;
                            break;
                    }
                    $user_meta[$user->id] = [
                        'user_id' => $user->id,
                        'fname' => $user_name,
                        'lname' => $user_last_name,
                        'phone' => $user_phone,
                        'email' => $user_email,
                        'city' => $user_city,
                        'country' => $user_country,
                        'address' => $user_address,
                        'state' => $user_state,
                    ];
                }
            }*/
        }

        $orders_items_meta = [];
        $orders_items = [];
        $order_deliveries = [];
        $orders = [];
        $order_logs = [];
        $order_statuses_count = [
            'wc-new' => 0,
            'wc-processing' => 0,
            'wc-pending' => 0,
            'wc-paid' => 0,
            'wc-on-hold' => 0,
            'wc-local' => 0,
            'wc-completed' => 0,
            'wc-refunded' => 0,
            'wc-cancelled' => 0,
            'trash' => 0
        ];
        $auto_drafts = [];

        foreach($this->orders as $order){
            $order_status = 1;

            //$order_statuses_count = []
/*            if($order->post_status == 'wc-wc-local'){
                $auto_drafts[] = $order->id;
            }
            if(!in_array($order->post_status, $order_statuses)){
                $order_statuses[$order->id] = $order->post_status;
            }*/
            $in_trash = 0;
            switch ($order->post_status){
                case 'wc-new':
                    $order_status = 1;
                    $order_statuses_count['wc-new'] += 1;
                    break;
                case 'wc-processing':
                    $order_status = 2;
                    $order_statuses_count['wc-processing'] += 1;
                    break;
                case 'wc-pending':
                    $order_status = 3;
                    $order_statuses_count['wc-pending'] += 1;
                    break;
                case 'wc-paid':
                    $order_status = 4;
                    $order_statuses_count['wc-paid'] += 1;
                    break;
                case 'wc-on-hold':
                    $order_status = 5;
                    $order_statuses_count['wc-on-hold'] += 1;
                    break;
                case 'wc-local':
                    $order_status = 6;
                    $order_statuses_count['wc-local'] += 1;
                    break;
                case 'wc-completed':
                    $order_status = 7;
                    $order_statuses_count['wc-completed'] += 1;
                    break;
                case 'wc-refunded':
                    $order_status = 8;
                    $order_statuses_count['wc-refunded'] += 1;
                    break;
                case 'wc-cancelled':
                    $order_status = 9;
                    $order_statuses_count['wc-cancelled'] += 1;
                    break;
                case 'trash':
                    $order_status = 1;
                    $order_statuses_count['trash'] += 1;
                    $in_trash = 1;
                    break;
                case 'auto-draft':
                    $order_status = 10;
                    break;
                case 'wc-local-local':
                    $order_status = 11;
                    break;
            }
            $orders[$order->id] = [
                'id' => $order->id,
                'number' => $order->id,
                'user_id' => $order->post_author,
                'cost' => 0,
                'prepayment' => 0.00,
                'status_id' => $order_status,
                'payment_type_id' => 2,
                'context_id' => 1,
                'delete' => $in_trash,
                'created_at' => $order->post_date
            ];
        }
        //var_dump($order_statuses_count); die;
        //var_dump($auto_drafts); die;
        //var_dump($order_statuses); die;
        //var_dump($orders); die;
       // $order_deliveries = [];
        foreach ($this->orders as $order){
            $delivery_id = 1;
            $delivery_cost = 0;

            $order_logs[$order->id] = $this->source->select('select * from wpbit2_comments where comment_post_ID = :comment_post_ID', ['comment_post_ID' => $order->id]);
            $orders_items[$order->id] = $this->source->select('select * from wpbit2_woocommerce_order_items where order_id = :order_id', ['order_id' => $order->id]);

            //var_dump($orders_items); die;


            /*
             * Order delivery info
             */

            $orders_meta[$order->id] = $this->source->select('select * from wpbit2_postmeta where post_id =:post_id', ['post_id' => $order->id]);
            foreach ($orders_meta as $order_meta){
                $billing_fname = '';
                $billing_lname = '';
                //$delivery_cost = 0.00;
                $billing_email = '';
                $billing_phone = '';
                $billing_country = '';
                $billing_address = '';
                $billing_state = '';
                $billing_country = '';
                $billing_city = '';
                $billing_comment = '';
                foreach ($order_meta as $meta_item){
                    switch ($meta_item->meta_key){
                        case '_billing_first_name':
                            $billing_fname = $meta_item->meta_value;
                            break;
                        case '_billing_last_name':
                            $billing_lname = $meta_item->meta_value;
                            break;
                        case '_billing_address_1':
                            $billing_address = $meta_item->meta_value;
                            break;
                        case '_billing_city':
                            $billing_city = $meta_item->meta_value;
                            break;
                        case '_billing_state':
                            $billing_state = $meta_item->meta_value;
                            break;
                        case '_billing_country':
                            $billing_country = $meta_item->meta_value;
                            break;
                        case '_billing_email':
                            $billing_email = $meta_item->meta_value;
                            break;
                        case '_billing_phone':
                            $billing_phone = $meta_item->meta_value;
                            break;
                        case '_payment_method':
                           // cod
                            //var_dump('cscdcsv'); die;
                            if($meta_item->meta_value == 'cheque'){
                               // var_dump($orders[$order->id]);// die;
                                $orders[$order->id]['payment_type_id'] = 1;
                               // var_dump($orders[$order->id]);
                                //die;
                            } else{
                                $orders[$order->id]['payment_type_id'] = 2;
                            }
                            break;
                        case '_customer_user':
                            $orders[$order->id]['user_id'] = $meta_item->meta_value;
                            break;
                    }
                }

                if($billing_country == 'UA'){
                    $orders[$order->id]['context_id'] = 2;
                } else{
                    $orders[$order->id]['context_id'] = 3;
                }

                $order_deliveries[$order->id] = [
                    'order_id' => $order->id,
                    'delivery_id' => $delivery_id,
                    'cost' => $delivery_cost,
                    'first_name' => $billing_fname,
                    'last_name' => $billing_lname,
                    'phone' => $billing_phone,
                    'email' => $billing_email,
                    'city' => $billing_city,
                    'country' => $billing_country,
                    'state' => $billing_state,
                    'address' => $billing_address,
                ];
            }
        }

       // var_dump($order_); die;
        $cart = [];
//var_dump($order_logs); die;
        foreach ($orders_items as $items){
            if (count($items) > 0){
                foreach ($items as $item){
                    $orders_items_meta[$item->order_id][$item->order_item_name] = $this->source->select('select * from wpbit2_woocommerce_order_itemmeta where order_item_id = :order_item_id', ['order_item_id' => $item->order_item_id ]);
                    //var_dump($orders_items_meta); die;
                    if($item->order_item_name != 'Shipping' && $item->order_item_name != 'Product Shipping'){
                        if($item->order_item_name == 'Новая почта'){
                            if(isset($order_deliveries[$item->order_id])){
                                $order_deliveries[$item->order_id]['delivery_id'] = 1;
                            }
                        } elseif ($item->order_item_name == 'Самовывоз'){
                            if(isset($order_deliveries[$item->order_id])) {
                                $order_deliveries[$item->order_id]['delivery_id'] = 3;
                            }
                        } elseif($item->order_item_name == 'Деловые линии' || $item->order_item_name == 'СДЭК'){
                            if(isset($order_deliveries[$item->order_id])){
                                $order_deliveries[$item->order_id]['delivery_id'] = 1;
                            }
                        }
                        $item_count = 1;
                        $item_total_cost = 0;


                        foreach ($orders_items_meta[$item->order_id][$item->order_item_name] as $meta){
                            //var_dump(); die;
                            if($meta->meta_key == '_line_subtotal'){
                                $item_total_cost = $meta->meta_value;
                            } elseif ($meta->meta_key == '_qty'){
                                $item_count = $meta->meta_value;
                            } elseif($meta->meta_key == '_product_id'){
                                $item_product_id = $meta->meta_value;
                            }
                        }
                        $cost = $item_total_cost / $item_count;
                        $cart[] = [
                            'order_id' => $item->order_id,
                            'product_id' => $item_product_id,
                            'cost' => $cost,
                            'count' => $item_count
                        ];
                    }
                }

            }
        }
        //var_dump($orders_items_meta); die;
//var_dump($cart); die;
        foreach($cart as $key => $line){
            if($line['cost'] == 0){
                unset($cart[$key]);
                continue;
            }

            if (isset($line['order_id'])){
                if(isset($orders[$line['order_id']])){
                    $line_cost = $line['cost'] * $line['count'];
                    $orders[$line['order_id']]['cost'] += (int)$line_cost;
                    if($orders[$line['order_id']]['cost'] < 0 || $orders[$line['order_id']]['cost'] > 999999){
                        unset($orders[$line['order_id']]);
                    }
                }
            } else{
                unset($cart[$key]);
            }
        }
//var_dump($cart); die;
/*        foreach ($cart as $key => $line){
            $isset = false;
            foreach ($orders as $order){
                if($line['order_id'] == $order['id']){
                    $isset = true;
                }
            }
            if(!$isset){
                unset($cart[$key]);
            }
        }

        foreach ($cart as $key => $line){
            $isset = false;
            foreach ($products as $product){
                if($line['product_id'] == $product['id']){
                    $isset = true;
                }
            }
            if(!$isset){
                unset($cart[$key]);
            }
        }*/

        foreach ($user_attrs as $key => $attr){
            $isset = false;
            foreach ($users as $user){
                if($attr['user_id'] == $user['id']){
                    $isset = true;
                }
            }
            if(!$isset){
                unset($user_attrs[$key]);
            }
        }

        foreach ($orders as $key => $order){
            if($order['status_id'] == 10 || $order['status_id'] == 11){
                unset($orders[$key]);
            }
        }

        $export['products'] = $products;
        $export['orders'] = $orders;
        $export['carts'] = $cart;
        $export['users'] = $users;
        $export['user_attrs'] = $user_attrs;
        $export['orders_deliveries'] = $order_deliveries;
        //var_dump($export['users']); die;
        return $export;
    }

    public function import($data)
    {
        /*
         * Import users
         */
        foreach ($data['users'] as $user_item){
            try {
                $user = new User();
                $user->id = $user_item['id'];
                $user->policy_id = $user_item['policy_id'];
                $user->name = $user_item['name'];
                $user->email = $user_item['email'];
                $user->password = $user_item['password'];
               // $user->fill($user_item);
                $user->save();
                //User::create($user);
            } catch (\Exception $e){
                continue;
            }
        }

        /*
         * Import User attributes
         */
        foreach ($data['user_attrs'] as $attr){
            try{
                UserAttribute::create($attr);
            } catch (\Exception $e){
                continue;
            }

        }
//die;
        /*
         * Import products
         */
        foreach ($data['products'] as $product){
            $contexts = Context::where('title', 'UA')->orWhere('title', 'RU')->get();
//var_dump($contexts); die;
            foreach ($contexts as $context){
                //try{
                $parent_page = Page::where('context_id', $context->id)->where('link', 'shop')->first();

                    $page = Page::create([
                        'parent_id' => $parent_page->id,
                        'context_id' => $context->id,
                        'view_id' => 5,
                        'link' => 'product/' . $product['articul'],
                        'title' => $product['title'],
                        'description' => '',
                    ]);
                    $page = Page::where('context_id', $context->id)->where('link', 'product/' . $product['articul'])->first();
                try{
                    $product['page_id'] = $page->id;
                    $product['context_id'] = $context->id;
                    //var_dump($product); die;
                    Product::create($product);
                } catch (\Exception $e){
                    continue;
                }
            }


        }

        /*
         * Import orders
         */
        foreach ($data['orders'] as $order){
            try{
                Order::create($order);
            } catch (\Exception $e){
                continue;
            }

        }

        /*
         * Import orders deliveries
         */
        foreach ($data['orders_deliveries'] as $delivery){
            try{
                OrderDelivery::create($delivery);
            } catch (\Exception $e){
                continue;
            }
        }

        /*
         * Import carts
         */
        foreach ($data['carts'] as $cart){
            try{
                Cart::create($cart);
            } catch (\Exception $e){
                continue;
            }

        }
    }

    public function process()
    {
        $data = $this->export();

        $this->import($data);
    }
}
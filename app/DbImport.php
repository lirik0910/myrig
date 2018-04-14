<?php

namespace App;

use Illuminate\Support\Facades\DB;
use App\Model\Base\User;
use App\Model\Base\UserAttribute;
use App\Model\Shop\Product;
use App\Model\Shop\Order;
use App\Model\Shop\Cart;

class DbImport
{
    protected $source;
    protected $actual;

    public $users;
    public $orders;
    public $news;
    public $products;

    public function __construct()
    {
        $this->source = DB::connection('sourcewp');
        $this->actual = DB::connection('mysql');
    }

    public function export()
    {
        $export = [];

        $this->users = $this->source->select('select id, user_login, user_pass, user_email, display_name from wploc_users where id  != 1');
        //$this->users_meta = $this->source->select('select user_id, user_login, user_pass, display_name from wploc_users where id  != 1');
        //$this->news = $this->source->select('select * from wploc_posts where post_type=:post_type', ['post_type' => '']);
        $this->orders = $this->source->select('select id, post_author, post_date from wploc_posts where post_type=:post_type', ['post_type' => 'shop_order']);
        $this->products = $this->source->select('select id, post_title,post_content, post_name from wploc_posts where post_type =:post_type', ['post_type' => 'product']);

        //var_dump($this->news); die;

        $products = [];

        foreach ($this->products as $product){
            //var_dump($product); die;
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

        $users = [];
        $user_attrs = [];
        //var_dump($this->users); die;
        foreach ($this->users as $user){
           // var_dump($user); die;
            $users[$user->id] = [
                'id' => $user->id,
                'policy_id' => 3,
                'name' => $user->user_login,
                'email' => $user->user_email,
                'password' => $user->user_pass,
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
        }
        //die;

        //var_dump($user_attrs); die;
        //var_dump($products); die;

        $orders_items_meta = [];
        $orders_items = [];

        $orders = [];
        foreach ($this->orders as $order){
            $orders_items[] = $this->source->select('select * from wploc_woocommerce_order_items where order_id = :order_id', ['order_id' => $order->id]);
            $orders[$order->id] = [
                'id' => $order->id,
                'number' => $order->id,
                'user_id' => $order->post_author,
                'cost' => 0,
                'prepayment' => 0.00,
                'status_id' => 7,
                'payment_type_id' => 1,
                'context_id' => 2,
                'created_at' => $order->post_date
            ];
        }
//var_dump($orders); die;
        $cart = [];

        foreach ($orders_items as $items){
            if (count($items) > 0){
                foreach ($items as $item){
                    $orders_items_meta[$item->order_id][$item->order_item_name] = $this->source->select('select * from wploc_woocommerce_order_itemmeta where order_item_id = :order_item_id', ['order_item_id' => $item->order_item_id ]);
                    if($item->order_item_name != 'Shipping' && $item->order_item_name != 'Product Shipping'){
                        $cost = 0;
                        $item_count = 1;
                        $item_total_cost = 0;
                        foreach ($orders_items_meta[$item->order_id][$item->order_item_name] as $meta){
                            //var_dump($meta); die;
                            if($meta->meta_key == '_line_subtotal'){
                                $item_total_cost = $meta->meta_value;
                            } elseif ($meta->meta_key == '_qty'){
                                $item_count = $meta->meta_value;
                            }
                        }
                        $cost = $item_total_cost / $item_count;
                        $cart[] = [
                            'order_id' => $item->order_id,
                            'product_id' => $item->order_item_id,
                            'cost' => $cost,
                            'count' => $item_count
                        ];
                    }
                }
            }
        }
//var_dump($cart); die;
        foreach($cart as $key => $line){
            if($line['cost'] == 0){
                unset($cart[$key]);
                continue;
            }

            //var_dump($orders[$line['order_id']]);
            if($orders[$line['order_id']]){
                $line_cost = $line['cost'] * $line['count'];
                $orders[$line['order_id']]['cost'] += (int)$line_cost;
                if($orders[$line['order_id']]['cost'] < 0){
                    unset($orders[$line['order_id']]);
                }
/*                if(isset($orders[$line['order_id']])){
                    var_dump($orders[$line['order_id']]['cost']);
                }*/

            }
        }

        foreach ($cart as $key => $line){
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
        }

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

        $export['products'] = $products;
        $export['orders'] = $orders;
        $export['carts'] = $cart;
        $export['users'] = $users;
        $export['user_attrs'] = $user_attrs;

        return $export;
    }

    public function import($data)
    {
        /*
         * Import users
         */
        foreach ($data['users'] as $user){
            User::create($user);
        }

        /*
         * Import User attributes
         */
/*        foreach ($data['user_attrs'] as $attr){
            UserAttribute::create($attr);
        }*/
//die;
        /*
         * Import products
         */
        foreach ($data['products'] as $product){
            Product::create($product);
        }

        /*
         * Import orders
         */
        foreach ($data['orders'] as $order){
            Order::create($order);
        }

        /*
         * Import carts
         */
        foreach ($data['carts'] as $cart){
            Cart::create($cart);
        }
    }

    public function process()
    {
        $data = $this->export();

        $this->import($data);
    }
}
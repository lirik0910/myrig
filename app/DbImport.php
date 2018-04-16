<?php

namespace App;

use Illuminate\Support\Facades\DB;
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
            $user_name = '';
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
            }
            //$user_meta[$user->id] =
        }

        $orders_items_meta = [];
        $orders_items = [];
        $order_deliveries = [];

        $orders = [];
        foreach ($this->orders as $order){
            $orders_meta[$order->id][] = $this->source->select('select * from wpbit2_postmeta where post_id =:post_id', ['post_id' => $order->id]);
            $orders_items[$order->id] = $this->source->select('select * from wpbit2_woocommerce_order_items where order_id = :order_id', ['order_id' => $order->id]);
            $order_status = 1;
            switch ($order->post_status){
                case 'wc-completed':
                    $order_status = 7;
                    break;
                case 'wc-cancelled':
                    $order_status = 9;
                    break;
                case 'trash':
                    $order_status = 9;
                    break;
                case 'auto-draft':
                    $order_status = 2;
                    break;
                case 'wc-paid':
                    $order_status = 4;
                    break;

            }
            $orders[$order->id] = [
                'id' => $order->id,
                'number' => $order->id,
                'user_id' => $order->post_author,
                'cost' => 0,
                'prepayment' => 0.00,
                'status_id' => $order_status,
                'payment_type_id' => 1,
                'context_id' => 2,
                'created_at' => $order->post_date
            ];
            //var_dump($orders_meta[$order->id]); die;
            foreach($orders_meta as $meta){
               // var_dump($meta); die;
                if(isset($meta['post_id'])){
                    if($meta['post_id'] == $order->id){
                        $user_name = '';
                        $user_last_name = '';
                        $user_phone = '';
                        $user_email = '';
                        $user_city = '';
                        $user_country = '';
                        $user_address = '';
                        $user_state = '';
                        switch ($meta->meta_key){
                            case '_billing_first_name':
                                $user_name = $meta->meta_value;
                                break;
                            case  '_billing_last_name':
                                $user_last_name = $meta->meta_value;
                                break;
                            case '_billing_phone':
                                $user_phone = $meta->meta_value;
                                break;
                            case '_billing_email':
                                $user_email = $meta->meta_value;
                                break;
                            case '_billing_city':
                                $user_city = $meta->meta_value;
                                break;
                            case '_billing_country':
                                $user_country = $meta->meta_value;
                                break;
                            case '_billing_address_1':
                                $user_address = $meta->meta_value;
                                break;
                            case '_billing_state':
                                $user_state = $meta->meta_value;
                                break;
                        }
                        $user_meta[$order->id] = [
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
                }
            }
           // var_dump($user_meta); die;
            if(isset($user_meta[$order->id])){
                $order_deliveries[$order->id] = [
                    'order_id' => $order->id,
                    'delivery_id' => 1,
                    'first_name' => $user_meta[$order->id]['fname'],
                    'last_name' => $user_meta[$order->id]['lname'],
                    'phone' => $user_meta[$order->id]['phone'],
                    'email' => $user_meta[$order->id]['email'],
                    'city' => $user_meta[$order->id]['city'],
                    'country' => $user_meta[$order->id]['country'],
                    'address' => $user_meta[$order->id]['address'],
                    'state' => $user_meta[$order->id]['state']
                ];
            }
        }
       // var_dump($order_deliveries); die;
//var_dump($orders); die;
        $cart = [];

        foreach ($orders_items as $items){
            if (count($items) > 0){
                foreach ($items as $item){
                    $orders_items_meta[$item->order_id][$item->order_item_name] = $this->source->select('select * from wpbit2_woocommerce_order_itemmeta where order_item_id = :order_item_id', ['order_item_id' => $item->order_item_id ]);
                    if($item->order_item_name != 'Shipping' && $item->order_item_name != 'Product Shipping'){
                        if($item->order_item_name == 'Новая почта'){
                            if(isset($order_deliveries[$item->order_id])){
                                $order_deliveries[$item->order_id]['delivery_id'] = 1;
                            }
                        } elseif ($item->order_item_name == 'Самовывоз'){
                            if(isset($order_deliveries[$item->order_id])) {
                                $order_deliveries[$item->order_id]['delivery_id'] = 3;
                            }
                        } elseif($item->order_item_name == 'Деловые линии'){
                            if(isset($order_deliveries[$item->order_id])){
                                $order_deliveries[$item->order_id]['delivery_id'] = 1;
                            }
                        }
                        $item_count = 1;
                        $item_total_cost = 0;

                        foreach ($orders_items_meta[$item->order_id][$item->order_item_name] as $meta){
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

        foreach($cart as $key => $line){
            if($line['cost'] == 0){
                unset($cart[$key]);
                continue;
            }

            if (isset($line['order_id'])){
                if(isset($orders[$line['order_id']])){
                    $line_cost = $line['cost'] * $line['count'];
                    $orders[$line['order_id']]['cost'] += (int)$line_cost;
                    if($orders[$line['order_id']]['cost'] < 0 || $orders[$line['order_id']]['cost'] > 300000){
                        unset($orders[$line['order_id']]);
                    }
                }
            } else{
                unset($cart[$key]);
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
        $export['orders_deliveries'] = $order_deliveries;
        //var_dump($export['carts']); die;
        return $export;
    }

    public function import($data)
    {
        /*
         * Import users
         */
        foreach ($data['users'] as $user){
            try {
                User::create($user);
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
            try{
                Product::create($product);
            } catch (\Exception $e){
                continue;
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
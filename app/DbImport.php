<?php

namespace App;

use App\Model\Base\Context;
use Illuminate\Support\Facades\DB;
use App\Model\Base\Page;
use App\Model\Base\PageVisits;
use App\Model\Base\User;
use App\Model\Base\UserAttribute;
use App\Model\Shop\Product;
use App\Model\Shop\Order;
use App\Model\Shop\OrderDelivery;
use App\Model\Shop\OrderLog;
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
        $this->news = $this->source->select('select id, post_author, post_content, post_title, post_name, post_date, post_status from wpbit2_posts where post_type=:post_type and post_status=:post_status', ['post_type' => 'post', 'post_status' => 'publish']);
        $this->articles = $this->source->select('select id, post_author, post_content, post_title, post_name, post_date, post_status from wpbit2_posts where post_type=:post_type', ['post_type' => 'article']);
        $this->orders = $this->source->select('select id, post_author, post_date, post_status from wpbit2_posts where post_type=:post_type', ['post_type' => 'shop_order']);
        $this->products = $this->source->select('select id, post_title, post_content, post_name from wpbit2_posts where post_type =:post_type', ['post_type' => 'product']);
        //$this->articles = $this->source->select('select id, post_author, post_date, post_content, post_title, post_name, ');

        $news = [];
        //$views_count = [];
        foreach ($this->news as $new){
            $views_count = $this->source->select('select meta_value from wpbit2_postmeta where post_id =:post_id and meta_key =:meta_key', ['post_id' => $new->id, 'meta_key' => 'post_views_count'])[0]->meta_value;
            //var_dump($views_count); die;
            $news[$new->id] = [
                'view_id' => 10,
                'link' => 'news/' . $new->post_name,
                'title' => $new->post_title,
                'description' => '',
                'introtext' => '',
                'content' => $new->post_content,
                'delete' => 0,
                'createdby_id' => $new->post_author,
                'created_at' => $new->post_date,
                'views_count' => $views_count
            ];
        }

        $articles = [];
        foreach ($this->articles as $article){
            $views_count = $this->source->select('select meta_value from wpbit2_postmeta where post_id =:post_id and meta_key =:meta_key', ['post_id' => $new->id, 'meta_key' => 'post_views_count'])[0]->meta_value;
            $articles[$article->id] = [
                'view_id' => 10,
                'link' => 'articles/' . $article->post_name,
                'title' => $article->post_title,
                'description' => '',
                'introtext' => '',
                'content' => $article->post_content,
                'delete' => 0,
                'createdby_id' => $article->post_author,
                'created_at' => $article->post_date,
                'views_count' => $views_count
            ];
        }
        //var_dump($views_count); die;

        $products = [];

        foreach ($this->products as $product){
            //var_dump($product); die;
            //if($product->post_content != ''){
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
            //}

        }
//var_dump($products); die;
        $users = [];
        $user_attrs = [];
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
        }

        $orders_items_meta = [];
        $orders_items = [];
        $order_deliveries = [];
        $order_payments_all = [];
        $order_deliveries_all = [];

        $orders = [];
        $orders_logs = [];
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

        foreach($this->orders as $order){
            $order_status = 1;

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
        foreach ($this->orders as $order){
            $delivery_id = 5;
            $delivery_cost = 0;

            $orders_logs[$order->id] = $this->source->select('select * from wpbit2_comments where comment_post_ID = :comment_post_ID', ['comment_post_ID' => $order->id]);
            $orders_items[$order->id] = $this->source->select('select * from wpbit2_woocommerce_order_items where order_id = :order_id', ['order_id' => $order->id]);

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
                            if($meta_item->meta_value == 'bitcoin' || $meta_item->meta_value == 'jetpack_custom_gateway'){
                               // var_dump($orders[$order->id]);// die;
                                $orders[$order->id]['payment_type_id'] = 1;
                               // var_dump($orders[$order->id]);
                                //die;
                            } elseif($meta_item->meta_value == 'bacs' || $meta_item->meta_value == 'cod'){
                                $orders[$order->id]['payment_type_id'] = 2;
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
                    $orders[$order->id]['context_id'] = 1;
                } else{
                    $orders[$order->id]['context_id'] = 2;
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

        $this->cartsUpdate($orders_items);
        die;
        $cart = [];

        foreach ($orders_items as $items){
            if (count($items) > 0){
                foreach ($items as $item){
                    $orders_items_meta[$item->order_id][$item->order_item_name] = $this->source->select('select * from wpbit2_woocommerce_order_itemmeta where order_item_id = :order_item_id', ['order_item_id' => $item->order_item_id ]);

                    if($item->order_item_type == 'line_item'){
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
                            $item_product_title = '';
                            if(!isset($item_product_id) || !$item_product_id){
                                $item_product_id = 0;
                                $item_product_title = $item->order_item_name;
                            }
                        }
                        $cost = $item_total_cost / $item_count;
                        $cart[] = [
                            'order_id' => $item->order_id,
                            'product_id' => $item_product_id,
                            'cost' => $cost,
                            'count' => $item_count,
                            'title' => $item_product_title ? $item_product_title : NULL
                        ];
                    } elseif ($item->order_item_type == 'shipping'){
                        if($item->order_item_name == 'Новая Почта'){
                            if(isset($order_deliveries[$item->order_id])){
                                $order_deliveries[$item->order_id]['delivery_id'] = 1;
                            }
                        } elseif ($item->order_item_name == 'Самовывоз'){
                            if(isset($order_deliveries[$item->order_id])) {
                                $order_deliveries[$item->order_id]['delivery_id'] = 4;
                            }
                        } elseif($item->order_item_name == 'Деловые линии'){
                            if(isset($order_deliveries[$item->order_id])){
                                $order_deliveries[$item->order_id]['delivery_id'] = 3;
                            }
                        } elseif($item->order_item_name == 'СДЭК'){
                            if(isset($order_deliveries[$item->order_id])){
                                $order_deliveries[$item->order_id]['delivery_id'] = 2;
                            }
                        }
                    }
                }

            }
        }

        $test = [];
        foreach($cart as $key => $line){
            if($line['order_id'] == 6842){
                $test[] = $line;
            }
            if($line['cost'] == 0){
                unset($cart[$key]);
                continue;
            }

            $strangeOrders = [];
            if (isset($line['order_id'])){
                if(isset($orders[$line['order_id']])){
                    $cart[$key]['created_at'] = $orders[$line['order_id']]['created_at'];
                    $line_cost = $line['discountCost'] * $line['count'];
                    $orders[$line['order_id']]['cost'] += (int)$line_cost;
                    if($orders[$line['order_id']]['cost'] < 0 || $orders[$line['order_id']]['cost'] > 999999){
                        $strangeOrders[] = $orders[$line['order_id']]['cost'];
                        //unset($orders[$line['order_id']]);
                    }
                }
            } else{
                unset($cart[$key]);
            }
        }
        //var_dump(count($strangeOrders)); //die;
//var_dump($cart); die;

        $logs = [];
        $log_statuses = [];

        $meta_log = 0;
        $without_meta_log = 0;

        $defaultOrdersCount = count($orders_logs);
        $defaultLogsCount = 0;
        $contentStrings = [];
        //var_dump($defaultOrdersCount);
        foreach ($orders_logs as $order_id => $order_log){
            if(count($orders_logs) > 0){
                foreach($order_log as $log){
                    $defaultLogsCount++;
                    $meta = $this->source->select('select * from wpbit2_commentmeta where comment_id =:comment_id', ['comment_id' => $log->comment_ID]);

                    $userId = 1;
                    foreach ($users as $user){
                        if($log->comment_author_email == $user['email']){
                            $userId = $user['id'];
                        }
                    }

/*                    if($meta){
                        var_dump($meta); die;
                    }*/

                    if(count($meta) < 1){
                        $without_meta_log++;
                        $string = $log->comment_content;
                        $contentStrings[] = $log->comment_content;
                        $stringCont = explode('Статус заказа изменен',$string);

                        //var_dump($string);
                        //var_dump(strpos('Статус заказа', $string));
                        if(count($stringCont) > 1){
                            $newStatus = trim(stristr(stristr($string, 'на '), ' '), '.!,; ');
                            if($newStatus === ''){
                                if($string == 'Order Paid in Full'){
                                    $newStatus = 'Оплачен';
                                }
                            }

                            if(!in_array($newStatus, $log_statuses)){
                                $log_statuses[] = $newStatus;
                            }

                            $value = '';
                            switch ($newStatus){
                                case 'Новый заказ':
                                    $value = 'New order';
                                    break;
                                case 'В ожидании оплаты':
                                    $value = 'Waiting for payment';
                                    break;
                                case 'Оплачен':
                                    $value = 'Has been paid';
                                    break;
                                case 'Обработка':
                                    $value = 'Processing';
                                    break;
                                case 'На удержании':
                                    $value = 'Shipped by the factory';
                                    break;
                                case 'Отменен':
                                    $value = 'Сancelled';
                                    break;
                                case 'Выполнен':
                                    $value = 'Completed';
                                    break;
                                case 'Возвращен':
                                    $value = 'Returned';
                                    break;
                            }
                            $type = 'status';
                        } else{
                            //var_dump('note');
                            $value = $string;
                            $type = 'note';
                        }
                    } else{
                        foreach($meta as $item){
                            if ($item->comment_id == $log->comment_ID){
                                $meta_log++;
                                $value = $log->comment_content;
                                $type = 'message';
                            }
                        }
                    }

                    if($value){
                       // var_dump($type);
                        $logs[] = [
                            'order_id' => $order_id,
                            'user_id' => $userId,
                            'type' => $type,
                            'value' => $value,
                            'created_at' => $log->comment_date
                        ];
                    }
                }
            }
        }
        //die;
        //var_dump($without_meta_log, $meta_log, $logs); die;
        //var_dump($defaultLogsCount);
//var_dump($contentStrings); die;
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
//var_dump(count($orders));
        foreach ($orders as $key => $order){
            if($order['status_id'] == 10 || $order['status_id'] == 11){
                unset($orders[$key]);
            }
        }
//var_dump(count($orders)); die;

        $export['products'] = $products;
        $export['orders'] = $orders;
        $export['carts'] = $cart;
        $export['users'] = $users;
        $export['user_attrs'] = $user_attrs;
        $export['orders_deliveries'] = $order_deliveries;
        $export['news'] = $news;
        $export['articles'] = $articles;
        $export['logs'] = $logs;
        //var_dump($export['users']); die;
        return $export;
    }

    public function import($data)
    {
        /*
         * Comment tables which do you need to import
         */
        $data['users'] = [];
        $data['products'] = [];
       // $data['orders'] = [];
       // $data['carts'] = [];
        $data['user_attrs'] = [];
       // $data['orders_deliveries'] = [];
        $data['news'] = [];
        $data['articles'] = [];
       // $data['logs'] = [];


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
        $contexts = Context::where('title', 'UA')->orWhere('title', 'RU')->get();
        //var_dump($contexts); die;
        /*
         * Import products
         */
        $currentRuProducts = Product::where('context_id', 3)->get();
        foreach ($data['products'] as $product){
            //var_
            foreach ($contexts as $context){
                $write = true;
                //try{
               // $parent_page = Page::where('context_id', $context->id)->where('link', 'shop')->first();

/*                    $page = Page::create([
                        'parent_id' => $parent_page->id,
                        'context_id' => $context->id,
                        'view_id' => 5,
                        'link' => 'product/' . $product['articul'],
                        'title' => $product['title'],
                        'description' => '',
                    ]);*/
              //      $page = Page::where('context_id', $context->id)->where('link', 'product/' . $product['articul'])->first();
                try{
                    $product['page_id'] = 0;
                    $product['context_id'] = $context->id;
                    if($context->id == 3){
                        foreach ($currentRuProducts as $ruProd){
                            if($product['title'] === $ruProd['title']){
                                //continue;
                                $write = false;
                            }
                        }
                       unset($product['id']);
                    }
                    //var_dump($product); die;
                    if($write){
                        Product::create($product);
                    }

                } catch (\Exception $e){
/*                    if($context->id == 3){
                        var_dump('RUUUUU'); die;
                    }*/
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
                //var_dump($e); die;
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

       // $broken_carts = [];
        /*
         * Import carts
         */
        foreach ($data['carts'] as $cart){
            try{
                Cart::create($cart);
            } catch (\Exception $e){
                //$broken_carts[] = $cart;
                continue;
            }
        }

        //var_dump(count($broken_carts)); die;
        /*
         * Import news
         */
        $newsPage = Page::where('title', 'Новости')->orWhere('title', 'News')->where('context_id', 2)->first();
        //$currentNews = Page::where('parent_id', $newsPage->id)->get();
        foreach ($data['news'] as $new){
            $write = true;
            $view_count = $new['views_count'];
            //var_dump($view_count); die;
            unset($new['views_count']);

          //  foreach ($currentNews as $curNew){
            //    if($new['title'] == $curNew['title']){
              //      $write = false;
                //}
            //}
            //foreach ($contexts as $context){

            if($write){
                $new['parent_id'] = $newsPage->id;
                $new['context_id'] = 2;
                try{
                    $page = Page::create($new);
                } catch (\Exception $e){
                    continue;
                }
                // var_dump($page->id); die;
                try{
                    PageVisits::create([
                        'page_id' => $page->id,
                        'count' => $view_count
                    ]);
                } catch (\Exception $e){
                    continue;
                }
            }
            //}
        }

        /*
         * Import articles
         */
        foreach ($data['articles'] as $article){
            $view_count = $article['views_count'];
            unset($article['views_count']);

           // foreach ($contexts as $context){
                $article['context_id'] = 2;
                $articlesPage = Page::where('title', 'Articles')->where('context_id', 2)->first();
                $article['parent_id'] = $articlesPage->id;
                try{
                    $page = Page::create($article);
                } catch (\Exception $e){
                    continue;
                }
                try{
                    PageVisits::create([
                        'page_id' => $page->id,
                        'count' => $view_count
                    ]);
                } catch (\Exception $e){
                    continue;
                }
            //}
        }

        /*
         * Import order logs
         */
        foreach ($data['logs'] as $log){
            try{
                OrderLog::create($log);
            } catch (\Exception $e){
                continue;
            }
        }
    }

    public function process()
    {

        $this->ordersCostUpdate();
        die;
        $data = $this->export();

        $this->import($data);
    }

    public function cartsUpdate($order_items){
        $current_carts = Cart::all();
        $newCarts = [];

        foreach ($current_carts as $cart){
            $product = Product::find($cart->product_id);

            if(!$product && $cart->title == NULL || $cart->order_id < 7686){
                Cart::where('order_id', $cart->order_id)->delete();
            }
        }

        $current_orders = Order::all();

        foreach ($current_orders as $order){
            $order_carts = $order->carts;

            if(count($order_carts) < 1){
                foreach ($order_items[$order->id] as $item){
                    //foreach ($items as $item){
                        $orders_items_meta[$item->order_id][$item->order_item_name] = $this->source->select('select * from wpbit2_woocommerce_order_itemmeta where order_item_id = :order_item_id', ['order_item_id' => $item->order_item_id ]);

                        if($item->order_item_type == 'line_item'){
                            $item_count = 1;
                            $item_subtotal_cost = 0;
                            $item_total_cost = 0;

                            foreach ($orders_items_meta[$item->order_id][$item->order_item_name] as $meta){
                                if($meta->meta_key == '_line_subtotal'){
                                    $item_subtotal_cost = $meta->meta_value;
                                } elseif ($meta->meta_key == '_line_total'){
                                    $item_total_cost = $meta->meta_value;
                                } elseif ($meta->meta_key == '_qty'){
                                    $item_count = $meta->meta_value;
                                } elseif($meta->meta_key == '_product_id'){
                                    $item_product_id = $meta->meta_value;
                                }
                                $item_product_title = '';
                                if(!isset($item_product_id) || !$item_product_id || !Product::find($item_product_id)){
                                    $item_product_id = 0;
                                    $item_product_title = $item->order_item_name;
                                }
                            }

                            if(!$item_total_cost){
                                $item_total_cost = $item_subtotal_cost;
                            }

                            $subtotal_cost = $item_subtotal_cost / $item_count;
                            $total_cost = $item_total_cost / $item_count;

                            $newCarts[] = [
                                'order_id' => $item->order_id,
                                'product_id' => $item_product_id,
                                'cost' => $subtotal_cost,
                                'discountCost' => $total_cost,
                                'count' => $item_count,
                                'title' => $item_product_title ? $item_product_title : NULL
                            ];
                        }
                    //}
                }
            }
        }

        foreach ($newCarts as $newCart){
            try{
                Cart::create($newCart);
            }catch (\Exception $e){
                continue;
            }
        }
    }

    public function ordersCostUpdate(){
        $orders = Order::all();

        foreach($orders as $order){
            $carts = $order->carts;
            $cost = 0;

            foreach ($carts as $cart){
                $cost += ($cart->discountCost * $cart->count);
            }

            $order->cost = $cost;
            $order->save();
        }
    }
}
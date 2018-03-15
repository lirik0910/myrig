@extends('layouts.app')

@section('content')
    <main>
        <div class="main-back"></div>
        <script>
            var width = $(window).width();
            var cont = $('.container').outerWidth();
            var margin = (width - cont) / 2;
            var wM = cont * 33.333333 / 100 + margin;
            if (width > 767) {
                $('.main-back').css('left', wM +'px');
            }
            else {
                $('.main-back').css('left', '0px');
            }
        </script>
        @php
            $user = App\Model\Base\User::where('email', session()->get('client'))->with('attributes', 'orders')->first();
            $orders = App\Model\Shop\Order::where('user_id', $user->id)->with('products')->get();
            foreach ($orders as $gt){
                //var_dump($gt); die;
            }

        @endphp
        <section class="content profile">
            <div class="container">
                <div class="article-row row">
                    <div class="col-sm-4 profile-links">
                        <div>
                            <a href="" class="personal active" data-target="#personalF" data-wpel-link="internal">Personal info</a>
                        </div>
                        <div>
                            <a href="" class="history" data-target="#historyField" data-wpel-link="internal">Orders history</a>
                        </div>
                        <div>
                            <a href="{{url(env('APP_URL') . 'sso-login?action=logout')}}" class="exit" data-wpel-link="internal">Logout</a>
                        </div>
                    </div>
                    <div class="article-content col-sm-8">
                        <div class="article-text">
                            <div id="personalF">
                                <form id="personalForm" action="#">
                                    <div class="form-group">

                                        <input type="text" value="{{$user->attributes->fname}}" name="first_name" placeholder="Имя" class="form-control full-width" required="required" data-bv-message=" "/>
                                    </div>
                                    <div class="form-group">

                                        <input type="text" value="{{$user->attributes->lname}}" name="last_name" placeholder="Фамилия" class="form-control full-width" required="required" data-bv-message=" "/>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Пароль" data-bv-identical-field="password_confirm" data-bv-message="Пароли не совпадают"/>
                                        <div class="checkbox-wrapper">
                                            <input type="checkbox" name="tfa" class="form-control tfa-check" />
                                            <label class="form-label">двуфакторная авторизация</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Повторите пароль" data-bv-identical-field="password_confirm" data-bv-message="Пароли не совпадают"/>

                                    </div>
                                    <div class="form-group tfa hidden">
                                        [twofactor_user_settings]	                    </div>
                                    <div class="form-group">
                                        <input type="email" name="user_email"  value="{{$user->email}}" disabled class="form-control" placeholder="Эл. почта" />
                                    </div>
                                    <div class="form-group">
                                        <input type="tel" name="billing_phone" value="{{$user->attributes->phone}}" class="form-control" placeholder="Телефон" required="required" data-bv-message=" "/>

                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="billing_address_1" value="{{$user->attributes->address}}" class="form-control full-width" placeholder="Адрес доставки" value=""/>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="submit" class="btn-default" value="Сохранить"/>
                                    </div>
                                    <input type="hidden" name="action" value="bitmain_account_register">
                                    <input type="hidden" name="user" value="3018">
                                </form>
                                <p class="result" data-text="Профиль обновлен!"></p>
                            </div>
                            <div id="historyField">
                                <div class="table-like table-expanded">
                                    <div class="table-row table-header">
                                        <div class="table-cell  ">Номер и дата</div>
                                        <div class="table-cell ">Товар и его цена</div>
                                        <div class="table-cell table-cell-title">Кол-во</div>
                                        <div class="table-cell">Стоимость</div>


                                        <div class="table-cell table-cell-status">Статус</div>
                                        <div class="table-cell"></div>
                                    </div>
                                    @isset($govno)
                                    @foreach($orders as $order)
                                        <div class="table-row  table-row-border table-row-top-several">
                                            <div class="table-cell table-cell-border">
                                                <div class="order-number-wrap">
                                                    <span class="order-number">#{{$order->number}}</span>
                                                    <span class="order-data">@php echo date('d-m-Y', strtotime($order->created_at)) @endphp</span>
                                                </div>
                                            </div>
                                            @if(count($order->products) > 1)
                                                <div class="table-cell table-product-cell">
                                                    <div class="order_thumbs order_thumbs_several">
                                                        <span class="several_products">@php echo count($order->products) @endphp items</span>
                                                        <a href=".order-{{$order->number}}" data-wpel-link="internal" class="">
                                                            <span class="show_products"><i class="fa fa-chevron-down" aria-hidden="true"></i>Show</span>
                                                            <span class="hide_products"><i class="fa fa-chevron-up" aria-hidden="true"></i>Hide</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="table-cell table-product-cell">
                                                    <div class="order_thumbs">
                                                        <img src="{{asset('uploads/' . $order->products[0]->images[0]->name)}}" title="{{$order->products[0]->title}}">
                                                        <div class="cost">
                                                            <a href="{{$order->products[0]->page->link}}" data-wpel-link="internal">{{$order->products[0]->title}}</a>
                                                            <span class="hidden-md">Item cost</span>
                                                            <span class="table-price">${{$order->products[0]->price}}</span>
                                                            <span class="table-bitcoin">0.3464<i class="fa fa-bitcoin"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="table-cell number">
                                                <span class="hidden-md">Count</span>
                                                <span> @php $count = 0; foreach($order->orderItems as $orderItem){ $count += $orderItem->count; } echo $count @endphp шт </span>
                                            </div>
                                            <div class="table-cell number number-price">
                                                <span class="hidden-md">Total</span>
                                                <span class="table-price"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>{{ number_format($order->cost, 2, '.', '') }}</span></span>
                                                <span class="table-bitcoin">0.3464<i class="fa fa-bitcoin"></i></span>
                                            </div>
                                            <div class="table-cell status">
                                                <span class="">
                                                    <p class="hidden-md">Status</p>
                                                    <span class="mark cancelled">Отменен</span><br>
                                                    <a class="order-history" data-wpel-link="internal">История
                                                        <div class="history-dd" style="height: auto !important">
                                                            <div class="modal-body">
                                                                <h3>14 марта 2018 в 13:07</h3>
                                                                <div class="comment-order">
																    Статус заказа изменен с Новый заказ на Отменен.
                                                                </div>
															    <h3>14 марта 2018 в 08:40</h3>
                                                                <div class="comment-order">
																    Статус заказа изменен с trash на Новый заказ.
															    </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </span>
                                            </div>
                                            <div class="table-cell"></div>
                                        </div>
                                        @if(count($order->products) > 1)
                                            @foreach($order->products as $product)
                                                <div class="table-row table-row-several order-{{$order->number}} hidden-block">
                                                    <div class="table-cell table-cell-border table-cell-border-none">
                                                    </div>
                                                    <div class="table-cell table-product-cell">
                                                        <div class="order_thumbs">
                                                            <img src="{{asset('uploads/' . $product->images[0]->name)}}" title="{{$product->title}}">
                                                            <div class="cost">
                                                                <a href="{{$product->page->link}}" data-wpel-link="internal">{{$product->title}}</a>
                                                                <span class="hidden-md">Cost</span>
                                                                <span class="table-price">${{$product->price}}</span>
                                                                <span class="table-bitcoin">0.3464<i class="fa fa-bitcoin"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="table-cell number">
                                                        <span class="hidden-md">Count</span>
                                                        <span> {{$product->pivot->count}} шт.</span>
                                                    </div>
                                                    <div class="table-cell number number-price">
                                                        <span class="hidden-md">Item cost</span>
                                                        <span class="table-price">$@php echo $product->cost * $product->pivot->count; @endphp</span>
                                                        <span class="table-bitcoin">1.0392<i class="fa fa-bitcoin"></i></span>
                                                    </div>
                                                    <div class="table-cell status">
                                                    </div>
                                                    <div class="table-cell "></div>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
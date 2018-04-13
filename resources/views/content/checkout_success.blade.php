@extends('layouts.app')

@section('content')
    <main>
        @php
            $order = App\Model\Shop\Order::where('number', $number)->with('orderDeliveries', 'products')->first();
            $delivery = App\Model\Shop\Delivery::where('id', $order->orderDeliveries->delivery_id)->first();
            $payment = App\Model\Shop\PaymentType::where('id', $order->payment_type_id)->first();
            //var_dump($order->products); die;
        @endphp
        <div class="main-back"  ></div>
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

            jQuery(document).ready(function($){

                if ($("#timer").length) {
                    function startTimer(){
                        var e=document.getElementById("timer").innerHTML.split(/[:]+/),
                            t=e[0],n=checkSecond(e[1]-1);59==n&&(t-=1),
                            document.getElementById("timer").innerHTML=t+":"+n,
                            setTimeout(startTimer,1e3)}

                    function checkSecond(e)
                    {return e<10&&e>=0&&(e="0"+e),e<0&&(e="59"),e}
                    document.getElementById("timer").innerHTML="",
                        startTimer();
                }

            })

        </script>
        <style>
            .timer {
                background: #60a645;
                color: #fff;

                padding: 10px;
                font-weight: bold;
            }
            #timer {
                float: right;
            }
        </style>
        <section class="content order">
            <div class="container">
                <div class="row widgets">
                    <div class="woocommerce">
                        <div class="woocommerce-order">
                            <div class="col-sm-4" id="customer_details">
                                <div class="widget wPay">
                                    <h4 class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">Thank you. Your order was successfully accepted.</h4>
                                    <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
                                        <li class="woocommerce-order-overview__order order">
                                            Order number:						<strong>{{$order->number}}</strong>
                                        </li>
                                        <li class="woocommerce-order-overview__date  ">
                                            Date:						<strong>@php echo date('d-m-Y', strtotime($order->created_at)) @endphp</strong>
                                        </li>
                                        <li class="woocommerce-order-overview__total total">
                                            Total:						<strong><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;</span>{{ number_format($order->cost, 2, '.', '') }}</span></strong>
                                        </li>
                                        <li class="woocommerce-order-overview__payment-method method">
                                            Payment:						<strong>{{$payment->title}}</strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="article-text">
                                    <div class="widget wDelivery">
                                        <section class="woocommerce-order-details">
                                            <a href="download-pdf/{{ $order->number }}">DOWNLOAD INVOICE</a>
                                            <h2 class="woocommerce-order-details__title">Info about order</h2>
                                            <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
                                                <thead>
                                                <tr>
                                                    <th class="woocommerce-table__product-name product-name">Product</th>
                                                    <th class="woocommerce-table__product-table product-total">Price</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($order->products as $product)
                                                        @php
                                                            if($product->auto_price){
                                                                $price = number_format($product->calcAutoPrice(), 2, '.', '');
                                                            } else{
                                                                $price = number_format($product->price, 2, '.', '');
                                                            }
                                                        @endphp
                                                        <tr class="woocommerce-table__line-item order_item">
                                                            <td class="woocommerce-table__product-name product-name">
                                                                <a href="{{$product->page->link}}" data-wpel-link="internal">{{$product->title}}</a> <strong class="product-quantity">&times; {{$product->pivot->count}}</strong>	</td>
                                                            <td class="woocommerce-table__product-total product-total">
                                                                <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;</span>{{ number_format($price * $product->pivot->count, 2, '.', '') }}</span>	</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th scope="row">Items cost:</th>
                                                    <td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;</span>{{ number_format($order->cost, 2, '.', '') }}</span></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Delivery:</th>
                                                    <td>{{$delivery->title}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Payment type:</th>
                                                    <td>{{$payment->title}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Total:</th>
                                                    <td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;{{ number_format($order->cost, 2, '.', '') }}</span></span></td>
                                                </tr>
                                                </tfoot>

                                            </table>
                                            <section class="woocommerce-customer-details">
                                                <h2>Info about client</h2>
                                                <table class="woocommerce-table woocommerce-table--customer-details shop_table customer_details">
                                                    <tr>
                                                        <th>Comment:</th>
                                                        <td>{{$order->orderDeliveries->comment}}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Email:</th>
                                                        <td>{{$order->orderDeliveries->email}}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Phone:</th>
                                                        <td>{{$order->orderDeliveries->phone}}</td>
                                                    </tr>
                                                </table>
                                                <h3 class="woocommerce-column__title">Address info</h3>
                                                <address>{{$order->orderDeliveries->first_name}} {{$order->orderDeliveries->last_name}}<br/>{{ __('common.country_' . $order->orderDeliveries->country) }}, {{$order->orderDeliveries->city}}<br/>{{$order->orderDeliveries->address}}</address>
                                            </section>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
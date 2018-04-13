<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body style="margin: 0; padding: 0; font: 400 30px Calibri, sans-serif;">
@php
    $order = App\Model\Shop\Order::where('number', $number)->with('orderDeliveries', 'products')->first();
        $delivery = App\Model\Shop\Delivery::where('id', $order->orderDeliveries->delivery_id)->first();
@endphp
<div style="width: 1000px; margin: 0 auto; padding-top: 270px">
    <img src="{{ url('uploads/design/dots.png') }}" alt="" style="position: absolute; top: 0; right: 650px;">

    <img src="{{ url('uploads/design/logo.png') }}" alt="" style="position: fixed; width: 300px; top: 45px; left: 265px">

    <div>
        <table style="width: 100%; font-size: 25px;">
            <tr>
                <td style="font-size: 40px;">Client Name</td>
                <td style="text-align: right; vertical-align: bottom;">{{$order->orderDeliveries->first_name}} {{$order->orderDeliveries->last_name}}</td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: right;">{{$order->orderDeliveries->address}}</td>
            </tr>
            <tr>
                <td style="text-transform: uppercase; font-weight: 700; letter-spacing: 4px;">INVOICE #{{ $order->number }}</td>
                <td style="text-align: right;">{{$order->orderDeliveries->city}}</td>
            </tr>
            <tr>
                <td>{{ date('d F`y') }}</td>
                <td style="text-align: right;">{{ $order->number }}</td>
            </tr>
        </table>
    </div>
    <div>
        <table style="width: 100%; border-collapse: collapse; margin-top: 100px; font-size: 30px;">
            <tr style="text-transform: uppercase; text-align: center; font-size: 20px;">
                <td style="text-align: left; font-weight: 400; padding: 15px 5px; width: 500px; border-bottom: 5px solid #7f7e7c;">Description</td>
                <td style="font-weight: 400; width: 100px; border-bottom: 5px solid #7f7e7c;">Quantity</td>
                <td style="font-weight: 400; width: 200px; border-bottom: 5px solid #7f7e7c;">Price</td>
                <td style="font-weight: 400; width: 200px; border-bottom: 5px solid #7f7e7c;">Total</td>
            </tr>
            @foreach($order->products as $product)
                @php
                    if($product->auto_price){
                       $price = number_format($product->calcAutoPrice(), 2, '.', '');
                       } else{
                       $price = number_format($product->price, 2, '.', '');
                        }
                @endphp
                <tr style="text-align: center;">
                    <td style="text-align: left; padding: 20px 5px;">{{ $product->title }}</td>
                    <td>{{$product->pivot->count}}</td>
                    <td>{{ number_format($price, 2, '.', '') }}</td>
                    <td style="color: #76a364">{{ number_format($price * $product->pivot->count, 2, '.', '') }}</td>
                </tr>
            @endforeach

        </table>


        <div style="float: right; width: 333.3px">
            <table style="width: 333.3px; border-collapse: collapse; font-size: 23px;">
                <tr style="text-transform: uppercase;">
                    <td style="padding: 40px 0 15px 10px;">Total</td>
                    <td style="padding: 40px 0 15px 10px;">{{ number_format($order->cost, 2, '.', '') }}</td>
                </tr>
                <tr style="text-transform: uppercase;">
                    <th style="font-weight: 600; padding: 15px 0 15px 10px;">Tax</th>
                    <th style="font-weight: 600; padding: 15px 0 15px 10px;">$00.0</th>
                </tr>
                <tr style="text-transform: uppercase;">
                    <td style="padding: 15px 0 15px 10px; font-weight: 600;">Amount Due</td>
                    <td style="color: #76a364; font-size: 40px; font-weight: 600;">{{ number_format($order->cost, 2, '.', '') }}</td>
                </tr>
            </table>
        </div>

    </div>
    <p style="text-transform: uppercase; margin: 350px 0 0 0; font-size: 25px;">Payment Terms</p>
    <p style="margin: 0 0 60px; font-size: 25px;">Write your payment terms and conditions here</p>
</div>
<footer style="padding: 50px 0 50px; background: #77a565; font-size: 0; color: #fff;">
    <div style="width: 1333px; margin: 0 auto;">
        <div style="display: inline-block; width: 444.3px;">
            <div style="display: inline-block; margin-right: 15px;">
                <img src="{{ url('uploads/design/phone.png') }}" alt="" style="width: 50px; height: 50px;">
            </div>
            <div style="display: inline-block; vertical-align: top; width: 379.3px; font-size: 20px;">
                <p style="margin: 0;">+38 044 360 79 58</p>
                <p style="margin: 0;">+38 098 619 73 73</p>
            </div>
        </div>
        <div style="display: inline-block; width: 444.3px;">
            <div style="display: inline-block; margin-right: 15px;">
                <img src="{{ url('uploads/design/point.png') }}" alt="" style="width: 50px; height: 50px;">
            </div>
            <div style="display: inline-block; vertical-align: top; width: 379.3px; font-size: 20px;">
                <p style="margin: 0; padding-right: 50px;">3700 Quebec Street<br>Unit 100-239 Denver<br> Colorado 80270</p>
            </div>
        </div>
        <div style="display: inline-block; width: 444.3px;">
            <div style="display: inline-block; margin-right: 15px;">
                <img src="{{ url('uploads/design/world.png') }}" alt="" style="width: 50px; height: 50px;">
            </div>
            <div style="display: inline-block; vertical-align: top; width: 379.3px; font-size: 20px;">
                <p style="margin: 0;">alex@bitmainwarranty.com</p>
                <p style="margin: 0;">www.myrig.com.ua</p>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
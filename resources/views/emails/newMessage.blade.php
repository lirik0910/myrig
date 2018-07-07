<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" style="margin: 0; padding: 0;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
</head>
<body style="margin: 0; padding: 0; font: 400 18px Calibri, sans-serif;">
@php
    $order = App\Model\Shop\Order::where('number', $number)->with('orderDeliveries', 'products')->first();
    $delivery = App\Model\Shop\Delivery::where('id', $order->orderDeliveries->delivery_id)->first();
    $order_status = App\Model\Shop\OrderStatus::where('id', $order->status_id)->first();
@endphp
<div style="width: 500px; margin: 0 auto;">
    <p>{{__('default.email_message_title') }}</p>
    <p>{{ $text }}</p>
</div>
</body>
</html>
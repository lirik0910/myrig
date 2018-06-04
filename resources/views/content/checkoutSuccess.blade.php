@extends('layouts.app')

@section('content')

@php
$order = App\Model\Shop\Order::where('number', $number)
    ->with('orderDeliveries', 'products')
    ->first();

$delivery = App\Model\Shop\Delivery::where('id', $order->orderDeliveries->delivery_id)->first();
$payment = App\Model\Shop\PaymentType::where('id', $order->payment_type_id)->first();
@endphp

<div id="dark__container" class="dark__container"></div>
@endsection
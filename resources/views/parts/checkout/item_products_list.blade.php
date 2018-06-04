@php
    $count = 0;
    foreach ($inCart as $key => $val){
        if($key == $item->id){
            $count = $val;
        }
    }

    if($item->auto_price){
        $price = number_format($item->calcAutoPrice(), 2, '.', '');
    } else{
        $price = number_format($item->price, 2, '.', '');
    }

    $btcPrice = number_format($item->calcBtcPrice(), 4, '.', '');

    $cost = $count * $price;
    $btcCost = $count * $btcPrice;
    $icon = $item->images->first();
@endphp
<div class="table-row">
    <div class="table-cell foto">
        <img src="{{asset('uploads/' . $icon['name'])}}" title="">
    </div>

    <div class="table-cell product">
        <a href="https://myrig.com.ua/product/dragonmint-16-th-s-2/" data-wpel-link="internal">{{$item->title}}</a>

        <span class="hidden-md">Product price</span>
        <span class="table-price">${{ $price }}</span>

        <span class="table-bitcoin">{{ $btcPrice }}<i class="fa fa-bitcoin"></i></span>
    </div>

    <div class="table-cell number">
        <span class="hidden-md">Count</span>
        <span> {{$count}} шт.</span>
    </div>

    <div class="table-cell number-price">
        <span class="hidden-md">Cost</span>
        <span class="table-price">${{ $cost }}</span>
        <span class="table-bitcoin">{{ $btcCost }}<i class="fa fa-bitcoin"></i></span>
    </div>
</div>
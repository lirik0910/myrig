@php
    $count = 0;
    foreach ($inCart as $key => $val){
        if($key == $item->id){
            $count = $val;
        }
    }
    $cost = $count * $item->price;
    $icon = $item->images->first();
@endphp
<div class="table-row">
    <div class="table-cell foto">
        <img src="{{asset('uploads/' . $icon['name'])}}" title="">
    </div>

    <div class="table-cell product">
        <a href="https://myrig.com.ua/product/dragonmint-16-th-s-2/" data-wpel-link="internal">{{$item->title}}</a>

        <span class="hidden-md">Цена товара</span>
        <span class="table-price">{{$item->price}}</span>

        <span class="table-bitcoin">0.3248<i class="fa fa-bitcoin"></i></span>
    </div>

    <div class="table-cell number">
        <span class="hidden-md">Количество</span>
        <span> {{$count}} шт.</span>
    </div>

    <div class="table-cell number-price">
        <span class="hidden-md">Стоимость</span>
        <span class="table-price">${{$cost}}</span>
        <span class="table-bitcoin">5.5222<i class="fa fa-bitcoin"></i></span>
    </div>
</div>
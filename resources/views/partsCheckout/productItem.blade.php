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

<tr style="border-top: 1px solid #FFF">
    <td class="product-line__container" style="width: 84px">
        <img src="{{ asset('uploads/' . $icon['name']) }}" alt="product" style="width: 68px;">
    </td>

    <td class="product-line__container">
        <a href="https://myrig.com.ua/product/dragonmint-16-th-s-2/" class="default__link product-title__container">
            {{$item->title}}
        </a>

        <div class="price__container padding__collapse margin__collapse mobile-price__container d-block" style="min-width: 194px">
            <span class="font-weight-bold default-small__price attribute-item__container" style="color: #000; font-size: 15px;">
                <span class="attribute-item__label">{{ __('default.product_price') }}</span>
                <span class="currency__symbol">&#36;</span>
                <span id="{{ 'default-price__container-' . $item->id }}" class="font-weight-light">{{ $price }}</span>
            </span>

            <span class="bitcoin-small__price attribute-item__container" style="font-size: 15px;">
                <span class="attribute-item__label">{{ __('default.cost') }}</span>
                <span id="{{ 'bitcoin-price__container-' . $item->id }}" class="font-weight-light">{{ $btcPrice }}</span>
                <i class="fa fa-bitcoin"></i>
            </span>

            <span class="attribute-item__container d-block-991" style="font-size: 15px;">
                <span class="attribute-item__label">{{ __('default.count') }}</span>
                <span class="font-weight-light" style="color: #000">{{ $count }}</span>
            </span>
        </div>
    </td>

    <td class="product-line__container checkout-order__cost">
        <span class="hidden-md">{{ __('default.count') }}</span>
        <span style="color: #000">{{ $count }}</span>
    </td>

    <td class="checkout-order__cost product-line__container" style="width: 100px">
        <div class="price__container padding__collapse margin__collapse mobile-price__container d-block" style="min-width: 174px">
            <span class="font-weight-bold default-small__price d-block margin__collapse padding__collapse" style="color: #000; font-size: 15px; line-height: 24px;">
                <span class="currency__symbol">&#36;</span>
                <span id="{{ 'default-price__container-' . $item->id }}" class="font-weight-light">{{ $cost }}</span>
            </span>

            <span class="bitcoin-small__price d-block margin__collapse padding__collapse"  style="font-size: 15px; line-height: 24px">
                <span id="{{ 'bitcoin-price__container-' . $item->id }}" class="font-weight-light">{{ $btcCost }}</span>
                <i class="fa fa-bitcoin"></i>
            </span>
        </div>
    </td>
</tr>
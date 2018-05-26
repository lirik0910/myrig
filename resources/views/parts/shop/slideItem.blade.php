@php
    if($item->auto_price){
        $autoprice = $item->calcAutoPrice();
        if(!$autoprice){
            $price = number_format($item->price, 2, '.', '');
        } else{
            $price = number_format($autoprice, 2, '.', '');
        }
    } else{
        $price = number_format($item->price, 2, '.', '');
    }

    $btcPrice = number_format($item->calcBtcPrice(), 4, '.', '');

    if($locale == 'en'){
		$default_img = 'default/eng.no-photo.jpg';
	} else{
		$default_img = 'default/ru.no-photo.jpeg';
	}
//var_dump($item); die;
@endphp

<a href="{{ asset($item->page->link) }}" class="related-item" data-wpel-link="internal" data-dot="<span class='dot' data-id='{{ $i }}'><p class='dashnav-progress'></p></span>">
    <div class="related-title">{{ $item->title }}</div>

    <div class="related-img">
        @if (isset($item->images[0]))
            <img width="1000" height="1000" src="@if(empty($item->images[0]) or !file_exists(public_path() . '/uploads/' . $item->images[0]->name)){{ $preview(asset('uploads/' . $default_img), 215, 215) }}@else{{ $preview(asset('uploads/' . $item->images[0]->name), 215, 215) }}@endif"
                 class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="previw"/>
        @else
            <img width="1000" height="1000" src="{{ $preview(asset('uploads/' . $default_img), 215, 215) }}"
                 class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="previw"/>
        @endif
    </div>

    <div class="tag @if ($item->productStatus->title === 'in-stock') tag-check @elseif ($item->productStatus->title === 'pre-order') tag-order  @elseif ($item->productStatus->title === 'not-available') tag-no @endif">{{ __('common.product_status_' . str_replace(' ', '_', mb_strtolower($item->productStatus->description))) }}</div>

    <div class="tag tag tag-waranty">{{ __('default.warranty') }} {{ $item->warranty }}</div>

    <div class="related-price">
        <div>
			<span class="woocommerce-Price-amount amount">
				<span class="woocommerce-Price-currencySymbol">&#36;</span>
                {{ number_format($price, 2, '.', '') }}
			</span>

            <span class="table-bitcoin">{{ $btcPrice }}
                <i class="fa fa-bitcoin"></i>
			</span>
        </div>

        <div class="note"></div>
        <div class="tag tag-info"></div>
    </div>

    <form class="related-form item-count__container">
		<span class="input-number ">
			<input id="{{ 'count-products-' . $item->id }}" type="text" name="count"
                   class="form-control form-number count add-to-cart-count"
                   value="{{ isset($inCart[$item->id]) ? $inCart[$item->id] : 1 }}" data-id="{{ $item->id }}"/>
					
			<div class="btn-count btn-count-plus" data-id="{{ $item->id }}">
				<i class="fa fa-plus"></i>
			</div>

			<div class="btn-count btn-count-minus" data-id="{{ $item->id }}">
				<i class="fa fa-minus"></i>
			</div>
		</span>

        @if (isset($inCart[$item->id]))
            <p data-success="{{ __('shop.added') }}" data-add="{{ __('default.to_cart') }}" data-id="{{ $item->id }}"
               class="btn-default intocarts">
                <span>{{ __('default.added') }}</span>
                <i class="fa fa-spin fa-refresh" style="display: none"></i>
            </p>
        @elseif ($item->productStatus->title === 'not-available')
            <p href="#report-availability" data-id="{{ $item->id }}" class="btn-default report-availability">
                <span>{{ __('default.report_availability') }}</span>
                <i class="fa fa-spin fa-refresh" style="display: none"></i>
            </p>
        @else
            <p data-success="{{ __('default.added') }}" data-add="{{ __('default.to_cart') }}" data-id="{{ $item->id }}"
               class="btn-default addtocarts">
                <span>{{ __('default.to_cart') }}</span>
                <i class="fa fa-spin fa-refresh" style="display: none"></i>
            </p>
        @endif
    </form>
</a>
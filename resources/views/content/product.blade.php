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
    $product = App\Model\Shop\Product::where('page_id', $it->id)->with('images', 'options')->first();
    $options = $product->options->groupBy('name')->toArray();
    //var_dump($options); die;
@endphp
<section class="content item">
	<div class="container">
        @isset($product)
            <div class="article-row row">
                <div class="col-sm-4">
                    <div id="isync1" class="  owl-carousel owl-theme">
                        <div class="product-item"><img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-300x300.png" class="attachment-medium size-medium" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-300x300.png 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-150x150.png 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-768x768.png 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-1024x1024.png 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-47x47.png 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-140x140.png 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-100x100.png 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-600x600.png 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png 1280w" sizes="(max-width: 300px) 100vw, 300px" /></div><div class="product-item"><img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-300x300.jpg" class="attachment-medium size-medium" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1.jpg 1280w" sizes="(max-width: 300px) 100vw, 300px" /></div><div class="product-item"><img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-300x300.jpg" class="attachment-medium size-medium" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1.jpg 1280w" sizes="(max-width: 300px) 100vw, 300px" /></div><div class="product-item"><img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-300x300.jpg" class="attachment-medium size-medium" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1.jpg 1280w" sizes="(max-width: 300px) 100vw, 300px" /></div>
                    </div>
                    <div id="isync2" class="visible-md owl-carousel owl-theme">
                        <div class="product-item"><img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-47x47.png" class="attachment-i47 size-i47" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-47x47.png 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-150x150.png 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-300x300.png 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-768x768.png 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-1024x1024.png 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-140x140.png 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-100x100.png 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-600x600.png 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png 1280w" sizes="(max-width: 47px) 100vw, 47px" /></div><div class="product-item"><img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-47x47.jpg" class="attachment-i47 size-i47" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1.jpg 1280w" sizes="(max-width: 47px) 100vw, 47px" /></div><div class="product-item"><img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-47x47.jpg" class="attachment-i47 size-i47" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1.jpg 1280w" sizes="(max-width: 47px) 100vw, 47px" /></div><div class="product-item"><img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-47x47.jpg" class="attachment-i47 size-i47" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1.jpg 1280w" sizes="(max-width: 47px) 100vw, 47px" /></div></div>
                </div>
                <div class="col-sm-8">
                    <div class="article-text">
                        <h1>{{$product->title}}</h1>
                        <div class="tag tag-order">{{$options['status'][0]['value']}}</div>

                        <div class="tag tag-waranty" >{{$options['warranty'][0]['value']}}</div>



                        <div class="single-product-price">
                            <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;</span>{{ number_format($product->price, 2, '.', '') }}</span>
                        </div>
                        <form class="related-form ">
	<span class="input-number ">
        <input type="text" name="count" value="1" class="form-control form-number count"/>
        <div class="btn-count btn-count-plus"><i class="fa fa-plus"></i></div>
        <div class="btn-count btn-count-minus"><i class="fa fa-minus"></i></div>
    </span>
                            <a data-success="Добавлено!" rel="nofollow" href="#" data-quantity="1" data-product_id="4652" data-product_sku="dm_16ua" class="btn-default addtocarts ">Add to cart <i class="fa fa-spin fa-refresh"></i></a>
                        </form>
                        <div class='tag tag-payback'>{{$options['recoupment'][0]['value']}}</div>
                        <div class="single-product-tabs">
                            <div class="product-tab-links">
                                <a href="" class="active" data-target="#description" data-wpel-link="internal">Description</a>
                                <a href="" class="" data-target="#details"><span class="hidden-xxs">Characteristics</span><span class="visible-xxs">Characteristics</span></a>
                            </div>
                            <div class="tabs-field">
                                <div id="description">
                                    {{$product->description}}
                                </div>
                                <div id="details"><table class="shop_attributes">
                                        @foreach($options['charact'] as $charact)
                                            <tr>
                                                <th>{{$charact['title']}}</th>
                                                <td><p>{{$charact['value']}}</p>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div id="video">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endisset
	</div>
</section>


</main>
@endsection
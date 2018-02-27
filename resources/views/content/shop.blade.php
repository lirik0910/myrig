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
        <section class="content item items">
            <div class="container">
                <!--<div class="col-sm-4">&nbsp;</div>
                <div class="col-sm-8"> -->
                <!--</div>-->
                <div class="clearfix" style="clear: both"></div>


                <div class="article-row row">
                    <div class="col-sm-4">
                        <div class="slider-tag">
                        </div>
                        <div class="itemSlider owl-carousel owl-theme">
                            <div class="product-item active"><img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-300x300.png" class="attachment-medium size-medium" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-300x300.png 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-150x150.png 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-768x768.png 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-1024x1024.png 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-47x47.png 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-140x140.png 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-100x100.png 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-600x600.png 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png 1280w" sizes="(max-width: 300px) 100vw, 300px" /></div><div class="product-item "><img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-300x300.jpg" class="attachment-medium size-medium" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1.jpg 1280w" sizes="(max-width: 300px) 100vw, 300px" /></div><div class="product-item "><img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-300x300.jpg" class="attachment-medium size-medium" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1.jpg 1280w" sizes="(max-width: 300px) 100vw, 300px" /></div><div class="product-item "><img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-300x300.jpg" class="attachment-medium size-medium" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1.jpg 1280w" sizes="(max-width: 300px) 100vw, 300px" /></div>
                        </div>
                        <div class="itemSliderVer visible-md">
                            <div class="product-item active"><img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-47x47.png" class="attachment-i47 size-i47" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-47x47.png 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-150x150.png 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-300x300.png 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-768x768.png 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-1024x1024.png 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-140x140.png 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-100x100.png 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-600x600.png 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png 1280w" sizes="(max-width: 47px) 100vw, 47px" /></div><div class="product-item "><img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-47x47.jpg" class="attachment-i47 size-i47" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1.jpg 1280w" sizes="(max-width: 47px) 100vw, 47px" /></div><div class="product-item "><img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-47x47.jpg" class="attachment-i47 size-i47" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1.jpg 1280w" sizes="(max-width: 47px) 100vw, 47px" /></div><div class="product-item "><img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-47x47.jpg" class="attachment-i47 size-i47" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1.jpg 1280w" sizes="(max-width: 47px) 100vw, 47px" /></div>        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="article-text">
                            <h2><a href="https://myrig.com.ua/product/dragonmint-16-th-s-2/" data-wpel-link="internal">DRAGONMINT T1 16TH/s</a></h2>
                            <div class="tag tag-order">Предзаказ</div>

                            <div class="tag tag-waranty" >Расширенная гарантия 180 дней</div>
                            <div><ul>
                                    <li>Количество ограничено!</li>
                                    <li>Отгрузка с завода в Китае 20 апреля &#8212; 10 мая.</li>
                                    <li>100% предоплата в BTC!</li>
                                    <li>Окончательную стоимость уточняйте у менеджера!</li>
                                    <li>Гарантийное обслуживание: 1-5 дня</li>
                                    <li>Локальная доставка по Украине</li>
                                </ul>
                            </div>


                            <div class="single-product-price">
                                <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;</span>2810.00</span>					            <span class="table-bitcoin">0.2433<i class="fa fa-bitcoin"></i></span></div>

                            <form class="related-form ">
	<span class="input-number ">
        <input type="text" name="count" value="1" class="form-control form-number count"/>
        <div class="btn-count btn-count-plus"><i class="fa fa-plus"></i></div>
        <div class="btn-count btn-count-minus"><i class="fa fa-minus"></i></div>
    </span>
                                <a data-success="Добавлено!" rel="nofollow" href="#" data-quantity="1" data-product_id="4652" data-product_sku="DM_16ua" class="btn-default addtocarts ">В корзину <i class="fa fa-spin fa-refresh"></i></a>
                            </form>
                            <div class='tag tag-payback'>Окупаемость 185 дней</div>        </div>
                    </div>
                </div>



                <div class="article-row row">
                    <div class="col-sm-4">
                        <div class="slider-tag">
                        </div>
                        <div class="itemSlider owl-carousel owl-theme">
                            <div class="product-item active"><img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51-300x300.jpg" class="attachment-medium size-medium" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51.jpg 1280w" sizes="(max-width: 300px) 100vw, 300px" /></div><div class="product-item "><img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10-300x300.jpg" class="attachment-medium size-medium" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10.jpg 1280w" sizes="(max-width: 300px) 100vw, 300px" /></div><div class="product-item "><img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13-300x300.jpg" class="attachment-medium size-medium" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13.jpg 1280w" sizes="(max-width: 300px) 100vw, 300px" /></div><div class="product-item "><img width="300" height="191" src="https://myrig.com.ua/wp-content/uploads/2017/12/DSC00913-1-300x191.jpg" class="attachment-medium size-medium" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2017/12/DSC00913-1.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2017/12/DSC00913-1.jpg" data-large_image_width="1000" data-large_image_height="638" srcset="https://myrig.com.ua/wp-content/uploads/2017/12/DSC00913-1-300x191.jpg 300w, https://myrig.com.ua/wp-content/uploads/2017/12/DSC00913-1-768x490.jpg 768w, https://myrig.com.ua/wp-content/uploads/2017/12/DSC00913-1-47x30.jpg 47w, https://myrig.com.ua/wp-content/uploads/2017/12/DSC00913-1-190x121.jpg 190w, https://myrig.com.ua/wp-content/uploads/2017/12/DSC00913-1.jpg 1000w" sizes="(max-width: 300px) 100vw, 300px" /></div>
                        </div>
                        <div class="itemSliderVer visible-md">
                            <div class="product-item active"><img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51-47x47.jpg" class="attachment-i47 size-i47" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_12-40-51.jpg 1280w" sizes="(max-width: 47px) 100vw, 47px" /></div><div class="product-item "><img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10-47x47.jpg" class="attachment-i47 size-i47" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-10.jpg 1280w" sizes="(max-width: 47px) 100vw, 47px" /></div><div class="product-item "><img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13-47x47.jpg" class="attachment-i47 size-i47" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2017/12/photo_2017-12-22_13-30-13.jpg 1280w" sizes="(max-width: 47px) 100vw, 47px" /></div><div class="product-item "><img width="47" height="30" src="https://myrig.com.ua/wp-content/uploads/2017/12/DSC00913-1-47x30.jpg" class="attachment-i47 size-i47" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2017/12/DSC00913-1.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2017/12/DSC00913-1.jpg" data-large_image_width="1000" data-large_image_height="638" srcset="https://myrig.com.ua/wp-content/uploads/2017/12/DSC00913-1-47x30.jpg 47w, https://myrig.com.ua/wp-content/uploads/2017/12/DSC00913-1-300x191.jpg 300w, https://myrig.com.ua/wp-content/uploads/2017/12/DSC00913-1-768x490.jpg 768w, https://myrig.com.ua/wp-content/uploads/2017/12/DSC00913-1-190x121.jpg 190w, https://myrig.com.ua/wp-content/uploads/2017/12/DSC00913-1.jpg 1000w" sizes="(max-width: 47px) 100vw, 47px" /></div>        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="article-text">
                            <h2><a href="https://myrig.com.ua/product/antminer-d3-19-3gh-s/" data-wpel-link="internal">ANTMINER D3 19.3GH/s</a></h2>
                            <div class="tag tag-check">В наличии</div>

                            <div class="tag tag-waranty" >Расширенная гарантия 180 дней</div>
                            <div><ul>
                                    <li>Количество ограничено!</li>
                                    <li>Отгрузка с завода в Китае 21-30 ноября.</li>
                                    <li>100% предоплата в BTC!</li>
                                    <li>Окончательную стоимость уточняйте у менеджера!</li>
                                    <li>Замена по гарантии: 1-3 дня</li>
                                    <li>Локальная доставка по России</li>
                                </ul>
                            </div>


                            <div class="single-product-price">
                                <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;</span>1500.00</span>					            <span class="table-bitcoin">0.1299<i class="fa fa-bitcoin"></i></span></div>

                            <form class="related-form ">
	<span class="input-number ">
        <input type="text" name="count" value="1" class="form-control form-number count"/>
        <div class="btn-count btn-count-plus"><i class="fa fa-plus"></i></div>
        <div class="btn-count btn-count-minus"><i class="fa fa-minus"></i></div>
    </span>
                                <a data-success="Добавлено!" rel="nofollow" href="#" data-quantity="1" data-product_id="5251" data-product_sku="d3_19ua" class="btn-default addtocarts ">В корзину <i class="fa fa-spin fa-refresh"></i></a>
                            </form>
                        </div>
                    </div>
                </div>



                <div class="article-row row">
                    <div class="col-sm-4">
                        <div class="slider-tag">
                        </div>
                        <div class="itemSlider owl-carousel owl-theme">
                            <div class="product-item active"><img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476-300x300.png" class="attachment-medium size-medium" alt="Antminer S9\T9_1" title="" data-src="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476.png" data-large_image="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476.png" data-large_image_width="2000" data-large_image_height="2000" srcset="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476-300x300.png 300w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476-150x150.png 150w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476-768x768.png 768w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476-1024x1024.png 1024w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476-47x47.png 47w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476-140x140.png 140w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476-100x100.png 100w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476-600x600.png 600w" sizes="(max-width: 300px) 100vw, 300px" /></div><div class="product-item "><img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-300x300.png" class="attachment-medium size-medium" alt="Antminer S9\T9_3" title="" data-src="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-e1512655412296.png" data-large_image="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-e1512655412296.png" data-large_image_width="1500" data-large_image_height="1500" srcset="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-300x300.png 300w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-150x150.png 150w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-768x768.png 768w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-1024x1024.png 1024w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-47x47.png 47w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-140x140.png 140w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-100x100.png 100w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-600x600.png 600w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-e1512655412296.png 1500w" sizes="(max-width: 300px) 100vw, 300px" /></div><div class="product-item "><img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-300x300.png" class="attachment-medium size-medium" alt="Antminer S9_2" title="" data-src="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-e1512655351132.png" data-large_image="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-e1512655351132.png" data-large_image_width="1500" data-large_image_height="1500" srcset="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-300x300.png 300w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-150x150.png 150w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-768x768.png 768w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-1024x1024.png 1024w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-47x47.png 47w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-140x140.png 140w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-100x100.png 100w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-600x600.png 600w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-e1512655351132.png 1500w" sizes="(max-width: 300px) 100vw, 300px" /></div><div class="product-item "><img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-300x300.png" class="attachment-medium size-medium" alt="Antminer S9\T9_4" title="" data-src="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-e1512655422549.png" data-large_image="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-e1512655422549.png" data-large_image_width="1500" data-large_image_height="1500" srcset="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-300x300.png 300w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-150x150.png 150w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-768x768.png 768w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-1024x1024.png 1024w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-47x47.png 47w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-140x140.png 140w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-100x100.png 100w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-600x600.png 600w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-e1512655422549.png 1500w" sizes="(max-width: 300px) 100vw, 300px" /></div>
                        </div>
                        <div class="itemSliderVer visible-md">
                            <div class="product-item active"><img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476-47x47.png" class="attachment-i47 size-i47" alt="Antminer S9\T9_1" title="" data-src="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476.png" data-large_image="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476.png" data-large_image_width="2000" data-large_image_height="2000" srcset="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476-47x47.png 47w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476-150x150.png 150w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476-300x300.png 300w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476-768x768.png 768w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476-1024x1024.png 1024w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476-140x140.png 140w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476-100x100.png 100w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38476-600x600.png 600w" sizes="(max-width: 47px) 100vw, 47px" /></div><div class="product-item "><img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-47x47.png" class="attachment-i47 size-i47" alt="Antminer S9\T9_3" title="" data-src="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-e1512655412296.png" data-large_image="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-e1512655412296.png" data-large_image_width="1500" data-large_image_height="1500" srcset="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-47x47.png 47w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-150x150.png 150w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-300x300.png 300w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-768x768.png 768w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-1024x1024.png 1024w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-140x140.png 140w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-100x100.png 100w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-600x600.png 600w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38467-e1512655412296.png 1500w" sizes="(max-width: 47px) 100vw, 47px" /></div><div class="product-item "><img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-47x47.png" class="attachment-i47 size-i47" alt="Antminer S9_2" title="" data-src="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-e1512655351132.png" data-large_image="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-e1512655351132.png" data-large_image_width="1500" data-large_image_height="1500" srcset="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-47x47.png 47w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-150x150.png 150w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-300x300.png 300w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-768x768.png 768w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-1024x1024.png 1024w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-140x140.png 140w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-100x100.png 100w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-600x600.png 600w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38480-e1512655351132.png 1500w" sizes="(max-width: 47px) 100vw, 47px" /></div><div class="product-item "><img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-47x47.png" class="attachment-i47 size-i47" alt="Antminer S9\T9_4" title="" data-src="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-e1512655422549.png" data-large_image="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-e1512655422549.png" data-large_image_width="1500" data-large_image_height="1500" srcset="https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-47x47.png 47w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-150x150.png 150w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-300x300.png 300w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-768x768.png 768w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-1024x1024.png 1024w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-140x140.png 140w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-100x100.png 100w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-600x600.png 600w, https://myrig.com.ua/wp-content/uploads/2017/09/5DM38460-e1512655422549.png 1500w" sizes="(max-width: 47px) 100vw, 47px" /></div>        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="article-text">
                            <h2><a href="https://myrig.com.ua/product/antminer-s9-14th-s/" data-wpel-link="internal">ANTMINER S9 14TH/s</a></h2>
                            <div class="tag tag-no">Нет в наличии</div>

                            <div class="tag tag-waranty" >Расширенная гарантия 180 дней</div>
                            <div><ul>
                                    <li>Количество ограничено!</li>
                                    <li>100% предоплата в BTC!</li>
                                    <li>Окончательную стоимость уточняйте у менеджера!</li>
                                    <li>Гарантийное обслуживание: 1-3 дня</li>
                                    <li>Локальная доставка по Украине</li>
                                </ul>
                            </div>


                        </div>
                    </div>
                </div>



                <div class="article-row row">
                    <div class="col-sm-4">
                        <div class="slider-tag">
                        </div>
                        <div class="itemSlider owl-carousel owl-theme">
                            <div class="product-item active"><img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1-300x300.png" class="attachment-medium size-medium" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1.png" data-large_image="https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1.png" data-large_image_width="1000" data-large_image_height="1000" srcset="https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1-300x300.png 300w, https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1-150x150.png 150w, https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1-768x768.png 768w, https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1-47x47.png 47w, https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1-140x140.png 140w, https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1-100x100.png 100w, https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1-600x600.png 600w, https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1.png 1000w" sizes="(max-width: 300px) 100vw, 300px" /></div>
                        </div>
                        <div class="itemSliderVer visible-md">
                            <div class="product-item active"><img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1-47x47.png" class="attachment-i47 size-i47" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1.png" data-large_image="https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1.png" data-large_image_width="1000" data-large_image_height="1000" srcset="https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1-47x47.png 47w, https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1-150x150.png 150w, https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1-300x300.png 300w, https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1-768x768.png 768w, https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1-140x140.png 140w, https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1-100x100.png 100w, https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1-600x600.png 600w, https://myrig.com.ua/wp-content/uploads/2017/09/Untitled-2-1.png 1000w" sizes="(max-width: 47px) 100vw, 47px" /></div>        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="article-text">
                            <h2><a href="https://myrig.com.ua/product/antminer-l3-504mh-s-2/" data-wpel-link="internal">ANTMINER L3+ 504MH/s</a></h2>
                            <div class="tag tag-no">Нет в наличии</div>

                            <div class="tag tag-waranty" >Расширенная гарантия 180 дней</div>
                            <div><ul>
                                    <li>Количество ограничено!</li>
                                    <li>100% предоплата в BTC!</li>
                                    <li>Окончательную стоимость уточняйте у менеджера!</li>
                                    <li>Гарантийное обслуживание: 1-3 дня</li>
                                    <li>Локальная доставка по Украине</li>
                                </ul>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="related">
            <div class="container">
                <div class="row">
                    <header>Дополнительное оборудование</header>
                    <div id="relatedSlider" class="owl-carousel owl-theme">
                        <a href="https://myrig.com.ua/product/antrouter-r1/" class="related-item" data-wpel-link="internal">
                            <div class="related-title">AntRouter R1</div>
                            <div class="related-img">
                                <img width="1000" height="1000" src="https://myrig.com.ua/wp-content/uploads/2018/01/R1-e1516020218585.png" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" />    </div>
                            <div class="tag tag-check">В наличии</div>

                            <div class="tag tag-waranty" >Расширенная гарантия 365 дней</div>
                            <BR>
                            <div class="related-price">
                                <div>
                                    <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;</span>65.00</span>		        <span class="table-bitcoin">0.0056<i class="fa fa-bitcoin"></i></span></div>
                                <div class="note"></div>
                                <div class="tag tag-info"></div>
                            </div>
                            <form class="related-form">
    	<span class="input-number ">
	        <input type="text" name="count" value="1" class="form-control form-number count"/>
	        <div class="btn-count btn-count-plus"><i class="fa fa-plus"></i></div>
	        <div class="btn-count btn-count-minus"><i class="fa fa-minus"></i></div>
	    </span>
                                <p data-success="Добавлено!" rel="nofollow"  data-quantity="1" data-product_id="405" data-product_sku="R1" class="btn-default addtocarts ">В корзину <i class="fa fa-spin fa-refresh"></i></p>
                            </form>
                        </a>
                        <a href="https://myrig.com.ua/product/plata-upravlenia-d3-l3/" class="related-item" data-wpel-link="internal">
                            <div class="related-title">Плата управления D3/L3</div>
                            <div class="related-img">
                                <img width="1000" height="1000" src="https://myrig.com.ua/wp-content/uploads/2018/01/Control-S7-e1516020628854.png" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" />    </div>
                            <div class="tag tag-check">В наличии</div>

                            <div class="tag tag-waranty" >Расширенная гарантия 90 дней</div>
                            <BR>
                            <div class="related-price">
                                <div>
                                    <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;</span>130.00</span>		        <span class="table-bitcoin">0.0113<i class="fa fa-bitcoin"></i></span></div>
                                <div class="note"></div>
                                <div class="tag tag-info"></div>
                            </div>
                            <form class="related-form">
    	<span class="input-number ">
	        <input type="text" name="count" value="1" class="form-control form-number count"/>
	        <div class="btn-count btn-count-plus"><i class="fa fa-plus"></i></div>
	        <div class="btn-count btn-count-minus"><i class="fa fa-minus"></i></div>
	    </span>
                                <p data-success="Добавлено!" rel="nofollow"  data-quantity="1" data-product_id="4330" data-product_sku="CNTRL_D3" class="btn-default addtocarts ">В корзину <i class="fa fa-spin fa-refresh"></i></p>
                            </form>
                        </a>
                        <a href="https://myrig.com.ua/product/fan_6000rpm/" class="related-item" data-wpel-link="internal">
                            <div class="related-title">Вентилятор 6000RPM</div>
                            <div class="related-img">
                                <img width="1000" height="1000" src="https://myrig.com.ua/wp-content/uploads/2018/01/Cooler-e1516020575830.png" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" />    </div>
                            <div class="tag tag-no">Нет в наличии</div>

                            <div class="tag tag-waranty" >Расширенная гарантия 90 дней</div>
                            <BR>
                            <div class="related-price">
                                <div>
                                    <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;</span>30.00</span>		        <span class="table-bitcoin">0.0026<i class="fa fa-bitcoin"></i></span></div>
                                <div class="note"></div>
                                <div class="tag tag-info"></div>
                            </div>
                            <form class="related-form">
    	<span class="input-number disabled">
	        <input type="text" name="count" value="1" class="form-control form-number count"/>
	        <div class="btn-count btn-count-plus"><i class="fa fa-plus"></i></div>
	        <div class="btn-count btn-count-minus"><i class="fa fa-minus"></i></div>
	    </span>
                                <p data-success="Добавлено!" rel="nofollow"  data-quantity="1" data-product_id="398" data-product_sku="FAN_6000" class="btn-default addtocarts disabled">В корзину <i class="fa fa-spin fa-refresh"></i></p>
                            </form>
                        </a>
                        <a href="https://myrig.com.ua/product/beagle-bone-s9-t9-r4/" class="related-item" data-wpel-link="internal">
                            <div class="related-title">Beagle Bone S9/T9/R4</div>
                            <div class="related-img">
                                <img width="1000" height="1000" src="https://myrig.com.ua/wp-content/uploads/2018/01/BBB-S9-e1516020714221.png" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" />    </div>
                            <div class="tag tag-check">В наличии</div>

                            <div class="tag tag-waranty" >Расширенная гарантия 90 дней</div>
                            <BR>
                            <div class="related-price">
                                <div>
                                    <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;</span>75.00</span>		        <span class="table-bitcoin">0.0065<i class="fa fa-bitcoin"></i></span></div>
                                <div class="note"></div>
                                <div class="tag tag-info"></div>
                            </div>
                            <form class="related-form">
    	<span class="input-number ">
	        <input type="text" name="count" value="1" class="form-control form-number count"/>
	        <div class="btn-count btn-count-plus"><i class="fa fa-plus"></i></div>
	        <div class="btn-count btn-count-minus"><i class="fa fa-minus"></i></div>
	    </span>
                                <p data-success="Добавлено!" rel="nofollow"  data-quantity="1" data-product_id="400" data-product_sku="BB_S9" class="btn-default addtocarts ">В корзину <i class="fa fa-spin fa-refresh"></i></p>
                            </form>
                        </a>
                        <a href="https://myrig.com.ua/product/data_18pin/" class="related-item" data-wpel-link="internal">
                            <div class="related-title">Дата кабель 18 pin</div>
                            <div class="related-img">
                                <img width="1000" height="1000" src="https://myrig.com.ua/wp-content/uploads/2018/01/Data-e1516020435921.png" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" />    </div>
                            <div class="tag tag-check">В наличии</div>

                            <div class="tag tag-waranty" >Расширенная гарантия 90 дней</div>
                            <BR>
                            <div class="related-price">
                                <div>
                                    <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;</span>4.00</span>		        <span class="table-bitcoin">0.0003<i class="fa fa-bitcoin"></i></span></div>
                                <div class="note"></div>
                                <div class="tag tag-info"></div>
                            </div>
                            <form class="related-form">
    	<span class="input-number ">
	        <input type="text" name="count" value="1" class="form-control form-number count"/>
	        <div class="btn-count btn-count-plus"><i class="fa fa-plus"></i></div>
	        <div class="btn-count btn-count-minus"><i class="fa fa-minus"></i></div>
	    </span>
                                <p data-success="Добавлено!" rel="nofollow"  data-quantity="1" data-product_id="803" data-product_sku="DATA_18PIN" class="btn-default addtocarts ">В корзину <i class="fa fa-spin fa-refresh"></i></p>
                            </form>
                        </a>
                        <a href="https://myrig.com.ua/product/plata-upravleniya-s5-s7/" class="related-item" data-wpel-link="internal">
                            <div class="related-title">Плата управления S5/S7</div>
                            <div class="related-img">
                                <img width="1000" height="1000" src="https://myrig.com.ua/wp-content/uploads/2018/01/Control-S7-e1516020628854.png" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" />    </div>
                            <div class="tag tag-check">В наличии</div>

                            <div class="tag tag-waranty" >Расширенная гарантия 90 дней</div>
                            <BR>
                            <div class="related-price">
                                <div>
                                    <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;</span>35.00</span>		        <span class="table-bitcoin">0.003<i class="fa fa-bitcoin"></i></span></div>
                                <div class="note"></div>
                                <div class="tag tag-info"></div>
                            </div>
                            <form class="related-form">
    	<span class="input-number ">
	        <input type="text" name="count" value="1" class="form-control form-number count"/>
	        <div class="btn-count btn-count-plus"><i class="fa fa-plus"></i></div>
	        <div class="btn-count btn-count-minus"><i class="fa fa-minus"></i></div>
	    </span>
                                <p data-success="Добавлено!" rel="nofollow"  data-quantity="1" data-product_id="401" data-product_sku="CNTRL_S7" class="btn-default addtocarts ">В корзину <i class="fa fa-spin fa-refresh"></i></p>
                            </form>
                        </a>
                        <a href="https://myrig.com.ua/product/plata-upravleniya-s9-t9-r4/" class="related-item" data-wpel-link="internal">
                            <div class="related-title">Плата управления S9/T9/R4</div>
                            <div class="related-img">
                                <img width="1000" height="1000" src="https://myrig.com.ua/wp-content/uploads/2018/01/Control-S9-e1516020603169.png" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" />    </div>
                            <div class="tag tag-check">В наличии</div>

                            <div class="tag tag-waranty" >Расширенная гарантия 90 дней</div>
                            <BR>
                            <div class="related-price">
                                <div>
                                    <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;</span>50.00</span>		        <span class="table-bitcoin">0.0043<i class="fa fa-bitcoin"></i></span></div>
                                <div class="note"></div>
                                <div class="tag tag-info"></div>
                            </div>
                            <form class="related-form">
    	<span class="input-number ">
	        <input type="text" name="count" value="1" class="form-control form-number count"/>
	        <div class="btn-count btn-count-plus"><i class="fa fa-plus"></i></div>
	        <div class="btn-count btn-count-minus"><i class="fa fa-minus"></i></div>
	    </span>
                                <p data-success="Добавлено!" rel="nofollow"  data-quantity="1" data-product_id="685" data-product_sku="CNTRL_R4" class="btn-default addtocarts ">В корзину <i class="fa fa-spin fa-refresh"></i></p>
                            </form>
                        </a>
                        <a href="https://myrig.com.ua/product/beagle-s5-s7/" class="related-item" data-wpel-link="internal">
                            <div class="related-title">Beagle Bone S5/S7</div>
                            <div class="related-img">
                                <img width="2000" height="2000" src="https://myrig.com.ua/wp-content/uploads/2017/09/Plati2587.png" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="BBB_S5\S7" srcset="https://myrig.com.ua/wp-content/uploads/2017/09/Plati2587.png 2000w, https://myrig.com.ua/wp-content/uploads/2017/09/Plati2587-150x150.png 150w, https://myrig.com.ua/wp-content/uploads/2017/09/Plati2587-300x300.png 300w, https://myrig.com.ua/wp-content/uploads/2017/09/Plati2587-768x768.png 768w, https://myrig.com.ua/wp-content/uploads/2017/09/Plati2587-1024x1024.png 1024w, https://myrig.com.ua/wp-content/uploads/2017/09/Plati2587-47x47.png 47w, https://myrig.com.ua/wp-content/uploads/2017/09/Plati2587-140x140.png 140w, https://myrig.com.ua/wp-content/uploads/2017/09/Plati2587-100x100.png 100w, https://myrig.com.ua/wp-content/uploads/2017/09/Plati2587-600x600.png 600w" sizes="(max-width: 2000px) 100vw, 2000px" />    </div>
                            <div class="tag tag-no">Нет в наличии</div>

                            <div class="tag tag-waranty" >Расширенная гарантия 90 дней</div>
                            <BR>
                            <div class="related-price">
                                <div>
                                    <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;</span>60.00</span>		        <span class="table-bitcoin">0.0052<i class="fa fa-bitcoin"></i></span></div>
                                <div class="note"></div>
                                <div class="tag tag-info"></div>
                            </div>
                            <form class="related-form">
    	<span class="input-number disabled">
	        <input type="text" name="count" value="1" class="form-control form-number count"/>
	        <div class="btn-count btn-count-plus"><i class="fa fa-plus"></i></div>
	        <div class="btn-count btn-count-minus"><i class="fa fa-minus"></i></div>
	    </span>
                                <p data-success="Добавлено!" rel="nofollow"  data-quantity="1" data-product_id="399" data-product_sku="BB_S7" class="btn-default addtocarts disabled">В корзину <i class="fa fa-spin fa-refresh"></i></p>
                            </form>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
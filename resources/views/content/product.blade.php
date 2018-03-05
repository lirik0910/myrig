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
        <section class="content item">
            <div class="container">
                <div class="article-row row">
                    <div class="col-sm-4">
                        <div id="isync1" class="  owl-carousel owl-theme">
                            @foreach($options['images'] as $image)
                                <div class="product-item @if($loop->first) active @endif">
                                    <img width="300" height="300" src="{{asset($image->value)}}" class="attachment-medium size-medium" alt="" title="" data-src="{{asset($image->value)}}" data-large_image="{{asset($image->value)}}" data-large_image_width="1280" data-large_image_height="1280" sizes="(max-width: 300px) 100vw, 300px" />
                                </div>
                            @endforeach
                            <!--<div class="product-item"><img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-300x300.png" class="attachment-medium size-medium" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-300x300.png 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-150x150.png 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-768x768.png 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-1024x1024.png 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-47x47.png 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-140x140.png 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-100x100.png 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-600x600.png 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png 1280w" sizes="(max-width: 300px) 100vw, 300px" /></div><div class="product-item"><img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-300x300.jpg" class="attachment-medium size-medium" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1.jpg 1280w" sizes="(max-width: 300px) 100vw, 300px" /></div><div class="product-item"><img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-300x300.jpg" class="attachment-medium size-medium" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1.jpg 1280w" sizes="(max-width: 300px) 100vw, 300px" /></div><div class="product-item"><img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-300x300.jpg" class="attachment-medium size-medium" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1.jpg 1280w" sizes="(max-width: 300px) 100vw, 300px" /></div>-->
                        </div>
                        <div id="isync2" class="visible-md owl-carousel owl-theme">
                            @foreach($options['images'] as $image)
                                <div class="product-item @if($loop->first) active @endif">
                                    <img width="300" height="300" src="{{asset($image->value)}}" class="attachment-medium size-medium" alt="" title="" data-src="{{asset($image->value)}}" data-large_image="{{asset($image->value)}}" data-large_image_width="1280" data-large_image_height="1280" sizes="(max-width: 300px) 100vw, 300px" />
                                </div>
                            @endforeach
                            <!--<div class="product-item"><img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-47x47.png" class="attachment-i47 size-i47" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-47x47.png 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-150x150.png 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-300x300.png 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-768x768.png 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-1024x1024.png 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-140x140.png 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-100x100.png 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-600x600.png 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png 1280w" sizes="(max-width: 47px) 100vw, 47px" /></div><div class="product-item"><img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-47x47.jpg" class="attachment-i47 size-i47" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1.jpg 1280w" sizes="(max-width: 47px) 100vw, 47px" /></div><div class="product-item"><img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-47x47.jpg" class="attachment-i47 size-i47" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1.jpg 1280w" sizes="(max-width: 47px) 100vw, 47px" /></div><div class="product-item"><img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-47x47.jpg" class="attachment-i47 size-i47" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1.jpg" data-large_image_width="1280" data-large_image_height="1280" srcset="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-47x47.jpg 47w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-150x150.jpg 150w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-300x300.jpg 300w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-768x768.jpg 768w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-1024x1024.jpg 1024w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-140x140.jpg 140w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-100x100.jpg 100w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-600x600.jpg 600w, https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1.jpg 1280w" sizes="(max-width: 47px) 100vw, 47px" /></div></div>-->
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="article-text">
                            <h1>{{$product->title}}</h1>
                            <div class="tag tag-order">Предзаказ</div>

                            <div class="tag tag-waranty" >{{$options['warranty']->value}}</div>



                            <div class="single-product-price">
                                <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;</span>{{$product->price . '.00'}}</span>
                            </div>
                            <form class="related-form ">
	<span class="input-number ">
        <input type="text" name="count" value="1" class="form-control form-number count"/>
        <div class="btn-count btn-count-plus"><i class="fa fa-plus"></i></div>
        <div class="btn-count btn-count-minus"><i class="fa fa-minus"></i></div>
    </span>
                                <a data-success="Добавлено!" rel="nofollow" href="#" data-quantity="1" data-product_id="4652" data-product_sku="DM_16ua" class="btn-default addtocarts ">В корзину <i class="fa fa-spin fa-refresh"></i></a>
                            </form>
                            <div class='tag tag-payback'>Окупаемость 218 дней</div>
                            <div class="single-product-tabs">
                                <div class="product-tab-links">
                                    <a href="" class="active" data-target="#description" data-wpel-link="internal">Описание</a>
                                    <a href="" class="" data-target="#details"><span class="hidden-xxs">Характеристики</span><span class="visible-xxs">Характер-ки</span></a>
                                </div>
                                <div class="tabs-field">
                                    <div id="description">
                                        {{$product->description}}
                                        <!--<p>DragonMint 16TH/s – последняя новинка на рынке оборудования для добычи Bitcoin, созданная компанией Halong Mining. Исходя из заявленных характеристик, более эффективного майнера SHA-256 на сегодняшний день не существует.</p>
                                        <p>Основная «изюминка» конструкции майнера – это чипы DM8575 . Именно они обеспечивают высокий хешрейт и энергоэффективность устройства, которая равна 0,075J/GH. DragonMint оснащен двумя вентиляторами, обеспечивающими нормальную работоспособность при температурах от 0 до +25.</p>
                                        <p>Над созданием данного майнера на протяжении года трудилось множество экспертов (одни занимались разработкой программного обеспечения, другие – аппаратного обеспечения, третьи – проектировали чипы). При этом была проведена огромная исследовательская работа. В результате, Halong Mining все-таки удалось выпустить уникальный продукт – DragonMint 16TH/s, обладающий великолепными техническими и эксплуатационными характеристиками.</p>-->
                                    </div>
                                    <div id="details">
                                        <table class="shop_attributes">
                                            @foreach($options['characteristics'] as $characteristic)
                                                <tr>
                                                    <th>{{$characteristic->name}}</th>
                                                    <td><p>{{$characteristic->value}}</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <!--<tr>
                                                <th>Энергопотребление</th>
                                                <td><p>1432Вт</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Энергоэффективность</th>
                                                <td><p>0.075 Дж/Гх</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Кол-во чипов</th>
                                                <td><p>189*DM8575</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Номинальное напряжение</th>
                                                <td><p>11.6 ~ 13В</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Охлаждение</th>
                                                <td><p>2 вентилятора: 6000 об/м</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Размеры</th>
                                                <td><p>340 x 125 x 155 мм</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Вес</th>
                                                <td><p>6 кг</p>
                                                </td>
                                            </tr>-->
                                        </table>
                                    </div>
                                    <div id="video">
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
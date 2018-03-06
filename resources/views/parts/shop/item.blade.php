<div class="article-row row">
	<div class="col-sm-4">
		<div class="slider-tag"></div>

		<!-- Slider for mobile version -->
		<div class="itemSlider owl-carousel owl-theme">
			<div class="product-item active">
				<img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-300x300.png" class="attachment-medium size-medium" alt="" title="" />
			</div>

			<div class="product-item ">
				<img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-300x300.jpg" class="attachment-medium size-medium" alt="" title="" />
			</div>

			<div class="product-item ">
				<img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-300x300.jpg" class="attachment-medium size-medium" alt="" title="" />
			</div>

			<div class="product-item ">
				<img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-300x300.jpg" class="attachment-medium size-medium" alt="" title="" />
			</div> 
		</div>

		<!-- Slider for desctop version -->
		<div class="itemSliderVer visible-md">
			<div class="product-item active">
				<img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-47x47.png" class="attachment-i47 size-i47" alt="" title="" />
			</div>

			<div class="product-item ">
				<img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-47x47.jpg" class="attachment-i47 size-i47" alt="" title="" />
			</div>

			<div class="product-item ">
				<img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_4-1-47x47.jpg" class="attachment-i47 size-i47" alt="" title="" />
			</div>

			<div class="product-item ">
				<img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_1-1-47x47.jpg" class="attachment-i47 size-i47" alt="" title="" />
			</div>
		</div>
	</div>

	<div class="col-sm-8">
		<div class="article-text">
			<h2>
				<a href="{{ $item->page ? asset($item->page->link) : '' }}" data-wpel-link="internal">
					{{ $item->title }}
				</a>
			</h2>
			
			<div class="tag tag-order">Предзаказ</div>
			<div class="tag tag-waranty" >Расширенная гарантия 180 дней</div>

			<div>
				<ul>
					<li>Количество ограничено!</li>
					<li>Отгрузка с завода в Китае 20 апреля &#8212; 10 мая.</li>
					<li>100% предоплата в BTC!</li>
					<li>Окончательную стоимость уточняйте у менеджера!</li>
					<li>Гарантийное обслуживание: 1-5 дня</li>
					<li>Локальная доставка по Украине</li>
				</ul>
			</div>

			<div class="single-product-price">
				<span class="woocommerce-Price-amount amount">
					<span class="woocommerce-Price-currencySymbol">&#36;</span>2810.00
				</span>

				<span class="table-bitcoin">0.2485
					<i class="fa fa-bitcoin"></i>
				</span>
			</div>

			<form class="related-form ">
				<span class="input-number ">
					<input type="text" name="count" value="1" class="form-control form-number count"/>
					
					<div class="btn-count btn-count-plus">
						<i class="fa fa-plus"></i>
					</div>

					<div class="btn-count btn-count-minus">
						<i class="fa fa-minus"></i>
					</div>
				</span>

				<a data-success="Добавлено!" rel="nofollow" href="#" data-quantity="1" data-product_id="4652" data-product_sku="DM_16ua" class="btn-default addtocarts ">В корзину <i class="fa fa-spin fa-refresh"></i></a>
			</form>
			
			<div class='tag tag-payback'>Окупаемость 201 день</div>
		</div>
	</div>
</div>
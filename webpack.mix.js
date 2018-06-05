let mix = require('laravel-mix');

mix.js('resources/assets/front/pages/index/index.js', 'public/js')
	.js('resources/assets/front/pages/shop/index.js', 'public/js/shop.js')
	.js('resources/assets/front/pages/product/index.js', 'public/js/product.js')
	.js('resources/assets/front/pages/cart/index.js', 'public/js/cart.js')
	.js('resources/assets/front/pages/checkout/index.js', 'public/js/checkout.js')
	.js('resources/assets/front/pages/news/index.js', 'public/js/news.js')
	.js('resources/assets/front/pages/article/index.js', 'public/js/article.js')
	.autoload({
		jquery: [
			'$', 
			'window.jQuery', 
			'jQuery'
		]
	});

mix.sass('resources/assets/front/pages/critical.scss', 'public/css/critical.css')
	.sass('resources/assets/front/pages/index/styles.scss', 'public/css/index.css')
	.sass('resources/assets/front/pages/shop/styles.scss', 'public/css/shop.css')
	.sass('resources/assets/front/pages/product/styles.scss', 'public/css/product.css')
	.sass('resources/assets/front/pages/cart/styles.scss', 'public/css/cart.css')
	.sass('resources/assets/front/pages/checkout/styles.scss', 'public/css/checkout.css')
	.sass('resources/assets/front/pages/news/styles.scss', 'public/css/news.css')
	.sass('resources/assets/front/pages/article/styles.scss', 'public/css/article.css');
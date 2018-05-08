 /**
 * Created by Ann on 12.02.2017.
 */
 
var click = false;
jQuery(document).ready(function ($) {

	var width = $(window).width(),
		cont = $('.container').outerWidth();

	var margin = (width - cont) / 2;
	console.log(margin);
	console.log(cont);
/*    if($('#mapField').attr('data-lat')){
        margin = margin - 21;
    }*/
	wM = cont * 33.333333 / 100 + margin;
console.log(wM);
	if (width > 767) {
		$('.main-back').css('left', wM +'px');
	}

	else $('.main-back').css('left', '0px');
	
	/**
	 * Get cart session
	 */
	$.get(window.global.app.connector +'/cart', function (data)  {
		var i;
		var	r;
		var	s = [];

		if (data === '' || data === null) {
			sessionStorage['cart'] = JSON.stringify(s);
		}

		else {
			if (typeof data === 'string') {
				r = JSON.parse(data);
			}
			else {
				r = data;
			}
				
			for (i in r) {
				s.push({id: i, count: r[i]});
			}

			sessionStorage['cart'] = JSON.stringify(s);
		}
	});

	$('#cart-form').on('submit', function(e) {
		e.preventDefault();
	});

	/**
	 * Delete item from cart
	 */
	$( '#cart-form .remove').click(function(e) {
		e.preventDefault();
		e.stopPropagation();
		
		if (click === false) {
			click = true;

			var id = e.currentTarget.dataset['id'],
				input,
				cart,
				i;

			if (id) {
				input = $('#count-products-'+ id);
				var session = sessionStorage['cart'];

				if (input && session) {
					session = JSON.parse(session);

					for (i = 0; i < session.length; i++) {
						if (Number(session[i].id) === Number(id)) {
							id = Number(session[i].id);
							session.splice(i, 1);
							break;
						}
					}

					$.ajax({
						url: window.global.app.connector +'/cart',
						type: 'DELETE',
						data: {
							id: id,
							_token: window.global.app.csrf
						},
						success: function(r) {
							sessionStorage['cart'] = JSON.stringify(session);
							$('#cart-line-item-'+ id).remove();
							click = false;

							countProducts(session);
						}
					});
				}
			}
		}	
	});
	
	$('body').on('click','.disabled',function(e){
		e.preventDefault;
		e.stopPropagation();
	});
	
	   $('#billing_country').change(function(){
		$( document.body ).trigger( 'update_checkout' );
	})
	
	/*	intlTelInput
	=====================================
  */
 
	$('.billing_phone-reg0').intlTelInput({
		//onlyCountries: ["ru", "ua", "by", "kz"],
		initialCountry: "auto",
		  geoIpLookup: function(callback) {
			$.get('http://ipinfo.io', function() {}, "jsonp").always(function(resp) {
			  var countryCode = (resp && resp.country) ? resp.country : "";
			  callback(countryCode);
			});
		  },
		  
	})
	$('.billing_phone-reg').on("countrychange", function(e, countryData) {
			$(this).val(countryData.dialCode) 
		});
		
	 $(window).on('load resize',function(){
		var hfooter=$('.footer').height();
		var hw=$(window).height();
		$('main').css('minHeight',hw-hfooter+'px');
	 });
	var main=$('.main-slider');
	$('#mainSlider').owlCarousel({
		items: 1,
		slideSpeed: 4000,
		smartSpeed:1000,
		nav: false,
		dots: true,
		loop: true,
		autoplay:4000,
		//onInitialized:stopAuto,
	   dotsData:true,
		animateOut: 'fadeOut',
	   animateIn: 'fadeIn'
	});
	$('.single-slider').owlCarousel({
		items: 1,
		slideSpeed: 4000,
		smartSpeed:1000,
		nav: false,
		dots: true,
		loop: true,
		autoplay:4000,
		dotsData:true
	});
	main.each(function(index) {
		$(this).find('.owl-nav, .owl-dots').wrapAll("<div class='container'></div>");
	});
	 var ms=jQuery.makeArray($('.owl-dot'));  
	/*function stopAuto(event){
		  var ms=jQuery.makeArray($('.owl-dot'));
		for(var i=0;i<ms.length;i++){
			console.log(i);	
			window.setTimeout(function(){
				main.trigger('next.owl.carousel');
			},2000)		
		//main.trigger('next.owl.carousel',[4000]);/
		}
	}*/
   
	var transit=0;
	main.on('changed.owl.carousel',function(event){
		transit++;    	
		if(transit==ms.length-1){
		main.trigger('stop.owl.autoplay');
		window.clearTimeout();}    	
	});

	var related = $('.related-slider');
    related.on('changed.owl.carousel',function(event){
        transit++;
        if(transit==ms.length-1){
            main.trigger('stop.owl.autoplay');
            window.clearTimeout();}
    });
  

	$('.contacts ul li').on('click',function () {
		$('.contacts ul li').removeClass('active');
		$(this).addClass('active');
	});
	
	$(document).on('click','span:not(.disabled)>.btn-count',function (e) {
		e.preventDefault();
		
		if (click === false) {
			click = true;

			var c=$(this).parent().find('.form-control').val();
			var id = $(this).parent().find('.form-control').data('id');
			
			if($(this).hasClass('btn-count-plus')) {
				c++;
				$(this).parent().find('.form-control').val(c);
			}

			else {
				if(c>1) {
					c--;
					$(this).parent().find('.form-control').val(c);
				}
			}

			if ($(this).hasClass('server')) {
				var cart;
				if (id) {
					input = $('#count-products-'+ id);
					var session = sessionStorage['cart'];

					if (input && session) {
						session = JSON.parse(session);
						cart = {};
						for (i = 0; i < session.length; i++) {
							if (Number(session[i].id) === Number(id)) {
								cart = session[i];
								a = i;
								break;
							}
						}

						cart['id'] = id;
						cart['count'] = Number(input.val());

						if (a === false) {
							session.push(cart);
						}
						else session[a] = cart;

						cart['_token'] = window.global.app.csrf;
						$.post(window.global.app.connector +'/cart', cart, function () {
							sessionStorage['cart'] = JSON.stringify(session);
							countProducts(session);
							click = false;
						});
					}
				}
			}

			else {
				var btn = $('.intocarts[data-id='+ id + ']');
				if (btn.length > 0) {
					btn.removeClass('intocarts');
					btn.addClass('addtocarts');
					btn.find('span').text(btn.data('add'));
				}
				
				$('.count').change()
				$('.cart-form .table-row:first-child  input.qty').change();

				click = false;
			}
		}
	});

	/**
	 * Change input field and update session in the server
	 */
	$('.form-control.form-number.count.add-to-cart-count.server').on('change', (function (e) {
		if (click === false) {
			click = true;

			var cart,
				session = sessionStorage['cart'];

			if (session) {
				session = JSON.parse(session);
				cart = {};
				for (i = 0; i < session.length; i++) {
					if (Number(session[i].id) === Number($(this).data('id'))) {
						cart = session[i];
						a = i;
						break;
					}
				}

				cart['id'] = $(this).data('id');
				cart['count'] = Number($(this).val());

				if (a === false) {
					session.push(cart);
				}
				else session[a] = cart;

				cart['_token'] = window.global.app.csrf;
				$.post(window.global.app.connector +'/cart', cart, function () {
					sessionStorage['cart'] = JSON.stringify(session);
					countProducts(session);
					click = false;
				});
			}
		}
	}));

	$(window).on('resize',function () {
		var width=$(this).width();
		var cont=$('.container').outerWidth();
		var margin=(width-cont)/2;
		var wM=cont*33.33/100+margin;
		if(width>767) {
		   $('.main-back').css('left', wM + 'px');
		}
		else {
			$('.main-back').css('left', '0px');
		}
	});
	$(window).on('load resize',function () {
		/*if($('.item .btn-default').text()=="В корзину"){
			$('.item .btn-default').text('Добавить в корзину');
		}*/
		var width=$(this).width();
		var height=$(this).height();

		//var cont=$('.nav li:nth-child(3)').offset();
		var cont=$('.container').outerWidth();

		var margin=(width-cont)/2;
		var wM=cont*33.33/100+margin;
		if(width>767) {
			var sls=jQuery.makeArray($('.itemSliderVer'));
			for(var i=0;i<sls.length;i++){
				var sh=$(sls[i]).height();
				$(sls[i]).parent().css('minHeight',sh+40+'px');
			}      	
			
			//$('.main-back').css('left', wM + 'px');
			if(width>1249 && height>669 && height<1025) {
				var tarh = height - 76;
				$('.slider').height(tarh);
				//$('.main-slide').height(tarh).css('lineHeight', tarh + 'px');
			}
			else{

			}
		}
		else{
		   // $('.main-back').css('left', '0px');
			if(width<480){
			  //  $('.item .btn-default').text('В корзину');
			}
		}

	});

		$('.navbar-toggle').on('click', function () {
			var width=$(window).width();
			if(width<992) {
				$('body').toggleClass('display-nav');
				$(this).toggleClass('close-btn');
			}
		})        

	$('.dropdown').on('click',function () {
	if($(this).hasClass('open'))
		$(this).removeClass('open');
	else
	$(this).addClass('open');
})

   /* $('.navbar-brand').hover(function () {
		$(this).find('img').attr('src','img/logo2.png');
		   // setTimeout(function(){$(this).find('img').attr('src','img/logo3.png')},100);
			$(this).delay(200).queue(function(next) { $(this).find('img').attr('src','img/logo3.png'); next(); });
	},
	function () {
		$(this).find('img').attr('src','img/logo2.png');
		$(this).delay(200).queue(function(next) { $(this).find('img').attr('src','img/logo.png'); next(); });
	});*/
	$('body').on('click','.reg-links a',function(e){
		e.preventDefault();
		var target=$(this).parent().data('target');
		$('.reg-links a').parent().removeClass('active');
		$(this).parent().addClass('active');
		$('#reg-field,#enter-field').hide();
		$(target).show();
	})
	$('body').on('click','.profile-links div:not(:last-child) a',function(e){
		e.preventDefault();
		var target=$(this).data('target');
		$('.profile-links a').removeClass('active');
		$(this).addClass('active');
		$('#personalF,#historyField').hide();
		$(target).show();
	})
	$('body').on('click','.product-tab-links a',function(e){
		e.preventDefault();
		var target=$(this).data('target');
		$('.product-tab-links a').removeClass('active');
		$(this).addClass('active');
		$('#details,#description,#video').hide();
		$(target).show();
	})
	
	//$('#reg-field .btn-default').on('click',function(){
	//    setTimeout(function(){$('.regsuccess').click();},300);
   // })

	$("a.reg-f, a.reg-c, a.regsuccess , a.ticket, a.report-availability, p.report-availability").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'showCloseButton':false,
		'speedIn'		:	600,
		'speedOut'		:	200,
		'overlayShow'	:	false,
		onComplete: function (links, index) {
			window.location.hash = '';
			window.location.hash = index.src;
		},
		onClosed: function () {
			window.location.hash = '';
		}
	});

	$(window).load(function(){
		if (window.location.hash == '#reg')	
		 $("a.reg-f").click()
		 
		 if (window.location.hash.indexOf("#regsuccess") >= 0 )
		 $("a.regsuccess").click()
	 
	});
	
	
	var flag = false;

	if($('section').hasClass('items')){

		var owl=$(".itemSlider");
        var f=true;

		$(window).on('resize',function(){
			if($(window).width()<992)
			{
				f=false;
			}
			else
				f=true;
		});
		$(window).on('load',function () {
			if($(window).width()<992)
			{
				f=false;
			  owl.owlCarousel({
					items : 1,
					slideSpeed : 2000,
					nav: false,
					dots: false,
					loop: false,
					navRewind:false,
					touchDrag: true,
					mouseDrag: true,
					dragEndSpeed:880,
					responsive:{
						0:{
							items:1,
							dots:true
						},
						600:{
							items:1,
							dots:true
						},
						1000:{
							items:1,
							dots:false
						}
					}
				}).on('resize.owl.carousel',function(e){
				  if(f==true) {
						  $(this).trigger('to.owl.carousel', [0, duration, true]);
				  }

			  });
			}
			else {
				f=true;
				owl.owlCarousel({
				items : 1,
				slideSpeed : 2000,
				nav: false,
				dots: false,
				loop: false,
				navRewind:false,
				touchDrag: false,
				mouseDrag: false,
				dragEndSpeed:880,
				responsive:{
					0:{
						items:1,
						dots:true
					},
					600:{
						items:1,
						dots:true
					},
					1000:{
						items:1,
						dots:false
					}
				}
			}).on('resize.owl.carousel',function(e){
					if(f==false) {
						$(this).trigger('to.owl.carousel', [0, duration, true]);
					}
				}).on('changed.owl.carousel', function (e){
				if (!flag) {
					flag = true;
					$(this).next('.itemSliderVer')
						.find(".product-item")
						.removeClass("active")
						.eq(e.item.index)
						.addClass("active");
					flag = false;
				}

			});}
		});
		$('.itemSliderVer').on('click','.product-item',function () {
			$(this).parent().prev('.itemSlider').trigger('to.owl.carousel', [$(this).index(), duration, true]);
			var pos=$(this).parent().prev('.itemSlider').find('.owl-item').eq($(this).index()).position();
			$(this).parent().prev('.itemSlider').find('.owl-stage').css('transform','translate3d(0,-'+pos.top+'px,0)');
		})
	}
	var sync1 = $("#isync1");
	var sync2 = $("#isync2");

	var duration = 300;
	sync1.owlCarousel({
		margin: 0,
		responsiveClass: true,
		smartSpeed: 1000,
		dots:false,
		loop:false,
		nav:false,
		responsive: {
			0: {
				items: 1,
				dots:true
			},
			600: {
				items: 1,
				dots:true
			},
			1000: {
				items: 1,
				dots:false
			}
		}
	}).on('changed.owl.carousel', function (e) {
		if (!flag) {
			flag = true;
			sync2.trigger('to.owl.carousel', [e.item.index, duration, true]);
			flag = false;
			$("#isync2")
				.find(".owl-item")
				.removeClass("current")
				.eq(e.item.index)
				.addClass("current");
		}
	});
$(window).on('load',function(){
	$("#isync2").find(".owl-item").eq(0).addClass("current");
	$(".itemSliderVer").find(".product-item").eq(0).addClass("active");
})
	sync2.owlCarousel({
		items:4,
		loop:false,
		nav:false,
		dots:false,
		margin:10
	}).on('click', '.owl-item', function () {
		syncPosition();
		sync1.trigger('to.owl.carousel', [$(this).index(), duration, true]);

	})
		.on('changed.owl.carousel', function (e) {
			if (!flag) {
				flag = true;
				sync1.trigger('to.owl.carousel', [e.item.index, duration, true]);
				flag = false;
			}
		});

	function syncPosition(el){
		var current = this.currentItem;
		$("#isync2")
			.find(".owl-item")
			.removeClass("current")
			.eq(current)
			.addClass("current");
		if($("#isync2").data("owlCarousel") !== undefined){
			center(current)
		}
	}

	$("#isync2").on("click", ".owl-item", function(e){
		e.preventDefault();
		$("#isync2")
			.find(".owl-item")
			.removeClass("current");
		$(this).addClass("current");
		var number = $(this).data("owlItem");
		sync1.trigger("owl.goTo",number);
	});

	function center(number){
		var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
		var num = number;
		var found = false;
		for(var i in sync2visible){
			if(num === sync2visible[i]){
				var found = true;
			}
		}

		if(found===false){
			if(num>sync2visible[sync2visible.length-1]){
				sync2.trigger("owl.goTo", num - sync2visible.length+2)
			}else{
				if(num - 1 === -1){
					num = 0;
				}
				sync2.trigger("owl.goTo", num);
			}
		} else if(num === sync2visible[sync2visible.length-1]){
			sync2.trigger("owl.goTo", sync2visible[1])
		} else if(num === sync2visible[0]){
			sync2.trigger("owl.goTo", num-1)
		}

	}

	$('#relatedSlider').owlCarousel({
		items : 3,
		dots: true,
		nav: false,
		loop: true,
		margin:20,
        slideSpeed : 500,
        smartSpeed: 200,
        autoplay:true,
        //onInitialized:stopAuto,
        dotsData:true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',

		slideBy: 3, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
		responsiveClass:true,
		responsive:{
			0:{
				items:1,
				dots:true
			},
			768:{
				items:2,
				dots:true
			},
			1000:{
				items:3
			}
		}
	});
/*$('.table-close img').on('click',function () {
	$(this).parent().parent().remove();
	var count = $('.table-like div').length;
	console.log(count)
})
*/
$(document).on('change', '.cart-form  input.qty', function(e) {
		e.preventDefault();
		 
		$('.cart-holder').animate({'opacity':0.6},300)
		
		var qty = $( this ).val();
		var currentVal  = parseFloat( qty);
		var item_hash = $( this ).attr( 'name' ).replace(/cart\[([\w]+)\]\[qty\]/g, "$1");
		var data = {
				action: 'update_total_price',
				//security: rf_cart_params.rf_update_total_price_nonce,
				quantity: currentVal,
				hash : item_hash 
			};
		$.ajax({
			url: global.url,
			 
			data: data,
			type: 'POST',
			success: function(data) {
				//console.log(data);            	
 
				$('.cart-holder')
				.html(data)
				.animate({'opacity':1},300);		 
				 
			},
			error: function(errorThrown) {
				console.log(errorThrown);
			}
		});
		
	})

	$(document).on('click', '.intocarts:not(.disabled)', function(e) {
		e.preventDefault();
	});


	$(document).on('click', '.addtocarts:not(.disabled)', function(e) {
		e.preventDefault();
		
		if (click === false) {
			click = true;

			var el = $(this);
			var id = e.currentTarget.dataset['id'],
				a = false,
				i,
				cart,
				input;

			if (id) {
				el.find('.fa-refresh').show();

				input = $('#count-products-'+ id);
				var session = sessionStorage['cart'];

				if (input && session) {
					session = JSON.parse(session);
					cart = {};
					for (i = 0; i < session.length; i++) {
						if (Number(session[i].id) === Number(id)) {
							cart = session[i];
							a = i;
							break;
						}
					}

					cart['id'] = id;
					cart['count'] = Number(input.val());

					if (a === false) {
						session.push(cart);
					}
					else session[a] = cart;

					cart['_token'] = window.global.app.csrf;
					
					$.post(window.global.app.connector +'/cart', cart, function () {
						el.find('span').text(el.attr('data-success'));
						el.find('.fa-refresh').hide();

						el.removeClass('addtocarts');
						el.addClass('intocarts');

						sessionStorage['cart'] = JSON.stringify(session);
						click = false;

						countProducts(session);
					});
				}
			}
		}
	})

	/**
	 * Count products and show in the cart label
	 */
	function countProducts(session) {
		var count = 0,
			cost = 0,
			i;

		for (i = 0; i < session.length; i++) {
			count += Number(session[i].count);
		}

		$('#cart-count-label').html(Number(count));

		var i;
		$('.add-to-cart-count.server').each(function(e) {
			i = Number($(this).data('price')) * Number($(this).val());
			$('#amount-default-value-'+ $(this).data('id')).html(i.toFixed(2));
			cost += i;
		});
		
		$('#total-default-cost').html(cost.toFixed(2));
	}

	
	 $(document).on('click', '.contact-item', function(e) {
		e.preventDefault();
		$('.contact-item').removeClass('head-contact-item')
		$(this).addClass('head-contact-item')
		$('#mapField').attr('data-lat', $(this).attr('data-lat'))
		$('#mapField').attr('data-lng', $(this).attr('data-lng'))
		if ($(this).attr('data-lat').length)
		initialize() 
	})

	 
	function initialize() {
		var map;
		var lat = parseFloat($('#mapField').attr('data-lat'))
		var lng = parseFloat($('#mapField').attr('data-lng'))
		var img =  ($('#mapField').attr('data-img'))
		var target = { lat: lat, lng: lng};
		var Options = {
			center: target, 
			scrollwheel: false,
			zoom: 10,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById("mapField"), Options);
		var icon = {
			url: img, // url
			scaledSize: new google.maps.Size(222, 135), // scaled size
			origin: new google.maps.Point(0,0), // origin
			anchor: new google.maps.Point(0, 0),
			labelOrigin: new google.maps.Point(110, 85)
		};
		var marker = new google.maps.Marker({
			position: target,
			map: map,
			title: 'Bitmain',
			label: {
				text: lat + ' ' + lng,
				color: 'gray'
			},
			icon:icon
		});
		var styles = [
			{
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#f5f5f5"
					}
				]
			},
			{
				"elementType": "labels.icon",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#616161"
					}
				]
			},
			{
				"elementType": "labels.text.stroke",
				"stylers": [
					{
						"color": "#f5f5f5"
					}
				]
			},
			{
				"featureType": "administrative.land_parcel",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#bdbdbd"
					}
				]
			},
			{
				"featureType": "poi",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#eeeeee"
					}
				]
			},
			{
				"featureType": "poi",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#757575"
					}
				]
			},
			{
				"featureType": "poi.park",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#e5e5e5"
					}
				]
			},
			{
				"featureType": "poi.park",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#9e9e9e"
					}
				]
			},
			{
				"featureType": "road",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#ffffff"
					}
				]
			},
			{
				"featureType": "road.arterial",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#757575"
					}
				]
			},
			{
				"featureType": "road.highway",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#dadada"
					}
				]
			},
			{
				"featureType": "road.highway",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#616161"
					}
				]
			},
			{
				"featureType": "road.local",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#9e9e9e"
					}
				]
			},
			{
				"featureType": "transit.line",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#e5e5e5"
					}
				]
			},
			{
				"featureType": "transit.station",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#eeeeee"
					}
				]
			},
			{
				"featureType": "water",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#c9c9c9"
					}
				]
			},
			{
				"featureType": "water",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#9e9e9e"
					}
				]
			}
		];

		map.setOptions({styles: styles});
		
		$('body, html').animate({
			scrollTop: $(window).height() /2
		}, 400)
		
		//$('#mapField > div').css({'top' : - ($(window).height() /2 - $(window).scrollTop()) })
	}
	if($('main').hasClass('contact-map')) {
		google.maps.event.addDomListener(window, 'load', initialize);
		
	}
		
		
	 $('.expand_order').click(function(e){
		e.preventDefault();
		$('.items_order').hide()
		var order = $(this).attr('href')
		$('[data-order_id="'+order+'"]').css('display', 'table-row');
		
		$('.hidden_costs_label').css('opacity', 1);
	})

	$('.order_thumbs_several a').click(function(){	
		event.preventDefault();
		
		var prod = $(this).attr("href");
		var parent = $(this).closest('.table-row');
		
		if ($(this).hasClass('a-opened')) {
			$(parent).toggleClass('opened'); 
			$(this).find('.show_products').toggleClass('hidden-block'); 
			$(prod).toggleClass('hidden-block');
			
			$('.table-like').removeClass('table-expanded');
			$('.table-like>div').each(function(){		
				if ($(this).hasClass('opened')) {
					$('.table-like').addClass('table-expanded');
				}
			})
			$(this).removeClass('a-opened') 
			return false;
		}
		$('.order_thumbs_several a').removeClass('a-opened') 
		$(this).addClass('a-opened') 
		
		
		$('.table-row-several').addClass('hidden-block'); 		
		$('.order_thumbs_several a .show_products').removeClass('hidden-block'); 
		$('.table-row-top-several').removeClass('opened');
		
		
		
		
		
		
		
		
		$(parent).toggleClass('opened'); 
		$(this).find('.show_products').toggleClass('hidden-block'); 
		$(prod).toggleClass('hidden-block');
		
		$('.table-like').removeClass('table-expanded');
		$('.table-like>div').each(function(){		
			if ($(this).hasClass('opened')) {
				$('.table-like').addClass('table-expanded');
			}
		})
		
		//$('.table-row').not(parent).not('.opened').not('.table-row-several').toggleClass('opacity-block');
		
		 
		/* var prod = $(this).attr("href");
		$(prod).toggleClass('hidden-block');
		$(this).find('.show_products').toggleClass('hidden-block');
		$('.table-row').not($(this).closest('.table-row')).toggleClass('opacity-block');
			
		 */

	});

	/*$('.order_thumbs_several a').click(function(){
		event.preventDefault();
		$('.table-row-several').toggleClass('hidden-block');
		$('.table-row').toggleClass('opacity-block');
		$('.show_products').toggleClass('hidden-block');
		$('.table-cell-border').toggleClass('table-cell-border-none');

	});*/

	/**
	 * Check values that inputed into count products fields
	 * @fires input
	 */
	//console.log($('.form-control.form-number.count.add-to-cart-count'))
	$('.form-control.form-number.count.add-to-cart-count').on('input', (function (e) {
		if (e.target.value.length > 6) {
			e.target.value = e.target.value.substr(0, 6);
		}

		if (e.target.value.length <= 0) {
			e.target.value = 1;
		}
		e.target.value = e.target.value.replace(/[^\d]/g, '');

		var btn = $('.intocarts[data-id='+ e.target.dataset['id'] + ']');
		if (btn.length > 0) {
			btn.removeClass('intocarts');
			btn.addClass('addtocarts');
			btn.find('span').text(btn.data('add'));
		}
	}));

    /**
     * Click report availability button
     */
    $('.report-availability').on('click', function (e) {
        e.preventDefault();
		var productId = $(this).data('id');

		if($.isEmptyObject(products)){
            $.ajax({
                url:global.url + 'rep-avail',
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {id: productId},
                success: function (data) {
                   // console.log('data ' + data);
                    products = data;

                    var select = $('.selects').find('select')[0];
                    for(var k in products){
                        var option = document.createElement('option');

                        $(option).attr('value', products[k].id);
                        $(option).text(products[k].title);
                        if(productId == products[k].id){
                            $(option).attr('selected', 'selected');
                        }
                        select.append(option);
                    }
                }
            });
        } else{

        }
    });

    $('.add-report-select').on('click', function (e) {
		e.preventDefault();
		var newSelect = $(this).parent('.form-group').prev('.report-form-select').clone();
        $(this).parent('.form-group').prev('.report-form-select').after(newSelect);
        newSelect.find('.input').val(1);
        var defaultOption = document.createElement('option');//'<option selected="selected" value="0">Choose product</option>';
		$(defaultOption).attr('selected', 'selected');
		$(defaultOption).attr('disabled', 'disabled');
		$(defaultOption).text('Choose product');
		$(defaultOption).val(0);
		console.log(defaultOption);
		newSelect.find('option')[0].before(defaultOption);
        $('.form-group-btn-remove').show();
    });

    $('.remove-report-select').on('click', function (e) {
        e.preventDefault();
        $(this).parent('.form-group').prev().prev('.report-form-select').remove();
        if($('.selects').find('.report-form-select').length < 2){
            $('.form-group-btn-remove').hide();
        }
        //console.log('minus select!');
    });

    $('#report-availability-form').on('submit', function (e) {
        e.preventDefault();

        var dat = {
            products: {}
        };

        var captcha = $(this).find('#g-recaptcha-response').text();
//console.log(captcha.length);
        if(captcha.length > 0) {
            $(this).find('.error-captcha').hide();

            $(this).find('input').each(function () {
                if($(this).attr('name') != 'submit' && $(this).attr('name').indexOf('count') == -1){
                    dat[$(this).attr('name')] = $(this).val();
                }
                //console.log($(this).attr('name') + ' ' + $(this).val());
            });
            //console.log($(this).find('select'));
            var i = 0;
            $(this).find('.report-form-select').each(function () {
                dat.products[i] = {};
                dat.products[i]['id'] = $(this).find('select').val();
                dat.products[i]['count'] = $(this).find('input').val();
                i++;
            });
            //console.log(dat);
            $.ajax({
                url:global.url + 'create_report',
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: dat,
                success: function (data) {
                    $('#report-availability-form').hide();
                    $('#report-availability .modal-header').hide();
                    $('#report-availability .report-message').hide();
                    if(data.message){

                    } else{
                        $('#report-availability').addClass('popup-success');
                        $('#report-availability').find('.result').show();
                        $('body').animate({
                            'opacity': 1
                        }, 400);
                    }
                },
                error: function (data) {
                    $('.error-captcha').show();
                }
            });
        } else{
            $(this).find('.error-captcha').show();
		}


    });

    $('#billing_country').on('change', function () {
    	if($(this).val() == 'UA'){
			$('.ua-shipping-method').show();
			$('.ua-shipping-method').find('input').prop('checked', true);
            $('.selfment-shipping-method').show();
			$('.ru-shipping-method').hide();
			$('.ru-shipping-method').find('input').prop('checked', false);
			$('.without-delivery').val(0);
            $('.no-availible-shipping-method').hide();
		} else if($(this).val() == 'RU'){
            $('.ua-shipping-method').hide();
            $('.ua-shipping-method').find('input').prop('checked', false);
            $('.without-delivery').val(0);
            $('.ru-shipping-method').show();
            $('.ru-shipping-method').find('input').prop('checked', true);
            $('.selfment-shipping-method').show();
            $('.no-availible-shipping-method').hide();
		} else{
            $('.ru-shipping-method').hide();
            $('.ua-shipping-method').hide();
            $('.selfment-shipping-method').hide();
            $('.no-availible-shipping-method').show();
            $('.ua-shipping-method').find('input').prop('checked', false);
            $('.ru-shipping-method').find('input').prop('checked', false);
            $('.without-delivery').val(1);
            console.log($('.without-delivery').find('input').val());
            $('.selfment-shipping-method').find('input').prop('checked', false);
		}
		//console.log($(this).val());
    });
});

 
 
 
 
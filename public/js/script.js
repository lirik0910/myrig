 /**
 * Created by Ann on 12.02.2017.
 */
 
 
jQuery(document).ready(function ($) {
	
		//delete
	$( '.cart-form .remove').click(function(e) {
		e.preventDefault();
		e.stopPropagation();
		var that = $(this)
		that.parent().css({
	        'opacity': 0.5
	    })
	    
	    
 
	    
	    
		$.ajax({
	        url: '/wp-admin/admin-ajax.php',	
	            
	        data: {
	            action: 'modal_cart_delete_product', 
	            product_id: that.attr('data-product_id'),
	      
	        },
	        type: 'POST',
	        success: function(data) {
	        	 
				that.closest('table-row').fadeOut().remove();
				window.location.reload() 
	        }
 		})
		
	})
 	
	
	
	
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
  

    $('.contacts ul li').on('click',function () {
        $('.contacts ul li').removeClass('active');
        $(this).addClass('active');
    });
    $(document).on('click','span:not(.disabled)>.btn-count',function (e) {
        e.preventDefault();
        var c=$(this).parent().find('.form-control').val();
        if($(this).hasClass('btn-count-plus')){
           c++;
            $(this).parent().find('.form-control').val(c);
        }
        else{
            if(c>1) {
                c--;
                $(this).parent().find('.form-control').val(c);
            }
        }
        
        $('.count').change()
        $('.cart-form .table-row:first-child  input.qty').change()
         

    })
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

    })

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
    $("a.reg-f, a.reg-c, a.regsuccess , a.ticket").fancybox({
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
	 
	})
    
    
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
        margin:20,
        slideSpeed : 500,
        slideBy: 1, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
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
    })
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
    	
	
	 $(document).on('click', '.addtocarts:not(.disabled)', function(e) {
        e.preventDefault();
         
        var that = $(this)
 		that.find('.fa-refresh').addClass('spinned')
        $.ajax({
            url: global.url,
             
            data: {
                action: 'add_to_cart',
                product_id: that.attr('data-product_id'),
                qty: that.parent().find('.count').val(),
 
            },
            type: 'POST',
            success: function(data) {
             	 
                $('.user-panel .label').html(data)
                that.text(that.attr('data-success'))
                that.find('.fa-refresh').addClass('spinned')
            },
            error: function(errorThrown) {
                console.log(errorThrown);
            }
        });
    })

	
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

});
 
 
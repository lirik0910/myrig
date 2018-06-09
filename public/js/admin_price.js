jQuery(document).ready(function($) {
	
	$(window).load(function(){
		//$('#_typecurrency').trigger('change')
		if (!$('._change').is(':checked')) {
			$('#_regular_price').attr( 'readonly',  'readonly' );
			$('.costs_fields input').removeAttr( 'readonly'  )
		} else {
			$('.costs_fields input').attr( 'readonly',  'readonly' )
			
			$('#_regular_price').removeAttr( 'readonly'  )
		}
		
	
	
	$('._change').change(function(){
		if (!$(this).is(':checked')) {
			$('#_regular_price').attr( 'readonly',  'readonly' )
			$('.costs_fields input').removeAttr( 'readonly'  )
		}
			
		else {
			$('.costs_fields input').attr( 'readonly',  'readonly' )
			
			$('#_regular_price').removeAttr( 'readonly'  )
		}
			
	})
	
	})
	$('.options_price input, .options_price select').on('change input keypress',function(){
		
		var btc = parseFloat($('.btc').val());
		
		var costs = parseFloat($('.costs').val());
		var costsCurrency = $('.costscurrency').val(); 
		var delivery = parseFloat($('.delivery').val());		
		var waranty = parseFloat($('.waranty').val());
		var warantyCurrency = $('.warantycurrency').val(); 
		var profit = parseFloat($('.profit').val());
		var profitCurrency = $('.profitcurrency').val(); 
		var fes = parseFloat($('.fes').val());
		 
		if (costsCurrency == 1)
			costs = costs * btc;
			
		if (warantyCurrency == 1)
			waranty = costs * waranty/100;
		
		if (profitCurrency == 1)
			profit = costs * profit/100;
						
		var newPrice = costs + delivery + waranty + profit + fes;
		var newPriceM = Math.ceil(newPrice/10)
		$('#_regular_price').val( newPriceM * 10 )
		
		 
			
	})
	
 
	
})
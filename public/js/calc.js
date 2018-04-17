	jQuery(document).ready(function($) {
 
		$('.korpus > input').change(function(){
		    console.log($(this));
			$('.income-number').html('-');
			var index = $(this).attr('data-index');
			var currencyType = $(this).attr('data-currencyType');
			var updateAction = $(this).attr('data-updateAction');
			$('.calculator-form').appendTo(".tab-" + index);
			$('.currencyType').val(currencyType);
			console.log(currencyType, updateAction);
			var obj = {
				currencyType : currencyType,
				updateAction : updateAction
			}
			udate_network(obj);		
			 
			udate_devices(obj)
  
		})
		
		function udate_network(obj) {
			$('.network-status--inner div:last-child').html('<i class="fa fa-cog fa-spin"></i>')
			$.ajax({
					url:global.url + 'calc',
				    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
					data: {
						action:obj.updateAction,
						currency:obj.currencyType, 
					},
					success: function(data) {
						$('.network-status').html(data);
						if (obj.currencyType == 'LTC' || obj.currencyType == 'DASH')
							$('#quantity').attr('readonly','readonly');
						else 
							$('#quantity').removeAttr('readonly' );
					}	
				})
		}
		
		function udate_devices(obj) {
			$('.miners').html('<i class="fa fa-cog fa-spin"></i>');
			$('.calculator-form').animate({
				'opacity' : 0.6
			})
		 	$.ajax({
				url:global.url + 'calc',
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
				data: {
					action:'update_devices',
					currency:obj.currencyType, 
				},
				success: function(data) {
					$('.miners').html(data);
					select();
					$('.calculator-form').animate({
						'opacity' : 1
					})
	 
				}
			})
		}
		
		/**
		change form inouts on change type
		*/
		$(document).on('change', '.radio-buttons input', function(){
			var val = $(this).val();
			if (val == 2) {
				$('.costs').removeAttr('disabled'); 
				$('.hash').removeAttr('readonly');
				$('.energy').removeAttr('readonly'); 
			}
				
			else {
				$('.hash').attr('readonly', 'readonly');
				$('.energy').attr('readonly', 'readonly');
				$('.costs').attr('disabled','disabled');
			}
		});
		
 		/**
		update
		*/
		
		$(window).load(function(){
			update_rates($('#rialto').val());
			update_net_status()
		});
		//$( "#quantity" ).spinner();
		/**
		submit
		*/
		
		$('.calculator-form').submit(function(e){
			e.preventDefault();
			calc_btc(1);
		});

		function calc_btc(val) {
			$('.income-number').html('<i class="fa fa-cog fa-spin"></i>');
			var network = {difficulty: $('.difficulty').text(), reward_block: 1250000000};
			var status = {hashrate: $('.hashrate').text(), expected_difficulty_raw: $('.expected_diff').text(), expected_difficulty_date: $('.diff_date').text(), expected_difficulty: 8.52};
			//console.log('network :' + network, 'status' + status);
			//console.log(calc);
			//console.log($('.calculator-form').serialize());
			$.ajax({
				url:global.url + 'calc_btn',
                method: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
				data: $('.calculator-form').serialize() + '&calc='+JSON.stringify(calc) + '&network=' + JSON.stringify(network) + '&status=' + JSON.stringify(status),
			 	//dataType: 'json',
				success: function(data) {
					if (data === 0) {
						alert ("Введите все данные!");
						$('.hash').css({'border-color':'red'})
						return;
					}
					// console.log(data);
					$('.income-table').html(data);
					$('a[href="'+val+'"]').parent().addClass('active');
					$('#buyers').slideDown();
					$('.hash').css({'border-color':'#c5c5c5'})
					//var buyers = document.getElementById('buyers').getContext('2d');
					 /*var buyerData = {
						labels: data.chartLabels ,
						datasets: [{
							fillColor: "rgba(157,200,241,0.4)",
							strokeColor: "#72b0ea",
							poi
							ntColor: "#72b0ea",
							pointStrokeColor: "#72b0ea",
							data:  data.chart 
							
						}],
						 
					}
					new Chart(buyers).Line(buyerData);*/
				} 
			}) 
		}
		
		/**
		change form inputs on change usrt
		*/
		var hr = parseFloat($('.hash').val());
		var en = parseFloat($('.energy').val());
		function changeSelect(obj) {
			var rel = obj.attr('rel');
			var option = $('[value="'+rel+'"]')
  
		 	if (option.attr('data-hr') )  {
				if (option.attr('value')  ) {
					hr = option.attr('data-hr');
					en = option.attr('data-en');
					$('.hash').val(hr).attr('readonly','readonly') ;
					$('.energy').val(en).attr('readonly','readonly') ;
					$('.costs').attr('disabled','disabled');
					 
					$('#quantity').removeAttr('readonly') ;
					$('#radio1').prop('checked',true)  ;
					$('#radio2').prop('checked',false) ;
					
				} else {
					$('.hash').removeAttr('readonly');
					$('.energy').removeAttr('readonly');
					$('#quantity').attr('readonly','readonly') ;
					$('#radio1').prop('checked',false)  ;
					$('#radio2').prop('checked',true) ;
					$('.hash, .energy').val('');
					$('.costs').removeAttr('disabled');
				 
				}
			} else {
				
				if (option.parent().attr('id') === 'rialto') {
					option.prop('selected',true) ;
					 
				}
				
			}
			
		} 
		
		
		
		/**
		change hash
		*/
		
		$('.hash').on('change', function(){
			$('#radio1').prop('checked',false).prop('disabled',true) ;
			$('#radio2').prop('checked',true) ;
			 
		})
		
		
		
		/**
		change quantity
		*/
		
		$(document).on('change input keypress', '#quantity', function(){
			
			var qty = parseInt($(this).val());
			
			$('.energy').val((en * qty).toFixed(2));
			$('.hash').val((hr * qty).toFixed(2));
		})
		
		/**
		update_rates
		*/
		
		function update_rates(obj) {
			//console.log(obj);
			$.ajax({
				url:global.url + 'calc',
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
				data: {
					action:'parse_btc_courses_calc',
					src: obj  ? obj  : 'coinbase'
				},
				success: function(data) {
					$('.btc-courses').html(data);
                    calc = data;
				}
			})
		}
		
		/**
		update_net_status
		*/
		
		function update_net_status() {
			
			$.ajax({
				url:global.url + 'calc',
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
				data: {
					action:'parse_btc_network_status',
					 
				},
				success: function(data) {
					$('.network-status').html(data)
				}
			})
		}
		
		
		

			//script for calculator tabs
 
				$('.tab ul.tabs').addClass('active').find('> li:eq(0)').addClass('current-tab');

				$('.tab ul.tabs li a').click(function(g) {
					var tab = $(this).closest('.tab'),
						index = $(this).closest('li').index();

					tab.find('ul.tabs > li').removeClass('current-tab');
					$(this).closest('li').addClass('current-tab');

					tab.find('.tab_content').find('div.tabs_item').not('div.tabs_item:eq(' + index + ')').slideUp();
					tab.find('.tab_content').find('div.tabs_item:eq(' + index + ')').slideDown();

					g.preventDefault();
				});
		 

			select();
		 	function select() {
				$('select.calc-select').each(function() {
				var $this = $(this),
					numberOfOptions = $(this).children('option').length;
					
				if ($this.next().hasClass('select-styled')) {
					$this.next().next().remove();
					$this.next().remove();
				}
					

				$this.addClass('select-hidden');
				$this.wrap('<div class="select"></div>');
				$this.after('<div class="select-styled"></div>');

				var $styledSelect = $this.next('div.select-styled');
				$styledSelect.text($this.children('option').eq(0).text());

				var $list = $('<ul />', {
					'class': 'select-options'
				}).insertAfter($styledSelect);

				for (var i = 0; i < numberOfOptions; i++) {
					$('<li />', {
						text: $this.children('option').eq(i).text(),
						rel: $this.children('option').eq(i).val()
					}).appendTo($list);
				}

				var $listItems = $list.children('li');

				$styledSelect.click(function(e) {
					e.stopPropagation();
					
					$('div.select-styled.active').not(this).each(function() {
						$(this).removeClass('active').next('ul.select-options').hide();
					});
					$(this).toggleClass('active').next('ul.select-options').toggle();
				});

				$listItems.click(function(e) {
				//	e.stopPropagation();
					changeSelect($(this)); 
					$styledSelect.text($(this).text()).removeClass('active');
					$this.val($(this).attr('rel'));
					$list.hide();
					//console.log($this.val());
				});

				$(document).click(function() {
					$styledSelect.removeClass('active');
					$list.hide();
				});

			});
			}


			//script for new select	
			
			
			
			
					 
		$('.slct').click(function () {
		    /* Заносим выпадающий список в переменную */
		    var dropBlock = $(this).parent().find('.drop');

		    /* Делаем проверку: Если выпадающий блок скрыт то делаем его видимым*/
		    if (dropBlock.is(':hidden')) {
		        dropBlock.slideDown();

		        /* Выделяем ссылку открывающую select */
		        $(this).addClass('active');

		        /* Работаем с событием клика по элементам выпадающего списка */
		        $('.drop').find('li').click(function () {

		            /* Заносим в переменную HTML код элемента
		            списка по которому кликнули */
		            var selectResult = $(this).html();

		            /* Находим наш скрытый инпут и передаем в него
		            значение из переменной selectResult */
		            $(this).parent().parent().find('input').val(selectResult);

		            /* Передаем значение переменной selectResult в ссылку которая
		            открывает наш выпадающий список и удаляем активность */
		            $(this).parent().parent().find('.slct').removeClass('active').html(selectResult);

		            /* Скрываем выпадающий блок */
		            dropBlock.slideUp();
		        });

		        /* Продолжаем проверку: Если выпадающий блок не скрыт то скрываем его */
		    } else {
		        $(this).removeClass('active');
		        dropBlock.slideUp();
		    }

		    /* Предотвращаем обычное поведение ссылки при клике */
		    return false;
		});
 
			

		
		


		});
@php
//var_dump(app()->getLocale()); die;
@endphp
<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" style="margin: 0; padding: 0; font-weight: lighter">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
</head>
<body style="margin: 0; padding: 0; font: 400 18px Calibri, sans-serif;">
@php
	$order = App\Model\Shop\Order::where('number', $number)->with('orderDeliveries', 'products')->first();
    $delivery = App\Model\Shop\Delivery::where('id', $order->orderDeliveries->delivery_id)->first();
@endphp
<div style="width: 500px; margin: 0 auto;">
	<img src="{{ url('uploads/design/dots.png') }}" alt="" style="position: absolute; top: 0; right: 0; width: 300px;">
	<img src="{{ url('uploads/design/logo.png') }}" alt="" style="width: 150px; margin-bottom: 70px;">
	<div>
		<table style="width: 100%; font-size: 14px; margin-top: 130px;">
			<tr>
				<td style="font-size: 16px;">{{ __('default.client_name_invoice') }}</td>
				<td style="text-align: right; vertical-align: bottom;">{{$order->orderDeliveries->first_name}} {{$order->orderDeliveries->last_name}}</td>
			</tr>
			<tr>
				<td></td>
				<td style="text-align: right;">{{$order->orderDeliveries->address}}</td>
			</tr>
			<tr>
				<td style="text-transform: uppercase; font-weight: 700; letter-spacing: 4px;">{{ __('default.invoice') }} # {{ $order->number }}</td>
				<td style="text-align: right;">{{$order->orderDeliveries->city}}</td>
			</tr>
			<tr>
				<td>
					@php
						$month = date('F', strtotime($order->created_at));
                        $default = 'common.';
                        $translate = $default . strtolower($month);
                        echo date('d', strtotime($order->created_at)) . ' ' . __($translate) . '`' . date('y', strtotime($order->created_at));
					@endphp
				</td>
				<td style="text-align: right;">{{$order->number }}</td>
			</tr>
		</table>
	</div>
	@php $i = 0 @endphp
	@foreach($order->products as $product)
		@php $i++; @endphp
	@endforeach
	@if($i < 9)
		<div style="margin-top: 100px; height: 400px">
			@else
				<div style="margin-top: 100px; height: auto;">
					@endif
					<table class="main-table" style="border-collapse: collapse;">
						<tr style="border-bottom: 2px solid grey; font-size: 10px; text-transform: uppercase;">
							<td style="width: 200px; text-align: left; border-bottom: 2px solid grey; padding: 10px 5px;">{{ __('default.description_title') }}</td>
							<td style="text-align: center; width: 100px; border-bottom: 2px solid grey; padding: 10px 5px;">{{ __('default.quantity_title') }}</td>
							<td style="text-align: center; width: 100px; border-bottom: 2px solid grey; padding: 10px 5px;">{{ __('default.price_title') }}</td>
							<td style="text-align: center; width: 100px; border-bottom: 2px solid grey; padding: 10px 5px;">{{ __('default.total_title') }}</td>
						</tr>
						<tbody style="border-bottom: 2px solid grey; font-size: 10px;">
						@foreach($order->products as $product)
							@php
								if($product->auto_price){
                                 $price = number_format($product->calcAutoPrice(), 2, '.', '');
                                 } else{
                                 $price = number_format($product->price, 2, '.', '');
                                  }
							@endphp
							<tr style="font-size: 10px;">
								<td style="text-align: left; padding: 10px 5px;">{{ $product->title }}</td>
								<td style="text-align: center; padding: 10px 5px;">{{$product->pivot->count}}</td>
								<td style="text-align: center; padding: 10px 5px;">{{number_format($price, 2, '.', '') }}</td>
								<td style="text-align: center; padding: 10px 5px;" id="green">{{number_format($price * $product->pivot->count, 2, '.', '') }}</td>
							</tr>
						@endforeach
						</tbody>
					</table>

					<table>
						<tr>
							<td style="width: 340px;">

							</td>
							<td>

								<table class="additional-table" style="width: 193px; font-size: 10px; border-collapse: collapse; margin-top: 5px;">
									<tbody>
									<tr id="bottom">
										<td id="bottom" style="padding: 10px 0;">{{ __('default.total_bottom') }}</td>
										<td id="bottom" style="padding: 10px 0;">{{ number_format($order->cost, 2, '.', '') }}</td>
									</tr>
									<tr>
										<td id="bottom" style="padding: 10px 0;"><strong>{{ __('default.tax_bottom') }}</strong></td>
										<td id="bottom" style="padding: 10px 0;"><strong>$0.00</strong></td>
									</tr>
									<tr style="vertical-align: middle;">
										<td style="padding: 10px 0;"><strong>{{ __('default.amount_bottom') }}</strong></td>
										<td id="green" style="font-weight: 700; font-size: 16px; padding: 10px 0;">{{ number_format($order->cost, 2, '.', '') }}</td>
									</tr>
									</tbody>
								</table>

							</td>
						</tr>
					</table>


				</div>
{{--				<p style="text-transform: uppercase; margin: 20px 0 0 0; font-size: 14px;">{{ __('default.payment_terms') }}</p>
				<p style="margin: 0 0 20px; font-size: 14px;">{{ __('default.write_your_payment') }}</p>--}}
		</div>
		<footer style="position: fixed; bottom: 0px; left: 0px; right: 0px; height: 55px; padding: 20px 0 50px; background: #77a565; font-size: 0; color: #fff;">
			<div style="width: 500px; margin: 0 auto;">
				<div style="display: inline-block; width: 166.6px; vertical-align: top;">
					<div style="display: inline-block; margin-right: 7px; vertical-align: top;">
						<img src="{{ url('uploads/design/phone.png') }}" alt="" style="width: 20px; height: 20px;">
					</div>
					<div style="display: inline-block; vertical-align: top; width: 116.6px; font-size: 11px;">
						<p style="margin: 0;">+38 044 360 79 58</p>
						<p style="margin: 0;">+38 098 619 73 73</p>
					</div>
				</div>
				<div style="display: inline-block; width: 166.6px; vertical-align: top;">
					<div style="display: inline-block; margin-right: 7px; vertical-align: top;">
						<img src="{{ url('uploads/design/point.png') }}" alt="" style="width: 20px; height: 20px;">
					</div>
					<div style="display: inline-block; vertical-align: top; width: 116.6px; font-size: 11px;">
						<p style="margin: 0;">3700 Quebec Street<br>Unit 100-239 Denver<br> Colorado 80270</p>
					</div>
				</div>
				<div style="display: inline-block; width: 166.6px; vertical-align: top;">
					<div style="display: inline-block; margin-right: 7px; vertical-align: top;">
						<img src="{{ url('uploads/design/world.png') }}" alt="" style="width: 20px; height: 20px;">
					</div>
					<div style="display: inline-block; vertical-align: top; width: 116.6px; font-size: 11px;">
						<p style="margin: 0;">support@myrig.com</p>
						<p style="margin: 0;">{{ __('default.link_pdf') }}</p>
					</div>
				</div>
			</div>
		</footer>
</body>
</html>
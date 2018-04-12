<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		 <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
		 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <style>
      *{ font-family: Calibri !important;}
    </style>
</head>

<body>
	@php
    $order = App\Model\Shop\Order::where('number', $number)->with('orderDeliveries', 'products')->first();
        $delivery = App\Model\Shop\Delivery::where('id', $order->orderDeliveries->delivery_id)->first();
  @endphp
	 <div style="font-family: calibri;">
     <img style="width: 400px; position: absolute; top: 0px; right: 30px;" src="{{ url('uploads/design/dots.png') }}">
   
    <div class="container">

  

		<div class="container">
			<div class="row">
						<img src="{{ /*$preview(*/asset('uploads/design/logo.png')/*, 162, 35)*/ }}" alt="{{ env('APP_NAME') }}" style="width: 190px"/>
			</div>
		</div>
	

<div class="client">
  <div class="container">
    <div class="row">
        <div class="col">
            <ul>
              <li><h3>Client Name</h3></li>
              <li></li>
              <li><strong><h5>I N V O I C E # {{ $order->number }}</strong></h5></li>
              <li>{{ date('d.F.y') }}</li>
            </ul>
        </div>
        <div class="col">
          <ul align="right">
            <li>{{$order->orderDeliveries->first_name}} {{$order->orderDeliveries->last_name}}</li>
            <li>{{$order->orderDeliveries->address}}</li>
            <li>{{$order->orderDeliveries->city}}</li>
            <li>{{ $order->number }}</li>
          </ul>
        </div>
    </div>
  </div>
</div>

<div class="container">
	<table class="minimalistBlack">
  <thead id="bottom">
    <tr>
      <td><span class="description">Description</span></td>
      <th></th>
      <th></th>
      <th></th>
      <th>Quantity</th>
      <th>Price</th>
      <th>Total</th> 
    </tr>
  </thead>
  <tbody>
    @foreach($order->products as $product)
     @php
      if($product->auto_price){
         $price = number_format($product->calcAutoPrice(), 2, '.', '');
         } else{
         $price = number_format($product->price, 2, '.', '');
          }
      @endphp
    <tr>
      <td>{{ $product->title }}</td>
      <td></td>
      <td></td>
      <td></td>
      <td align="center">{{$product->pivot->count}}</td>
      <td align="center">{{ number_format($price, 2, '.', '') }}</td>
      <td align="center" id="green">{{ number_format($price * $product->pivot->count, 2, '.', '') }}</td>
    </tr>
    @endforeach
    
  </tbody>
</table>
</div> 
<div class="container">
    <div class="row">
      <div class="col-sm">
      </div>
      <div class="col-sm">
      </div>
      <div class="col-sm">
       <table class="minimalist">
    
    <tbody>
      <tr id="bottom">
        <td>TOTAL</td>
        <td>{{ number_format($order->cost, 2, '.', '') }}</td>
      </tr>
      <tr id="bottom">
        <td><strong>TAX</strong></td>
        <td><strong>$0.00</strong></td>
      </tr>
      <tr>
        <td><strong>AMOUNT DUE</strong></td>
        <td id="green"><h2>{{ number_format($order->cost, 2, '.', '') }}</h2></td>
      </tr>
    </tbody>
  </table>
      </div>
    </div>
  </div>
</div>
<div class="pay">
  <div class="container">
    <div class="row">
      <ul>
        <li><span class="font_pay">PAYMENT TERMS</span></li>
        <li><span class="font_pay">Write your paiment terms and conditions here</span></li>
      </ul>
    </div>
  </div>
</div>



<!--Footer-->
            <div class="foot">
<footer class="footer">
            <div class="row py-4 d-flex align-items-center">

                <div class="container">
          <div class="row justify-content-md-center">
              <div class="col">
                <div class="row">
                  <div class="col">
                    <img class="icons" src="{{ asset('uploads/design/phone.png') }}" alt="{{ env('APP_NAME') }}">
                  </div>
                  <div class="col-10">
                    <ul>
                      <li><span class="font">+38 044 360 79 58</span></li>
                      <li><span class="font">+38 098 619 73 73</span></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="row">
                  <div class="col">
                    <img class="icons" src="{{ asset('uploads/design/point.png') }}" alt="{{ env('APP_NAME') }}">
                  </div>
                <div class="col-10">
                  <ul>
                  <li><span class="font">3700 Quebec Street</span></li>
                  <li><span class="font">Unit 100-239 Denver</span></li>
                  <li><span class="font">Colorado 80207</span></li>
                  </ul>
              </div>
              </div>
            </div>
                
              <div class="col">
                <div class="row">
                  <div class="col">
                    <img class="icons" src="{{ asset('uploads/design/world.png') }}" alt="{{ env('APP_NAME') }}">
                  </div>
                  <div class="col-10">
                  <ul>
                    <li><span class="font">alex@bitmainwarranty.com</span></li>
                    <li><span class="font">www.myrig.com</span></li>
                  </ul>
                </div>
                </div>
              </div>
              
          </div>
     
            </div>
            <!--Grid row-->
        </div>
</footer>
    </div>
<!--/.Footer-->
        </div>              
</body>
</html>
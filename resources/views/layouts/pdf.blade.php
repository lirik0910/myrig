<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
  </head>
  <body style="margin: 0; padding: 0; font: 400 30px Calibri, sans-serif;">
    @php
      $order = App\Model\Shop\Order::where('number', $number)->with('orderDeliveries', 'products')->first();
      $delivery = App\Model\Shop\Delivery::where('id', $order->orderDeliveries->delivery_id)->first();
  @endphp
  <div style="width: 1000px; margin: 0 auto; padding-top: 270px">
    <img src="{{ url('uploads/design/dots.png') }}" alt="" style="position: absolute; top: 0; right: 650px;">
    
      <img src="{{ url('uploads/design/logo.png') }}" alt="" style="position: fixed; width: 300px; top: 45px; left: 265px">
    
    <div>
      <table style="width: 100%; font-size: 25px;">
        <tr>
          <td style="font-size: 40px;">Client Name</td>
          <td style="text-align: right; vertical-align: bottom;">{{$order->orderDeliveries->first_name}} {{$order->orderDeliveries->last_name}}</td>
        </tr>
        <tr>
          <td></td>
          <td style="text-align: right;">{{$order->orderDeliveries->address}}</td>
        </tr>
        <tr>
          <td style="text-transform: uppercase; font-weight: 700; letter-spacing: 4px;">INVOICE #{{ $order->number }}</td>
          <td style="text-align: right;">{{$order->orderDeliveries->city}}</td>
        </tr>
        <tr>
          <td>{{ date('d F`y') }}</td>
          <td style="text-align: right;">{{$order->number }}</td>
        </tr>
      </table>
    </div>
    <div style="margin-top: 70px;">
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
  <tbody id="bottom">
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
      <td align="center">{{number_format($price, 2, '.', '') }}</td>
      <td align="center" id="green">{{number_format($price * $product->pivot->count, 2, '.', '') }}</td>
    </tr>
    @endforeach
    
  </tbody>
</table>
      
      <table>
  <tr>
    <td style="width: 625px;">

        <table>
          <tr><td><table class="minimalist">
   <tbody> 
      <tr>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><strong></strong></td>
        <td><strong></strong></td>
      </tr>
      <tr>
        <td><strong></strong></td>
        <td><h2></h2></td>
      </tr>
    </tbody>
  </table></td></tr>
        </table>


    </td>

    <td>

        <table>
          <tr><td><table class="minimalist" style="width: 375px;">
   <tbody> 
      <tr id="bottom">
        <td id="bottom">TOTAL</td>
        <td id="bottom">{{ number_format($order->cost, 2, '.', '') }}</td>
      </tr>
      <tr>
        <td id="bottom"><strong>TAX</strong></td>
        <td id="bottom"><strong>$0.00</strong></td>
      </tr>
      <tr>
        <td style="line-height: 30px;"><strong>AMOUNT DUE</strong></td>
        <td id="green" style="line-height: 30px;"><h2>{{ number_format($order->cost, 2, '.', '') }}</h2></td>
      </tr>
    </tbody>
 </table></td></tr>
        </table>


    </td>
  </tr>
</table>
      

    </div>
    <p style="text-transform: uppercase; margin: 350px 0 0 0; font-size: 25px;">Payment Terms</p>
    <p style="margin: 0 0 60px; font-size: 25px;">Write your payment terms and conditions here</p>
  </div>
  <footer style="padding: 50px 0 50px; background: #77a565; font-size: 0; color: #fff;">
    <div style="width: 1333px; margin: 0 auto;">
      <div style="display: inline-block; width: 444.3px;">
        <div style="display: inline-block; margin-right: 15px;">
          <img src="{{ url('uploads/design/phone.png') }}" alt="" style="width: 50px; height: 50px;">
        </div>
        <div style="display: inline-block; vertical-align: top; width: 379.3px; font-size: 20px;">
          <p style="margin: 0;">+38 044 360 79 58</p>
          <p style="margin: 0;">+38 098 619 73 73</p>
        </div>
      </div>
      <div style="display: inline-block; width: 444.3px;">
        <div style="display: inline-block; margin-right: 15px;">
          <img src="{{ url('uploads/design/point.png') }}" alt="" style="width: 50px; height: 50px;">
        </div>
        <div style="display: inline-block; vertical-align: top; width: 379.3px; font-size: 20px;">
          <p style="margin: 0; padding-right: 50px;">3700 Quebec Street<br>Unit 100-239 Denver<br> Colorado 80270</p>
        </div>
      </div>
      <div style="display: inline-block; width: 444.3px;">
        <div style="display: inline-block; margin-right: 15px;">
          <img src="{{ url('uploads/design/world.png') }}" alt="" style="width: 50px; height: 50px;">
        </div>
        <div style="display: inline-block; vertical-align: top; width: 379.3px; font-size: 20px;">
          <p style="margin: 0;">alex@bitmainwarranty.com</p>
          <p style="margin: 0;">www.myrig.com.ua</p>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>
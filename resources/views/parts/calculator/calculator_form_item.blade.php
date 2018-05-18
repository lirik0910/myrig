<div class="calculator-form--item ">
    <div class="width-60">
        <select id="device" name="device" class="calc-select">
            <option value="hide" >{{__('default.device')}}</option>
            <option value="" data-hr="0">{{__('default.manual_input')}}</option>
            @if(isset($devices))
            @foreach ($devices as $device)
                <option data-currency="{{$device[3]}}" data-hr="{{$device[1]}}" data-en="{{$device[2]}}" value="{{$device[0]}}">{{$device[0]}}</option>
            @endforeach
            @endif
        </select>
    </div>

    <input type="number"  step="1" class="quantity width-33 quantity-center" id="quantity" name="qty" placeholder="1 шт" min="1" readonly>
</div>

<div class="calculator-form--item cur-LTC">
    <input type="number" step="0.01" class="quantity width-60 hash" name="hash" placeholder="{{__('default.input_hashrate') }}">

    <div class="width-33 cur-LTC-ul">
        <select id="ghs" name="powers" class="calc-select">

            @if(isset($cur) && $cur == 'LTC')
                <option value="1" selected>MH/s</option>
            @elseif(isset($cur) && $cur == 'DASH')
                <option value="1" selected>GH/s</option>
            @else
                <option  value="0.001" selected >TH/s</option>
            @endif
        </select>
    </div>
</div>
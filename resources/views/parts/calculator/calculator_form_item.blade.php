<div class="calculator-form--item ">
    <div class="width-60">
        <select id="device" name="device">
            <option value="hide" >Устройство</option>
            <option value="" data-hr="0">Ручной ввод</option>
            @foreach ($devices as $device)
                <option data-currency="{{$device['currency']}}" data-hr="{{$device['hr']}}" data-en="{{$device['en']}}" value="{{$device['name']}}">{{$device['name']}}</option>
            @endforeach
        </select>
    </div>

    <input type="number"  step="1" class="quantity width-33 quantity-center" id="quantity" name="qty" placeholder="1 шт" min="1" readonly>
</div>

<div class="calculator-form--item cur-LTC">
    <input type="number" step="0.01" class="quantity width-60 hash" name="hash" placeholder="Введите хешрейт">

    <div class="width-33 cur-LTC-ul">
        <select id="ghs" name="powers">
            @if($cur == 'LTC')
                <option value="1" selected>MH/s</option>
            @elseif($cur == 'DASH')
                <option value="1" selected>GH/s</option>
            @else
                <option  value="0.001" selected >TH/s</option>
            @endif
        </select>
    </div>
</div>
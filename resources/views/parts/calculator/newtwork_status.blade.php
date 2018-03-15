<div class="network-status--title ">Статус сети</div>
<div class="network-status--parent">
    <div class="network-status--inner">
        <div>Хэшрейт</div>
        <div class="hashrate">{{$data['hashrate']}}</div>
    </div>

    <div class="network-status--inner">
        <div>Сложность</div>
        <div class="difficulty">{{$data['difficulty']}}</div>
    </div>

    <div class="network-status--inner network-delimiter">
        <div>Добыча</div>
        <div>1 {{$TH}} * 24H = {{$P}} {{$currency}}</div>
    </div>

    @isset($btc)
        <div class="network-status--inner">
            <div>Ожидаемая следующая сложность</div>
            <div class="expected_diff">{{$data['expected_difficulty_raw']}}</div>
        </div>

        <div class="network-status--inner">
            <div>Дата следующей сложности</div>
            <div class="diff_date">{{$data['expected_difficulty_date']}}</div>
        </div>
    @endisset
</div>
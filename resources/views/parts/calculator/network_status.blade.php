@php
//var_dump($D); die;
@endphp
<div class="network-status--title ">{{ __('default.network_status') }}</div>
<div class="network-status--parent">
    <div class="network-status--inner">
        <div>{{ __('default.hashrate') }}</div>
        <div class="hashrate">@php echo $data['hashrate'] @endphp</div>
    </div>

    <div class="network-status--inner">
        <div>{{ __('default.difficulty') }}</div>
        <div class="difficulty">@if(isset($btc)) {{ number_format($D * 10000000000000 , 1, '.', '') }} @else {{ $data['difficulty']}} @endif</div>
    </div>

    <div class="network-status--inner network-delimiter">
        <div>{{ __('default.mining') }}</div>
        <div>1 {{$TH}} * 24H = {{$P}} {{$currency}}</div>
    </div>

    @isset($btc)
        <div class="network-status--inner">
            <div>{{ __('default.next_difficulty') }}</div>
            <div class="expected_diff">{{$data['expected_difficulty_raw']}}</div>
        </div>

        <div class="network-status--inner">
            <div>{{ __('default.next_difficulty_date') }}</div>
            <div class="diff_date">{{$data['expected_difficulty_date']}}</div>
        </div>
    @endisset
</div>
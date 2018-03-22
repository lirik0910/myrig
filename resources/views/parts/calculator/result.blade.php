<div class="income-table__inner">
    <div class="income-days-title ">Расчет</div>
</div>

<div class="income-table__title">
    <div class="income-table__title--item">
        <div class="income-icon income-icon-<?php echo $request->get('currency') == 'BTC' || $request->get('currency') == 'BCH' ? 1 : ''  ?>"><?php echo $request->get('currency') ?></div>
        <div class="income-icon income-icon-2">USD</div>
        <div class="income-icon income-icon-3">RUB</div>
        <div class="income-icon income-icon-4">UAH &#8372;</div>
    </div>
</div>

<div class="income-table__inner">
    <div class="income-table__inner-title">Доход</div>
    <div class="income-table__item">
        <div class="income-icon income-icon-1">BTC</div>
        <div class="income-number"><?php echo number_format($P,6, '.', '') ?></div>
        <div class="income-icon income-icon-2">USD</div>
        <div class="income-number"><?php echo  number_format($P*$coursers['base']["$currency / USD"] , 2, '.', '') ?></div>
        <div class="income-icon income-icon-3">RUB</div>
        <div class="income-number"><?php echo number_format($P*$coursers['base']["$currency / RUR"], 2, '.', '') ?></div>
        <div class="income-icon income-icon-4">UAH</div>
        <div class="income-number"><?php echo number_format($P*$coursers['base']["$currency / UAH"] , 2, '.', '')?></div>
    </div>
</div>

<div class="income-table__inner">
    <div class="income-table__inner-title">Затраты</div>
    <div class="income-table__item">
        <div class="income-icon income-icon-1">BTC</div>
        <div class="income-number"><?php echo number_format($costs['BTC'], 6, '.', '') ?></div>
        <div class="income-icon income-icon-2">USD</div>
        <div class="income-number"><?php echo  number_format($costs['USD'], 2, '.', '') ?></div>
        <div class="income-icon income-icon-3">RUB</div>
        <div class="income-number"><?php echo  number_format($costs['RUR'], 2, '.', '') ?></div>
        <div class="income-icon income-icon-4">UAH</div>
        <div class="income-number"><?php echo  number_format($costs['UAH'], 2, '.', '') ?></div>
    </div>
</div>

<div class="income-table__inner">
    <div class="income-table__inner-title">Прибыль</div>
    <div class="income-table__item">
        <div class="income-icon income-icon-1">BTC</div>
        <div class="income-number"><?php echo number_format($P - $costs['BTC'] ,6, '.', '') ?></div>
        <div class="income-icon income-icon-2">USD</div>
        <div class="income-number"><?php echo  number_format($P*$coursers['base']["$currency / USD"] - $costs['USD']  , 2, '.', '') ?></div>
        <div class="income-icon income-icon-3">RUB</div>
        <div class="income-number"><?php echo number_format($P*$coursers['base']["$currency / RUR"] - $costs['RUR'] , 2, '.', '') ?></div>
        <div class="income-icon income-icon-4">UAH</div>
        <div class="income-number"><?php echo number_format($P*$coursers['base']["$currency / UAH"]  - $costs['UAH'], 2, '.', '') ?></div>
    </div>
</div>
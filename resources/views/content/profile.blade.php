@extends('layouts.app')

@section('content')
    <main>
        <div class="main-back"></div>
        <script>
            var width = $(window).width();
            var cont = $('.container').outerWidth();
            var margin = (width - cont) / 2;
            var wM = cont * 33.333333 / 100 + margin;
            if (width > 767) {
                $('.main-back').css('left', wM +'px');
            }
            else {
                $('.main-back').css('left', '0px');
            }
        </script>
        @php
            $user = App\Model\Base\User::where('email', 'lirik-vagabund@yandex.ru')->with('attributes')->first();
        @endphp
        <section class="content profile">
            <div class="container">
                <div class="article-row row">
                    <div class="col-sm-4 profile-links">
                        <div>
                            <a href="" class="personal active" data-target="#personalF" data-wpel-link="internal">Персональные данные</a>
                        </div>
                        <div>
                            <a href="" class="history" data-target="#historyField" data-wpel-link="internal">История заказов</a>
                        </div>
                        <div>
                            <a href="{{url(env('APP_URL') . 'sso-login?action=logout')}}" class="exit" data-wpel-link="internal">Выйти</a>
                        </div>
                    </div>
                    <div class="article-content col-sm-8">
                        <div class="article-text">
                            <div id="personalF">
                                <form id="personalForm" action="#">
                                    <div class="form-group">

                                        <input type="text" value="{{$user->attributes->fname}}" name="first_name" placeholder="Имя" class="form-control full-width" required="required" data-bv-message=" "/>
                                    </div>
                                    <div class="form-group">

                                        <input type="text" value="{{$user->attributes->lname}}" name="last_name" placeholder="Фамилия" class="form-control full-width" required="required" data-bv-message=" "/>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Пароль" data-bv-identical-field="password_confirm" data-bv-message="Пароли не совпадают"/>
                                        <div class="checkbox-wrapper">
                                            <input type="checkbox" name="tfa" class="form-control tfa-check" />
                                            <label class="form-label">двуфакторная авторизация</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Повторите пароль" data-bv-identical-field="password_confirm" data-bv-message="Пароли не совпадают"/>

                                    </div>
                                    <div class="form-group tfa hidden">
                                        [twofactor_user_settings]	                    </div>
                                    <div class="form-group">
                                        <input type="email" name="user_email"  value="{{$user->email}}" disabled class="form-control" placeholder="Эл. почта" />
                                    </div>
                                    <div class="form-group">
                                        <input type="tel" name="billing_phone" value="{{$user->attributes->phone}}" class="form-control" placeholder="Телефон" required="required" data-bv-message=" "/>

                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="billing_address_1" value="{{$user->attributes->address}}" class="form-control full-width" placeholder="Адрес доставки" value=""/>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="submit" class="btn-default" value="Сохранить"/>
                                    </div>
                                    <input type="hidden" name="action" value="bitmain_account_register">
                                    <input type="hidden" name="user" value="3018">
                                </form>
                                <p class="result" data-text="Профиль обновлен!"></p>
                            </div>
                            <div id="historyField">

                                <div class="table-like">
                                    <div class="table-row table-header">
                                        <div class="table-cell  ">Номер и дата</div>
                                        <div class="table-cell ">Товар и его цена</div>
                                        <div class="table-cell table-cell-title">Кол-во</div>
                                        <div class="table-cell">Стоимость</div>


                                        <div class="table-cell table-cell-status">Статус</div>
                                        <div class="table-cell"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
<div style="display: none">
    <script type="text/javascript">
        var verifyCallback = function(response) {
            //console.log(response);
            $(document).find('#g-recaptcha-response').text(response);
        };
        var onloadCallback = function() {
            var captcha = grecaptcha.render('g-recaptcha', {
                'sitekey' : '6LdY_VMUAAAAANIypbzQz5mga0NnT-PJyASZbJOQ',
                'callback' : verifyCallback
            });
            //console.log('captcha response : ' + grecaptcha.getResponse(captcha));
          //  $(document).find('#g-recaptcha-response').text(grecaptcha.getResponse(captcha));
            //alert("grecaptcha is ready!");
        };
    </script>
    <div id="report-availability">
        <div class="modal-header">
            <ul class="reg-links">
                <li data-target="#enter-field"><a href="" data-wpel-link="internal">{{ __('default.report_availability_popup') }}</a></li>
            </ul>
        </div>
        <div class="modal-body">
            <div id="report-availability-field">
                <p class="report-message">{{ __('default.leave_request') }}</p>
                <form id="report-availability-form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="{{ __('default.name') }}" required="required"/>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="E-mail" required="required"/>
                    </div>
                    <div class="form-group">
                        <input name="phone" type="tel" class="form-control" placeholder="{{ __('default.phone') }}" required="required"/>
                    </div>
                    <div class="selects">
                        <div class="form-group report-form-select">
                            <select name="product" class="form-control"></select>
                            <input type="number"  step="1" class="quantity width-33 quantity-center" name="count-1" placeholder="1" min="1" value="1"/>
                        </div>

                        <div class="form-group form-group-btn" style="float: left">
                            <a href="#" class="form-control report-select-btn add-report-select">+</a>
                        </div>
                        <div class="form-group form-group-btn form-group-btn-remove" style="float: right">
                            <a href="#" class="form-control report-select-btn remove-report-select">-</a>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 60px; margin-bottom: 20px">
                        <div id="g-recaptcha" data-check="0"></div>
                    </div>

                    <p class="error-captcha">{{ __('default.captcha') }}</p>

                    <div class="form-group" style="position: inherit">
                        <input type="submit" name="submit" value="{{ __('default.send') }}" class="btn-default btn-subscribe"/>
                    </div>
                </form>
                <div class="result">
                    <div class="success-header">{{ __('default.thank_you') }}</div>
                    <div class="result-body">{{ __('default.manager_contact') }}</div>
                    <button data-fancybox-close>{{ __('default.close') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

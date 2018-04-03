<div style="display: none">
    <div id="report-availability">
        <div class="modal-header">
            <ul class="reg-links">
                <li data-target="#enter-field"><a href="" data-wpel-link="internal">Report availability</a></li>
            </ul>
        </div>
        <div class="modal-body">
            <div id="report-availability-field">
                <form id="report-availability-form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Name" required="required"/>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="E-mail" required="required"/>
                    </div>
                    <div class="form-group">
                        <input name="phone" type="tel" class="form-control" placeholder="Phone" required="required"/>
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

                    <div class="form-group" style="position: inherit">
                        <input type="submit" name="submit" value="Send" class="btn-default btn-subscribe"/>
                    </div>
                </form>
                <div class="result">
                    <div class="success-header">Thank you<br/> for request!</div>
                    <div class="result-body">Manager contact with you.</div>
                    <button data-fancybox-close>Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

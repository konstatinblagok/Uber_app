<div class="alert {{ Session::get('alert-class', 'alert-info') }}" role="alert">

    <div class="row" style="display: flex;align-items: center;">

        <div class="col-md-4 offset-2">

            <label for="">@lang('lang.Email verification required')!</label>

        </div>

        <div class="col-md-6">

            <a href="{{ route('user.email.verification.resend') }}" type="button" class="btn btn-chezdon">@lang('lang.Resend Email')</a>

        </div>

    </div>
    
</div>

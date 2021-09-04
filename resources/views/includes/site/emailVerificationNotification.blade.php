<div class="alert {{ Session::get('alert-class', 'alert-info') }}" role="alert">

    <div class="row">

        <div class="col-md-4 offset-2">

            <label for="">Email verification required!</label>

        </div>

        <div class="col-md-6">

            <a href="{{ route('user.email.verification.resend') }}" type="button" class="btn btn-chezdon">Resend Email</a>

        </div>

    </div>
    
</div>

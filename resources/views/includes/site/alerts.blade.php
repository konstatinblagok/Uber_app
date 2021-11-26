@if(Session::has('error'))
    <div class="alert {{ Session::get('alert-class', 'alert-danger') }} fadedAlert" role="alert">
        <i class="mdi mdi-alert-circle-outline mr-2"></i>@lang('lang.'.Session::get('error'))
        <script>
            setTimeout(function () {
                $('div.fadedAlert').toggle(1000);
            }, 5000);
        </script>
    </div>
@endif

@if(Session::has('success'))
    <div class="alert {{ Session::get('alert-class', 'alert-success') }} fadedAlert" role="alert">
        <i class="mdi mdi-alert-circle-outline mr-2"></i>@lang('lang.'.Session::get('success'))
        <script>
            setTimeout(function () {
                $('div.fadedAlert').toggle(1000);
            }, 5000);
        </script>
    </div>
@endif

@if(Session::has('info'))
    <div class="alert {{ Session::get('alert-class', 'alert-info') }} fadedAlert" role="alert">
        <i class="mdi mdi-alert-circle-outline mr-2"></i>@lang('lang.'.Session::get('info'))
        <script>
            setTimeout(function () {
                $('div.fadedAlert').toggle(1000);
            }, 5000);
        </script>
    </div>
@endif
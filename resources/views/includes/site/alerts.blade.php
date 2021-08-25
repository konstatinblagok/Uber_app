@if(Session::has('error'))
    <div class="alert {{ Session::get('alert-class', 'alert-danger') }}" role="alert">
        <i class="mdi mdi-alert-circle-outline mr-2"></i>{{ Session::get('error') }}
        <script>
            setTimeout(function () {
                $('div.alert').toggle(1000);
            }, 5000);
        </script>
    </div>
@endif

@if(Session::has('success'))
    <div class="alert {{ Session::get('alert-class', 'alert-success') }}" role="alert">
        <i class="mdi mdi-alert-circle-outline mr-2"></i>{{ Session::get('success') }}
        <script>
            setTimeout(function () {
                $('div.alert').toggle(1000);
            }, 5000);
        </script>
    </div>
@endif

@if(Session::has('info'))
    <div class="alert {{ Session::get('alert-class', 'alert-info') }}" role="alert">
        <i class="mdi mdi-alert-circle-outline mr-2"></i>{{ Session::get('info') }}
        <script>
            setTimeout(function () {
                $('div.alert').toggle(1000);
            }, 5000);
        </script>
    </div>
@endif
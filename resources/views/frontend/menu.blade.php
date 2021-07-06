@extends('layouts.app')
@section('content')

<main>
    <div class="section" id="menu">
        <div id="menuword">
            <p>Menu</p>
        </div>
    </div>
    <div class="menusection">
        
        @foreach ($menu as $mn)

            <div class="heading">
                <p>{{ $mn->name }}</p>
            </div>
            <hr id="devider">
            <p class="description">{{ $mn->description }}</p>

            <div class="subsection" id="starter">
                
                @foreach ($mn->menu as $mnMenu)
                
                    <div class="item" id="box1">
                        <h5>{{ $mnMenu->name }}</h5>
                        <p>{{ $mnMenu->description }}</p>
                        <p>{{ $mnMenu->currency->symbol }}{{ $mnMenu->price }}</p>
                        <hr>
                    </div>

                @endforeach

            </div>

        @endforeach

    </div>
</main>

@endsection

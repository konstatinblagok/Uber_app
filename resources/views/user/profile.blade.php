@extends('layouts.app')
@section('content')

<main>
    <div class="row">
        <div class="memcol">
            <div class="memberimg">
                <img src="{{ asset('site-asset/images/sample.jpg') }}" alt="member image">
                <p class="span">{{ Auth::user()->name }}</p>
            </div>
            <div class="followers">
                <p id="rb">Followers</p>
                <p id="gb">Following</p>
            </div>
            <button class="followbtn">Follow</button>
    </div>
</main>

@endsection

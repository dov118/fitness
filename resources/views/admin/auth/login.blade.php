@extends('admin.layouts.admin')

@section('content')
    <div class="col-6 mx-auto text-center" style="max-width: 360px">
        <a class="btn btn-large btn-outline mt-5" type="button" href="{{ route('login.discord') }}">
            <img class="octicon" src="{{ Vite::asset('resources/imgs/discord.svg') }}" alt="">
            <span>Login with discord</span>
        </a>
    </div>
@endsection

@extends('layouts.app')

@section('content')
<div class="content dashboard">
    {{--Laat zien dat de leerling ingelogd is omdat hij/zij begroet wordt mijn zijn/haar naam--}}
    <h1>Welkom {{ $user->firstname}}</h1>
    <img class="dashboard_img" src="{{ asset('storage/images/dashboard.svg') }}">
</div>

@endsection

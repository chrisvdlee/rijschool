@extends('layouts.app')

@section('content')
    <div class="content announcements">
        <h1>Mededelingen</h1>
        <div class="announcement_wrapper">
            @foreach($announcementsSorted as $announcement)
                <div class="announcement">
                    <div class="left">
                        {{--Laat de datum en tijd van de mededeling zien in een bepaalde format--}}
                        <p>{{ \Carbon\Carbon::parse($announcement->created_at)->formatLocalized('%d %b %Y') }}</p>
                        <p>{{ \Carbon\Carbon::parse($announcement->created_at)->format('H:i') }}</p>
                    </div>
                    <div class="right">
                        <h3>{{ $announcement->title}}</h3>
                        <p>{{ $announcement->message}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

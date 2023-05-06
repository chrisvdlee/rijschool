@extends('layouts.app')

@section('content')
<div class="content lesrooster" x-data="{ open: false }">
    <h1>Lesrooster</h1>
    {{--Button voor een pop up waarin het formulier voor een les inplannen staat--}}
    <button class="button"  @click="open = ! open">Les inplannen</button>
    <div class="lessons">
        <div class="future-wrapper">
            <h3 class="future_title">Toekomstige lessen</h3>
            @foreach($futureSorted as $lesson)
                <a class="lesson future" href="{{ route('future_show', $lesson->id) }}">
                    <div class="top">
                        <p>{{ $lesson->instructor_name}}</p>
                        <p>{{ \Carbon\Carbon::parse($lesson->date)->formatLocalized('%a %d %B %Y') }}</p>

                    </div>
                    <div class="bottom">
                        <p>{{ $lesson->lessonobjective}}</p>
                        <div class="time">
                            <p>{{ \Carbon\Carbon::parse($lesson->start_time)->format('H:i')}} - {{ \Carbon\Carbon::parse($lesson->finish_time)->format('H:i')}}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="finished_wrapper">
            <h3 class="finished_title">Voltooide lessen</h3>
            @foreach($finishedSorted as $lesson)
                <a class="lesson finished" href="{{ route('finished_show', $lesson->id) }}">
                    <div class="top">
                        <p>{{ $lesson->instructor_name}}</p>
                        <p>{{ \Carbon\Carbon::parse($lesson->date)->formatLocalized('%a %d %B %Y') }}</p>
                    </div>
                    <div class="bottom">
                        <p>{{ $lesson->lessonobjective}}</p>
                        <div class="time">
                            <p>{{ \Carbon\Carbon::parse($lesson->start_time)->format('H:i')}} - {{ \Carbon\Carbon::parse($lesson->finish_time)->format('H:i')}}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    {{--Formulier voor een les inplannen--}}
    <div class="alert" x-cloak x-show="open">
        <div class="main-alert">
            <div class="relative-wrapper">
                <button class="close"  @click="open = ! open"><i class="fa-solid fa-xmark fa-2x"></i></button>
                <div class="form_wrapper">
                    <form action="{{ route('lesson.store') }}" method="POST">
                        @csrf
                        <h3>Rijles inplannen</h3>
                        <h4>Instructeur*</h4>
                        <select class="input" name="instructor" id="instructor" required>
                            <option value="piet">Piet Rijsnel</option>
                            <option value="Klaas">Klaas Hoekstra</option>
                            <option value="Julia">Julia Slingerveen</option>
                            <option value="Sarah">Sarah Bloemfontijn</option>
                        </select>
                        <h4>Ophaallocatie*</h4>
                        <input class="input" id="location" name="location" type="text" required>
                        <h4>Lesdoel</h4>
                        <input class="input" id="objective" name="objective" type="text">
                        <h4>Datum*</h4>
                        {{--Kalender invoerveld waarin de dagen die je selecteren kan gelimiteerd word op alleen toekomstige datums (Dus niet vandaag en dagen ervoor)--}}
                        <input class="input" id="date" name="date" type="date" min="{{ Carbon\Carbon::now()->addDay()->format('Y-m-d') }}" required>
                        <div class="time">
                            <div class="time_wrapper">
                                <h4>Start tijd*</h4>
                                <input class="input" id="start_time" name="start_time" type="time" required>
                            </div>
                            <div class="time_wrapper">
                                <h4>Eind tijd*</h4>
                                <input class="input" id="end_time" name="end_time" type="time" required>
                            </div>
                        </div>
                        <button class="button">Les inplannen</button>
                    </form>
                    <img src="{{ asset('storage/images/les_inplannen.svg') }}">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{--Script om de alert te sluiten door de pagina te herladen--}}
<script>
    function refreshPage(){
        window.location.reload();
    }
</script>

{{-- Alert wanneer iets gelukt is --}}
@if (Session::has('success'))
    <div class="alert-wrapper">
        <div class="alert text-alert" role="alert">
            {{ session('success') }}
            <button class="button" type="button" onClick="refreshPage()">Sluiten</button>
        </div>
    </div>
@endif

{{--Alert wanneer er iets fout gaat--}}
@if (Session::has('error'))
    <div class="alert-wrapper">
        <div class="alert text-alert" role="alert">
            {{ session('error') }}
            <button class="close" type="button" onClick="refreshPage()">Close</button>
        </div>
    </div>
@endif

{{--Pop up voor alle toekomstige lessen--}}
@if (Session::has('future_lesson_show'))
    <div class="alert-wrapper">
        <div class="alert" role="alert">
            <div class="relative-wrapper">
                {{ session('future_lesson_show') }}
                <button class="close" type="button" onClick="refreshPage()"><i class="fa-solid fa-xmark fa-2x"></i></button>
                <h3>Rijles {{ \Carbon\Carbon::parse($futureLesson->date)->formatLocalized('%A %d %B %Y') }}</h3>
                <p>{{ \Carbon\Carbon::parse($futureLesson->start_time)->format('H:i')}} - {{ \Carbon\Carbon::parse($futureLesson->finish_time)->format('H:i')}}</p>
                <div class="info-wrapper">
                    <div class="info">
                        <h4>Instructeur:</h4>
                        <p>{{ $futureLesson->instructor_name}}</p>
                        <h4>Ophaallocatie:</h4>
                        <p>{{ $futureLesson->location}}</p>
                        <h4>Lesdoel:</h4>
                        <p>{{ $futureLesson->lessonobjective}}</p>
                    </div>
                    <img src="{{ asset('storage/images/toekomstige_rijles.svg') }}">
                </div>
            </div>
        </div>
    </div>
@endif

{{--pop up voor alle voltooide lessen met alle opmerkingen--}}
@if (Session::has('finished_lesson_show'))
    <div class="alert-wrapper">
        <div class="alert" role="alert">
            <div class="relative-wrapper">
                {{ session('finished_lesson_show') }}
                <button class="close" type="button" onClick="refreshPage()"><i class="fa-solid fa-xmark fa-2x"></i></button>
                <h3>Rijles {{ \Carbon\Carbon::parse($lesson->date)->formatLocalized('%A %d %B %Y') }}</h3>
                <p>{{ \Carbon\Carbon::parse($lesson->start_time)->format('H:i')}} - {{ \Carbon\Carbon::parse($lesson->finish_time)->format('H:i')}}</p>
                <div class="info-wrapper">
                    <div class="info">
                        <h4>Instructeur:</h4>
                        <p>{{ $lesson->instructor_name}}</p>
                        <h4>Ophaallocatie:</h4>
                        <p>{{ $lesson->location}}</p>
                        <h4>Lesdoel:</h4>
                        <p>{{ $lesson->lessonobjective}}</p>
                        <h4>Opmerkingen instructeur:</h4>
                        <p>{{ $lesson->instructor_comment}}</p>
                        <h4>Opmerkingen leerling:</h4>
{{--                        @dd($lesson->comment);--}}
                        @foreach($lesson->comment as $comment)
                            <p class="comment">{{ $comment->comment}}</p>
                        @endforeach
                    </div>
                    <img src="{{ asset('storage/images/voltooide_les.svg') }}">
                </div>
                <a class="button" href="{{ route('comment.create', $lesson->id) }}">Opmerking toevoegen</a>
            </div>
        </div>
    </div>
@endif

{{--Pop up om een opmerking aan te maken--}}
@if (Session::has('comment'))
    <div class="alert-wrapper">
        <div class="alert" role="alert">
            <div class="relative-wrapper">
                {{ session('finished_lesson_show') }}
                <button class="close" type="button" onClick="refreshPage()"><i class="fa-solid fa-xmark fa-2x"></i></button>
                <h3>Rijles {{ \Carbon\Carbon::parse($lesson->date)->formatLocalized('%A %d %B %Y') }}</h3>
                <p>{{ \Carbon\Carbon::parse($lesson->start_time)->format('H:i')}} - {{ \Carbon\Carbon::parse($lesson->finish_time)->format('H:i')}}</p>
                <div class="info-wrapper">
                    <div class="opmerking">
                        <form action="{{ route('comment.store')}}" method="POST">
                            @csrf
                            <h4>Opmerking toevoegen:</h4>
                            <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
                            <textarea class="input" id="comment" name="comment" rows="4" cols="50"></textarea>
{{--                            <input class="input" id="comment" name="comment" type="text">--}}
                            <div class="buttons">
                                <button type="submit" class="button">Opslaan</button>
                                <a class="button button_reverse" href="{{ route('finished_show', $lesson->id) }}">Annuleren</a>
                            </div>
                        </form>
                    </div>
                    <img src="{{ asset('storage/images/opmerking.svg') }}">
                </div>
            </div>
        </div>
    </div>
@endif

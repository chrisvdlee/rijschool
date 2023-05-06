<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Comment;
use Carbon\Carbon;

class LessonController extends Controller
{
    public function index()
    {
        // Haalt de ingelogde gebruiker op
        $user = auth()->user();

        // Set de taal van de datums in het Nederlands
        setlocale(LC_ALL, 'nld_nld');

        // Haalt alle toekomstige lessen op basis van de ingelogde gebruiker op
        $allfutureLessons = Lesson::where('user_id', '=', $user->id)->where('date', '>', Carbon::today()->toDateString())
            ->orWhere(function ($query) use ($user) {
                $query->where('user_id', '=', $user->id)->where('date', '=', Carbon::today()->toDateString())->where('finish_time', '>', Carbon::now()->format('H:i:m'));
            })->get();

        // Haalt alle voltooide lessen op basis van de ingelogde gebruiker op
        $allfinishedLessons = Lesson::where('user_id', '=', $user->id)->where('date', '<', Carbon::today()->toDateString())
            ->orWhere(function ($query) use ($user) {
                $query->where('user_id', '=', $user->id)->where('date', '=', Carbon::today()->toDateString())->where('finish_time', '<', Carbon::now()->format('H:i:m'));
            })->get();

        // Sorteerd de toekomstige lessen op datum
        $futureSorted = $allfutureLessons->sortBy([
            ['date', 'asc'],
            ['start_time', 'asc'],
        ]);

        // Sorteerd de voltooide lessen op datum
        $finishedSorted = $allfinishedLessons->sortBy([
            ['date', 'desc'],
            ['start_time', 'desc'],
        ]);

        $futureLesson = session('futureLesson');
        session()->forget('futureLesson');

        $finishedLesson = session('finishedLesson');
        session()->forget('finishedLesson');

        // Stuurt de gebruiker naar lesson.index met alle voltooide lessen en toekomstige lessen
        return view("lesson.index", compact("finishedSorted", "futureSorted", "futureLesson", "finishedLesson"));
    }

    public function store(Request $request)
    {
        // Haalt de ingelogde gebruiker op
        $user = auth()->user();

        // Haalt de lessen op van de opgegeven dag
        $result1 = Lesson::where('date', '=', $request->date)
            // Al zijn er lessen op die dag wordt er gekeken of de leerling van de les hetzelfde is als de ingelogde leerling
            ->where('user_id', '=', $user->id)
            ->get();

//      Er zijn geen andere lessen op de opgegeven dag of de les is niet van de ingelogde gebruiker
        if (count($result1) == '0') {
            // Maakt nieuwe les aan
            Lesson::create([
                'user_id' => $user->id,
                'instructor_name' => $request->instructor,
                'location' => $request->location,
                'lessonobjective' => $request->objective,
                'date' => $request->date,
                'start_time' => $request->start_time,
                'finish_time' => $request->end_time
            ]);
            //Stuurt de gebruiker terug naar lesson.index en geeft aan dat het gelukt is
            return redirect()->route("lesson.index")->with('success', 'Les succesvol ingeplant.');
        }
        else {
            // Haalt alle lessen op
            $lessen = Lesson::all();

            // Haalt alle lessen op die buiten de gegeven dag en tijd is
            $result2 = Lesson::whereNot('date', '=', $request->date)
                ->whereNot('user_id', '=', $user->id)
                ->where('start_time', '>', $request->start_time)
                ->where('start_time', '>', $request->end_time)
                ->orWhere(function ($query) use ($request) {
                    $query->where('finish_time', '<', $request->start_time)
                        ->where('finish_time', '<', $request->end_time);
                })->get();

            // Als alle lessen die erbuiten vallen evenveel is als alle lessen die er zijn (Dus dan zijn er geen lessen die binnen de opgegeven tijd zijn)
            if (count($result2) == count($lessen)) {
                // Maakt nieuwe les aan
                Lesson::create([
                    'user_id' => $user->id,
                    'instructor_name' => $request->instructor,
                    'location' => $request->location,
                    'lessonobjective' => $request->objective,
                    'date' => $request->date,
                    'start_time' => $request->start_time,
                    'finish_time' => $request->end_time
                ]);
                //Stuurt de gebruiker terug naar lesson.index en geeft aan dat het gelukt is
                return redirect()->route("lesson.index")->with('success', 'Les succesvol ingeplant.');
            } else {
                //Stuurt de gebruiker terug naar lesson.index en geeft aan dat de les op dat tijdstip niet mogelijk is
                return redirect()->route("lesson.index")->with('error', 'Op deze tijd is de instructeur al bezet');
            }
        }
    }

    public function future_show(Lesson $lesson)
    {
        $futureLesson = $lesson;
        // Stuurt je naar lesson.index met een pop up van de geselecteerde les
        return redirect()->route("lesson.index")->with(['future_lesson_show' => '.', 'futureLesson' => $futureLesson]);
    }

    public function finished_show(Lesson $lesson)
    {
        $finishedLesson = $lesson;
        // Haalt alle opmerkingen op van de geselecteerde les
        $comment = Comment::all()->where('lesson_id', '=', $lesson->id);
        // Stuurt je naar lesson.index met alle opmerkingen en met een pop up van de geselecteerde les
        return redirect()->route("lesson.index")->with(['finished_lesson_show' => '.', 'finishedLesson' => $finishedLesson]);
    }
}

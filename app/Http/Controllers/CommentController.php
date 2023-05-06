<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Lesson $lesson)
    {
        // Stuurt de gebruiker naar lesson.index met de opmerkingformulier pop up
        return redirect()->route("lesson.index", compact("lesson"))->with('comment', '.');
    }

    public function store(Request $request)
    {
        //Haalt de les op die geselecteerd was
        $lesson = Lesson::all()->where('id', '=', $request->lesson_id);

        // Haalt de ingelogde gebruiker op
        $user = auth()->user();

        // Maakt opmerking aan
        Comment::create([
            'user_id'=> $user->id,
            'lesson_id'=> $request->lesson_id,
            'comment'=> $request->comment
        ]);

        // Stuurt de gebruiker terug naar de voltooide les pop up waar hij/zij net op zat
        return redirect()->route("lesson.index", compact("lesson"))->with('finished_lesson_show', '.');
    }
}

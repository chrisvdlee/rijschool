<?php

namespace App\Models;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    protected $fillable = [
        'id',
        'user_id',
        'lesson_id',
        'comment',
    ];
}

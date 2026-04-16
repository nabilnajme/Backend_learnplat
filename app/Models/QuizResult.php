<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Quiz;

class QuizResult extends Model
{
    protected $fillable = ['quiz_id', 'apprenant_id', 'score', 'total_questions'];

    public $timestamps = false;

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
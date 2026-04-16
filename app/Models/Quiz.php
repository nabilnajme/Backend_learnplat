<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{

    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['course_id', 'title', 'duration_minutes'];
 
    public function course() { 

        return $this->belongsTo(Course::class); 

    }


    public function questions() { 

    
        return $this->hasMany(Question::class); 
        
    }
    // public function results()   { return $this->hasMany(QuizResult::class); }

}

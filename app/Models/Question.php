<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['quiz_id', 'question_text', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_option'];
 
    public function quiz() {

    
        return $this->belongsTo(Quiz::class); 
        
    }
}
    //


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Chapter;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description','category', 'formateur_id', 'is_published'];

    //

    public function enrollments(){
        return $this->hasMany(Enrollment::class);

    }
    public function chapters(){
        return $this->hasMany(Chapter::class)->orderBy('order_num');

    }
    public function quizzes(){
        return $this->hasMany(Quiz::class);

    }

    public function formateur(){
        return $this->belongsTo(User::class , "formateur_id");
    }
}

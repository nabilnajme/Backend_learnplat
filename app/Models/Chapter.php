<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chapter extends Model
{
    use HasFactory;
     public $timestamps = false;
    protected $fillable = ['course_id', 'title', 'content', 'order_num'];
    //
    public function course() {

        return $this->belongsTo(Course::class); 

    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Course;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
     use HasApiTokens, HasFactory, Notifiable;
     
    protected $fillable = ['name', 'email', 'password', 'role'];

    public function courses()    { return $this->hasMany(Course::class, 'formateur_id'); }
}

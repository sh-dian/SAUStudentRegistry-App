<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'address',
        'study_course_id',
    ];

    public function course(){
        return $this->belongsTo(StudyCourse::class);
    }
}

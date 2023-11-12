<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniversityStaff extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    protected $table = 'university_staffs';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

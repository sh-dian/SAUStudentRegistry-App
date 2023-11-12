<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\RegistrationStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'registration_status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        // Enum
        'registration_status' => RegistrationStatusEnum::class,
    ];

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }

    public function isLecturer(): bool
    {
        return $this->hasRole('lecturer');
    }

    public function universityStaff()
    {
        return $this->hasOne(UniversityStaff::class);
    }

    public function getRegistrationStatusLabelAttribute()
    {
        return RegistrationStatusEnum::from($this->attributes['registration_status'])->label;
    }
}

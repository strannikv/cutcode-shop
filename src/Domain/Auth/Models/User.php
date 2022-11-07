<?php

namespace Domain\Auth\Models;

// use Illuminate\Contracts\AuthRegistrar\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'github_id',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    public function avatar(): Attribute
    {
        return Attribute::make(
            get:fn() => 'https://ui-avatars.com/api/?name='.$this->name
        );
    }
}

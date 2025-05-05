<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'user';
    protected $casts = ['roles' => 'array'];
    protected $fillable = ['email', 'password', 'roles'];

    public static function createUser(array $data): self
    {
        return self::create([
            'email' => $data['email'],
            'password' => $data['password'],
            'roles' => $data['roles'] ?? ['Client'],
        ]);
    }

    public function hasRole($role)
    {
        return in_array($role, $this->roles);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property Collection|Service[] $services
 * @property Collection|Event[] $events
 *
 * @property string name
 * @property string email
 * @property string password
 * @property string phone_number
 * @property bool is_admin
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return HasMany
     */
    public function services(): HasMany
    {
        return $this->hasMany('Service', 'administrator_id');
    }

    /**
     * @return HasMany
     */
    public function events(): HasMany
    {
        return $this->hasMany('Event', 'administrator_id');
    }
}

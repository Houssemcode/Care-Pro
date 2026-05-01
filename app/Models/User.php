<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'phone'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone', // Add your custom fields here!
    ];

    public function family()
    {
        return $this->hasOne(Family::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function localization()
    {
        return $this->hasOne(Localization::class);
    }
    public function getRoleBadgeAttribute()
    {
        if ($this->admin) return ['name' => 'Admin', 'class' => 'bg-slate-100 text-slate-700 ring-slate-500/20'];
        if ($this->employee) return ['name' => 'Employee', 'class' => 'role-employee'];
        return ['name' => 'Family', 'class' => 'role-family'];
    }
    public function isAdmin(): bool
    {
        return $this->admin !== null;
    }

    public function isEmployee(): bool
    {
        return $this->employee !== null;
    }

    public function isFamily(): bool
    {
        return $this->family !== null;
    }
}

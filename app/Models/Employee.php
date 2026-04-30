<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    // Add this line!
    protected $fillable = ['user_id', 'experience', 'diploma', 'status', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function documents()
    {
        return $this->hasMany(EmployeeDocument::class);
    }
}

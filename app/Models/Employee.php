<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    // Add this line!
    protected $fillable = ['user_id', 'experience', 'diploma', 'status', 'description'];
}

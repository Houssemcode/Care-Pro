<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    // Add this line!
    protected $fillable = ['user_id', 'address'];
}

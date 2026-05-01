<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingMessage extends Model
{
    protected $fillable = ['request_id', 'user_id', 'message'];

    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

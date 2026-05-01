<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localization extends Model
{
    protected $fillable = ['user_id', 'wilaya', 'commune', 'latitude', 'logitude'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get a formatted address string (commune, wilaya).
     */
    public function getFullAddressAttribute(): string
    {
        return "{$this->commune}, {$this->wilaya}";
    }
}

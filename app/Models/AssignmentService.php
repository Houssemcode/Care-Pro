<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentService extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_id',
        'offre_id',
        'price',
        'assigned_at', // <-- Added this
        'start_date',
        'end_date',
        'status',
    ];

    // Automatically cast these columns to Carbon date objects
    protected $casts = [
        'assigned_at' => 'datetime',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // --- Relationships ---
    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function offre()
    {
        return $this->belongsTo(Offre::class);
    }
    public function rating()
    {
        return $this->hasOne(Rating::class);
    }
}
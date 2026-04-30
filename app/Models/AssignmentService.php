<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentService extends Model
{
    // Match the exact spelling of your migration table!
    protected $table = 'assignement_services';
    
    // Depending on if your migration has $table->timestamps(), you may need to disable them
    public $timestamps = false; 

    protected $fillable = [
        'family_id', 
        'offre_id', 
        'assigned_at', 
        'price'
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
}
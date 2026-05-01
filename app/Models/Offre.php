<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'wilaya',
        'commune',
        'service_type',
        'working_house',
    ];

    // Automatically cast this column to a boolean
    protected $casts = [
        'working_house' => 'boolean',
    ];

    public function employee()
    {
        // An Offre belongs to one Employee
        return $this->belongsTo(Employee::class);
    }
    
    // (Optional but recommended) If you want to access the requests from an offer later:
    public function requests()
    {
        return $this->hasMany(BookingRequest::class, 'offre_id');
    }
}

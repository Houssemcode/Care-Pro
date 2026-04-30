<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['assignment_service_id', 'stars', 'comment'];

    public function assignmentService()
    {
        return $this->belongsTo(AssignmentService::class);
    }
}
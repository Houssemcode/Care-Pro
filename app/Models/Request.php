<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests'; // Links to your requests table
    protected $fillable = ['family_id', 'offre_id', 'start_date', 'end_date', 'status'];

    public function family() { return $this->belongsTo(Family::class); }
    public function offre() { return $this->belongsTo(Offre::class); }
}
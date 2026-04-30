<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignementService extends Model
{
    protected $table = 'assignement_services';
    public $timestamps = false; // Based on your ERD
    protected $fillable = ['family_id', 'offre_id', 'assigned_at', 'price'];

    public function family() { return $this->belongsTo(Family::class); }
    public function offre() { return $this->belongsTo(Offre::class); }
}
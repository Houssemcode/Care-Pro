<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['admin_id', 'employee_id', 'family_id', 'report_reason', 'description', 'status'];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function family() {
        return $this->belongsTo(Family::class);
    }

    public function admin() {
        return $this->belongsTo(Admin::class);
    }
}
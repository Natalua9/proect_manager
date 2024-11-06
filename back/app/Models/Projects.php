<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'date_start',
        'date_end',
        'status',
        'id_manager',
        
    ];
    public function reportsProject() {
        return $this->hasMany(Reports::class);
    }
    public function projectTask() {
        return $this->hasMany(Tasks::class, 'id_project');
    }
    public function user() {
        return $this->belongsTo(User::class, 'id_manager');
    }
}

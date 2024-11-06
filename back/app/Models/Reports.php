<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_project',
        'date_start',
        'id_user',
        'statistics',
    ];
    public function reportUser() {
        return $this->belongsTo(related: User::class);
        }
        public function project() {
            return $this->belongsTo(related: Projects::class);
            }
}

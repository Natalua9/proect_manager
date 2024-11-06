<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'id_project',
        'id_user',
        'priority',
        'date_start',
        'date_end',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class,'id_user');
        }
        public function projects() {
            return $this->belongsTo(Projects::class, 'id_project');
        }
        public function comment() {
            return $this->hasMany(Comment::class, 'id_task');
        }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'content',   
        'id_user',
        'id_task',
    ];
    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function task() {
        return $this->belongsTo(Tasks::class, 'id_task');
    }
}

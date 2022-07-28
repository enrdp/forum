<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    use HasFactory;
    protected $fillable = ['thread_id', 'user_id','like', 'dislike'];

    public function threads()
    {
        return $this->belongsTo(Thread::class);
    }
}

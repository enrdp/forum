<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'user_id','thread_id', 'body'];

    /**
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'thread_id';
    }


    public function threads()
    {
       return $this->belongsTo(Thread::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

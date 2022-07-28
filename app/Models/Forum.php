<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'desc','user_id', 'category_id'];

    public function threads()
    {
        return $this->HasMany(Thread::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function latestThread()
    {
        return $this->hasOne(Thread::class)->latest();
    }
    public function countThread()
    {
        return $this->hasMany(Thread::class);
    }

}

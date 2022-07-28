<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['title','user_id','desc','image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function forum()
    {
        return $this->HasMany(Forum::class);
    }
}

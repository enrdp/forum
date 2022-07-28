<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;


class Thread extends Model
{
    use HasFactory;
    use HasRichText;
    protected $guarded = [];
    protected $richTextFields = [
        'body',
    ];
    protected $fillable = ['user_id', 'title', 'body','forum_id'];

    public function reply()
    {
        return $this->HasMany(Reply::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }
    public function countReply()
    {
        return $this->hasMany( Reply::class);
    }
    public function incrementReadCount() {
        $this->reads++;
        $this->timestamps = false;
        return $this->save();
    }
    public function likes()
    {
        return $this->HasMany(Likes::class);
    }
}

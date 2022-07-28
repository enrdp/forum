<?php

namespace App\Http\Livewire;

use App\Models\Likes;
use Livewire\Component;

class Like extends Component
{
    public $thread;
    public function like($id)
    {

        if(Likes::where('thread_id', $id)
            ->where('user_id', auth()->user()->id)
            ->where('like', 1)->count() === 1 ){

            Likes::where('thread_id', $id)
                ->where('user_id', auth()->user()->id)
                ->update([
                'like' => 0,
            ]);
        }else{
        Likes::updateOrCreate(
            [
                'user_id' => auth()->user()->id,
                'thread_id' => $id
            ],
            [
                'like' => true,
                'dislike' => false
        ]);
        }
    }

    public function dislike($id)
    {
        if(Likes::where('thread_id', $id)
                ->where('user_id', auth()->user()->id)
                ->where('dislike', 1)->count() === 1 ){

            Likes::where('thread_id', $id)
                ->where('user_id', auth()->user()->id)
                ->update([
                    'dislike' => 0,
                ]);
        }else {

            Likes::updateOrCreate(
                [
                    'user_id' => auth()->user()->id,
                    'thread_id' => $id
                ],
                [
                    'like' => false,
                    'dislike' => true
                ]);
        }

    }

    public function render()
    {
        $like = Likes::where('user_id', auth()->user()->id)
            ->where('thread_id', $this->thread->id)
            ->first();

        $likes = Likes::where('thread_id', $this->thread->id)
            ->where('like', 1)
            ->get();
        $dislikes = Likes::where('thread_id', $this->thread->id)
            ->where('dislike', 1)
            ->get();

        $countLike = count($likes);
        $countDislike = count($dislikes);


        return view('livewire.like', [
            'like' => $like,
            'countLike' => $countLike,
            'countDislike' => $countDislike,
        ]);
    }
}

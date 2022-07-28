<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\User;
class ProfilesController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        $users = User::with('reply','threads')
            ->where('id', '=', $user->id)
            ->paginate(2);

        $threads = Thread::
            where('user_id','=' ,$user->id)
            ->orderBy('created_at','desc')
            ->paginate(2);

        return view('profiles.show', compact('user','threads','users'));
    }
}

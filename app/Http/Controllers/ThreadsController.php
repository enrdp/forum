<?php

namespace App\Http\Controllers;
use App\Models\{Forum, Thread, User, Reply};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class ThreadsController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Forum $forum)
    {
    $threads = Thread::with('user')->paginate(10);
    //$users = User::with('threads')->get();

        return view('threads.index',
            compact('threads','forum'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create(Forum $forum, Thread $thread)
    {
        return view('threads.create', compact('forum', 'thread'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Forum $forum
     * @return false|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Forum $forum)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $thread = Thread::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'body' => $request->body,
            'forum_id' => $forum->id
        ]);

        if ($thread) {
            return redirect()->route('forum.show', $forum->id)
                ->with('success','Thread has been created successfully.');
        }else{
            return false;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Thread $thread
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Forum $forum,Thread $thread)
    {
        if(!isset($_GET['page'])) {
            $thread->incrementReadCount();
        }

//        $users = User::with('threads')
//            ->where('id', '=', $thread->user_id)
//            ->get();

        $user = User::with('threads','reply','roles')
        ->where('id', '=', $thread->user_id)->first();

        $replies = Reply::with('threads','user')
            ->where('thread_id', '=', $thread->id)
            ->orderBy('updated_at', 'desc')
            ->paginate(5);

        return view('threads.show', compact('thread','forum','user','replies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Thread $thread
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|never
     */
    public function edit(Request $request,Forum $forum, Thread $thread)
    {
        if ($request->user()->cannot('edit', $thread)
            && Auth::user()->id != $thread->user_id) {
            return abort(403);
        }
        else{
            return view('threads.edit',compact('forum','thread'));
        }

//        $role_user = DB::table('role_user')->select('role_id')->where('user_id', '=', Auth::user()->id)->first();
//        if(Auth::user()->id == $thread->user_id){
//            return view('threads.edit',compact('thread'));
//        }
//        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Forum $forum,Thread $thread)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $thread['title'] = $request->title;
        $thread['body'] = $request->body;
        $thread['user_id'] = Auth::user()->id;
        $thread->save();
        return redirect()->route('threads.show',['forum' => $forum->id, 'thread' => $thread->id])
            ->with('success','Thread Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Forum $forum, Thread $thread)
    {
        $thread->delete();
        return redirect()->route('forum.show', $forum->id)
            ->with('success','Thread has been deleted successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Thread  $thread
     */
    public function createReply(Thread $thread)
    {
        return redirect()->route('threads.show', $thread->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Thread $thread
     * @return false|\Illuminate\Http\RedirectResponse
     */
    public function storeReply(Request $request, Thread $thread, Forum $forum)
    {
        $request->validate([
            'body' => 'required'
        ]);

        $replies = Reply::create([
            'user_id' => Auth::user()->id,
            'thread_id' => $thread->id,
            'body' => $request->body
        ]);

        if (!$replies) {
            return false;
        }

        return redirect()->back()
            ->with('success','Thread has been created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|never
     */
    public function destroyReply($id, Request $request)
    {
        $replies = Reply::where('user_id', Auth::user()->id)
        ->get();

        if ($request->user()->cannot('delete')
            && !$replies) {
            return abort(403);
        }
        else {
            Reply::where('id', '=', $id)
                ->delete();

            return redirect()->back()
                ->with('success', 'Thread has been deleted successfully');
        }
    }

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['auth','can:create'])->only('create');
    }
}

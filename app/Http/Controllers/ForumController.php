<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Forum;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     */
    public function show(Forum $forum, Thread $thread)
    {
        $threads = Thread::with('user','forum')
            ->where('forum_id', $forum->id)
            ->orderBy('updated_at','desc')
            ->paginate(10);

        $countReplies = Thread::withCount('countReply')
            ->get();


        return view('forum.show',
            compact('threads','forum','thread', 'countReplies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $categories = Category::all();
        return view('forum.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'desc' => 'required'
        ],
        [
            'title.required' => 'The title field is required!',
            'desc.required' => 'The description field is required!',
        ]);

        $forum = Forum::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'desc' => $request->desc,
            'category_id' => $request->category
        ]);

        if ($forum) {
            return redirect()->route('category.index')
                ->with('success','Thread has been created successfully.');
        }else{
            return false;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Forum  $forum
     */
    public function edit(Request $request, Forum $forum)
    {
        $categories = Category::with('forum')
            ->get();

        $categoryActive = DB::table('categories')
            ->where('id', '=', $forum->category_id)
            ->value('id');

        if ($request->user()->cannot('edit', $forum)
            && Auth::user()->id != $forum->user_id) {
            return abort(403);
        }

        else{
            return view('forum.edit',
                compact('forum','categories','categoryActive'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Forum  $forum
     */
    public function update(Request $request, Forum $forum)
    {
        $request->validate([
            'title' => 'required',
            'desc' => 'required',
        ]);

        $forum['title'] = $request->title;
        $forum['desc'] = $request->desc;
        $forum['user_id'] = Auth::user()->id;
        $forum['category_id'] = $request->categoryActive;
        $forum->save();

        return redirect()->back()
            ->with('success','Thread Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Forum  $forum
     */
    public function destroy(Forum $forum)
    {
        $forum->delete();
        return redirect()->back();
    }
    public function __construct()
    {
        $this->middleware(['can:edit'])->only(['edit','destroy']);
        $this->middleware(['auth','can:create'])->only(['create']);
    }
}

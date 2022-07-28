<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Forum;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('user','forum')
                      ->get();

        $OneLastThreads = Thread::with('forum')
            ->latest()->first();

        $LastThread = Forum::with('latestThread', 'user')->get();


        $countThreads = Forum::withCount('countThread')
                 ->get();
        $allThreads = Thread::all()->count();
        $allReplies = Reply::all()->count();

        return view('category.index',
            compact('categories', 'OneLastThreads','LastThread','countThreads','allThreads','allReplies' ));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('category.create');
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
            'desc' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        $path = $request->file('image')->store('public/images');


        $categories = Category::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'desc' => $request->desc,
            'image' =>  $path,
        ]);

        if ($categories) {
            return redirect()->route('category.index')
                ->with('success','Thread has been created successfully.');
        }else{
            return false;
        }
    }

    public function edit(Request $request, Category $category)
    {
        if ($request->user()->cannot('edit', $category)
            && Auth::user()->id != $category->user_id) {
            return abort(403);
        }
        else{
            return view('category.edit',
                compact('category'));
        }
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'title' => 'required',
            'desc' => 'required',
        ]);

        if($request->hasFile('image')){
            $request->validate([
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);
            $path = $request->file('image')->store('public/images');
            $category->image = $path;
        }
        $category->title = $request->title;
        $category->desc = $request->desc;
        $category->save();

        return redirect()->route('category.index')
            ->with('success','Post updated successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back();
    }

}

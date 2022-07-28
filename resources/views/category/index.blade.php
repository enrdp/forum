@extends('layouts.master')
    @section('title') | Forum @endsection
@section('content')

    <div class="container">
        <div class="">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInRight">

                    <div class="ibox-content m-b-sm border-bottom">
                        <div class="p-xs">

                            <h2>Welcome to our forum</h2>
                            <span>Feel free to choose topic you're interested in.</span>
                        </div>
                    </div>

                    <div class="ibox-content forum-container">

                        @forelse($categories as $key=>$category)
                            <div class="forum-title">
                               <img src="{{ Storage::url($category->image) }}"
                                    width="100" height="100" class="image-category"/>
                                <h3>{{ $category->title }}</h3>

                                @can('edit')
                                    <div class="col-md-1 forum-info">
                                        <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-success" >Edit</a>
                                    </div>
                                @endcan

                                    <form action="{{ route('category.destroy', $category->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                @can('delete')
                                            <button type="submit" onclick="return confirm('Are you sure?');" title="Delete"
                                                    class="btn btn-sm btn-danger"> Delete
                                            </button>
                                @endcan
                                    </form>
                            </div>


                            @foreach($category->forum as $forums)

                                <div class="forum-item active">
                                    <div class="row-flex">

                                        <div class="col-md-9">

                                            <a href="{{ route('forum.show',$forums->id) }}">{{$forums->title}}</a>
                                            <div class="forum-sub-title">{{ $forums->desc }}</div>
                                        </div>
                                        <div class="options">
                                        <div class="col-md-1 forum-info forum-options">
                                        <form action="{{ route('forum.destroy', $forums->id) }}" method="post">
                                            @csrf
                                        @method('DELETE')
                                            @can('delete')

                                            <button type="submit" onclick="return confirm('Are you sure?');" title="Delete"
                                                    class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                            @endcan
                                        </form>
                                        </div>

                                        @can('edit')


                                        <div class="col-md-1 forum-info forum-options">
                                         <a href="{{ route('forum.edit', $forums->id) }}" class="btn btn-sm btn-success">
                                             <i class="bi bi-pencil-fill"></i>
                                         </a>
                                        </div>
                                        @endcan

                                        </div>

                                        @foreach($countThreads as $countThread)
                                            @if($forums->id === $countThread->id )
                                                <div class="col-md-1 forum-info topics">
                            <span class="views-number">

                             {{ $countThread->count_thread_count }}

                            </span>
                                                    <div>
                                                        <small>Topics</small>
                                                    </div>
                                                </div>
                                            @if($countThread->count_thread_count < 1)
                                                    <div class="col-md-2 forum-info">
                                                        <p class="text-danger text-center fw-bold"> No post found! </p>
                                                    </div>
                                                        @endif
                                            @endif
                                        @endforeach

                                        @foreach($LastThread as $LT)
                                            @if(isset($LT->latestThread->forum->id))

                                            @if($forums->id === $LT->latestThread->forum->id)

                                                <div class="col-md-2 forum-info">
                                                    <a href="{{ route('threads.show', [$LT->latestThread->forum_id, $LT->latestThread->id]) }}">{{$LT->latestThread->title}}</a>
                                                    <small>write by

                                                        @if($LT->latestThread->user->id ?? 'null' === null)
                                                            <a href="{{ route('profiles.show', $LT->latestThread->user->id ?? 'None') }}">
                                                                {{ $LT->latestThread->user->name ?? 'User Delete'}}</a>
                                                        @else
                                                            <p>User Delete</p>
                                                        @endif
                                                    </small>
                                                    <small>
                                                        {{ $LT->latestThread->created_at->diffForHumans() }}
                                                    </small>
                                                </div>



                                @endif
                                @endif
                                @endforeach
                    </div>
                </div>
                            @endforeach

                        @empty

                            <div>
                                <p class="text-danger text-center fw-bold"> No post found! </p>
                            </div>

                        @endforelse


                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="posts-info">
<p>
    Last Post:
    <span class="block center">
    <a href="{{ route('threads.show', [$OneLastThreads->forum_id, $OneLastThreads->id]) }}">{{ $OneLastThreads->title }}</a>
        </span>

    <span class="block center">
    write by <a href="{{ route('profiles.show', $OneLastThreads->user->id) }}">{{ $OneLastThreads->user->name }}</a>
         </span>
</p>
    <p>
        Total Post:
        <span class="block center">
{{ $allThreads }}
        </span>
    </p>

    <p>
        Total replies:
        <span class="block center">
        {{$allReplies}}
        </span>
    </p>
</div>


@endsection

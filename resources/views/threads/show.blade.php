@extends('layouts.master')
@section('title')
    | Show Post
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="card card-thread">
                <div class="card-header card-header-thread">
                    <h5 class="card-title card-title-thread"> {{ $thread ? $thread->title : '' }} </h5>
                    @livewire('like', ['thread' => $thread])
                </div>
                <div class="card-body">
                    <div class="user-info">
                    <div class="img_container avatar">
                        @if(!isset($user))
                            <?php $name = 'UD'; ?>
                            @else
                            <?php $name = $user->name; ?>
                        @endif
                        <img src="https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={{ $name }}" alt="avatar.{{ $name }}" />

                    </div>
                        @if(isset($user))
                        <div><b>User Name:</b> {{ $user->name }}</div>
                        <div><b>Post written:</b> {{ $user->threads->count() }}</div>
                        <div><b>Replies written:</b> {{ $user->reply->count() }}</div>
                        <div><b>Data inscription:</b> {{ $user->created_at->format('Y-m-d') }}</div>
                            @if($user->roles->count() > 0)
                                 @if($user->roles[0]->id == 2)
                                    <?php $color = 'red';?>
                                 @elseif($user->roles[0]->id == 1)
                                <?php $color = 'green';?>
                                 @else
                                <?php $color = 'black';?>
                                    @endif
                            <div><b>Role:</b> <span style="color:{{$color}};">{{$user->roles[0]->name}}</span></div>
                                @endif

                        @else
                            <div>User Deleted</div>
                        @endif
                    </div>


                    <div class="form-group my-3">
                        <h4> Description </h4>
                        <p>{!! clean($thread->body) !!}</p>
                    </div>

                    <div class="button-thread">
                    <form action="{{ route('threads.destroy', [$forum->id, $thread->id]) }}" method="post">
                        @csrf
                        @if (!Auth::user())
                        @else
                            @if(Auth::user()->id == $thread->user_id || Auth::user()->can('edit'))
                                <a href="{{ route('threads.edit', [$forum->id,$thread->id]) }}" title="Edit"
                                   class="btn btn-sm btn-success">
                                    Edit </a>
                            @endif
                        @endif

                        @method('DELETE')
                        @can('delete')
                            <button type="submit" onclick="return confirm('Are you sure?');" title="Delete"
                                    class="btn btn-sm btn-danger"> Delete
                            </button>
                    </form>
                    @endcan
                    <div class="form-group">
                        <a href="{{ route('forum.show', $forum->id) }}" class="btn btn-success btn-back"> Back </a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 mx-auto">
            <form action="{{ route('threads.storeReply', $thread->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="card card-forum-reply">
                    <div class="card-body">
                        <div class="form-group my-3">
                            <label for="body"> Reply </label>
                            <textarea name="body" id="body" class="form-control" placeholder="Text"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success"> Save </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @foreach($replies as $key=>$reply)
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card card-reply">
                    <div class="card-header">
                        <h5 class="card-title"> Show Reply by {{ $reply->user->name ??  'User Deleted' }}</h5>
                    </div>
                    <div class="card-body card-reply">
                        <div class="form-group my-3">
                            <h4> Body </h4>
                            <p>{{ $reply->body }}</p>
                            <form action="{{ route('threads.destroyOneReply', $reply->id) }}" method="post">
                                @csrf
                                    @if(Auth::user()->id == $reply->user_id || Auth::user()->can('delete'))
                                    @method('DELETE')

                                        <button type="submit" onclick="return confirm('Are you sure?');" title="Delete"
                                                class="btn btn-sm btn-danger"> Delete
                                        </button>

                                @endif
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach





    <div class="d-flex justify-content-center">
        {!! $replies->links() !!}
    </div>

@endsection



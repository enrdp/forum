@extends('layouts.master')

    @section('title') | Threads Listing @endsection
@section('content')
@can('create')
    <div class="row">
        <div class="col-xl-12 text-end create-post">
            <a href="{{ route('threads.create', $forum->id) }}" class="btn btn-primary"> Create Post </a>
        </div>
    </div>
    @endcan
    <div class="card my-3">
        <table class="table">
            <thead class="thead-forums">
            <tr>
                <th>Title</th>
                <th>Count Replies</th>
                <th>Views</th>
                <th>Author</th>
            <tr>
            </thead>

            <tbody class="tbody-forums">

            @forelse ($threads as $thread)
                <tr>

                    <td><a href="{{ route('threads.show', [$forum->id, $thread->id]) }}" title="View" class="">
                            {{ $thread->title }}</a></td>
                        @foreach($countReplies as $countReply)
                            @if($thread->id === $countReply->id)
                            <td> {{ $countReply->count_reply_count }}</td>
                            @endif
                        @endforeach
                    <td>{{$thread->reads}}</td>

                    @if($thread->user->id ?? 'null' === null)
                        <td><b>{{ $thread->updated_at->diffForHumans() }}</b> <i>write by</i> <a href="{{ route('profiles.show',$thread->user->id ?? 'None') }}">
                                <b>{{ $thread->user->name ?? 'User Delete'}}</b></a></td>
                    @else
                        <td>User Delete</td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        <p class="text-danger text-center fw-bold"> No post found! </p>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {!! $threads->links() !!}
    </div>
@endsection

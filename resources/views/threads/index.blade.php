@extends('layouts.master')

    @section('title') | Threads Listing @endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 text-end">
            <a href="{{ route('threads.create', $forum->id) }}" class="btn btn-primary"> Create Post </a>
        </div>
    </div>
    <div class="card my-3">
        <table class="table">
            <thead>
            <tr>
                <th>Author</th>
                <th>Id</th>
                <th>Title</th>
            <tr>
            </thead>

            <tbody>

            @forelse ($threads as $thread)
                <tr>
@if($thread->user->name ?? 'null' === null)
                        <td><a href="{{ route('profiles.show',$thread->user->name ?? 'None') }}">
                            {{ $thread->user->name ?? 'User Delete'}}</a></td>
                    @else
                        <td>User Delete</td>
@endif
                        <td>{{ $thread->id }}</td>
                    <td><a href="{{ route('threads.show', [$forum->id,$thread->id]) }}" title="View" class="">
                            {{ $thread->title }}</a></td>
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

@extends('layouts.master')

    @section('title') | Update Post @endsection
@section('content')
    <div class="row">
        <div class="col-xl-6 mx-auto">
            <form action="{{ route('threads.update', [$forum->id, $thread->id]) }}" method="post">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"> Update Post </h5>
                    </div>

                    <div class="card-body">
                        <div class="form-group my-3">
                            <label for="title"> Title </label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{ $thread ? $thread->title : '' }}" />
                        </div>
                    <!--
                        <div class="form-group my-3">
                            <label for="body"> Description </label>
                            <textarea name="body" id="body" class="form-control" placeholder="BOdy">{{ $thread ? $thread->body : '' }}</textarea>
                        </div>
                    -->
                        <x-forms.richtext id="content" name="body" :value="$thread->body" />

                        <div class="form-group">
                            <button type="submit" class="btn btn-success"> Update </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

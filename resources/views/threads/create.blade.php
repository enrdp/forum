@extends('layouts.master')

    @section('title') | Create Post @endsection
@section('content')
    <div class="row">
        <div class="col-xl-6 mx-auto">
            <form action="{{ route('threads.store', $forum->id) }}" method="post">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"> Create Post </h5>
                    </div>

                    <div class="card-body">
                        <div class="form-group my-3">
                            <label for="title"> Title </label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Title" />
                        </div>

<!--
                        <div class="form-group my-3">
                            <label for="body"> Body </label>
                            <textarea name="body" id="body" class="form-control" placeholder="Body"></textarea>
                        </div>
-->
                        <x-forms.richtext id="content" name="body" :value="$thread->body" />

                        <div class="form-group">
                            <button type="submit" class="btn btn-success"> Save </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

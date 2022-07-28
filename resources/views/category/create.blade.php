@extends('layouts.master')

    @section('title') | Create Category @endsection
@section('content')
    <div class="row">
        <div class="col-xl-6 mx-auto">
            <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
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

                        <div class="form-group my-3">
                            <label for="desc"> Desc </label>
                            <input type="text" name="desc" id="desc" class="form-control" placeholder="Desc" />
                        </div>

                        <div class="custom-file">
                            <label class="custom-file-label" for="image">Select file</label>
                            <input type="file" name="image" class="custom-file-input" id="image">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success"> Save </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

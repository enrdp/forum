@extends('layouts.master')

    @section('title') | Create Category @endsection
@section('content')
    <div class="row">
        <div class="col-xl-6 mx-auto">
            <form action="{{ route('category.update', $category->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"> Edit Category </h5>
                    </div>

                    <div class="card-body">
                        <div class="form-group my-3">
                            <label for="title"> Title </label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Title"
                            value="{{ $category ? $category->title : '' }}" />
                        </div>

                        <div class="form-group my-3">
                            <label for="desc"> Desc </label>
                            <input type="text" name="desc" id="desc" class="form-control" placeholder="Desc"
                                   value="{{ $category ? $category->desc : '' }}" />
                        </div>

                        <div class="custom-file">
                            <label class="custom-file-label" for="image">Select file</label>
                            <input type="file" name="image" class="custom-file-input" id="image">
                        </div>

                        <div class="form-group">
                            <img src="{{ Storage::url($category->image) }}" height="200" width="200" alt="" />
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

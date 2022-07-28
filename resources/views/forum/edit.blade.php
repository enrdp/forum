@extends('layouts.master')

    @section('title') | Update Post @endsection
@section('content')
    <div class="row">
        <div class="col-xl-6 mx-auto">
            <form action="{{ route('forum.update', $forum->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"> Update Forum </h5>
                    </div>

                    <div class="card-body">
                        <div class="form-group my-3">
                            <label for="title"> Title </label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{ $forum ? $forum->title : '' }}" />
                        </div>

                        <div class="form-group my-3">
                            <label for="desc"> Description </label>
                            <textarea name="desc" id="desc" class="form-control" placeholder="Desc">{{ $forum ? $forum->desc : '' }}</textarea>
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" type="button">Button</button>
                            </div>
                        <select name="categoryActive" class="select-option custom-select" id="inputGroupSelect03" aria-label="Example select with button addon">
                            @foreach($categories as $category)
                                <option {{ $category->id == $categoryActive ? 'selected' : '' }}
                                    value="{{ $category->id }}">
                                    {{ $category->title }} - {{ $category->id }}
                                </option>
                            @endforeach
                        </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success"> Update </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

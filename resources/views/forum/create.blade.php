@extends('layouts.master')

    @section('title') | Create Forum @endsection
@section('content')

    <div class="row">
        <div class="col-xl-6 mx-auto">
            <form action="{{ route('forum.store') }}" method="post">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"> Create Forum </h5>
                    </div>

                    <div class="card-body">
                        <div class="form-group my-3">
                            <label for="title"> Title </label>
                            <input type="text" name="title" id="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   placeholder="Enter Title..."
                                   />
                            @error('title')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group my-3">
                            <label for="desc"> Description </label>
                            <input type="text" name="desc" id="desc"
                                   class="form-control @error('desc') is-invalid @enderror" placeholder="Enter Description..."
                            />
                            @error('desc')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" type="button">Button</button>
                            </div>
                            <select name="category" class="select-option custom-select" id="inputGroupSelect03" aria-label="Example select with button addon">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->title }} - {{ $category->id }}
                                    </option>
                                @endforeach
                            </select>
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

@extends('layouts.master')

    @section('title') | Update User @endsection
@section('content')
    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="card">
            <form action="{{ route('dashboard.editUsers', $user) }}" method="post">
                @csrf
                @method('PUT')

                    <div class="card-header">
                        <h5 class="card-title"> Update User </h5>
                    </div>

                    <div class="card-body">
                        <div class="form-group my-3">
                            <label for="name"> Name </label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $user ? $user->name : '' }}" />
                        </div>

                        <div class="form-group my-3">
                            <label for="email"> Email </label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ $user ? $user->email : '' }}" />
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" type="button">Button</button>
                            </div>
                            <select name="role" class="custom-select select-option" id="inputGroupSelect03" aria-label="Example select with button addon">
                                @foreach($rolename as $roles)
                                    <option  {{ $roles->id == $role ? 'selected' : '' }}
                                             value="{{ $roles->id }}"
                                    >
                                        {{ $roles->name }} - {{ $roles->id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success"> Update </button>
                        </div>

                    </div>

    </form>

            <form action="{{ route('dashboard.delete', $user) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure?');"
                        title="Delete" class="btn btn-sm btn-danger"> Delete </button>
            </form>
            </div>
        </div>
    </div>

@endsection

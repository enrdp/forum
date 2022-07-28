@extends('layouts.master')

@section('title') | Update User @endsection
@section('content')
<div class="row">
    <div class="col-xl-6 mx-auto">
        <div class="card">
            <form action="{{ route('dashboard.update', Auth::user()) }}" method="post">
                @csrf
                @method('PUT')

                <div class="card-header">
                    <h5 class="card-title"> Update User </h5>
                </div>

                <div class="card-body">
                    <div class="form-group my-3">
                        <label for="name"> Name </label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ Auth::user()->name }}" />
                    </div>

                    <div class="form-group my-3">
                        <label for="email"> Email </label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ Auth::user()->email }}" />
                    </div>

                    <div class="form-group my-3">
                        <a href="{{ route('change-password', Auth::user()) }}" class="btn-changePassword">Change Password</a>
                    </div>


                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <button type="submit" class="btn btn-success"> Update </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

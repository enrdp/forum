@extends('layouts.master')
@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard">
    <p> <a href="{{route('dashboard.edit', Auth::user() )}}" class="link-dashboard"><i class="bi bi-person-circle"></i> Edit Profile</a></p>
    @can('edit_user')
               <p> <a href="{{ route('showUser', 'users') }}" class="link-dashboard"><i class="bi bi-people-fill"></i> Edit Users Profile</a></p>
    @endcan

    @can('create')
        <p>  <a href="{{ route('forum.create') }}" class="link-dashboard"><i class="bi bi-plus-circle-fill"></i> Create Forum</a></p>
        <p> <a href="{{ route('category.create') }}" class="link-dashboard"><i class="bi bi-plus-square-fill"></i> Create Category</a></p>
    @endcan
    </div>

@endsection

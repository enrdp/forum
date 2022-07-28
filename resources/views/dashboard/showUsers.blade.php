@extends('layouts.master')
@section('title')
    | Search User
@endsection
@section('content')
    <form class="form-search" action="{{ route('showUser') }}" method="GET">
        <label class="search-bar-label">
            <input type="text" name="search" required class="search-bar-input" />
            <ul class="search-bar-ul">
                <li s>s</li>
                <li e>e</li>
                <li a>a</li>
                <li r>r</li>
                <li c>c</li>
                <li h>h</li>
            </ul>
        </label>
    </form>

@can('edit_user')
        <table class="search-table">
            <thead>
            <tr>
                <th>UserName</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($searchQuery as $users)
                <tr>
                    <td><a href="{{ route('dashboard.editUsers',$users->id) }}">{{ $users->name }}</a></td>
                    <td>{{ $users->email }}</td>
                    <td>{{ $users->roles[0]->name }}</td>
                </tr>
            @empty
                <tr><td colspan="3">No users found.</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {!! $searchQuery->appends(['search' => $searchTerm])->links() !!}
        </div>
@endcan
    @endsection

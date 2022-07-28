
@extends('layouts.master')

@section('content')
    <p>Username: {{ $users[0]->name }}</p>
@foreach($users[0]->reply as $key=>$reply)
    <div class="row" style="margin-bottom: 2rem">
        <div class="col-xl-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    Reply #{{ $key+1 }}
                </div>
                <div class="card-body">
                    <div class="form-group my-3">
                        <small>
                            {{ $user->created_at->diffforHumans() !== $user->updated_at->diffforHumans()
                                 ? 'Updated at: ' . $user->updated_at->diffforHumans()
                                 : 'Created at: ' . $user->created_at->diffforHumans()}}
                        </small>

                    <div class="form-group my-3">
                        <h4> Description </h4>
    {{ $reply->body }}
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

    @foreach($users[0]->threads as $key=>$user)
            <div class="row">
                <div class="col-xl-6 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <b>Thread #{{ $key+1 }}</b>
                        </div>
                        <div class="card-body">
                            <div class="form-group my-3">

                                   <small>
                                       {{ $user->created_at->diffforHumans() !== $user->updated_at->diffforHumans()
                                            ? 'Updated at: ' . $user->updated_at->diffforHumans()
                                            : 'Created at: ' . $user->created_at->diffforHumans()}}
                                   </small>

                                <h4>Title</h4>
                                <p>{{ $user ? $user->title : '' }}</p>
                            </div>

                            <div class="form-group my-3">
                                <h4> Description </h4>
                                <p>{!! clean($user->body) !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @endforeach

    <div class="d-flex justify-content-center">
    {!! $users->links() !!}
    </div>


@endsection


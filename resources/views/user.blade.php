@extends('layouts.app')

@section('content')
    <div class="text-center">
        <div style="width: 100%; max-width: 990px; display: inline-block;">
            @if(session()->has('mesg'))
                @if(session('mesg-type') == 'error')
                    <div class="alert alert-danger text-left" role="alert">
                        {{ session('mesg') }}
                    </div>
                @else
                    <div class="alert alert-success text-left" role="alert">
                        {{ session('mesg') }}
                    </div>
                @endif
            @endif
            <h1>Users</h1>
            <div class="float-right"><a href="{{ route('register') }}"><i class="fas fa-user-plus"></i></a></div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Enabled</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            @if($user->enabled)
                                Yes
                            @else
                                No
                            @endif
                        </td>
                        <td>
                            @if(Auth::id() != $user->id)
                                @if($user->enabled)
                                    <form action="{{ route('users.disable', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="form-control">Disable</button>
                                    </form>
                                @else
                                    <form action="{{ route('users.enable', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="form-control">Enable</button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

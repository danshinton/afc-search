@extends('layouts.app')

@section('content')
    <div class="text-center">
        <div style="width: 100%; max-width: 990px; display: inline-block; text-align: left">
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

            <h1 class="text-center">
                Users
                <div class="float-right">
                    <a href="{{ route('register') }}"><i class="fas fa-user-plus" style="font-size: 0.5em" data-toggle="tooltip" data-placement="top" title="Add User"></i></a>
                </div>
            </h1>

            <table id="user-table" class="table table-striped table-bordered">
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
                        <td class="text-center">
                            @if(Auth::id() == $user->id)
                                <a href="{{ route('password.change') }}" class="btn btn-primary  w-75" role="button">Change Password</a>
                            @else
                                @if($user->enabled)
                                    <form action="{{ route('users.disable', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger w-75">Disable</button>
                                    </form>
                                @else
                                    <form action="{{ route('users.enable', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success w-75">Enable</button>
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

@section('scripts')
    <script type="application/javascript">
        window.onload = function () {
            $(document).ready(function() {
                $('#user-table').DataTable();
                $('[data-toggle="tooltip"]').tooltip()
            });
        }
    </script>
@endsection

@extends('layouts.master')
@section('title', 'List User')

{{-- import file css (private) --}}
@push('css')
    
@endpush
@section('content')
    <h1>List User</h1>
    @if (Session::has('error'))
      <div class="alert alert-error">
          {{ session('error') }}
      </div>
    @endif
    @if (Session::has('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
    @endif
    <a href="{{ route('user.create') }}" class="btn btn-primary">Create User</a>
    <table class="table table-striped table-inverse">
        <thead class="thead-inverse">
            <tr>
                <th>#</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Avatar</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ( $users as $key => $user )
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><img src="{{ asset($user->avatar)}}" alt="" width="100"></td>
                    <td><a href="">Details</a></td>
                    <td><a href="{{ route('user.edit',['id' => $user->id]) }}">Edit</a></td>
                    <td>
                        <form action="{{ route('user.destroy',['id'=>$user->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Detete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
    </table>
    {{ $users->links() }}
@endsection
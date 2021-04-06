@extends('layouts.master')
@section('title', 'List Task')

{{-- import file css (private) --}}
@push('css')
    
@endpush
@section('content')
    <h1>List Task</h1>
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
    <a href="{{ route('task.create') }}" class="btn btn-primary">Create Task</a>
    <table class="table table-striped table-inverse">
        <thead class="thead-inverse">
            <tr>
                <th>#</th>
                <th>Task ID</th>
                <th>Content</th>
                <th>User</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ( $tasks as $key => $task )
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $task->id }}</td>
                    <td style="width:500px;white-space: normal;word-break: break-all">{{ $task->content }}</td>
                    <td>{{ $task->user->name }}</td>
                    <td><a href="">Details</a></td>
                    <td><a href="{{ route('task.edit',['id' => $task->id]) }}">Edit</a></td>
                    <td>
                        <form action="{{ route('task.destroy',['id'=>$task->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('are you sure delete?')">Detete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
    </table>
    {{ $tasks->links() }}
@endsection
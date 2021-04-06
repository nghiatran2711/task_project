@extends('layouts.master')
@section('title', 'Edit Task')

{{-- import file css (private) --}}
@push('css')
    
@endpush
@section('content')
    <h1>Edit Task</h1>
    @if (Session::has('error'))
      <div class="alert alert-danger">
          {{ session('error') }}
      </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form class="row g-3" action="{{ route('task.update',['id'=>$task->id]) }}" method="POST" enctype="multipart/form-data">
		@csrf
        @method('PUT')
        <div class="col-md-8">
            <label for="inputEmail4" class="form-label">Content</label>
            <input type="text" name="content" class="form-control" id="inputEmail4" value="{{ $task->content }}">
            @error('content')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-8">
            <label for="inputEmail4" class="form-label">User</label>
            <select class="form-control" name="user_id" id="">
                <option></option>
                @if (!empty($users))
                @foreach ($users as $userID => $userName )
                    <option value="{{ $userID }}" {{ old('user_id', $task->user_id) == $userID ? 'selected' : ''  }}>{{ $userName }}</option>
                @endforeach
                @endif
              </select>
              @error('user_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        
	    <div class="col-12">
        <br>
	    <button type="submit" class="btn btn-primary">Store</button>
	    <a href="{{ route('task.index') }}" class="btn btn-info">List Task</a>
	  </div>
	</form>
      
@endsection
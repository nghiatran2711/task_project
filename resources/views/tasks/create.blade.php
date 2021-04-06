@extends('layouts.master')
@section('title', 'Create Task')

{{-- import file css (private) --}}
@push('css')
    
@endpush
@section('content')
    <h1>Create Task</h1>
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
    <form class="row g-3" action="{{ route('task.store') }}" method="POST" enctype="multipart/form-data">
		@csrf
        <div class="col-md-8">
            <label for="inputEmail4" class="form-label">Content</label>
            <input type="text" name="content" class="form-control" id="inputEmail4" value="{{ old('password') }}">
            @error('content')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-8">
            <label for="inputEmail4" class="form-label">User</label>
            <select class="form-control" name="user_id" id="">
                <option></option>
                @foreach ($users as $userID => $userName )
                <option value="{{ $userID }}">{{ $userName }}</option>
                @endforeach
              </select>
        </div>
        
	    <div class="col-12">
        <br>
	    <button type="submit" class="btn btn-primary">Store</button>
	    <a href="{{ route('task.index') }}" class="btn btn-info">List Task</a>
	  </div>
	</form>
      
@endsection
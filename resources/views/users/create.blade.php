@extends('layouts.master')
@section('title', 'Create User')

{{-- import file css (private) --}}
@push('css')
    
@endpush
@section('content')
    <h1>Create User</h1>
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
    <form class="row g-3" action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
		@csrf
        <div class="col-md-8">
            <label for="inputEmail4" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="inputEmail4" value="{{ old('name') }}">
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-8">
            <label for="inputEmail4" class="form-label">Email</label>
            <input type="text" name="email" class="form-control" id="inputEmail4" value="{{ old('email') }}">
          
        </div>
        <div class="col-md-8">
            <label for="inputEmail4" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="inputEmail4" value="{{ old('password') }}">
          
        </div>
        <div class="col-md-8">
            <label for="inputEmail4" class="form-label">Avatar</label>
            <input type="file" name="avatar" class="form-control" id="inputEmail4">
        </div>
        
	    <div class="col-12">
        <br>
	    <button type="submit" class="btn btn-primary">Store</button>
	    <a href="{{ route('user.index') }}" class="btn btn-info">List User</a>
	  </div>
	</form>
      
@endsection
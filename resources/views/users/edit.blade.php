@extends('layouts.master')
@section('title', 'Edit User')

{{-- import file css (private) --}}
@push('css')
    
@endpush
@section('content')
    <h1>Edit User</h1>
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
    <form class="row g-3" action="{{ route('user.update',['id'=>$user->id]) }}" method="POST" enctype="multipart/form-data">
		@csrf
        @method('PUT')
        <div class="col-md-8">
            <label for="inputEmail4" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="inputEmail4" value="{{ $user->name }}">
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-8">
            <label for="inputEmail4" class="form-label">Email</label>
            <input type="text" name="email" class="form-control" id="inputEmail4" value="{{ $user->email }}">
          
        </div>
        <div class="col-md-8">
            <label for="inputEmail4" class="form-label">Avatar</label>
            <img src="{{ asset($user->avatar) }}" alt="">
            <input type="file" name="avatar" class="form-control" id="inputEmail4">
        </div>
        
	    <div class="col-12">
        <br>
	    <button type="submit" class="btn btn-primary">Store</button>
	    <a href="{{ route('user.index') }}" class="btn btn-info">List Category</a>
	  </div>
	</form>
      
@endsection
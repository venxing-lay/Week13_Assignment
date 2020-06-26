@extends('layouts.page')

@section('header') Edit Category @endsection

@section('content_page')

<form action="{{route('category.update',$category->id)}}" method="post">
    @csrf
    @method("PUT")
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="{{$category->name}}">
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
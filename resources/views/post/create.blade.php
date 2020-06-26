@extends('layouts.page')

@section('header') Create Post @endsection

@section('content_page')

<form action="{{route('post.store')}}" method="post">
    @csrf
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" placeholder="Title" name="title">
    </div>
    <label for="title">Category</label>
    <select class="form-control" name="category_id" require>
        <option></option>
        @foreach($categories as $category)
        <option value="{{$category->id}}">{{ $category->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
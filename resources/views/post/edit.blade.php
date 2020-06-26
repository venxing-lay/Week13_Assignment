@extends('layouts.page')

@section('header') Edit Post @endsection

@section('content_page')

<form action="{{route('post.update',$post->id)}}" method="post">
    @csrf
    @method("PUT")
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
        <input type="text" class="form-control" id="title" placeholder="Title" name="title" value="{{$post->title}}">
    </div>
    <label for=" title">Category</label>
    <select class="form-control" name="category_id" require>
        <option></option>
        @foreach($categories as $category)
        @if($category->id == $post->category_id)
        <option selected value="{{$category->id}}">{{ $category->name }}</option>
        @else
        <option value="{{$category->id}}">{{ $category->name }}</option>
        @endif
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
@extends('layouts.page')

@section('header') Create Category @endsection

@section('content_page')

<button onclick="window.location.href='{{url()->previous()}}'" type="button" class="btn btn-primary">Back</button> <br>
<form action="{{route('category.store')}}" method="post">
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
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" placeholder="Name" name="name">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
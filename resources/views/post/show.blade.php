@extends('layouts.page')

@section('header') Show Post @endsection

@section('content_page')


<b>Title:</b> {{ $post->title }} <br>
<b>Category:</b> {{ $post->category->name }} <br>
<b>Posted By:</b> {{ $post->user->name }} <br>

@endsection
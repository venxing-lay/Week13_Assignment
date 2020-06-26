@extends('layouts.page')

@section('header') List post @endsection

@section('content_page')

<button onclick="window.location.href='{{route('post.create')}}'" type="button" class="btn btn-primary" style="float: right;">Create</button>
<table id="dtOrderExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="th-sm">ID</th>
            <th class="th-sm">Title</th>
            <th class="th-sm">Category</th>
            <th class="th-sm">By</th>
            <th class="th-sm">Handle</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <th scope="row">{{ $category->id }}</th>
            <td>{{ $category->title }}</td>
            <td>{{ $category->category->name }}</td>
            <td>{{ $category->user->role }}</td>
            <td style="text-align: center;">

                @if(Auth::user()->id == $category->posted_by || Auth::user()->id == 1 || Auth::user()->role == "admin")
                <button onclick="window.location.href='{{ route('post.show', $category->id) }}'" type="button" class="btn">Show</button>
                <button onclick="window.location.href='{{ route('post.edit', $category->id) }}'" type="button" class="btn">Edit</button>
                <button onclick="confirm_delete('{{ $category->id }}')" type="button" class="btn">Delete</button>
                <form action="{{route('post.destroy',$category->id)}}" method="POST" id="delete_{{$category->id}}">
                    @csrf
                    @method("delete")
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>

</table>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">

        @if(app('request')->input('page') == NULL || app('request')->input('page') == 1 )
        <li class="page-item disabled">
            <a class="page-link" href="#">Previous</a>
        </li>
        <li class="page-item active"><a class="page-link" href="{{ url('/post?page=1') }}">{{ 1 }}</a></li>
        @else
        <li class="page-item">
            <a class="page-link" href="{{ url('/post?page='.(app('request')->input('page')-1)) }}">Previous</a>
        </li>
        <li class="page-item"><a class="page-link" href="{{ url('/post?page=1') }}">{{ 1 }}</a></li>
        @endif
        @for ($i = 2; $i <= $categories->lastPage(); $i++)

            @if(app('request')->input('page') == $i )
            <li class="page-item active"><a class="page-link" href="{{ url('/post?page='.$i) }}">{{ $i }}</a></li>
            @else
            <li class="page-item"><a class="page-link" href="{{ url('/post?page='.$i) }}">{{ $i }}</a></li>
            @endif
            @endfor
            @if(app('request')->input('page') == $categories->lastPage())
            <li class="page-item disabled">
                <a class="page-link">Next</a>
            </li>
            @elseif(app('request')->input('page') == NULL)
            <li class="page-item">
                <a class="page-link" href="{{ url('/post?page=2') }}">Next</a>
            </li>
            @else
            <li class="page-item">
                <a class="page-link" href="{{ url('/post?page='.(app('request')->input('page')+1)) }}">Next</a>
            </li>
            @endif
    </ul>
</nav>

<script>
    function confirm_delete(id) {
        if (confirm("PLEASE CONFIRM")) {
            document.getElementById("delete_" + id).submit();
        }
    }
</script>
@endsection

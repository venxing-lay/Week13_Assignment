@extends('layouts.page')

@section('header') List Category @endsection

@section('content_page')


<table id="dtOrderExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="th-sm">ID</th>
            <th class="th-sm">Name</th>
            <th class="th-sm">Handle</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
            <tr>
                @can('categories',$category)
                    <button onclick="window.location.href='{{route('category.create')}}'" type="button" class="btn btn-primary" style="float: right;">Create</button>
                @endcan
            </tr>
        <tr>
            <th scope="row">{{ $category->id }}</th>
            <td>{{ $category->name }}</td>
            <td style="text-align: center;">
                @can('categories',$category)
                <button onclick="window.location.href='{{ route('category.show', $category->id) }}'" type="button" class="btn">Show</button>
                <button onclick="window.location.href='{{ route('category.edit', $category->id) }}'" type="button" class="btn">Edit</button>
                <button onclick="confirm_delete('{{ $category->id }}')" type="button" class="btn">Delete</button>
                <form action="{{route('category.destroy',$category->id)}}" method="POST" id="delete_{{$category->id}}">
                    @csrf
                    @method("delete")
                </form>
                @endcan
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
        <li class="page-item active"><a class="page-link" href="{{ url('/category?page=1') }}">{{ 1 }}</a></li>
        @else
        <li class="page-item">
            <a class="page-link" href="{{ url('/category?page='.(app('request')->input('page')-1)) }}">Previous</a>
        </li>
        <li class="page-item"><a class="page-link" href="{{ url('/category?page=1') }}">{{ 1 }}</a></li>
        @endif
        @for ($i = 2; $i <= $categories->lastPage(); $i++)

            @if(app('request')->input('page') == $i )
            <li class="page-item active"><a class="page-link" href="{{ url('/category?page='.$i) }}">{{ $i }}</a></li>
            @else
            <li class="page-item"><a class="page-link" href="{{ url('/category?page='.$i) }}">{{ $i }}</a></li>
            @endif
            @endfor
            @if(app('request')->input('page') == $categories->lastPage())
            <li class="page-item disabled">
                <a class="page-link">Next</a>
            </li>
            @elseif(app('request')->input('page') == NULL)
            <li class="page-item">
                <a class="page-link" href="{{ url('/category?page=2') }}">Next</a>
            </li>
            @else
            <li class="page-item">
                <a class="page-link" href="{{ url('/category?page='.(app('request')->input('page')+1)) }}">Next</a>
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

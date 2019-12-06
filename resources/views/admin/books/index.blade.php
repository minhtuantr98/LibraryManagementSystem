@extends('layouts/app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item " aria-current="page">Book</li>
    </ol>
</nav>
<div class="panel panel-default">
    <div class="panel-heading">
        <h1>{{ "Book" }}</h1>
    </div>
    @if (count($errors) > 0)
    <div class="alert alert-danger">
      <strong>Sorry !</strong> There were some problems with your input.<br><br>
      <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
    @endif
    <div class="panel-body">
        <a href="/admin/book/create" class="badge badge-dark">Create Book</a>
    </div>
    <form action="/search" method="GET" role="search">
        <div class="input-group">
            <input type="text" class="form-control" name="title"
                placeholder="Search Book"> <span class="input-group-btn">
                <button type="submit" class="btn btn-default">
                    <span class="badge badge-dark">Search</span>
                </button>
            </span>
        </div>
    </form>
    <div>
        @if(count($books) == 0) 
                <p style="color:red;font-size:20px">There is no book for you search !!!<p>
        @else
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                </tr>
            </thead> 
            @foreach ($books as $value)
            <tr>
                <th scope="row" style="padding-top: 16px;">{{ $value->id }}</th>
                <td>
                    <form action="/admin/book/{{ $value->id }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <div id="category">
                            <p>{{ $value->title }}</p>
                            <input type="submit" class="btn btn-danger" onclick="return confirm('Are you sure ?') "
                                value="Delete">
                            <a class="btn btn-primary" href="/admin/book/{{ $value->id }}/edit" role="button">Edit</a>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        <div style="padding-left:300px"> {{ $books->links() }}</div>
        @endif
    </div>
</div>
@endsection

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

    @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
    @endif
    <div class="panel-body">
    <a href="/admin/bookdetail/create/{{ $book->id }}" class="badge badge-dark">Create Book Detail</a>
    </div>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                </tr>
            </thead> 
            @foreach ($bookdetail as $value)
            <tr>
                <th scope="row" style="padding-top: 16px;">{{ $value->id }}</th>
                <td>
                    <form action="/admin/bookdetail/{{ $value->id }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <div id="category">
                            <p>{{ $book->title }}</p>
                            @if ($value->isAvailable == 1)
                                    <input type="submit" class="btn btn-danger" onclick="return confirm('Are you sure ?') " value="Delete">
                            @else
                            <a class="btn btn-success" href="#" role="button">Borrowed</a>
                            @endif
                            <a class="btn btn-primary" href="/admin/bookdetail/{{ $value->id }}/edit" role="button">Edit</a>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        <div style="padding-left:300px"> {{ $bookdetail->links() }}</div>
        
    </div>
</div>
@endsection

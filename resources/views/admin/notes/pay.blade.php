@extends('layouts/app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item "><a href="/admin/book">Book</a></li>
            <li class="breadcrumb-item ">Edit</li>
        </ol>
    </nav>
    <div class="panel panel-default">
        <div class="panel-heading"><h1>{{ "Edit Book" }}</h1></div>
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
        <div class="panel-body">
            <br>
            <form action="/admin/borrow/{{ $book->id }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                        <label>Title</label>
                        <input class="form-control" placeholder="Enter title..." type="text" name="title" value="{{$book->title}}"><br>
                        <label>Number of page</label>
                        <input class="form-control" placeholder="Enter pages..." type="text" name="pages" value="{{$book->number_of_page}}"><br>
                        <input class="btn btn-primary" type="submit" value="Pay">
                    </div>
            </form>
        </div>
    </div>
@endsection

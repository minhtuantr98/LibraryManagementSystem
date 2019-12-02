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
            <form action="/admin/book/{{ $book->id }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                        <label>Title</label>
                        <input class="form-control" placeholder="Enter title..." type="text" name="title" value="{{$book->title}}"><br>
                        <label>Number of page</label>
                        <input class="form-control" placeholder="Enter pages..." type="text" name="pages" value="{{$book->number_of_page}}"><br>
                        <label>Price</label>
                        <input class="form-control" placeholder="Enter price..." type="text" name="price" value="{{$book->price}}"><br>
                        <label>Total</label>
                        <input class="form-control" placeholder="Enter total..." type="text" name="total" value="{{$book->total}}"><br>
                        <label>Author</label>
                        <input class="form-control" placeholder="Enter author..." type="text" name="author" value="{{$book->author}}"><br>
                        <label>Publishing company</label>
                        <input class="form-control" placeholder="Enter company..." type="text" name="company" value="{{$book->publishing_company}}"><br>
                        <label>Location</label>
                        <select class="form-control" name="location">
                            @foreach ($location as $value)
                            <option value="{{ $value->id }}" 
                                @if ($value->id == $book->location_id)
                                    {{ "selected" }}
                                @endif>
                                {{ $value->name }}
                            </option>
                            @endforeach
                        </select><br>
                        <label>Category</label>
                        <select class="form-control" name="category">
                                @foreach ($categories as $value)
                                <option value="{{ $value->id }}" 
                                        @if ($book->category_id == $value->id)
                                        {{ "selected" }}
                                    @endif>
                                    {{ $value->name }}
                                </option>
                                @endforeach
                        </select><br>
                        <label>File Image</label>
                    <input name="file" type="file" value="{{$book->image}}">
                    {{$book->image}}
                        <br>
                        <input class="btn btn-primary" type="submit" value="Edit">
                    </div>
            </form>
        </div>
    </div>
@endsection

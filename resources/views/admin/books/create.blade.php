@extends('layouts/app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item "><a href="/admin/book">Book</a></li>
        <li class="breadcrumb-item ">Create</li>
    </ol>
</nav>
<div class="panel panel-default">
    <div class="panel-heading">
        <h1>{{ "Create Book" }}</h1>
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

      @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div> 
      @endif
    <div class="panel-body">
        <br>
        <form action="/admin/book" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label>Title</label>
                <input class="form-control" placeholder="Enter title..." type="text" name="title"><br>
                <label>Number of page</label>
                <input class="form-control" placeholder="Enter pages..." type="text" name="pages"><br>
                <label>Price</label>
                <input class="form-control" placeholder="Enter price..." type="text" name="price"><br>
                <label>Total</label>
                <input class="form-control" placeholder="Enter total..." type="text" name="total"><br>
                <label>Author</label>
                <input class="form-control" placeholder="Enter author..." type="text" name="author"><br>
                <label>Publishing company</label>
                <input class="form-control" placeholder="Enter company..." type="text" name="company"><br>
                <label>Location</label>
                <select class="form-control" name="location">
                    @foreach ($location as $value)
                    <option value="{{ $value->id }}">
                        {{ $value->name }}
                    </option>
                    @endforeach
                </select><br>
                <label>Category</label>
                <select class="form-control" name="category">
                    @foreach ($categories as $value)
                    <option value="{{ $value->id }}">
                        {{ $value->name }}
                    </option>
                    @endforeach
                </select><br>
                <label>File Image</label>
                <input name="file" type="file">
                <br>
                <input class="btn btn-primary" type="submit" value="Create">
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts/app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item "><a href="/admin/category">Category</a></li>
            <li class="breadcrumb-item ">Edit</li>
        </ol>
    </nav>
    <div class="panel panel-default">
        <div class="panel-heading"><h1>{{ "Edit Category" }}</h1></div>
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
            <form action="/admin/category/{{ $category->id }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label>Name</label>
                <input class="form-control" placeholder="Enter Name..." type="text" value="{{ $category->name }}" name="name"><br>
                    <input class="btn btn-primary" type="submit" value="Lưu"><br>
                </div>
            </form>
        </div>
    </div>
@endsection

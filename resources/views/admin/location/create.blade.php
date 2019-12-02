@extends('layouts/app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item "><a href="/admin/category">Category</a></li>
            <li class="breadcrumb-item ">Create</li>
        </ol>
    </nav>
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
    <div class="panel panel-default">
        <div class="panel-heading"><h1>{{ "Create Category" }}</h1></div>
        <div class="panel-body">
            <br>
            <form action="/admin/location" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                <label>Name</label>
                <input class="form-control" placeholder="Enter Name..." type="text" name="name" ><br>  
                <input class="btn btn-primary" type="submit" value="Create">
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layouts/app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item "><a href="/admin/location">Location</a></li>
            <li class="breadcrumb-item ">Edit</li>
        </ol>
    </nav>
    <div class="panel panel-default">
        <div class="panel-heading"><h1>{{ "Edit Location" }}</h1></div>
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
            <form action="/admin/location/{{ $location->id }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label>Name</label>
                <input class="form-control" placeholder="Enter Name..." type="text" value="{{ $location->name }}" name="name"><br>
                    <input class="btn btn-primary" type="submit" value="Lưu"><br>
                </div>
            </form>
        </div>
    </div>
@endsection

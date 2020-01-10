@extends('layouts/app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item "><a href="/admin/book">Book</a></li>
            <li class="breadcrumb-item ">Edit</li>
        </ol>
    </nav>
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
            <form action="/admin/bookdetail/{{ $bookdetail->id }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                        <label>Tinh Trang</label>
                        <select class="form-control" name="available">
                            <option value="0" 
                                @if ($bookdetail->isAvailable == 0)
                                    {{ "selected" }}
                                @endif>
                                Da duoc muon
                            </option>
                            <option value="1" 
                                @if ($bookdetail->isAvailable == 1)
                                    {{ "selected" }}
                                @endif>
                                Co the cho muon
                            </option>
                        </select><br>
    
                        <input class="btn btn-primary" type="submit" value="Edit">
                    </div>
            </form>
        </div>
    </div>
@endsection

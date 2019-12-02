@extends('layouts/app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
            <li class="breadcrumb-item "><a href="/admin/user">User</a></li>
            <li class="breadcrumb-item ">Create</li>
        </ol>
    </nav>
    <div class="panel panel-default">
        <div class="panel-heading"><h1>{{ "Create User" }}</h1></div>
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
            <form action="/admin/user" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                <label>Name</label>
                <input class="form-control" placeholder="Enter Name..." type="text" name="name" ><br>
                <label>Telephone</label>
                <input class="form-control" placeholder="Enter Telephone..." type="text" name="telephone" ><br>
                <label>Address</label>
                <input class="form-control" placeholder="Enter Address..." type="text" name="address" ><br>
                <label>Class</label>
                <input class="form-control" placeholder="Enter Class..." type="text" name="class" ><br>
                <label>CMTND</label>
                <input class="form-control" placeholder="Enter CMTND..." type="text" name="cmtnd" ><br>
                <label>Date of birth</label>
                <input type="date"  class="form-control" name="date_of_birth" ><br>
                <input type="radio" name="gender" value="1"> Male<br>
                <input type="radio" name="gender" value="0"> Female<br>
                <input class="btn btn-primary" type="submit" value="Create">
                </div>
            </form>
        </div>
    </div>
@endsection

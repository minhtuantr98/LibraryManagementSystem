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
        <h1>{{ "Create Borrow Note" }}</h1>
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
            <borrow-note></borrow-note>
    </div>
</div>
@endsection

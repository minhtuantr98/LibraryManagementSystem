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
            @foreach ($borrownote as $value)
            <form action="/admin/borrow/{{ $id }}/{{ $value->book_detail_id}}/pay" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                        <label> {{ $value->book_detail_id }}</label>
                        <label>Money imdemnification</label>
                <input class="form-control" placeholder="Enter pages..." type="text" name="indemnification_money" value="{{$value->indemnification_money}}" 
                @if ($value->indemnification_money == 0)
                    {{ "disabled" }}
                @endif
                >
                    </div>
                @if ($value->indemnification_money == -1)
                <input class="btn btn-primary" type="submit" value="Pay">
                @else 
                    <p style="color:blue">Payed</p>
                @endif
            </form>
            <br>
            @endforeach
            <form action="/admin/borrow/{{ $id }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <input class="btn btn-primary" type="submit" value="Pay Note">
            </form>
        </div>
    </div>
@endsection

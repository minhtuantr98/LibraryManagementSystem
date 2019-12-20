@extends('layouts/app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item "><a href="/admin/borrow">Borrow book</a></li>
        <li class="breadcrumb-item " aria-current="page">Pay Detail</li>
    </ol>
</nav>
<div class="panel panel-default">
    <div class="panel-heading">
        <h1>{{ "Book" }}</h1>
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

    @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
    @endif
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Detail</th>
                </tr>
            </thead>
            @foreach ($payDetail as $value)
            <tr>
                <th scope="row" style="padding-top: 16px;">{{ $value->title }}</th>
                <td>        
                            <p>ID : {{ $value->id }}</p>
                            <p>Money pay: {{ $value->indemnification_money }}</p>
                            <p>Date pay: {{ $value->date_pay_real }}</p>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection

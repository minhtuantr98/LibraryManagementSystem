@extends('layouts/app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item " aria-current="page">Category</li>
    </ol>
</nav>
{{-- @if (Session::has('success'))
<div class="alert alert-success">
    <ul>
        <li>{{ Session::get('success') }}</li>
    </ul>
</div>
@endif --}}
<div class="panel panel-default">
    <div class="panel-heading">
        <h1>{{ "Category" }}</h1>
    </div>
    <div class="panel-body">
        <a href="/admin/category/create" class="badge badge-dark">Create Category</a>
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
    @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
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
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                </tr>
            </thead>
            @foreach ($categories as $value)
            <tr>
                <th scope="row" style="padding-top: 16px;">{{ $value->id }}</th>
                <td>
                    <form action="/admin/category/{{ $value->id }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <div id="category">
                            <p>{{ $value->name }}</p>
                            <input type="submit" class="btn btn-danger" onclick="return confirm('Are you sure ?') "
                                value="Delete">
                            <a class="btn btn-primary" href="/admin/category/{{ $value->id }}/edit" role="button">Edit</a>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach

        </table>
        {{-- <pagination
                    :max-visible-buttons="2"
                    :render="existUser"
                    :total-pages="totalPage"
                    :total="totalUser"
                    :current-page="currentPage"
                    @pagechanged="onPageChange"
                ></pagination> --}}
    </div>
</div>
@endsection

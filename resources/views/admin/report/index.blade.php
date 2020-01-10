@extends('layouts.app')

@section('content')
<h1>Users Graphs</h1>
<div style="width:100%">
    {!! $usersChart->container() !!}
</div>
@endsection
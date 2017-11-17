<?php
//$customer = $data["customer"];
//$fixing = $data["fixing"];
//$user = $data["user"];
?>

@extends('layouts.base')

@section('title', 'Lista riparazioni')

@section('navbar-li-left')
@parent
@section('home_class', 'active')
<li class=""><a href="{{ route('newfixing', $userId) }}">Nuova Riparazione</a></li>
@endsection

@section('content')
<p>
    <a href="{{ route('fixing.create') }}">Create new fixing</a>
</p>
<table class="table">
    <tr>
        <th>id</th>
        <th>user id</th>
        <th>customer id</th>
        <th>description</th>
        <th>deposit</th>
        <th>estimate</th>
        <th></th>
        <th></th>
    </tr>
    @foreach($fixingList as $fixing)
    <tr>
	<td>{{ $fixing->id }}</td>
	<td>{{ $fixing->user_id }}</td>
	<td>{{ $fixing->customer_id }}</td>
	<td>{{ $fixing->description }}</td>
	<td>{{ $fixing->deposit }}€</td>
	<td>{{ $fixing->estimate }}€</td>
	<td>
	    <a class="btn btn-default" href="{{ route('fixing.edit', ['fixing' => $fixing->id]) }}">Modifica</a>
	</td>
	<td>
	    {!! Form::open(['route' => ['fixing.destroy', $fixing->id], 'method' => 'delete' ]) !!}
	    {!! Form::submit('Elimina', ['class' => 'btn btn-danger']) !!}
	    {!! Form::close() !!}
	</td>
    </tr>
    @endforeach
</table>
@endsection


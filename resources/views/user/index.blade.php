@extends('layouts.base')

{{--
@section('navbar-li-left')
<li class="active"><a href="home.php">Home</a></li>
@parent
@endsection
--}}
@section('content')
<p>
    <a href="{{ route('user.create') }}">Create new user</a>
</p>
<table class="table">
    @foreach($userList as $user)
    <tr>
	<td>{{ $user->name }}</td>
	<td>
	    <a class="btn btn-default" href="{{ route('user.edit', ['user' => $user->id]) }}">Modifica</a>
	</td>
	<td>
	    {!! Form::open(['route' => ['user.destroy', $user->id], 'method' => 'delete' ]) !!}
	    {!! Form::submit('Elimina', ['class' => 'btn btn-danger']) !!}
	    {!! Form::close() !!}
	</td>
    </tr>
    @endforeach
</table>
@endsection


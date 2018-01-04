@extends('layouts.base')

@section('title', 'Backup foto')
@section('head-stylesheet')
    @parent
    <link rel="stylesheet" href="{{ asset('css/bubbler.min.css') }}">
@endsection
@section('head-javascript')

@section('navbar-li-left')
    @parent
    @section('home_class', '')
    @if(preg_match("/Fixings/", Auth::user()->permissions))
	<li class=""><a href="{{ route('newFixing') }}">Nuova Riparazione</a></li>
    @elseif(preg_match("/SalesActs/", Auth::user()->permissions))
	<li class=""><a href="{{ route('newSaleAct') }}">Nuovo Atto di Vendita</a></li>
    @endif
    <li class="active"><a href="">Backup</a></li>
@endsection

@section('content')
    {{ $message }}
@endsection

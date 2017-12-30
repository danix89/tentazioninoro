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
    <li class=""><a href="{{ route('newSaleAct') }}">Nuovo Atto di Vendita</a></li>
    <li class="active"><a href="">Backup</a></li>
@endsection

@section('content')
    {{ $message }}
@endsection

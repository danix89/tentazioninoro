<?php
$photo_paths = explode("~", $photo_paths);
?>

@extends('layouts.base')

@section('title', 'Foto Atto di Vendita')
@section('content-title', 'Atto di vendita n.' . $id)

@section('navbar-li-left')
    @parent
    @section('home_class', '')
    <li class=""><a href="{{ route('newSaleAct') }}">Nuovo Atto di Vendita</a></li>
    <li class=""><a href="{{ route('photoBackup', Config::get('constants.folders.SALES_ACTS')) }}">Backup</a></li>
    <li class="active"><a href="">Foto</a></li>
@endsection

@section('content')
    @if(isset($photo_paths) && (count($photo_paths) > 0 && !empty($photo_paths[0])))
	@foreach($photo_paths as $photo_path)
	    @if(!empty($photo_path))
		<img class='photo' src="{{ Storage::url($photo_path) }}" />
	    @endif
	@endforeach
    @else
        <p>Nessuna foto trovata.</p>
    @endif
@endsection
<?php
$photo_paths = explode("~", $photo_paths);
?>

@extends('layouts.base')

@section('title', 'Foto Atto di Vendita')
@section('content-title', 'Foto Atto di Vendita n.' . $saleActId)

@section('head-stylesheet')
    @parent
    <link rel="stylesheet" href="{{ asset('css/bubbler.min.css') }}">
    
    <style>
	.photo {
	    margin-top: 0px;
	}
    </style>
@endsection

@section('navbar-li-left')
    @parent
    @section('home_class', '')
    <li class=""><a href="{{ route('newSaleAct') }}">Nuovo Atto di Vendita</a></li>
    <li class="active"><a href="">Foto</a></li>
@endsection

@section('dropdown-menu')
    @parent
    <li class=""><a href="{{ route('photoBackup', Config::get('constants.folders.SALES_ACTS')) }}">Backup</a></li>
@endsection

@section('content')
    @if(isset($photo_paths) && (count($photo_paths) > 0 && !empty($photo_paths[0])))
	<div id="myCarousel" class="carousel slide" data-ride="carousel">
	    <?php $i = 0; ?>
	    <!-- Indicators -->

	    <ol class="carousel-indicators">
		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		<li data-target="#myCarousel" data-slide-to="1"></li>
		<li data-target="#myCarousel" data-slide-to="2"></li>
		<li data-target="#myCarousel" data-slide-to="3"></li>
	    </ol>

	    <!-- Wrapper for slides -->
	    <div class="carousel-inner">
		@foreach($photo_paths as $photo_path)
		    @if(!empty($photo_path))
			@if($i === 0)
			    <div class="item active">
			@else
			    <div class="item">
			@endif
				<img class='photo big' style="margin: 0 auto;" src="{{ Storage::url($photo_path) }}" alt="{{ $i++ }}" />
			    </div>
		    @endif
		@endforeach
	    </div>

	    <!-- Left and right controls -->
	    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left"></span>
		<span class="sr-only">Precedente</span>
	    </a>
	    <a class="right carousel-control" href="#myCarousel" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right"></span>
		<span class="sr-only">Successiva</span>
	    </a>
	</div>
    @else
        <p>Nessuna foto trovata.</p>
    @endif
    
	
@endsection
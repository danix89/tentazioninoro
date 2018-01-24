<?php
$photo_paths = explode("~", $photo_paths);
$lastIndex = count($photo_paths) - 1;
if(empty($photo_paths[$lastIndex])) {
    array_splice($photo_paths, $lastIndex, 1);
}
?>

@extends('layouts.base')

@section('title', 'Foto Atto di Vendita n.' . $saleActId)

@section('head-stylesheet')
    @parent
    <link rel="stylesheet" href="{{ asset('css/bubbler.min.css') }}">
    
    <style>
	body {
	    margin-bottom: 100px !important;
	}
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

@section('anchor-backup-href', route('photoBackup', Config::get('constants.folders.SALES_ACTS')) )
@section('anchor-delete-photos-href', route('photoDelete', Config::get('constants.folders.SALES_ACTS')) )

@section('content')
    @if(isset($photo_paths) && (count($photo_paths) > 0 && !empty($photo_paths[0])))
    <div id="myCarousel" class="carousel slide" data-ride="carousel" style="width: 800px; margin: auto;">
	    <?php $i = 0; ?>
	    <!-- Indicators -->
	    <ol class="carousel-indicators">
		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		@for ($i = 1; $i < count($photo_paths); $i++)
		    <li data-target="#myCarousel" data-slide-to="{{ $i }}"></li>
		@endfor
	    </ol>
	    <?php $i = 0; ?>
	    <!-- Wrapper for slides -->
	    <div class="carousel-inner">
		@foreach($photo_paths as $photo_path)
		    @if(!empty($photo_path))
			@if($i === 0)
			    <div class="item active">
			@else
			    <div class="item">
			@endif
				<img class='photo big d-block img-fluid' style="margin: 0 auto;" src="{{ Storage::url($photo_path) }}" alt="{{ $i++ }}" />
			    </div>
		    @endif
		@endforeach
	    </div>

	    <!-- Left and right controls -->
	    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left fa-lg" aria-hidden="true"></span>
		<span class="sr-only">Precedente</span>
	    </a>
	    <a class="right carousel-control" href="#myCarousel" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right fa-lg" aria-hidden="true"></span>
		<span class="sr-only">Successiva</span>
	    </a>
	</div>
	    
    @else
        <p>Nessuna foto trovata.</p>
    @endif
    
    {!! Form::open(['route' => ['updatePhotos', $saleActId], 'method' => 'PUT', 'id' => 'pdf', 'class' => 'form-horizontal', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
	<div id='photos' class="">
	    <div id="fileContainer" style="margin-bottom: 5px;"></div>

	    {!! Form::hidden('deletePhotos', '', ['id' => 'deletePhotos']) !!}
	    <button id="add-photo-paths-btn" type="button" class="btn btn-default btn-info" onclick="" style="">Aggiungi campo</button>
	    <button id="remove-photo-paths-btn" type="button" class="btn btn-default btn-warning" onclick="removeFileInput()" style="">Rimuovi campo</button>
	</div>
    
	<!-- Questo pulsante serve per permettere di riprodurre correttamente l'operazione di submit del form, in modo da consentire di controllare in automatico se i campi input richiesti sono vuoti. -->
        <button id="save-btn" type="submit" class="btn btn-primary" style="display: none;">Salva</button>
    {!! Form::close() !!}
@endsection

@section('footer-javascript')
    @parent
    <script src="{{ asset('vendor/bubbler.min.js') }}"></script>
    <script src="{{ asset('js/photos.create.floatBtn.js') }}"></script>
    <script>
	setHomeRoute("{{ route('home') }}");
        setSaveButton("Aggiorna", function() {
            $("#save-btn").click();
        });
    </script>
@endsection
@extends('layouts.base')

<?php
//$customer = $data["customer"];
//$fixing = $data["fixing"];
//$user = $data["user"];
$user = Auth::user();
$fixingList = json_decode($fixingList, TRUE);
?>
@guest
    @section('redirect-to-login-page')
	@parent
    @endsection
@endguest
@auth
    @section('title', 'Lista riparazioni')

    @section('navbar-li-left')
	@parent
	@section('home_class', 'active')
	<li class=""><a href="{{ route('newfixing', $user? $user->id : "") }}">Nuova Riparazione</a></li>
    @endsection

    @section('content')
	@if (!isset($fixingList))
	    <p>Non ci sono riparazioni in corso.</p>
	@else
	    <table id="grid-basic" class="table">
		<thead>
		    <tr>
			<th data-column-id="fixing_id" data-identifier="true">Riparazione</th>
			<th data-column-id="customer_id" data-type="numeric" data-order="desc">Cliente</th>
			<th data-column-id="jewel_id" data-type="numeric">Gioiello</th>
			<th data-column-id="description">Descrizione</th>
			<th data-column-id="deposit">Anticipo</th>
			<th data-column-id="estimate">Preventivo</th>
			<th data-column-id="commands" data-formatter="commands" data-sortable="false">Comandi</th>
			<!--<th data-column-id="delete"></th>-->
		    </tr>
		</thead>
		<tbody>
		    @foreach($fixingList as $fixing)
			{{-- Debugbar::info($fixing) --}}
			<tr>
			    <td>{{ $fixing["id"] }}</td>
			    <td>{{ $fixing["customer_id"] }}</td>
			    <td>{{ $fixing["jewel_id"] }}</td>
			    <td>{{ $fixing["description"] }}</td>
			    <td>{{ $fixing["deposit"] }}€</td>
			    <td>{{ $fixing["estimate"] }}€</td>
    <!--			<td>
				{{-- <a class="btn btn-default" href="{{ route('fixing.edit', ['fixing' => $fixing->id]) }}">Modifica</a>--}}
			    </td>
			    <td>
			    {{--
				{!! Form::open(['route' => ['fixing.destroy', $fixing->id], 'method' => 'delete' ]) !!}
				{!! Form::submit('Elimina', ['class' => 'btn btn-danger']) !!}
				{!! Form::close() !!}
				--}}
			    </td>-->
			</tr>
		    @endforeach
		</tbody>
	    </table>
	@endif

	<script>
	    initializeGrid("#grid-basic", "{{ route('showFixing', ['fixingId' => '']) }}");
    //	$("#grid-basic").bootgrid();
	</script>
    @endsection
@endauth
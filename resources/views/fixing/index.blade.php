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
	    initializeGrid("#grid-basic");
	    
	    function initializeGrid(gridId, csrf_token, showFixingRouteBaseUrl, deleteFixingRouteBaseUrl) {
		var grid = $(gridId).bootgrid({
		    selection: true,
		    multiSelect: true,
		    formatters: {
			"commands": function (column, row) {
	    //		console.log(row);
                            $(".prova").attr("action", "{{ route('fixing.destroy', ['fixingId' => '']) }}/" + row.fixing_id);
                            console.log($(".prova"));
			    return "<a class=\"btn btn-default\" href=\"{{ route('showFixing', ['fixingId' => '']) }}/" + row.fixing_id + "\"><span class=\"glyphicon glyphicon-pencil\"></span></a> " +
				    '{!! Form::open(["method" => "delete", "class" => "prova", "style" => "display: inline;"]) !!}' +
				    '<button class="btn btn-danger" type="submit"><span class=\"glyphicon glyphicon-trash\"></span></button>' +
				    '{!! Form::close() !!}';
			}
		    }
		}).on("selected.rs.jquery.bootgrid", function (e, rows) {
		    var rowIds = [];
		    for (var i = 0; i < rows.length; i++) {
			rowIds.push(rows[i].fixingId);
		    }
		    console.log("Select: " + rowIds.join(","));
		}).on("deselected.rs.jquery.bootgrid", function (e, rows) {
		    var rowIds = [];
		    for (var i = 0; i < rows.length; i++) {
			rowIds.push(rows[i].fixingId);
		    }
		    console.log("Deselect: " + rowIds.join(","));
		}).on("loaded.rs.jquery.bootgrid", function (e, rows) {
		    if($("#delete-all-btn").length === 0) {
			$(".actions.btn-group .dropdown.btn-group").last().after('<div id="delete-all-btn" class="dropdown btn-group"><button class="btn btn-default dropdown-toggle" type="button" style="width:51px; height:34px;"><span class="glyphicon glyphicon-trash"></span></div>');
		    }
		});
	    }
    //	$("#grid-basic").bootgrid();
	</script>
    @endsection
@endauth
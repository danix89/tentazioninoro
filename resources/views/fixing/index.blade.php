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
			<th data-column-id="fixing_id" data-identifier="true" data-type="numeric" data-order="asc" data-width="5%">Id</th>
			<th data-column-id="updated_at" data-order="desc" data-width="9%">Data</th>
			<th data-column-id="customer_id" data-width="15%">Cliente</th>
			<th data-column-id="jewel_id" data-width="8%">Gioiello</th>
			<th data-column-id="description" data-width="30%">Descrizione</th>
			<th data-column-id="deposit" data-width="8%">Anticipo</th>
			<th data-column-id="estimate" data-width="10%">Preventivo</th>
			<th data-column-id="commands" data-formatter="commands" data-sortable="false" data-width="10%">Comandi</th>
			<!--<th data-column-id="delete"></th>-->
		    </tr>
		</thead>
		<tbody>
		    @foreach($fixingList as $fixing)
                        <?php 
                        $jewel = Tentazioninoro\Jewel::where('id', $fixing["jewel_id"])->get()->first();
//                        $customer = Customer::where('id', $fixing["customer_id"])->get()->first();
                        $identityDocument = Tentazioninoro\Customer::find($fixing["customer_id"])->identityDocument;
                        $date = explode(" ", $fixing["updated_at"])[0];
                        $date = explode("-", $date);
                        $year = $date[0];
                        $month = $date[1];
                        $day = $date[2];
                        ?>
			{{-- Debugbar::info($fixing) --}}
			{{-- Debugbar::info($identityDocument) --}}
			<tr>
			    <td>{{ $fixing["id"] }}</td>
			    <td>{{ $day . "/" . $month . "/" . $year }}</td>
			    <td>{{ $identityDocument->name . " " . $identityDocument->surname }}</td>
			    <td>{{ $jewel->typology }}</td>
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
            setDeleteRoute("{{ route('fixing.destroyAll') }}");
	    initializeGrid("#grid-basic");
	    
	    function initializeGrid(gridId) {
		var grid = $(gridId).bootgrid({
		    selection: true,
		    multiSelect: true,
		    formatters: {
			"commands": function (column, row) {
	    //		console.log(row);
                            $(".deleteForm").attr("action", "{{ route('fixing.destroy', ['fixingId' => '']) }}/" + row.fixing_id);
			    return "<a class=\"btn btn-default\" href=\"{{ route('showFixing', ['fixingId' => '']) }}/" + row.fixing_id + "\"><span class=\"glyphicon glyphicon-eye-open\"></span></a> " +
				    '{!! Form::open(["method" => "delete", "class" => "deleteForm", "style" => "display: inline;"]) !!}' +
				    '<button class="btn btn-danger" type="submit"><span class=\"glyphicon glyphicon-trash\"></span></button>' +
				    '{!! Form::close() !!}';
			}
		    }
		}).on("selected.rs.jquery.bootgrid", function (e, rows) {
		    var rowIds = [];
		    for (var i = 0; i < rows.length; i++) {
			rowIds.push(rows[i].fixing_id);
                        mm.saveValueToArray("toDelete", rows[i].fixing_id);
		    }
		    console.log("Select: " + rowIds.join(","));
		}).on("deselected.rs.jquery.bootgrid", function (e, rows) {
		    var rowIds = [];
		    for (var i = 0; i < rows.length; i++) {
			rowIds.push(rows[i].fixing_id);
                        mm.removeElementFromArray("toDelete", rows[i].fixing_id);
		    }
		    console.log("Deselect: " + rowIds.join(","));
		}).on("loaded.rs.jquery.bootgrid", function (e, rows) {
		    if($("#delete-all-div").length === 0) {
			$(".actions.btn-group .dropdown.btn-group").last().after('<div id="delete-all-div" class="dropdown btn-group"><button id="delete-all-btn" class="btn btn-default dropdown-toggle" type="button" style="width:51px; height:34px;"><span class="glyphicon glyphicon-trash"></span></div>');
		    }
		});
	    }
    //	$("#grid-basic").bootgrid();
	</script>
    @endsection
@endauth
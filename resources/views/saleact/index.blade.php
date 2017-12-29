@extends('layouts.base')

<?php
//$customer = $data["customer"];
//$saleAct = $data["saleAct"];
//$user = $data["user"];
$user = Auth::user();
$saleActList = json_decode($saleActList, TRUE);
?>
@guest
    @section('redirect-to-login-page')
	@parent
    @endsection
@endguest
@auth
    @section('title', 'Lista atti di vendita')
    @section('head-stylesheet')
    @section('head-javascript')
	@parent
	<script src="{{ asset('js/saleact.main.js') }}"></script>
    @endsection

    @section('navbar-li-left')
	@parent
	@section('home_class', 'active')
	<li class=""><a href="{{ route('newSaleAct') }}">Nuova Riparazione</a></li>
    @endsection

    @section('content')
	@if (!isset($saleActList))
	    <p>Non ci sono atti di vendita registrati.</p>
	@else
	    <table id="grid-basic" class="table">
		<thead>
		    <tr>
			<th data-column-id="saleAct_id" data-identifier="true" data-type="numeric" data-order="asc" data-width="5%">Id</th>
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
		    @foreach($saleActList as $saleAct)
                        <?php 
//                        $customer = Customer::where('id', $saleAct["customer_id"])->get()->first();
                        $identityDocument = Tentazioninoro\Customer::find($saleAct["customer_id"])->identityDocument;
                        $date = explode(" ", $saleAct["updated_at"])[0];
                        $date = explode("-", $date);
                        $year = $date[0];
                        $month = $date[1];
                        $day = $date[2];
                        ?>
			{{-- Debugbar::info($saleAct) --}}
			{{-- Debugbar::info($identityDocument) --}}
			<tr>
			    <td>{{ $saleAct["id"] }}</td>
			    <td>{{ $day . "/" . $month . "/" . $year }}</td>
			    <td>{{ $identityDocument->name . " " . $identityDocument->surname }}</td>
			    <td>ciao</td>
			    <td>{{ $saleAct["id"] }}</td>
			    <td>{{ $saleAct["id"] }}€</td>
			    <td>{{ $saleAct["id"] }}€</td>
    <!--			<td>
				{{-- <a class="btn btn-default" href="{{ route('sale-act.edit', ['saleAct' => $saleAct->id]) }}">Modifica</a>--}}
			    </td>
			    <td>
			    {{--
				{!! Form::open(['route' => ['sale-act.destroy', $saleAct->id], 'method' => 'delete' ]) !!}
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
	    mm.resetAll(["toDelete"]);
            
            setDeleteRoute("{{ route('sale-act.destroyAll') }}");
	    initializeGrid("#grid-basic");
	    $(document).ready(function() {
		$("form").submit(function(e) {
//		    e.preventDefault();
		    var saleActId = $(this).parents("tr").data("row-id");
		    $(this).attr("action", '{{ route("sale-act.destroy", ["saleActId" => ""]) }}/' + saleActId);
		});
	    });
	    function initializeGrid(gridId) {
		var grid = $(gridId).bootgrid({
		    selection: true,
		    multiSelect: true,
		    formatters: {
			"commands": function (column, row) {
//			    console.log(row.saleAct_id);
			    <?php
				$showSaleActRoute = route("showSaleAct", ["saleActId" => ""]);
				$deleteSaleActRoute = ["sale-act.destroy", ""];
			    ?>
			    return "<a class=\"btn btn-default\" href=\"{{ $showSaleActRoute }}/" + row.saleAct_id + "\"><span class=\"glyphicon glyphicon-eye-open\"></span></a> " +
				    '{!! Form::open(["method" => "delete", "route" => $deleteSaleActRoute, "class" => "deleteForm", "style" => "display: inline;"]) !!}' +
				    '<button class="btn btn-danger" type="submit"><span class=\"glyphicon glyphicon-trash\"></span></button>' +
				    '{!! Form::close() !!}';
			}
		    }
		}).on("selected.rs.jquery.bootgrid", function (e, rows) {
		    var rowIds = [];
		    for (var i = 0; i < rows.length; i++) {
			rowIds.push(rows[i].saleAct_id);
                        mm.saveValueToArray("toDelete", rows[i].saleAct_id);
		    }
//		    console.log("Select: " + rowIds.join(","));
		}).on("deselected.rs.jquery.bootgrid", function (e, rows) {
		    var rowIds = [];
		    for (var i = 0; i < rows.length; i++) {
			rowIds.push(rows[i].saleAct_id);
                        mm.removeElementFromArray("toDelete", rows[i].saleAct_id);
		    }
//		    console.log("Deselect: " + rowIds.join(","));
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
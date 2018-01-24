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
    @section('title', 'Lista Atti di Vendita')
    @section('head-stylesheet')
        @parent
        <style>
            #grid-basic {
                table-layout: inherit !important;
            }
        </style>
    @endsection
    @section('head-javascript')
	@parent
	<!--<script src="{{ asset('js/saleact.main.js') }}"></script>-->
    @endsection
    @section('footer-javascript')

    @section('navbar-li-left')
	@parent
	@section('home_class', 'active')
        <li class=""><a href="{{ route('showCustomerList') }}">Clienti</a></li>
	<li class=""><a href="{{ route('newSaleAct') }}">Nuovo Atto di Vendita</a></li>
    @endsection
    
    @section('anchor-backup-href', route('photoBackup', Config::get('constants.folders.SALES_ACTS')) )
    @section('anchor-delete-photos-href', route('photoDelete', Config::get('constants.folders.SALES_ACTS')) )
    
    @section('content')
	@if (!isset($saleActList))
	    <p>Non ci sono atti di vendita registrati.</p>
	@else
	    <table id="grid-basic" class="table">
		<thead>
		    <tr>
			<th data-column-id="saleAct_id" data-identifier="true" data-type="numeric" data-visible="false">Id</th>
			<th data-column-id="saleAct_id_number" data-identifier="true" data-order="asc">Numero</th>
			<th data-column-id="updated_at" data-order="desc">Data</th>
			<th data-column-id="customer_id">Cliente</th>
			<th data-column-id="objects_id">Oggetti</th>
			<th data-column-id="deposit">Prezzo</th>
			<th data-column-id="estimate">Concordato</th>
			<th data-column-id="estimate">AU (750/1000)</th>
			<th data-column-id="commands" data-formatter="commands" data-sortable="false">Comandi</th>
			<!--<th data-column-id="delete"></th>-->
		    </tr>
		</thead>
		<tbody>
		    @for ($i = 0; $i < count($saleActList); $i++)
                        <?php
//                        $customer = Customer::where('id', $saleAct["customer_id"])->get()->first();
//                        $identityDocument = Tentazioninoro\Customer::find($saleActList[$i]["customer_id"])->identityDocument;
			$customerId = $saleActList[$i]["customer_id"];
			Debugbar::info('$saleActList[$i] - start', $saleActList[$i], '$saleActList[$i] - end');
                        $identityDocument = $identityDocumentList[$customerId];
			Debugbar::info('$customerId - start', $customerId, '$customerId - end');
                        $date = explode(" ", $saleActList[$i]["updated_at"])[0];
                        $date = explode("-", $date);
                        $year = $date[0];
                        $month = $date[1];
                        $day = $date[2];
                        ?>
			{{-- Debugbar::info($saleActList[$i]) --}}
			{{-- Debugbar::info($identityDocument) --}}
			<tr>
			    <td>{{ $saleActList[$i]["id"] }}</td>
			    <td>{{ $saleActList[$i]["id_number"] }}</td>
			    <td>{{ $day . "/" . $month . "/" . $year }}</td>
			    <td>{{ $identityDocument->name . " " . $identityDocument->surname }}</td>
			    <td>{{ $saleActList[$i]["objects"] }}</td>
			    <td>{{ $saleActList[$i]["price"] }}€</td>
			    <td>{{ $saleActList[$i]["agreed_price"] }}€</td>
			    <td>{{ $saleActList[$i]["au_quotation"] }}€</td>
    <!--			<td>
				{{-- <a class="btn btn-default" href="{{ route('sale-act.edit', ['saleAct' => $saleActList[$i]->id]) }}">Modifica</a>--}}
			    </td>
			    <td>
			    {{--
				{!! Form::open(['route' => ['sale-act.destroy', $saleActList[$i]->id], 'method' => 'delete' ]) !!}
				{!! Form::submit('Elimina', ['class' => 'btn btn-danger']) !!}
				{!! Form::close() !!}
				--}}
			    </td>-->
			</tr>
		    @endfor
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
				$showSaleActPhotosRoute = route("showSaleActPhotos", ["saleActId" => ""]);
				$deleteSaleActRoute = ["sale-act.destroy", ""];
			    ?>
			    return "<a class=\"btn btn-default\" href=\"{{ $showSaleActRoute }}/" + row.saleAct_id + "\"><i class=\"fa fa-eye fa-lg\" aria-hidden=\"true\"></i></a> " +
				    "<a class=\"btn btn-default\" href=\"{{ $showSaleActPhotosRoute }}/" + row.saleAct_id + "\"><i class=\"fa fa-camera fa-lg\" aria-hidden=\"true\"></i></a> " +
				    '{!! Form::open(["method" => "delete", "route" => $deleteSaleActRoute, "class" => "deleteForm", "style" => "display: inline;"]) !!}' +
				    '<button class="btn btn-danger" type="submit"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button>' +
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
                    // Consente di navigare la tabella orizzontalmente su dispositivi con schermo piccolo.
                    var div = $("<div />").css("overflow-x", "auto");
                    $(this).wrap(div);
                    
		    if($("#delete-all-div").length === 0) {
			$(".actions.btn-group .dropdown.btn-group").last().after('<div id="delete-all-div" class="dropdown btn-group"><button id="delete-all-btn" class="btn btn-danger dropdown-toggle" type="button" style="width:51px; height:34px;"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></div>');
		    }
		    
		    $('form').submit(function (e) {
			appendIdToFormAction(e, $(this));
		    }); 
		        
		    $('#delete-all-btn').click(function () {
			deleteAll();
		    });
		});
	    }
    //	$("#grid-basic").bootgrid();
	</script>
    @endsection
@endauth
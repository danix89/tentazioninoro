@extends('layouts.base')

<?php
$fixingList = json_decode($fixingList, TRUE);
$stateList = [
    "" => "Tutti",
    Config::get('constants.fixing.state.NOT_YET_STARTED') => Config::get('constants.fixing.state.NOT_YET_STARTED'),
    Config::get('constants.fixing.state.IN_PROGRESS') => Config::get('constants.fixing.state.IN_PROGRESS'),
    Config::get('constants.fixing.state.COMPLETED') => Config::get('constants.fixing.state.COMPLETED'),
    Config::get('constants.fixing.state.DELIVERED') => Config::get('constants.fixing.state.DELIVERED')
];

if(!isset($state)) {
    $state = "";
}

?>
@guest
    @section('redirect-to-login-page')
	@parent
    @endsection
@endguest
@auth
    @section('title', 'Lista riparazioni')
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
	<script src="{{ asset('js/fixing.main.js') }}"></script>
    @endsection

    @section('navbar-li-left')
	@parent
	@section('home_class', 'active')
	<li class=""><a href="{{ route('showCustomerList') }}">Clienti</a></li>
	<li class=""><a href="{{ route('newFixing') }}">Nuova Riparazione</a></li>
    @endsection

    @section('anchor-backup-href', route('photoBackup', Config::get('constants.folders.FIXINGS')) )
    @section('anchor-delete-photos-href', route('photoDelete', Config::get('constants.folders.FIXINGS')) )

    @section('content')
	@if (!isset($fixingList))
	    <p>Non ci sono riparazioni in corso.</p>
	@else
            <div class="row">
                <div id="state-select-div" class="" hidden style="width: 33%; position: relative; top: 49px; left: 15px; z-index: 9999;">
                    {!! Form::select('state-select', $stateList, $state, ['id' => 'state-select', 'class' => 'form-control', 'required' => true,]); !!}
                </div>
                <table id="grid-basic" class="table">
                    <thead>
                        <tr>
                            <th data-column-id="fixing_id" data-identifier="true" data-type="numeric" data-order="asc">Id</th>
                            <th data-column-id="state" data-identifier="true">Stato</th>
                            <th data-column-id="updated_at" data-order="desc">Data</th>
                            <th data-column-id="customer_id">Cliente</th>
                            <th data-column-id="jewel_id">Gioiello</th>
                            <th data-column-id="description">Descrizione</th>
                            <th data-column-id="deposit">Anticipo</th>
                            <th data-column-id="estimate">Preventivo</th>
                            <th data-column-id="commands" data-formatter="commands" data-sortable="false">Comandi</th>
                            <!--<th data-column-id="delete"></th>-->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fixingList as $fixing)
                        <?php
                        $jewel = Tentazioninoro\Jewel::where('id', $fixing["jewel_id"])->get()->first();
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
                            <td>{{ $fixing["state"] }}</td>
                            <td>{{ $day . "/" . $month . "/" . $year }}</td>
                            <td>{{ $identityDocument->name . " " . $identityDocument->surname }}</td>
                            <td>{{ $jewel->typology }}</td>
                            <td>{{ $fixing["description"] }}</td>
                            <td>{{ $fixing["deposit"] }}&#8364;</td>
                            <td>{{ $fixing["estimate"] }}&#8364;</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
	@endif
	<script>
	    mm.resetAll(["toDelete"]);
            
            setDeleteRoute("{{ route('fixing.destroyAll') }}");
	    initializeGrid("#grid-basic");
	    $(document).ready(function() {
		$("form").submit(function(e) {
		    var fixingId = $(this).parents("tr").data("row-id");
		    $(this).attr("action", '{{ route("fixing.destroy", ["fixingId" => ""]) }}/' + fixingId);
		});
		
		$("#state-select").change(function(e) {
		    var url = "{{ route('showList') }}" + "/" + $(this).val();
		    console.log(url);
		    window.location = url;
		});
	    });
	    function initializeGrid(gridId) {
		var grid = $(gridId).bootgrid({
		    selection: true,
		    multiSelect: true,
		    formatters: {
			"commands": function (column, row) {
//			    console.log(row.fixing_id);
			    <?php
				$showFixingRoute = route("showFixing", ["fixingId" => ""]);
				$deleteFixingRoute = ["fixing.destroy", ""];
			    ?>
			    return "<a class=\"btn btn-default\" href=\"{{ $showFixingRoute }}/" + row.fixing_id + "\"><i class=\"fa fa-eye fa-lg\" aria-hidden=\"true\"></i></a> " +
				    '{!! Form::open(["method" => "delete", "route" => $deleteFixingRoute, "class" => "deleteForm", "style" => "display: inline;"]) !!}' +
				    '<button class="btn btn-danger" type="submit"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button>' +
				    '{!! Form::close() !!}';
			}
		    }
		}).on("selected.rs.jquery.bootgrid", function (e, rows) {
		    var rowIds = [];
		    for (var i = 0; i < rows.length; i++) {
			rowIds.push(rows[i].fixing_id);
                        mm.saveValueToArray("toDelete", rows[i].fixing_id);
		    }
//		    console.log("Select: " + rowIds.join(","));
		}).on("deselected.rs.jquery.bootgrid", function (e, rows) {
		    var rowIds = [];
		    for (var i = 0; i < rows.length; i++) {
			rowIds.push(rows[i].fixing_id);
                        mm.removeElementFromArray("toDelete", rows[i].fixing_id);
		    }
//		    console.log("Deselect: " + rowIds.join(","));
		}).on("loaded.rs.jquery.bootgrid", function (e, rows) {
                    // Consente di navigare la tabella orizzontalmente su dispositivi con schermo piccolo.
                    var div = $("<div />").css("overflow-x", "auto");
                    $(this).wrap(div);
                    
		    if($("#delete-all-div").length === 0) {
			$(".actions.btn-group .dropdown.btn-group").last().after('<div id="delete-all-div" class="dropdown btn-group"><button id="delete-all-btn" class="btn btn-danger dropdown-toggle" onclick="deleteAll()" type="button" style="width:51px; height:34px;"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></span></div>');
		    }
                    
                    $('form').submit(function (e) {
                        appendIdToFormAction(e, $(this));
                    });
                    
//                    $(this).removeClass("bootgrid-table")
                    $("#state-select-div").show();
		});
	    }
	</script>
    @endsection
@endauth
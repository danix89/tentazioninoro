var homeRoute;
var printRoute;
var formId;

function setHomeRoute(hr) {
    homeRoute = hr;
}

function setPrintRoute(pr) {
    printRoute = pr;
}

function setSaveButton(btnl, fid) {
    $("#save-update-btn").next().children("span").text(btnl);
    formId = fid;
}

var options =
	[
	    {
		icon: '<i id="save-update-btn" class="fa fa-floppy-o" aria-hidden="true" style="position: relative; top: 10px;"></i>',
		label: 'Salva',
		callback: function () {
//		    window.location = updateStateRoute;
//		    console.log(buttonLabel);
		    $(formId).submit();
		}
	    },
	    {
		icon: '<i class="fa fa-print" aria-hidden="true" style="position: relative; top: 10px;"></i>',
		label: 'Stampa',
		callback: function () {
		    window.location = printRoute;
		}
	    },
	    {
		icon: '<i class="fa fa-home" aria-hidden="true" style="position: relative; top: 10px;"></i>',
		label: 'Home',
		callback: function () {
		    window.location = homeRoute;
		}
	    },
	];
var context = new Bubbler(options);

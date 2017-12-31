var homeRoute;
var printRoute;

function setHomeRoute(hr) {
    homeRoute = hr;
}

function setPrintRoute(hr) {
    printRoute = hr;
}

var options =
	[
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

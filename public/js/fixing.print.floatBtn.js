var homeRoute;
function setHomeRoute(hr) {
    homeRoute = hr;
}

var options =
	[
	    {
		icon: '<i class="fa fa-print" aria-hidden="true" style="position: relative; top: 10px;"></i>',
		label: 'Stampa',
		callback: function () {
		    window.print();
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

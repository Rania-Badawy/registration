// JavaScript Document

 $( document ).ready(function() {
	 		"use strict";
			$('#input01').filestyle();



			$('#input02').filestyle({

				buttonText : 'My filestyle'

			});



			$('.input03').filestyle({

				input : false,

				buttonName : 'btn-success'

			});

			

			$('#input04').filestyle({

				icon : false

			});



			$('#input05').filestyle({

				buttonName : 'btn-warning'

			});



			$('#input07').filestyle({

				iconName : 'glyphicon-plus',

				buttonText : 'Add'

			});



			$('#input08').filestyle({

				buttonText : ' File',

				buttonName : 'btn-success'

			});



			$('#clear').click(function() {

				$('#input08').filestyle('clear');

			});



			$('#input09').filestyle({

				buttonText : 'File',

				buttonName : 'btn-primary'

			});



			$('#toggleInput').click(function() {

				var fs = $('#input09');

				if (fs.filestyle('input'))

					fs.filestyle('input', false);

				else

					fs.filestyle('input', true);

			});



			$('#input10').filestyle({

				buttonText : 'File',

				buttonName : 'btn-primary'

			});



			$('#toggleIcon').click(function() {

				var fs = $('#input10');

				if (fs.filestyle('icon'))

					fs.filestyle('icon', false);

				else

					fs.filestyle('icon', true);

			});



			$('#input11').filestyle({

				buttonText : 'Multiple',

				buttonName : 'btn-danger'

			});



			$('#input12').filestyle({

				buttonText : ''

			});



			$('#input13').filestyle({

				disabled : true

			});



			$('#input14').filestyle({

				buttonBefore : true

			});

			$('#input15').filestyle({

				size : 'lg'

			});

			$('#input15').filestyle({

				input : false,

				badge: false

			});



			// nultiple initialize

			$('.test').filestyle({

				buttonName : 'btn-primary'

			});

	});
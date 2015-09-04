( function( $ ) {
	"use strict";
	$(document).ready(function(){
		
		// DATE PICKER FIELDS
		if ( $( "#_class_date" ).length ){
			var dates = $( "#_class_date" ).datepicker({
			defaultDate: "",
			dateFormat: "yy-mm-dd",
			numberOfMonths: 1,
			showButtonPanel: true,
			onSelect: function( selectedDate ) {
				var option = $(this).is("#_class_date") ? "minDate" : "maxDate";

				var instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
				}
			});
		}

		if ( $( "#_product_color" ).length ){
			$("#_product_color").wpColorPicker();
		}
	});
} )( jQuery );
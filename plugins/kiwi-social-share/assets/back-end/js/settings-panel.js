(function( $ ) {

	'use strict';

	/* ==========================================================================
	 When document is ready, do
	 ========================================================================== */
	$( document ).ready( function() {

		// sortable field JS
		if ( typeof $.fn.sortable !== 'undefined' ) {

			$( '.kiwi-form-wrapper-left' ).sortable( {
				items: '.kiwi-checkbox-sortable-wrapper',
				//handle: '.kiwi-sortable-helper',
				containment: 'parent',
				cursor: 'move',
				placeholder: 'kiwi-checkbox-sortable-placeholder',
				update: function() {
					if ( $( '.kiwi-checkbox-sortable-wrapper' ).length && $( '#general-settings-order' ).length ) {

						var order_update = '';

						$( ".kiwi-switch-input" ).each( function() {
							var id = $( this ).attr( 'id' );
							if ( order_update == '' ) {
								order_update = id;
							} else {
								order_update = order_update + ',' + id;
							}
						} );
						// rewrite the value of the order input field
						$( '#general-settings-order' ).val( order_update );
					}
				}
			} );
		} // end sortable

		// helper function for the radio-img field
		// mitigates click events
		function kiwi_set_radio_img_button() {

			$( '.kiwi-field-helper-radio-img' ).on( 'click', function( e ) {

				var inputID = $( this ).data( 'click-to' );

				// now go ahead and move the click to the radio button
				$( 'input#' + inputID ).prop( "checked", true );

				$( '.kiwi-radio-img-field input[type="radio"]' ).each( function() {

					if ( $( this ).is( ':checked' ) ) {
						//go up the DOM tree to the parent

						$( this ).parent().parent().addClass( 'kiwi-active-field' );
					} else {
						$( this ).parent().parent().removeClass( 'kiwi-active-field' );
					}
				} );
			} );
		}

		// function used to check toggle visibility
		function kiwi_toggle_opacity_helper() {

			// the CSS selector we'll be using to loop over elements
			var selector = '.kiwi-checkbox-sortable-wrapper .kiwi-switch-input';

			// bind the click event
			$( selector ).on( 'click', function() {

				// loop over switch elements inside of a sortable
				$( selector ).each( function() {

					// check toggle status
					if ( !$( this ).is( ':checked' ) ) { // if toggle isn't checked, mark it as disabled
						$( this ).parent().parent().addClass( 'kiwi-sortable-disabled' );
					} else {
						$( this ).parent().parent().removeClass( 'kiwi-sortable-disabled' );
					}

				} );
			} );
		}

		//=====================
		// Run functions here
		//=====================

		kiwi_set_radio_img_button();
		kiwi_toggle_opacity_helper();

	} );
})( window.jQuery );
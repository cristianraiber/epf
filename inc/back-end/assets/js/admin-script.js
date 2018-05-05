/**
 * @todo: fix accordions
 */
(function( $ ) {

	'use strict';

	/**
	 * Function used to handle admin UI postboxes
	 */
	function admin_postboxes() {

		if ( typeof postboxes !== 'undefined' ) { // sanity check
			postboxes.add_postbox_toggles( pagenow );

			// set cursor to pointer
			$( '.postbox .hndle' ).css( 'cursor', 'pointer' );
		}
	}

	function admin_accordions() {
		var handle = $( '.epfw-accordion-handle' );
		var wrapper = $( '.epfw-accordion-wrapper' );
		var main_wrapper = $( '.epfw-field-slide-up-wrapper' );

		//hide by default
		$( wrapper ).hide();

		$( handle ).on( 'click', function() {
			//check visibility
			if ( $( wrapper ).is( ':visible' ) ) {
				$( wrapper ).hide( 150 );
				$( main_wrapper ).removeClass( 'epfw-accordion-visible' );
			} else {
				$( main_wrapper ).addClass( 'epfw-accordion-visible' );
				$( wrapper ).show( 200 );
			}
		} );
	}

	/**
	 * Function used for the image compression slider under "Image Optimization"
	 */
	function admin_jquery_sliders() {

		var slider_selector = ".sbp-slider";
		var slider_amount = ".sbp-amount";
		var slider_integer = "#sbp_integer";

		if ( $( slider_selector ).length > 0 ) {

			$( slider_selector ).slider( {
				value: jpegCompression,
				min: 0,
				max: 100,
				step: 1,
				slide: function( event, ui ) {
					jQuery( slider_amount ).val( ui.value );
					jQuery( slider_integer ).val( ui.value );
				}
			} );

			$( slider_amount ).val( $( slider_selector ).slider( "value" ) );
		}
	}

	/**
	 * Handle UI tab switching via jQuery instead of relying on CSS only
	 */
	function admin_tab_switching() {

		var nav_tab_selector = '.nav-tab-wrapper a';

		/**
		 * Default tab handling
		 */

		// make the first tab active by default
		$( nav_tab_selector + ':first' ).addClass( 'nav-tab-active' );

		// get the first tab href
		var initial_tab_href = $( nav_tab_selector + ':first' ).attr( 'href' );

		// make all the tabs, except the first one hidden
		$( '.epfw-turn-into-tab' ).each( function( index, value ) {
			if ( '#' + $( this ).attr( 'id' ) !== initial_tab_href ) {
				$( this ).hide();
			}
		} );

		/**
		 * Listen for click events on nav-tab links
		 */
		$( nav_tab_selector ).click( function( event ) {

			$( nav_tab_selector ).removeClass( 'nav-tab-active' ); // remove class from previous selector
			$( this ).addClass( 'nav-tab-active' ).blur(); // add class to currently clicked selector

			var clicked_tab = $( this ).attr( 'href' );

			$( '.epfw-turn-into-tab' ).each( function( index, value ) {
				if ( '#' + $( this ).attr( 'id' ) !== clicked_tab ) {
					$( this ).hide();
				}

				$( clicked_tab ).fadeIn();

			} );

			// prevent default behavior
			event.preventDefault();

		} );
	}

	function rollback() {
		$( '.epfw-rollback-button' ).on( 'click', function( event ) {
			event.preventDefault();

			var $this = $( this ),
				dialogsManager = new DialogsManager.Instance();

			dialogsManager.createWidget( 'confirm', {
				headerMessage: ElementorAdminConfig.i18n.rollback_to_previous_version,
				message: ElementorAdminConfig.i18n.rollback_confirm,
				strings: {
					confirm: ElementorAdminConfig.i18n.yes,
					cancel: ElementorAdminConfig.i18n.cancel
				},
				onConfirm: function() {
					$this.addClass( 'loading' );

					location.href = $this.attr( 'href' );
				}
			} ).show();
		} );
	}

	$( document ).ready( function() {
		admin_postboxes();
		admin_jquery_sliders();
		admin_tab_switching();
		admin_accordions();
		rollback();
	} );

})( jQuery );
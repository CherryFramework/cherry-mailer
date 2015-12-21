/**
 * Submit event
 */

jQuery( document ).ready( function() {

    jQuery( '#cherry-mailer-form' ).submit(
		function( e ) {
			var _this = jQuery( this );
			var data = jQuery( this ).serialize();
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

			e.preventDefault();

			_this.find( '.message' ).hide();

			// Valid email
			if ( false === regex.test( _this.find( 'input[type=email]' ).val() ) ) {

				// Show warning message
				_this.find( '.message-warning' )
                    .show( 'slow' )
                    .delay( 5000 )
                    .fadeOut();
				return true;
			}

			// Disable form element
			_this.find( 'input[type=email]' ).attr( 'disabled', 'disabled' );
			_this.find( 'button' ).attr( 'disabled', 'disabled' );

			// Send data
			jQuery.post( window.cherryMailerParam.ajaxurl, data,
				function( response ) {
                    _this.find( '.message' ).hide();

					// Show message
					if ( 'success' === response.status ) {
						_this.find( '.message-success' )
                            .show( 'slow' )
                            .delay( 5000 )
                            .fadeOut();
					} else {
						_this.find( '.message-fail' )
                            .show( 'slow' )
                            .delay( 5000 )
                            .fadeOut();
					}

					// Enable form element
					_this.find( 'input[type=email]' ).removeAttr( 'disabled' );
					_this.find( 'button' ).removeAttr( 'disabled' );

					// Clear form element
					_this.trigger( 'reset' );
				}
			);
			return true;
		}
	);

	// Popup window init
	jQuery( '.subscribe-popup-link' ).magnificPopup( {
		type: 'inline',
        width: 400,
		preloader: false,
		focus: '#cherry-mailer-form input[type=email]'
	});
});

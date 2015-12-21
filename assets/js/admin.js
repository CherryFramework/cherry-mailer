/**
 * Submit event
 */
jQuery( document ).ready( function() {

    jQuery( '#cherry-mailer-options-save' ).click( function() {
        var form = jQuery( '#cherry-mailer-option' );
        var data = form.serialize();

        jQuery( this ).find( 'div' ).addClass( 'active' );
        jQuery( this ).addClass( 'right-spiner' );

        // Send data
        jQuery.post( window.cherryMailerParam.ajaxurl, data,
            function( response ) {
                var message = '';
                var type = '';
                form.find( '#cherry-mailer-message' ).removeClass( 'cherry-message-success' );
                form.find( '#cherry-mailer-message' ).removeClass( 'cherry-message-failed' );

                if ( ! response.message ) {
                    message = window.cherryMailerParam.default_error_message;
                } else {
                    message = response.message;
                }

                if ( ! response.type ) {
                    type = 'error';
                } else {
                    type = response.type;
                }

                if ( ! response.connect_status ) {
                    jQuery( '#cherry-mailer-connect' ).removeClass( 'text-success' );
                    jQuery( '#cherry-mailer-connect' ).addClass( 'text-danger' );
                } else {
                    jQuery( '#cherry-mailer-connect' ).removeClass( 'text-danger' );
                    jQuery( '#cherry-mailer-connect' ).removeClass( 'text-success' );
                    jQuery( '#cherry-mailer-connect' ).addClass( 'text-' + response.connect_status );
                }

                if ( ! response.connect_message ) {
                    jQuery( '#cherry-mailer-connect' ).html( '(' + window.cherryMailerParam.default_disconnect_message + ')' );
                } else {
                    jQuery( '#cherry-mailer-connect' ).html( '(' + response.connect_message + ')' );
                }

                noticeCreate( type, message );

                jQuery( '#cherry-mailer-options-save' ).find( 'div' ).removeClass( 'active' );
                jQuery( '#cherry-mailer-options-save' ).removeClass( 'right-spiner' );

                cherrymailerGeneratorView();
            }
        );

    });
});

/**
 * Generate shortcode
 *
 * @param target
 * @returns {string}
 */
function genereateShortcode( target ) {

    var mask      = target.data( 'input_mask' ),
        shortcode = target.data( 'shortcode' ),
        sType     = target.data( 'type' ),
        $attrForm = jQuery( '.cherry-sg-popup_fields', target ),
        atts      = $attrForm.serializeArray(),
        attName,
        val,
        result;

    result = '[' + shortcode;

    jQuery.each( atts, function( index, val ) {
        result += ' ' + val.name + '="' + val.value + '"';
    });

    result += ']';

    if ( 'single' !== sType ) {
        result += '[/' + shortcode + ']';
    }

    return result;
}

/**
 * Insert shortcode in textarea
 *
 * @param target
 * @param result
 */
function pasteShortcode(target, result ) {
    var shortcode = genereateShortcode( target );
    result.val( shortcode );
}

/**
 * Generate view of ShortCode Generator
 */
function cherrymailerGeneratorView() {
    jQuery.post( window.cherryMailerParam.ajaxurl, { action: 'cherry_mailer_generator_view' },
        function( response ) {
            jQuery( '#cherry-mailer-generate-view' ).html( response );

            jQuery( '.cherry-sg-open' ).magnificPopup({
                type: 'inline',
                preloader: false,
                focus: '#name',
                callbacks: {
                    open: function() {

                        var resultShortcode = jQuery( '#generated-shortcode', this.content ),
                            target          = this.content;

                        // Init UI elements
                        jQuery( window ).trigger( 'cherry-ui-elements-init', { 'target': target } );

                        pasteShortcode( target, resultShortcode );

                        target.on( 'change blur', function() {
                            pasteShortcode( target, resultShortcode );
                        });

                        target.on( 'click', '.cherry-switcher-wrap', function() {
                            pasteShortcode( target, resultShortcode );
                        });

                        jQuery( '.cherry-slider-unit' ).on( 'slidechange', function() {
                            pasteShortcode( target, resultShortcode );
                        } );

                    }
                }

            });

        });
}

/**
 * Show message
 * @param type
 * @param message
 */
function noticeCreate( type, message ) {
    var
        notice = jQuery( '<div class="notice-box ' + type + '"><span class="dashicons"></span><div class="inner">' + message + '</div></div>' ),
        rightDelta = 0,
        timeoutId;

    jQuery( '#cherry-mailer-option' ).append( notice );
    reposition();
    rightDelta = -1 * ( notice.outerWidth( true ) + 10 );
    notice.css( { 'right': rightDelta } );

    timeoutId = setTimeout( function() {
        notice.css( { 'right': 10 } ).addClass( 'show-state' );
    }, 100 );

    timeoutId = setTimeout( function() {
        rightDelta = -1 * ( notice.outerWidth( true ) + 10 );
        notice.css( { right: rightDelta } ).removeClass( 'show-state' );
    }, 4000 );

    timeoutId = setTimeout( function() {
        notice.remove();
        clearTimeout( timeoutId );
    }, 4500 );

    function reposition() {
        var topDelta = 100;

        jQuery( jQuery( '.notice-box' ).get().reverse() ).each( function( index ) {
            jQuery( this ).css( { top: topDelta } );
            topDelta += jQuery( this ).outerHeight( true );
        });
    }
}

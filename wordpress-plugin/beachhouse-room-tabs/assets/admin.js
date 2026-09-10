( function ( $ ) {
	'use strict';

	$( function () {
		// Mediabibliotheek voor het kiezen van een foto per tab.
		$( '.brt-image-picker' ).each( function () {
			var $picker      = $( this );
			var $preview     = $picker.find( '.brt-preview' );
			var $placeholder = $picker.find( '.brt-preview-placeholder' );
			var $input       = $picker.find( '.brt-image-id' );
			var $chooseBtn   = $picker.find( '.brt-choose-image' );
			var $removeBtn   = $picker.find( '.brt-remove-image' );
			var frame;

			$chooseBtn.on( 'click', function ( e ) {
				e.preventDefault();

				if ( frame ) {
					frame.open();
					return;
				}

				frame = wp.media( {
					title: 'Kies een foto',
					button: { text: 'Gebruik deze foto' },
					multiple: false,
				} );

				frame.on( 'select', function () {
					var attachment = frame.state().get( 'selection' ).first().toJSON();
					var imageUrl   = attachment.sizes && attachment.sizes.medium
						? attachment.sizes.medium.url
						: attachment.url;

					$input.val( attachment.id );
					$preview.attr( 'src', imageUrl ).show();
					$placeholder.hide();
					$removeBtn.show();
				} );

				frame.open();
			} );

			$removeBtn.on( 'click', function ( e ) {
				e.preventDefault();
				$input.val( '' );
				$preview.attr( 'src', '' ).hide();
				$placeholder.show();
				$removeBtn.hide();
			} );
		} );
	} );
} )( jQuery );

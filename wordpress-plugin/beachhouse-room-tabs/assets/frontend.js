( function () {
	'use strict';

	function setupGallery( wrap ) {
		var tabs      = wrap.querySelectorAll( '.brt-tab' );
		var images    = wrap.querySelectorAll( '.brt-image' );
		var canHover  = window.matchMedia && window.matchMedia( '(hover: hover)' ).matches;

		function activate( room ) {
			tabs.forEach( function ( tab ) {
				var isMatch = tab.getAttribute( 'data-room' ) === room;
				tab.classList.toggle( 'active', isMatch );
				tab.setAttribute( 'aria-selected', isMatch ? 'true' : 'false' );
			} );

			images.forEach( function ( img ) {
				img.classList.toggle( 'active', img.getAttribute( 'data-room' ) === room );
			} );
		}

		tabs.forEach( function ( tab ) {
			tab.addEventListener( 'click', function () {
				activate( tab.getAttribute( 'data-room' ) );
			} );

			if ( canHover ) {
				tab.addEventListener( 'mouseenter', function () {
					activate( tab.getAttribute( 'data-room' ) );
				} );
			}
		} );
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		document.querySelectorAll( '.brt-wrap' ).forEach( setupGallery );
	} );
} )();

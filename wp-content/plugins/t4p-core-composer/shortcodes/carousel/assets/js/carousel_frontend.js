/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

( function ($) {
	'use strict';
	$( document ).ready(function () {		
		// Set manual event previous for carousel left control
		$('.t4p-element-carousel .left').on('click', function (e) {
			e.preventDefault();
			var parent_id = $(this).closest('.carousel').attr('id');
			if ( typeof( $('#' + parent_id ).carousel ) == 'function' ) {
				$('#' + parent_id ).carousel( 'prev' );
			}
		});
		
		// Set manual event next for carousel right control
		$('.t4p-element-carousel .right').on('click', function (e) {
			e.preventDefault();
			var parent_id = $(this).closest('.carousel').attr('id');
			if ( typeof( $('#' + parent_id ).carousel ) == 'function' ) {
				$('#' + parent_id ).carousel( 'next' );
			}
		});
		
		// Set manual event for carousel indicator controls
		$('.t4p-element-carousel .carousel-indicators li').each(function (index) {
			$(this).on('click', function (e) {
				e.preventDefault();
				var parent_id = $(this).closest('.carousel').attr('id');
				if ( typeof( $('#' + parent_id ).carousel ) == 'function' ) {
					$('#' + parent_id ).carousel( index );
				}
			});
		});
	});
} )(jQuery);
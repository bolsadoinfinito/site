/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

( function ($) {
	"use strict";

	$.IGSelectFonts	= $.IGSelectFonts || {};

    $.IGColorPicker = $.IGColorPicker || {};

    $.t4p_font_color = $.t4p_font_color || {};

	$.t4p_font_color = function () {
		if (typeof $.IGSelectFonts != 'undefined') { new $.IGSelectFonts(); }
        if (typeof $.IGColorPicker != 'undefined') { new $.IGColorPicker(); }
	}

	$(document).ready(function () {
		$('body').bind('t4p_after_popover', function (e) {
			$.t4p_font_color();
		});
	});

})(jQuery);
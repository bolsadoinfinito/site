/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

/**
 * Custom script for List element
 */
( function ($)
{
	"use strict";

	$.t4p_ltselect = $.t4p_ltselect || {};

	$.t4p_ltselect = function () {
		$('body').on('change', '#param-link_type', function () {
            var option_text = $("#param-link_type option:selected").text();
            var option_val = $("#param-link_type option:selected").val();
            var label = $("#parent-param-single_item").children('.control-label');
            label.html(t4p_translate.singleEntry.replace('%s', option_text));

            var controls = $("#parent-param-single_item").children('.controls');
            var visibleChild = controls.children("[data-depend-value='"+option_val+"']");
            if($.trim(visibleChild.html()) == ''){
                visibleChild.html('<label style="margin-top: 6px;">'+t4p_translate.noItem.replace('%s', option_text.toLowerCase())+'</label>');
            }
		});
	}

	$(document).ready(function () {
		$.t4p_ltselect();
	});

})(jQuery);
/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */

/**
 * Custom script for List element
 */
( function ($)
{
	"use strict";

	$.t4p_list = $.t4p_list || {};


	$.t4p_list = function () {
        
		$('#param-font').on('change', function () {
			if ($(this).val() == 'inherit') {
				$('#param-font_face_type').val('standard fonts');
				$('.jsn-fontFaceType').trigger('change');
				$('#param-font_size_value_').val('');
				$('#param-font_style').val('bold');
				$('#param-color').val('#000000');
				$('#color-picker-param-color').ColorPickerSetColor('#000000');
				$('#color-picker-param-color div').css('background-color', '#000000');
			}
		});
	}

	$(document).ready(function () {
		$.t4p_list();
	});

})(jQuery);
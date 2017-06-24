/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

/**
 * javascript for widget pagebuilder element
 */
(function ($) {
	'use strict';

	$.t4p_widget_pagebuilder = $.t4p_widget_pagebuilder || {};

	$.t4p_widget_refresh = $.t4p_widget_refresh || {};

	$.t4p_widget_pagebuilder = function () {
		$('.t4p_shortcode_widget').each(function () {
			$(this).closest('.widget-content').find('.t4p-pb-form-container').html('');
			if ( $(this).attr('value') ) {
				var shortcode_data = $(this).attr('value');
				shortcode_data = shortcode_data.replace(/--quote--/g, '"');
				shortcode_data = shortcode_data.replace(/--open_square--/g, '[');
				shortcode_data = shortcode_data.replace(/--close_square--/g, ']');
				var shortcode = $(this).closest('.widget-content').find('#t4p_widget_edit_btn').attr('data-shortcode');
				var html = '';
				if ( shortcode ) {
					var title = shortcode.replace('t4p_', '');
					title = title.replace('_', ' ');

					var html_preview = t4p_preview_html;
					html_preview = html_preview.replace(/T4P_SHORTCODE_CONTENT/g, shortcode);
					html_preview = html_preview.replace(/T4P_SHORTCODE_DATA/g, shortcode_data);

					html += '<input id="t4p-select-media" type="hidden" value="">';
					html += html_preview;
					html += '<div class="shortcode-preview-container" style="display: none">';
					html += '<div class="shortcode-preview-fog"></div>';
					html += '<div class="jsn-overlay jsn-bgimage image-loading-24"></div>';
					html += '</div>';
					html += '</div> ';
				}

				$(this).closest('.widget-content').find('.t4p-pb-form-container').html(html);
			}
		});
	}

	$.t4p_widget_refresh = function () {
		$.t4p_widget_pagebuilder();
		$('.t4p_widget_select_elm').each(function () {
			var selected = $(this).val();
			if ( selected ) {
				$(this).closest('.widget-content').find('#t4p_widget_edit_btn').attr('data-shortcode', selected);
				$(this).closest('.widget-content').find('.t4p-pb-form-container').html('<input type="hidden" id="t4p-select-media" value="" />');
			}
		});
		$('body').delegate('.t4p_widget_select_elm', 'change', function (e) {
			var selected = $(this).val();
			if ( selected ) {
				$(this).closest('.widget-content').find('#t4p_widget_edit_btn').attr('data-shortcode', selected);
				$(this).closest('.widget-content').find('.t4p-pb-form-container').html('<input type="hidden" id="t4p-select-media" value="" />');
			}
			$(this).closest('.widget-content').find('.t4p_shortcode_widget').attr('value', '');
		});

		$('body').delegate('.t4p_widget_edit_btn', 'click', function () {
			var elm_title = '';
			elm_title = $(this).closest('.widget-content').find('.t4p_widget_select_elm option:selected').text();
			$.t4p_widget_pagebuilder();
			// find parent for set active element
			$('.widget-content').removeClass('active_element');
			$(this).closest('.widget-content').addClass('active_element');
			$(this).closest('.widget-content').find('#t4p-widget-loading').show();
			$(this).closest('.widget-content').find('.icon-pencil').hide();
			if ( $('.active_element .t4p-pb-form-container .jsn-item').length ) {
				$('.active_element .t4p-pb-form-container .jsn-item').addClass('t4p-selected-element');
				var sc_html = $('.active_element .t4p-pb-form-container').html();
				var $shortcode = $(this).attr('data-shortcode');
	            var $type = $(this).parent().attr('data-type');
				$.HandleElement.appendToHolder($shortcode, null, $type, sc_html, elm_title);
			} else {
	            var $shortcode = $(this).attr('data-shortcode');
	            var $type = $(this).parent().attr('data-type');
	            $.HandleElement.appendToHolder($shortcode, null, $type, '', elm_title);
			}
		});

		// set event update shortcode
		$('body').bind('on_update_shortcode_widget', function (e, shortcode_content) {
			if ( shortcode_content ) {
				if ( shortcode_content == 'is_cancel' ) {
					$('.active_element #form-design-content .t4p-pb-form-container').html('');
				} else {
					$('.active_element #form-design-content .t4p-pb-form-container').find("[data-sc-info^='shortcode_content']").text(shortcode_content);
					var json_shortcode = shortcode_content;
					json_shortcode = json_shortcode.replace(/"/g, '--quote--');
					json_shortcode = json_shortcode.replace(/\[/g, '--open_square--');
					json_shortcode = json_shortcode.replace(/\]/g, '--close_square--');
					$('.active_element .t4p_shortcode_widget').val(json_shortcode);
					$('.active_element #form-design-content .t4p-pb-form-container').html('');
				}
				$('.jsn-icon-loading').hide();
				$('.icon-pencil').show();
			}
		});
	}

	$(document).ready(function () {
		$.t4p_widget_refresh();
	});

})(jQuery)
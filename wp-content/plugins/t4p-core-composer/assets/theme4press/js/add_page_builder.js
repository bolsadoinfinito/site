/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

/**
 * Add a new tab besides Visual, Text tab of content editor
 */
jQuery(function($) {
	// Move T4P PageBuilder box to content of "Page Builder" tab
	$('#t4p_page_builder')
		.insertAfter('#t4p_before_pagebuilder')
		.addClass('jsn-bootstrap3')
		.removeClass('postbox')
		.find('.handlediv').remove()
		.end()
		.find('.hndle').remove();

	$("#t4p_editor_tab2").append($("<div />").append($('#t4p_page_builder').clone()).html());

	// Remove T4P PageBuilder metabox
	$('#t4p_page_builder').remove();

	// Show T4P PageBuilder only when Click "Page Builder" tab
	$(document).ready(function() {
		$('#t4p_page_builder').show();

		// Switch between "Classic Editor" & "Page Builder"
		$('#t4p_editor_tabs a').click(function (e) {
			e.preventDefault();
			$(this).tab('show');
			$("#t4p_active_tab").val($('#t4p_editor_tabs a').index($(this)));
		});

		$(".t4p-editor-wrapper").show();

		// Show T4P PageBuilder if tab "Page Builder" is active
		if ($("#t4p_active_tab").val() == "1") {
			$('#t4p_editor_tabs a').eq('1').trigger('click',[true]);
		}

		// Hide T4P PageBuilder UI if deactivated on this page
		if ($("#t4p_deactivate_pb").val() == "1") {
			$(".switchmode-button[id='status-off']").trigger('click', [true]);
		} else {
			$(".switchmode-button[id='status-on']").addClass('btn-success');
		}

		// Preview Changes fix
		$('#preview-action').css('position', 'relative');

		// Add a overlay div of "Preview Changes" button
		$('<div />', {'id' : 't4p-preview-overlay'}).css({'position':'absolute', 'width' : '100%', 'height' : '24px'}).hide().appendTo($('#preview-action'));

		$('.t4p-pb-form-container').bind('t4p-pagebuilder-layout-changed', function() {
			// Prevent click "Preview Changes" button
			$('#t4p-preview-overlay').show();
			$('#post-preview').attr('disabled', true);

			_update_content(function() {
				// Active "Preview Changes" button
				$('#t4p-preview-overlay').hide();
				$('#post-preview').removeAttr('disabled');
			});

			function _update_content(callback) {
				// if this change doesn't come from Classic Editor tab
				if (!$('#TB_window #t4p-shortcodes').is(':visible')) {

					// get current T4P PageBuilder content
					var tab_content = '';

					$(".t4p-pb-form-container textarea[name^='shortcode_content']").each(function() {
						tab_content += $(this).val();
					});

					// update content of WP editor
					if (tinymce.activeEditor) {
						if (tinymce.activeEditor.id == 'content') {
							tinymce.activeEditor.setContent(tab_content);
						}
					}

					$("#t4p_editor_tab1 #content").val(tab_content);

					if (callback) {
						callback();
					}
				} else {
					if (callback) {
						callback();
					}
				}
			}
		});
	});

	/**
	 * outerHTML() plugin for jQuery.
	 *
	 * @return  string
	 */
	$.fn.outerHTML = function() {
		// IE, Chrome & Safari will comply with the non-standard outerHTML, all others (FF) will have a fall-back for cloning
		return (!this.length) ? this : (this[0].outerHTML || (
			function(el) {
				var div = document.createElement('div');
				div.appendChild(el.cloneNode(true));
				var contents = div.innerHTML;
				div = null;
				return contents;
		})(this[0]));
	};
});

// Add shortcode from Classic Editor
top.addInClassic = 0;

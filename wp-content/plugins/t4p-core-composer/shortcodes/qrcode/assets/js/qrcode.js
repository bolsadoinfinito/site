/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */

/**
 * Custom script for QRCode element
 */
(function ($) {
	
	"use strict";
	
	$.t4p_QRcode = $.t4p_QRcode || {};
	
	$.t4p_QRcode = function () {
		// QR Code element process
        $('#param-qr_content_area').on('change', function () {
        	var html = $(this).val();
        	html = html.replace(/&/g, '');
        	html = html.replace(/$/g, '');
        	html = html.replace(/#/g, '');
        	var encode_html = html.replace(/"/g, '<t4p_quote>');
        	$('#param-qr_content_area').val(html.substring(0, 1200));
        	$('#param-qr_content').val(encode_html);
        });
        $('#param-qr_content_area').trigger('change');
	}
	
	$(document).ready(function () {
		$.t4p_QRcode();
	});
	
})(jQuery)
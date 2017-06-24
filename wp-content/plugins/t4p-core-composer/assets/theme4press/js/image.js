/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

/**
 * Custom script for Image element
 */
(function ($) {

	"use strict";

	$.t4p_image_element	= $.t4p_image_element || {};

	$.t4p_image_element 	= function () {
		// Build Image Size
    	$('#param-image, #param-picture').on('change', function () {
    		var selectValue = $(this).val();
    		if (selectValue) {
    			$('#modalOptions .image_loader').show();
    			$.post(
		            t4p_ajax.ajaxurl,
		            {
		                action			: 'get_json_custom',
		                custom_type		: 'image_size',
		                image_url		: selectValue,
		                t4p_nonce_check	: t4p_ajax._nonce
		            },
		            function (data) {
		            	var response = JSON.parse(data);
		            	if ( response.sizes ) {
		            		var selectedValue 	= $('#param-image_image_size').val();
                                        var currentValue	= $('#param-image_size').val();
		            		var html_select 	= '<select id="select_image_image_size" class="select2-select">';
		            		var current_select 	= '<select id="select_image_size" class="select2-select">';
		            		var current_length	= 0;
		            		$.each(response.sizes, function (key, value) {
		            			var selected 			= '';
		            			var current_selected 	= '';

		            			if ( currentValue != '' ) {
			            			if ( currentValue == key.toLowerCase() ) {
			            				current_selected 	= 'selected="selected"';
			            				current_length		= value.total_size;
			            			}

			            			current_select 	+= '<option value="' + key.toLowerCase() + '" ' + current_selected + ' >' + key + ' – ' + value.width + ' &times; ' + value.height + '</option>';
		            			} else {
		            				current_select 	+= '<option value="' + key.toLowerCase() + '" ' + current_selected + ' >' + key + ' – ' + value.width + ' &times; ' + value.height + '</option>';
		            			}

		            			if ( currentValue != 'full' ) {
		            				if ( selectedValue == key.toLowerCase() ) {
			            				selected 			= 'selected="selected"';
			            			}

			            			if ( current_length != 0 && value.total_size > current_length )
			            				html_select 	+= '<option value="' + key.toLowerCase() + '" ' + selected + ' >' + key + ' – ' + value.width + ' &times; ' + value.height + '</option>';
		            			} else {
                                                                html_select 	+= '<option value="' + key.toLowerCase() + '" ' + selected + ' >' + key + ' – ' + value.width + ' &times; ' + value.height + '</option>';
		            			}

		            		});
		            		html_select += '</select>';
		            		current_select += '</select>';
		            		$('#param-image_size_wrapper').html(current_select);
		            		$('#param-image_image_size_wrapper').html(html_select);
		            		$('#select_image_image_size').on('change', function () {
		                		$('#param-image_image_size').val($(this).val());
		                	});
		            		$('#select_image_size').on('change', function () {
		                		$('#param-image_size').val($(this).val());
		                		$('#param-image, #param-picture').trigger('change');
		                	});
		                	$('#select_image_image_size').trigger('change');
		            	}
                                
	            		$('#modalOptions .image_loader').hide();
	            		$('#select_image_size').select2('destroy').select2({minimumResultsForSearch:-1});
		            }
		        );
    		} else {
    			$('#param-image_size_wrapper').html('<select id="select_image_size" class="select2-select"><option value="" >'+t4p_translate.noneTxt+'</option></select>');
        		$('#param-image_image_size_wrapper').html('<select id="select_image_image_size" class="select2-select"><option value="" >'+t4p_translate.noneTxt+'</option></select>');
    		}
    		
    		// Hide image size, alt text, onclick... fields when image file empty value
    		if ( ! $(this).val() ) {
    			$('#parent-param-image_size').addClass('hide');
    			$('#parent-param-image_alt').addClass('hide');
    			$('#parent-param-link_type').addClass('hide');
    			$('#parent-param-image_image_size').addClass('hide');
    			$('#parent-param-image_type_url').addClass('hide');
    			$('#parent-param-single_item').addClass('hide');
    			$('#parent-param-open_in').addClass('hide');
    		} else {
    			$('#parent-param-image_size').removeClass('hide');
    			$('#parent-param-image_alt').removeClass('hide');
    			$('#parent-param-link_type').removeClass('hide');
    			$('#parent-param-image_image_size').removeClass('hide');
    			$('#parent-param-image_type_url').removeClass('hide');
    			$('#parent-param-single_item').removeClass('hide');
    			$('#parent-param-open_in').removeClass('hide');
    		}
    	});

    	$('#param-image, #param-picture').trigger('change');
	}

	$.t4p_image_element.setImageSize	= function (json_obj) {
		$('#param-image_size').val(json_obj);
	}

	$(document).ready(function () {
		$.t4p_image_element();
		
		// Specific add select2 for large image
		$('#param-link_type').on('change', function () {
			if ( $(this).val() == 'large_image' ) {
				$('#select_image_image_size').select2('destroy').select2({minimumResultsForSearch:-1});
			}
		});
	});

})(jQuery)

/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

/**
 * Custom script for Row
 */
( function ($) {
	"use strict";

	$(document).ready(function () {
		$('body').on("click", ".t4p-dialog .radio_image", function (e) {
			e.stopPropagation();
		});

        // toggle Position box
        $('#param-background').change(function(){
            var value = $(this).val();
            if(value == 'image'){
                value = $('#parent-param-stretch button.active').attr('data-value');
                if(value == 'full'){
                    $('#parent-param-position').addClass('t4p_hidden_depend2');
                }else{
                    $('#parent-param-position').removeClass('t4p_hidden_depend2');
                }
            }
        });

        // toggle Padding left, right when Width = Full
        var fn_toggle_padding = function() {
            var $val = $("[name='param-width']:checked").val();
            if ( $val == 'full' ) {
                $('#parent-param-div_padding').children('.controls').children('.combo-item:odd').hide();
            } else {
                $('#parent-param-div_padding').children('.controls').children('.combo-item:odd').show();
            }
        }

        // on load
        fn_toggle_padding();

        // on change
        $("[name='param-width']").change(function(){
            fn_toggle_padding();
        });
	});

})(jQuery)
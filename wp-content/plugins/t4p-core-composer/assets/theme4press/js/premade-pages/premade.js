/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

/**
 * This file handle the premade page/layout function
 */

(function($) {
	"use strict";
    $.PremadePage = $.PremadePage || {};

	/**
	 * Function to init premade layout functions
	 */
    $.PremadePage.addPage = function() {
        
        // filter layout
    	$('body').on('change', '#t4p-layout-lib .jsn-filter-button', function(){
            var layout_type = $(this).val();
            $('#t4p-layout-lib .jsn-items-list').find('li[data-type!="'+layout_type+'"]').addClass('hidden');
            $('#t4p-layout-lib .jsn-items-list').find('li[data-type="'+layout_type+'"]').removeClass('hidden').hide();
            $('#t4p-layout-lib .jsn-items-list').find('li[data-type="'+layout_type+'"]').fadeIn( 1000 );
    	});

        //----------------------------------- BUTTON ACTIONS -----------------------------------
        //
        $('#t4p-layout-lib .premade-layout-item .delete-item').on('click', function(){
        	$.PremadePage.removePage($(this));
        });
        
        // click on a page
        $('#t4p-layout-lib .premade-layout-item').on('click', function(e){
        	// If user clicks on delete button then do nothing.        	
        	if ( e.target == $('.delete-item', $(this)).get(0) ) return;
        	
        	var layout_content = $(this).find('textarea').val();
        	var go = confirm( t4p_translate.select_layout );
        	if ( go ) {
                // update content
                window.parent.jQuery.HandleElement.updatePageBuilder( layout_content);
        		window.parent.jQuery.HandleElement.hideLoading();
        		window.parent.jQuery.HandleElement.removeModal();
        	}
        });
        

        var layout_fn = function(e, this_, val, loading, callback){
            e.preventDefault();

            if (val.trim() != '') {
                loading.toggleClass('hidden');
                this_.parent().toggleClass('hidden');

                callback();
            }
        }

        // callback function when finish
        var layout_callback_fn = function(loading, message, msg_callback , action_btn, show_loading){
            if(show_loading == null || show_loading)
                loading.toggleClass('hidden');
            message.toggleClass('hidden');
            if(msg_callback)
                msg_callback();

            // hide save layout box
            setTimeout(function(){
                message.toggleClass('hidden');
                action_btn.toggleClass('hidden');
            }, 3000 );
        }

        var igpb_reload_finish = function(layout_box) {
            layout_box.css('opacity', '1');
        }

        //----------------------------------- SAVE LAYOUT -----------------------------------
        $('#layout-name').on('keypress',function(e){
            var p = e.which;
            if (p == 13) {
                e.preventDefault();
            }
        });
        
        
        $('#save-layout-form button').click( function(e){
            var val = $('#save-layout-form #layout-name').val();
            var parent = $(this).parents('.layout-box');
            var loading = parent.find('.layout-loading');
            layout_fn(e, $(this), val, loading, function(){
                // get template content
                var layout_content = '';
                $(".t4p-pb-form-container textarea[name^='shortcode_content']").each(function(){
                    layout_content += $(this).val();
                });
                layout_content = t4p_pb_remove_placeholder(layout_content, 'wrapper_append', '');
                // ajax post to save
                $.post(
                    t4p_ajax.ajaxurl,
                    {
                        action          : 'save_layout',
                        layout_name     : val,
                        layout_content	: layout_content,
                        t4p_nonce_check  : t4p_ajax._nonce
                    },
                    function(response) {
                    	if ( response == 'error' ) {
                    		alert( t4p_translate.layout.name_exist );
                    	} else {
                    		var message = parent.find('.layout-message');
                            var action_btn = parent.find('.layout-action');
                            layout_callback_fn(loading, message, '' , action_btn);
                    	}
                    }
                );
            });
        });
        
        // reload layout box
        var reload_layouts_fn = function() {
            var layout_box = $('#t4p-pb-layout-box');
            layout_box.css('opacity', '0.3');
            layout_box.load(
                t4p_ajax.ajaxurl,
                {
                    action          : 'reload_layouts_box',
                    t4p_nonce_check  : t4p_ajax._nonce
                },
                function() {
                    igpb_reload_finish(layout_box);
                }
            );
        }

        // Show layout description on mouseover
        $('body').on('mouseover', '.igpb-layout-item', function(){
            if($(this).find('.igpb-layout-description').html() != '')
                $(this).find('.igpb-layout-description').toggleClass('hidden');
        }).on('mouseout', '.igpb-layout-item', function(){
            if($(this).find('.igpb-layout-description').html() != '')
                $(this).find('.igpb-layout-description').toggleClass('hidden');
        });

    }
    
    /**
     * Method to remove a saved page
     * @pramam obj: jquery object of the clicked item
     */
    $.PremadePage.removePage = function (obj) {
    	var r = confirm(t4p_translate.layout.delete_layout);
        if (r == true){
            var layout_type = $('#t4p-layout-lib #t4p-pb-layout-group').val();
            if (layout_type != 't4p_pb_layout') {
                var layout_id = obj.parents('.jsn-item').attr('data-id');
            	var parent_div = obj.parent('.premade-layout-item');            	
            	$('.delete-item', parent_div).removeClass('icon-trash').addClass('jsn-icon16 jsn-icon-loading').css('visibility', 'visible');            	
                $.post(
                    t4p_ajax.ajaxurl,
                    {
                        action          : 'delete_layout',
                        group           : layout_type,
                        layout          : layout_id,
                        t4p_nonce_check  : t4p_ajax._nonce
                    },
                    function(data) {
                        var parent = $('#t4p-pb-layout-box').find('.layout-box');
                        var message = parent.find('.layout-message');
                        var action_btn = $('#t4p-pb-layout-box').find('#upload-layout');
                        action_btn.toggleClass('hidden');
                        
                        if (data == 1) {                        	 
                             parent_div.animate({opacity:'0'}, 300);
                             parent_div.remove();
                        } else {
                        	$('.delete-item', parent_div).removeClass('jsn-icon16 jsn-icon-loading').addClass('icon-trash').css('visibility', 'hidden');
                        }
                    }
                );
            }
        }
    }
    
    $(document).ready(function (){    	
    	$.PremadePage.addPage();    	
    })
})(jQuery);    
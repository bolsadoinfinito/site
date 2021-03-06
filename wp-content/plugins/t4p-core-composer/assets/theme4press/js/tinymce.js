/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

(function ($) {
	if (typeof(t4p_translate) != 'undefined') {

        $(document).ready(function () {
        	$('#t4p_pb_button').on('click', function (e) {
        		e.preventDefault();
        		$('.jsn-modal').remove();
        		
        		 // triggers the thickbox
                tb_show( t4p_translate.inno_shortcode, '#TB_inline?width=' + 100 + '&height=' + 100 + '&inlineId=t4p_pb-form' );
                // custom style
                var height = $(window).height() * 0.8;
                $('#TB_window').css({'overflow-y' : 'auto', 'overflow-x' : 'hidden', 'width' : '95%', 'margin-left' : '0px', 'left' : '2.5%', height: height + 'px'});
                $('#TB_window .jsn-items-list').height(height - 146);
        	});
        	
        	// re-calculate sizes of modal "Add Page Element" when window resize
        	$(window).on('resize', function () {
        		if( $('#TB_window #t4p-shortcodes').length ) {
        			var width  = $(window).width() * 0.9;
        			var height = $(window).height() * 0.8;
        			
        			$('#TB_window').css({
        				top :'50%',
        				left :'50%',
        				margin :'-'+ (height / 2) +'px 0 0 -'+ ( (width / 2) - 7 ) +'px',
        				width : width + 'px',
        				height : height + 'px',
        			});
        			$('#TB_window .jsn-items-list').height(height - 146);
        		}
        	});
        });

        // executes this when the DOM is ready
        jQuery(function(){
            // creates a form to be displayed everytime the button is clicked
            // you should achieve this using AJAX instead of direct html code like this
        	var html_classic_popover = window.parent.jQuery.noConflict()('.jsn-elementselector').clone();
            var form = $("<div/>", {
                            "id":"t4p_pb-form"
                        }).append(
                            $("<div />").append('<div id="t4p-shortcodes" class="t4p-add-element add-field-dialog jsn-bootstrap3">' + html_classic_popover.html() + '</div>').html()
                        );
            form.appendTo('body').hide();
            form.find('#t4p-shortcodes').fadeIn(500);

            $.HandleCommon.setFilterFields('#t4p-shortcodes');
            $.HandleCommon.setQuickSearchFields('#t4p-shortcodes');
        });
	}
})(jQuery)
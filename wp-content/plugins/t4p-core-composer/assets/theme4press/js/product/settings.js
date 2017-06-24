/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

// Declare Theme4press Upgrade class
(function($) {
	t4p_pb_settings = function(params) {
		// Object parameters
		this.params = $.extend({}, params);

        $(document).ready($.proxy(function() {
			var params_ = this.params;
			// Get update button object
			this.button = document.getElementById(params_.button);

			// Set event handler to update product
			$(this.button).click($.proxy(function(event) {
				event.preventDefault();
				this.clear_cache(params_);
			}, this));
		}, this));
	};

	// Declare methods
	t4p_pb_settings.prototype = {
		clear_cache: function(params_) {
			var button     = $('#' + params_.button);
			var cache_html = button.html();
            var loading    = $(params_.loading);
            var message    = params_.message;
            
            loading.toggleClass('hidden');
            loading.show();
            button.addClass("disabled").attr("disabled", "disabled");
			$.post(
                params_.ajaxurl,
                {
                    action 		: 'igpb_clear_cache',
                    t4p_nonce_check : params_._nonce
                },
                function(data) {
                	loading.hide();
                    message.html(data).toggleClass('hidden');
                    var text_change = button.data('textchange');
                    button.text(text_change);
                    setTimeout(function(){
                        message.toggleClass('hidden');
                        button.removeClass("disabled").removeAttr("disabled");
                        button.html(cache_html);
                    }, 1000 );
                }
            );
		}
	};
})(jQuery);

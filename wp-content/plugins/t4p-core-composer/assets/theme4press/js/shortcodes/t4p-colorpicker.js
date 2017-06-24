/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */
(function ($) {
    "use strict";

    $.IGColorPicker = function (selector) {
        this.init(selector);
    };

    $.IGColorPicker.prototype = {
        init: function (selector) {
            if ( ! selector )
                selector = '#modalOptions .color-selector';

            $( selector ).each(function () {
                var self	= $(this);
                var colorInput = self.siblings('input').last();
                var inputId 	= colorInput.attr('id');
                var inputValue 	= inputId.replace(/_color/i, '') + '_value';
                if ($('#' + inputValue).length){
                    $('#' + inputValue).val($(colorInput).val());
                }

                self.ColorPicker({
                    color: $(colorInput).val(),
                    onShow: function (colpkr) {
                        $(colpkr).fadeIn(500);
                        return false;
                    },
                    onHide: function (colpkr) {
                        $(colpkr).fadeOut(500);
                        $.HandleSetting.shortcodePreview();
                        return false;
                    },
                    onChange: function (hsb, hex, rgb) {
                        $(colorInput).val('#' + hex);

                        if ($('#' + inputValue).length){
                            $('#' + inputValue).val('#' + hex);
                        }
                        self.children().css('background-color', '#' + hex);
                    }
                });
            });
        }
    }

})(jQuery);
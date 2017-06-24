/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

/**
 * Custom script for Textbox element
 */
var initContentEditor;

( function ($) {
    "use strict";

    $(document).ready(function () {     

        var intTimeout = 5000;
        var intAmount  = 100;

        var ifLoadedInt = setInterval(function(){
            if (iframe_load_completed || intAmount >= intTimeout) {

                var text_content = $( '#param-text.form-control' ).html();

                var t4p_editor = $( '#tmpl-t4p-editor' ).html();

                t4p_editor = t4p_editor.replace( '_T4P_CONTENT_', text_content );

                $( '#param-text' ).after( t4p_editor );

                $( '#param-text.form-control' ).remove();

                ( function() {
                    var init, id, $wrap;

                    // Render Visual Tab
                    for ( id in tinyMCEPreInit.mceInit ) {
                        if ( id != 'param-text' )
                            continue;

                        init  = tinyMCEPreInit.mceInit[id];
                        $wrap = tinymce.$( '#wp-' + id + '-wrap' );

                        tinymce.remove(tinymce.get('param-text'));
                        tinymce.init( init );

                        setTimeout( function(){
                            $( '#wp-param-text-wrap' ).removeClass( 'html-active' );
                            $( '#wp-param-text-wrap' ).addClass( 'tmce-active' );
                        }, 10 );

                        if ( ! window.wpActiveEditor )
                                window.wpActiveEditor = id;

                        break;
                    }

                    // Render Text tab
                    for ( id in tinyMCEPreInit.qtInit ) {
                        if ( id != 'param-text' )
                            continue;

                        quicktags( tinyMCEPreInit.qtInit[id] );

                        // Re call inset quicktags button
                        QTags._buttonsInit();

                        if ( ! window.wpActiveEditor )
                            window.wpActiveEditor = id;

                        break;
                    }
                }());

                iframe_load_completed = false;
                window.clearInterval(ifLoadedInt);
            }
        },
        intAmount
        );

    });
})(jQuery);
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

(function($) {
	$(document).ready(function() {
		var serverurl = 'http://www.theme4press.com/wp-admin/admin-ajax.php';
		var data = {
			'action': 't4p_update_checking',
			'url': ajax_t4p_check_update.url,
			'plugin': ajax_t4p_check_update.plugin,
			'version': ajax_t4p_check_update.version
		};
		$.ajax({
			type: "POST",
			url: serverurl,
			data: data
		});
	});
})(jQuery);

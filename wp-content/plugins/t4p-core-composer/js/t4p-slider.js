jQuery(document).ready(function() {
	jQuery('.wp-list-table #slug span:first,label[for=tag-slug],label[for=slug]').text('Shortcode');
	jQuery('label[for=tag-slug],label[for=slug]').parents('.form-field').find('p').text('This is the shortcode name that can be used in the post content area. It is usually all lowercase and contains only letters, numbers, and hyphens.');
	jQuery('#parent, #tag-description, #description').parents('.form-field').hide();
	jQuery('label[for=tag-name],label[for=name]').parents('.form-field').find('p').text('The name of your slider.');
	jQuery('.revslider_settings').parents('.postbox').hide();

	jQuery('.metabox-prefs #slugdiv-hide, .metabox-prefs #mymetabox_revslider_0-hide, .metabox-prefs #slug-hide').parents('label').hide();
	jQuery('#normal-sortables').hide();
        var theme_prefix = js_local_variables.prefix;
	var type = jQuery('#'+theme_prefix+'type').val();
	var container = jQuery('#'+theme_prefix+'type').parents('#'+theme_prefix+'slide_options');
	jQuery(container).find('.video_settings .t4p_metabox_field').hide();

	if(type == 'self-hosted-video' || type == 'youtube' || type == 'vimeo') {
		jQuery(container).find('.video_settings').slideDown();

		jQuery(container).find('.video_settings').find('#'+theme_prefix+'video_bg_color, #'+theme_prefix+'mute_video, #'+theme_prefix+'autoplay_video, #'+theme_prefix+'loop_video, #'+theme_prefix+'hide_video_controls').parents('.t4p_metabox_field').show();

		if(type == 'youtube') {
			jQuery(container).find('.video_settings #'+theme_prefix+'youtube_id').parents('.t4p_metabox_field').show();
                        jQuery(container).find('.video_settings #'+theme_prefix+'mute_video').parents('.t4p_metabox_field').hide();
		} else if(type == 'vimeo') {
			jQuery(container).find('.video_settings #'+theme_prefix+'vimeo_id').parents('.t4p_metabox_field').show();
			jQuery(container).find('.video_settings #'+theme_prefix+'mute_video, .video_settings #'+theme_prefix+'hide_video_controls').parents('.t4p_metabox_field').hide();
		} else if(type == 'self-hosted-video') {
			jQuery(container).find('.video_settings').find('.t4p_metabox_field').show();
                        jQuery(container).find('.video_settings #'+theme_prefix+'youtube_id').parents('.t4p_metabox_field').hide();
                        jQuery(container).find('.video_settings #'+theme_prefix+'vimeo_id').parents('.t4p_metabox_field').hide();
		}
	} else {
		jQuery(container).find('.video_settings').hide();
	}

	jQuery('#'+theme_prefix+'type').change(function() {
		var type = jQuery(this).val();
		var container = jQuery(this).parents('#'+theme_prefix+'slide_options');
		jQuery(container).find('.video_settings .t4p_metabox_field').hide();

		if(type == 'self-hosted-video' || type == 'youtube' || type == 'vimeo') {
			jQuery(container).find('.video_settings').slideDown();

			jQuery(container).find('.video_settings').find('#'+theme_prefix+'video_bg_color, #'+theme_prefix+'mute_video, #'+theme_prefix+'autoplay_video, #'+theme_prefix+'loop_video, #'+theme_prefix+'hide_video_controls').parents('.t4p_metabox_field').show();

			if(type == 'youtube') {
				jQuery(container).find('.video_settings #'+theme_prefix+'youtube_id').parents('.t4p_metabox_field').show();
                                jQuery(container).find('.video_settings #'+theme_prefix+'mute_video').parents('.t4p_metabox_field').hide();
			} else if(type == 'vimeo') {
				jQuery(container).find('.video_settings #'+theme_prefix+'vimeo_id').parents('.t4p_metabox_field').show();
				jQuery(container).find('.video_settings #'+theme_prefix+'mute_video, .video_settings #'+theme_prefix+'hide_video_controls').parents('.t4p_metabox_field').hide();
			} else if(type == 'self-hosted-video') {
				jQuery(container).find('.video_settings').find('.t4p_metabox_field').show();
                                jQuery(container).find('.video_settings #'+theme_prefix+'youtube_id').parents('.t4p_metabox_field').hide();
                                jQuery(container).find('.video_settings #'+theme_prefix+'vimeo_id').parents('.t4p_metabox_field').hide();
			}
		} else {
			jQuery(container).find('.video_settings').hide();
		}
	});

	var type = jQuery('#'+theme_prefix+'link_type').val();
	var container = jQuery('#'+theme_prefix+'link_type').parents('#'+theme_prefix+'slide_options');
	jQuery(container).find('#'+theme_prefix+'slide_link, #'+theme_prefix+'button_1, #'+theme_prefix+'button_2').parents('.t4p_metabox_field').hide();

	if(type == 'button') {
		jQuery(container).find('#'+theme_prefix+'button_1, #'+theme_prefix+'button_2').parents('.t4p_metabox_field').show();
	} else {
		jQuery(container).find('#'+theme_prefix+'slide_link').parents('.t4p_metabox_field').show();
	}

	jQuery('#'+theme_prefix+'link_type').change(function() {
		var type = jQuery(this).val();
		var container = jQuery(this).parents('#'+theme_prefix+'slide_options');
		jQuery(container).find('#'+theme_prefix+'slide_link, #'+theme_prefix+'button_1, #'+theme_prefix+'button_2').parents('.t4p_metabox_field').hide();

		if(type == 'button') {
			jQuery(container).find('#'+theme_prefix+'button_1, #'+theme_prefix+'button_2').parents('.t4p_metabox_field').show();
		} else {
			jQuery(container).find('#'+theme_prefix+'slide_link').parents('.t4p_metabox_field').show();
		}
	});
});
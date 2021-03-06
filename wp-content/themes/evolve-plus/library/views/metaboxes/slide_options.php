<div class='t4p_metabox'>
    <?php
    $this->evolve_select('type', 'Background Type', array('image' => 'Image', 'self-hosted-video' => 'Self-Hosted Video', 'youtube' => 'Youtube', 'vimeo' => 'Vimeo'), 'Select an image or video slide. If using an image, please evolve_select the image in the "Featured Image" box on the right hand side.'
    );
    ?>
    <div class="video_settings" style="display: none;">
        <h2>Video Options:</h2>
        <?php
        $this->evolve_text('youtube_id', 'Youtube Video ID', 'For example the Video ID for http://www.youtube.com/RZRyQT1qedE is RZRyQT1qedE'
        );
        $this->evolve_text('vimeo_id', 'Vimeo Video ID', 'For example the Video ID for http://vimeo.com/78439312 is 78439312'
        );
        $this->evolve_upload('webm', 'Video WebM Upload', 'Video must be in a 16:9 aspect ratio. Add your WebM video file. WebM and MP4 format must be included to render your video with cross browser compatibility. OGV is optional.');
        $this->evolve_upload('mp4', 'Video MP4 Upload', 'Video must be in a 16:9 aspect ratio. Add your MP4 video file. MP4 and WebM format must be included to render your video with cross browser compatibility. OGV is optional.');
        $this->evolve_upload('ogv', 'Video OGV Upload', 'Add your OGV video file. This is optional.');
        $this->evolve_upload('preview_image', 'Video Preview Image', 'IMPORTANT: This field must be used for self hosted videos. Self hosted videos do not work correctly on mobile devices. The preview image will be seen in place of your video on older browsers or mobile devices.');
        $this->evolve_text('video_bg_color', 'Video Color Overlay', 'Select a color to show over the video as an overlay. Hex color code, <strong>ex: #fff</strong>'
        );
        $this->evolve_select('mute_video', 'Mute Video', array('yes' => 'Yes', 'no' => 'No'), ''
        );
        $this->evolve_select('autoplay_video', 'Autoplay Video', array('yes' => 'Yes', 'no' => 'No'), ''
        );
        $this->evolve_select('loop_video', 'Loop Video', array('yes' => 'Yes', 'no' => 'No'), ''
        );
        $this->evolve_select('hide_video_controls', 'Hide Video Controls', array('yes' => 'Yes', 'no' => 'No'), 'If this is set to yes, then autoplay must be enabled for the video to work.'
        );
        ?>
    </div>
    <h2>Slider Content Settings:</h2>
    <?php
    $this->evolve_select('content_alignment', 'Content Alignment', array('left' => 'Left', 'center' => 'Center', 'right' => 'Right'), 'Select how the heading, caption and buttons will be aligned.'
    );
    $this->evolve_text('heading', 'Heading', 'Enter the evolve_text heading for your slide.'
    );
    $this->evolve_text('heading_font_size', 'Heading Font Size', 'Enter heading font size without px unit. In pixels, ex: 50 instead of 50px. <strong>Default: 60</strong>'
    );
    $this->evolve_text('heading_color', 'Heading Color', 'Select a color for the heading font. Hex color code, ex: #fff. <strong>Default: #fff</strong>'
    );
    $this->evolve_select('heading_bg', 'Heading Background', array('yes' => 'Yes', 'no' => 'No'), 'Select this option if you would like a semi-transparent background behind your heading.'
    );
    $this->evolve_text('caption', 'Caption', 'Enter the evolve_text caption for your slide.'
    );
    $this->evolve_text('caption_font_size', 'Caption Font Size', 'Enter caption font size without px unit. In pixels, ex: 24 instead of 24px. <strong>Default: 24</strong>'
    );
    $this->evolve_text('caption_color', 'Caption Color', 'Select a color for the caption font. Hex color code, ex: #fff. <strong>Default: #fff</strong>'
    );
    $this->evolve_select('caption_bg', 'Caption Background', array('yes' => 'Yes', 'no' => 'No'), 'Select this option if you would like a semi-transparent background behind your caption.'
    );
    ?>
    <h2>Slide Link Settings:</h2>
    <?php
    $this->evolve_select('link_type', 'Slide Link Type', array('button' => 'Button', 'full' => 'Full Slide'), 'Select how the slide will link.'
    );
    $this->evolve_text('slide_link', 'Slide Link', 'Please enter your URL that will be used to link the full slide.'
    );
    $this->evolve_textarea('button_1', 'Button #1<br/><a href="https://theme4press.com/docs/shortcodes/buttons/">Click here to view button option descriptions.</a>', 'Adjust the button shortcode parameters for the first button.', '[button link="" color="default" size="" type="" shape="" target="_self" title="" gradient_colors="|" gradient_hover_colors="|" accent_color="" accent_hover_color="" bevel_color="" border_width="1px" shadow="" icon="" icon_divider="yes" icon_position="left" modal="" animation_type="0" animation_direction="down" animation_speed="0.1" class="" id=""]Button Text[/button]'
    );
    $this->evolve_textarea('button_2', 'Button #2<br/><a href="https://theme4press.com/docs/shortcodes/buttons/">Click here to view button option descriptions.</a>', 'Adjust the button shortcode parameters for the second button.', '[button link="" color="default" size="" type="" shape="" target="_self" title="" gradient_colors="|" gradient_hover_colors="|" accent_color="" accent_hover_color="" bevel_color="" border_width="1px" shadow="" icon="" icon_divider="yes" icon_position="left" modal="" animation_type="0" animation_direction="down" animation_speed="0.1" class="" id=""]Button Text[/button]'
    );
    ?>
</div>
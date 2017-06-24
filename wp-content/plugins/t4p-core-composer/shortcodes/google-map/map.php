<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Map' ) ) :

/**
 * Google map element for T4P PageBuilder.
 *
 * @since  1.0.0
 */
class Map extends T4P_Pb_Shortcode_Parent {
    
        private $map_id;
    
	/**
	 * Constructor
	 *
	 * @return  void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Configure shortcode.
	 *
	 * @return  void
	 */
	public function element_config() {
		$this->config['shortcode']        = strtolower( __CLASS__ );
		$this->config['name']             = __( 'Google Maps', 't4p-core' );
		$this->config['cat']              = __( 'General', 't4p-core' );
		$this->config['icon']             = 't4p-pb-icon-google-map';
		$this->config['description']      = __( 'Map with a specified title and location', 't4p-core' );

		// Define exception for this shortcode
		$this->config['exception'] = array(
		);

		// Use Ajax to speed up element settings modal loading speed
		$this->config['edit_using_ajax'] = true;
	}

	/**
	 * Define shortcode settings.
	 *
	 * @return  void
	 */
	public function element_items() {
		$this->items = array(
			'content' => array(

                                array(
                                        'name' => __( 'Address', 't4p-core' ),
                                        'id'   => 'address',
                                        'type' => 'text_area',
                                        'tooltip' => __( 'Add address to the location which will show up on map. For multiple addresses, separate addresses by using the | symbol.
                                                            ex: Address 1|Address 2|Address 3', 't4p-core' ),
                                ),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
                                array(
					'name'    => __( 'Alignment', 't4p-core' ),
					'id'      => 'gmap_alignment',
					'class'   => 'input-sm',
					'std'     => 'center',
					'type'    => 'radio_button_group',
					'options' => T4P_Pb_Helper_Type::get_map_align(),
				),
                                array(
					'type' => 'hr',
				),
				array(
					'name'    => __( 'Select the Map Styling', 't4p-core' ),
					'id'      => 'map_style',
					'type'    => 'select',
					'class'   => 'input-sm',
					'std'     => T4P_Pb_Helper_Type::get_first_option( T4P_Pb_Helper_Type::get_qr_container_style() ),
					'options' => T4P_Pb_Helper_Type::get_qr_container_style(),
                                        'has_depend' => '1',
                                        'tooltip' => __( 'Choose default styling for classic google map styles. Choose theme styling for our custom style. Choose custom styling to make your own with the advanced options below.', 't4p-core' )
				),
                                array(
                                        'name' => __( 'Map Overlay Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'overlay_color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'dependency'  => array( 'map_style', '=', 'custom' ),
                                        'tooltip' => __( 'Custom styling setting only. Pick an overlaying color for the map. Works best with "roadmap" type.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Infobox Styling', 't4p-core' ),
                                        'id'         => 'infobox',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => 'default',
                                        'options'    => array(
                                                                'default'      => __( 'Default Infobox', 't4p-core' ),
                                                                'custom'   => __( 'Custom Infobox', 't4p-core' ),
                                                        ),
                                        'dependency'  => array( 'map_style', '=', 'custom' ),
                                        'tooltip' => __( 'Custom styling setting only. Choose between default or custom info box.', 't4p-core' ),
                                ),
                                array(
                                        'name' => __( 'Infobox Content', 't4p-core' ),
                                        'id'   => 'infobox_content',
                                        'type' => 'text_area',
                                        'dependency'  => array( 'map_style', '=', 'custom' ),
                                        'tooltip' => __( 'Custom styling setting only. Type in custom info box content to replace address string. For multiple addresses, separate info box contents by using the | symbol. '
                                                            . 'ex: InfoBox 1|InfoBox 2|InfoBox 3', 't4p-core' ),
                                ),
                                array(
                                        'name' => __( 'Info Box Text Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'infobox_text_color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'dependency'  => array( 'map_style', '=', 'custom' ),
                                        'tooltip' => __( 'Custom styling setting only. Pick a color for the info box text.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Info Box Background Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'infobox_background_color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'dependency'  => array( 'map_style', '=', 'custom' ),
                                        'tooltip' => __( 'Custom styling setting only. Pick a color for the info box background.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Custom Marker Icon', 't4p-core' ),
                                        'id'   => 'icon',
                                        'type' => 'text_area',
                                        'dependency'  => array( 'map_style', '=', 'custom' ),
                                        'tooltip' => __( 'Custom styling setting only. Use full image urls for custom marker icons or input "theme" for our custom marker. For multiple addresses, separate icons by using the | symbol or use one for all. '
                                                . 'ex: Icon 1|Icon 2|Icon 3', 't4p-core' ),
                                ),
				array(
					'type' => 'hr',
				),
                            	array(
					'name'    => __( 'Map Type', 't4p-core' ),
					'id'      => 'type',
					'type'    => 'select',
					'class'   => 'input-sm',
					'std'     => 'roadmap',
					'options' => T4P_Pb_Helper_Type::get_gmap_type(),
                                        'tooltip' => __( 'Select the type of google map to display.', 't4p-core' )
				),
                                array(
                                        'name'    => __( 'Map Width', 't4p-core' ),
                                        'id'      => 'width',
                                        'type'    => 'text_field',
                                        'std'     => '100%',
                                        'tooltip' => __( 'Map width in percentage or pixels. ex: 100%, or 940px', 't4p-core' )
                                ),
                                array(
                                        'name'    => __( 'Map Height', 't4p-core' ),
                                        'id'      => 'height',
                                        'type'    => 'text_field',
                                        'std'     => '300px',
                                        'tooltip' => __( 'Map height in percentage or pixels. ex: 100%, or 300px', 't4p-core' )
                                ),
				array(
					'name'    => __( 'Zoom Level', 't4p-core' ),
					'id'      => 'zoom',
					'class'   => 't4p-slider',
					'type'    => 'slider',
					'std_max' => '25',
					'std'     => '14',
                                        'tooltip' => __( 'Higher number will be more zoomed in.', 't4p-core' )
				),
                                array(
                                       'name'       => __( 'Scrollwheel on Map', 't4p-core' ),
                                       'id'         => 'scrollwheel',
                                       'type'       => 'radio',
                                       'std'        => 'yes',
                                       'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
                                       'tooltip'    => __( 'Enable zooming using a mouse scroll wheel.', 't4p-core' )
                                ),
                                array(
                                       'name'       => __( 'Show Scale Control on Map', 't4p-core' ),
                                       'id'         => 'scale',
                                       'type'       => 'radio',
                                       'std'        => 'yes',
                                       'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
                                       'tooltip'    => __( 'Display the map scale.', 't4p-core' )
                                ),
                                array(
                                       'name'       => __( 'Show Pan Control on Map', 't4p-core' ),
                                       'id'         => 'zoom_pancontrol',
                                       'type'       => 'radio',
                                       'std'        => 'yes',
                                       'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
                                       'tooltip'    => __( 'Displays pan control button.', 't4p-core' )
                                ),
                                array(
                                       'name'       => __( 'Show tooltip by default?', 't4p-core' ),
                                       'id'         => 'popup',
                                       'type'       => 'radio',
                                       'std'        => 'yes',
                                       'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
                                       'tooltip'    => __( 'Display or hide the tooltip when the map first loads.', 't4p-core' )
                                ),
                                T4P_Pb_Helper_Type::get_animation_type(),
                                T4P_Pb_Helper_Type::get_animations_direction(),
                                T4P_Pb_Helper_Type::get_animation_speeds(),
			)
		);
	}

	/**
	 * Generate HTML code from shortcode content.
	 *
	 * @param   array   $atts     Shortcode attributes.
	 * @param   string  $content  Current content.
	 *
	 * @return  string
	 */
	public function element_shortcode_full( $atts = null, $content = null ) {
                global $evl_options, $smof_data;
		$arr_params = shortcode_atts( $this->config['params'], $atts );
		extract( $arr_params );

                $address  = ( ! $address ) ? '' : $address;
                $gmap_alignment = ( ! $gmap_alignment ) ? '' : $gmap_alignment;
                $map_style  = ( ! $map_style ) ? '' : $map_style;
                $infobox = ( ! $infobox ) ? '' : $infobox;
                $infobox_content = ( ! $infobox_content ) ? '' : $infobox_content;
                $infobox_text_color = ( ! $infobox_text_color ) ? '' : $infobox_text_color;
                $infobox_background_color = ( ! $infobox_background_color ) ? '' : $infobox_background_color;
                $icon = ( ! $icon ) ? '' : $icon;
                $type = ( ! $type ) ? 'roadmap' : $type;
                $width = ( ! $width ) ? '100%' : $width;
                $height = ( ! $height ) ? '300px' : $height;
                $zoom = ( ! $zoom ) ? '14' : $zoom;
                $scrollwheel = ( ! $scrollwheel ) ? 'yes' : $scrollwheel;
                $scale = ( ! $scale ) ? 'yes' : $scale;
                $zoom_pancontrol = ( ! $zoom_pancontrol ) ? 'yes' : $zoom_pancontrol;
                $popup = ( ! $popup ) ? 'yes' : $popup;
                
                $html = '';
                $animation = '';
                
                if ( $gmap_alignment === 'right' ) {
                        $alignment = 'float: right';
		} else if ( $gmap_alignment === 'center' ) {
                        $alignment = 'margin: 0 auto; display: block;';
		} else if ( $gmap_alignment === 'left' ) {
                        $alignment = 'float: left';
		}

                if( $address ) {
			$addresses = explode( '|', $address );

			if( $infobox_content ) {
				$infobox_content_array = explode( '|', $infobox_content );
			} else {
				$infobox_content_array = '';
			}

			if( $icon ) {
				$icon_array = explode( '|', $icon );
			} else {
				$icon_array = '';
			}		

			if( $addresses ) {
				$address = $addresses;
			}

			$num_of_addresses = count( $addresses );
			if( is_array( $infobox_content_array ) && ! empty( $infobox_content_array ) ) {
			
				for( $i = 0; $i < $num_of_addresses; $i++ ) {
					if(	! $infobox_content_array[$i] ) {
						$infobox_content_array[$i] = $addresses[$i];
					}
				}
				$infobox_content = $infobox_content_array;
			} else {
				$infobox_content = $address;
			}

			if( $icon && strpos( $icon, '|' ) === false ) {
				for( $i = 0; $i < $num_of_addresses; $i++ ) {
					$icon_array[$i] = $icon;				
				}
			}

			if( $map_style == 'theme' ) {
				$map_style = 'custom';
				$icon = 'theme';
				$animation = 'yes';
				$infobox = 'custom';
				$infobox_background_color = T4PCore_Plugin::hex2rgb( $smof_data['primary_color'] . $evl_options['evl_general_link'] );
				$infobox_background_color = 'rgba(' . $infobox_background_color[0] . ', ' . $infobox_background_color[1] . ', ' . $infobox_background_color[2] . ', 0.8)';
				$overlay_color = $smof_data['primary_color'];
				$brightness_level = T4PCore_Plugin::calc_color_brightness( $smof_data['primary_color'] );

				if( $brightness_level > 140 ) {
					$infobox_text_color = '#fff';
				} else {
					$infobox_text_color = '#747474';
				}				
			}

			if( $icon == 'theme' && $map_style == 'custom' ) {
				for( $i = 0; $i < $num_of_addresses; $i++ ) {
					$icon_array[$i] = plugins_url( 'images/t4p_map_marker.png', dirname( __FILE__ ) );				
				}
			}

			wp_print_scripts( 'google-maps-api' );
			wp_print_scripts( 'google-maps-infobox' );

			foreach( $address as $add ) {

				$coordinates[] = $this->get_coordinates( $add );
			}

			if( ! is_array( $coordinates ) ) {
				return;
			}

			$map_id = uniqid( 't4p_map_' ); // generate a unique ID for this map
			$this->map_id = $map_id;

			ob_start(); ?>
			<script type="text/javascript">
				var map_<?php echo $map_id; ?>;
				var markers = [];
				var counter = 0;
				function t4p_run_map_<?php echo $map_id ; ?>() {
					var location = new google.maps.LatLng(<?php echo $coordinates[0]['lat']; ?>, <?php echo $coordinates[0]['lng']; ?>);
					var map_options = {
						zoom: <?php echo $zoom; ?>,
						center: location,
						mapTypeId: google.maps.MapTypeId.<?php echo strtoupper($type); ?>,
						scrollwheel: <?php echo ($scrollwheel == 'yes') ? 'true' : 'false'; ?>,
						scaleControl: <?php echo ($scale == 'yes') ? 'true' : 'false'; ?>,
						panControl: <?php echo ($zoom_pancontrol == 'yes') ? 'true' : 'false'; ?>,
						zoomControl: <?php echo ($zoom_pancontrol == 'yes') ? 'true' : 'false'; ?>						
					};
					map_<?php echo $map_id ; ?> = new google.maps.Map(document.getElementById("<?php echo esc_attr( $map_id ); ?>"), map_options);
					<?php $i = 0; ?>
					<?php foreach( $coordinates as $key => $coordinate ): ?>
					
					var content_string = "<div class='info-window'><?php echo $infobox_content[$key]; ?></div>";
					
					<?php if( $overlay_color && $map_style == 'custom' ) { ?>
					var styles = [
					  {
						stylers: [
						  { hue: '<?php echo $overlay_color; ?>' },
						  { saturation: -20 }
						]
					  },{
						featureType: "road",
						elementType: "geometry",
						stylers: [
						  { lightness: 100 },
						  { visibility: "simplified" }
						]
					  },{
						featureType: "road",
						elementType: "labels",
					  }
					];

					map_<?php echo $map_id ; ?>.setOptions({styles: styles});
					
					<?php } ?>

					map_<?php echo $map_id ; ?>_args = {
						position: new google.maps.LatLng("<?php echo $coordinate['lat']; ?>", "<?php echo $coordinate['lng']; ?>"),
						map: map_<?php echo $map_id ; ?>
					};

					<?php if ( $animation == 'yes' && $map_style == 'custom' ) { ?>
					map_<?php echo $map_id ; ?>_args.animation = google.maps.Animation.DROP;
					<?php } ?>
					<?php if( $icon == 'theme' && isset( $icon_array[$i] ) && $icon_array[$i] && $map_style == 'custom' ) { ?>
					map_<?php echo $map_id ; ?>_args.icon = new google.maps.MarkerImage( '<?php echo $icon_array[$i]; ?>', null, null, null, new google.maps.Size( 37, 55 ) );
					<?php } else if( isset( $icon_array[$i] ) && $icon_array[$i] && $map_style == 'custom' ) { ?>
					map_<?php echo $map_id ; ?>_args.icon = '<?php echo $icon_array[$i]; ?>';
					<?php } ?>
					<?php $i++; ?>

					markers[counter] = new google.maps.Marker(map_<?php echo $map_id ; ?>_args);

					<?php if ( $infobox == 'custom' && $map_style == 'custom' ) { ?>

						var info_box_div = document.createElement('div');
						info_box_div.className = 't4p-info-box';
						info_box_div.style.cssText = 'background-color:<?php echo $infobox_background_color; ?>;color:<?php echo $infobox_text_color; ?>;';

						info_box_div.innerHTML = content_string;

						var info_box_options = {
							 content: info_box_div
							,disableAutoPan: false
							,maxWidth: 150
							,zIndex: null
							,boxStyle: { 
							  background: 'none'
							  ,opacity: 1
							  ,width: "250px"
							 }
							,closeBoxMargin: "2px 2px 2px 2px"
							,closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif"
							,infoBoxClearance: new google.maps.Size(1, 1)

						};

						markers[counter]['infowindow'] = new google.maps.InfoWindow(info_box_options);

						<?php if( $popup == 'yes' ) { ?>
							markers[counter]['infowindow'].show = true;
							markers[counter]['infowindow'].open(map_<?php echo $map_id ; ?>, markers[counter]);
						<?php } ?>						

						google.maps.event.addListener(markers[counter], 'click', function() {
							if(this['infowindow'].show) {
								this['infowindow'].close(map_<?php echo $map_id ; ?>, this);
								this['infowindow'].show = false;
							} else {
								this['infowindow'].open(map_<?php echo $map_id ; ?>, this);
								this['infowindow'].show = true;
							}
						});					

					<?php } else { ?>
					
						markers[counter]['infowindow'] = new google.maps.InfoWindow({
							content: content_string
						});					
						
						<?php if( $popup == 'yes' ) { ?>
							markers[counter]['infowindow'].show = true;
							markers[counter]['infowindow'].open(map_<?php echo $map_id ; ?>, markers[counter]);
						<?php } ?>						

						google.maps.event.addListener(markers[counter], 'click', function() {
							if(this['infowindow'].show) {
								this['infowindow'].close(map_<?php echo $map_id ; ?>, this);
								this['infowindow'].show = false;
							} else {
								this['infowindow'].open(map_<?php echo $map_id ; ?>, this);
								this['infowindow'].show = true;
							}
						});
					
					<?php } ?>
					
					counter++;
					<?php endforeach; ?>

				}

				google.maps.event.addDomListener(window, 'load', t4p_run_map_<?php echo $map_id ; ?>);

			</script>
                        <style scoped >
                            .t4p-google-map {
                                <?php echo sprintf('height:%s;width:%s;%s',  $height, $width, $alignment ); ?>
                            }
                        </style>
			<?php
                        //html_attr
                        $class = 'shortcode-map t4p-google-map';
                        $id = $this->map_id;

			$html = ob_get_clean() . "<div class='$class' id='$id' ></div>";

		}

		return $this->element_wrapper( $html, $arr_params );
	}
        
        function get_coordinates( $address, $force_refresh = false ) {

	    $address_hash = md5( $address );

	    $coordinates = get_transient( $address_hash );

	    if ( $force_refresh || $coordinates === false ) {

	    	$args       = array( 'address' => urlencode( $address ), 'sensor' => 'false' );
	    	$url        = add_query_arg( $args, 'http://maps.googleapis.com/maps/api/geocode/json' );
	     	$response   = wp_remote_get( $url );

	     	if( is_wp_error( $response ) )
	     		return;

	     	$data = wp_remote_retrieve_body( $response );

	     	if( is_wp_error( $data ) )
	     		return;

			if ( $response['response']['code'] == 200 ) {

				$data = json_decode( $data );

				if ( $data->status === 'OK' ) {

				  	$coordinates = $data->results[0]->geometry->location;

				  	$cache_value['lat'] 	= $coordinates->lat;
				  	$cache_value['lng'] 	= $coordinates->lng;
				  	$cache_value['address'] = (string) $data->results[0]->formatted_address;

				  	// cache coordinates for 3 months
				  	set_transient($address_hash, $cache_value, 3600*24*30*3);
				  	$data = $cache_value;

				} elseif ( $data->status === 'ZERO_RESULTS' ) {
				  	return __( 'No location found for the entered address.', 't4p-core' );
				} elseif( $data->status === 'INVALID_REQUEST' ) {
				   	return __( 'Invalid request. Did you enter an address?', 't4p-core' );
				} else {
					return __( 'Something went wrong while retrieving your map, please ensure you have entered the short code correctly.', 't4p-core' );
				}

			} else {
			 	return __( 'Unable to contact Google API service.', 't4p-core' );
			}

	    } else {
	       // return cached results
	       $data = $coordinates;
	    }

	    return $data;

	}

}

endif;

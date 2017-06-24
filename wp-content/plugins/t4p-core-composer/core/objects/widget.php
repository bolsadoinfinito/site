<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
if ( ! class_exists( 'T4P_Pb_Objects_Widget' ) ) {

	class T4P_Pb_Objects_Widget extends WP_Widget {

		var $t4p_widget_cssclass;
		var $t4p_widget_description;
		var $t4p_widget_idbase;
		var $t4p_widget_name;

		/**
		 * constructor
		 *
		 * @access public
		 * @return void
		 */
		function __construct() {
			$this->t4p_widget_cssclass    = 't4p-widget-pagebuilder';
			$this->t4p_widget_description = __( 'Presentation of any PageBuilder element', 't4p-core' );
			$this->t4p_widget_idbase      = 't4p_widget_pagebuilder';
			$this->t4p_widget_name        = __( 'PageBuilder Element', 't4p-core' );

			/* Widget settings. */
			$widget_ops = array( 'classname' => $this->t4p_widget_cssclass, 'description' => $this->t4p_widget_description );

			/* Create the widget. */
			parent::__construct( 't4p_widget_pagebuilder', $this->t4p_widget_name, $widget_ops );
		}

		/**
		 * widget function
		 *
		 * @see WP_Widget::widget()
		 * @access public
		 * @param array $args
		 * @param array $instance
		 * @return void
		 */
		function widget( $args, $instance ) {
			extract( $args );
			$title = $shortcode = '';
			// process shortcode
			if ( isset( $instance['t4p_widget_shortcode'] ) ) {
				$shortcode = $instance['t4p_widget_shortcode'];
				if ( ! $title ) {
					$str_title = substr( $shortcode, strpos( $shortcode, 'el_title=--quote--' ) );
					$str_title = str_replace( 'el_title=--quote--', '', $str_title );
					$title     = substr( $str_title, 0, strpos( $str_title, '--quote--' ) );
				}
				$shortcode = str_replace( '--quote--', '"', $shortcode );
				$shortcode = str_replace( '--open_square--', '[', $shortcode );
				$shortcode = str_replace( '--close_square--', ']', $shortcode );
			}
			if ( ! $title ) {
				global $t4p_pb;
				$elements = $t4p_pb->get_elements();
				if ( isset( $elements['element'] ) ) {
					foreach ( $elements['element'] as $idx => $element ) {
						// don't show sub-shortcode
						if ( ! isset( $element->config['name'] ) )
						continue;
						if ( isset( $instance['t4p_element'] ) && $element->config['shortcode'] == $instance['t4p_element'] ) {
							$title = $element->config['name'];
						}
					}
				}
			}
			// process widget title
			$title = apply_filters( 'widget_title', empty($instance['t4p_element'] ) ? __( 'PageBuilder Element', 't4p-core' ) : $title, $instance, $this->id_base );
			echo balanceTags( $before_widget );
			if ( $title ) {
				echo balanceTags( $before_title . $title . $after_title );
			}
			echo '<div class="jsn-bootstrap3">';
			echo balanceTags( do_shortcode( $shortcode ) );
			echo '</div>';
			echo balanceTags( $after_widget );
		}

		/**
		 * update pagebuilder widget element
		 *
		 * @see WP_Widget::update()
		 */
		function update( $new_instance, $old_instance ) {
			$instance                        = $old_instance;
			$instance['t4p_element']          = strip_tags( $new_instance['t4p_element'] );
			$instance['t4p_widget_shortcode'] = $new_instance['t4p_widget_shortcode'];

			return $instance;
		}

		/**
		 * form function.
		 *
		 * @see WP_Widget::form()
		 * @access public
		 * @param array $instance
		 * @return void
		 */
		function form( $instance ) {
			// Default
			$instance            = wp_parse_args( (array ) $instance, array( 't4p_element' => '', 't4p_widget_shortcode' => '' ) );
			$title               = '';
			$selected_value      = esc_attr( $instance['t4p_element'] );
			$t4p_widget_shortcode = $instance['t4p_widget_shortcode'];

			global $t4p_pb;
			$elements      = $t4p_pb->get_elements();
			$elements_html = array();
			if ( $elements ) {
				foreach ( $elements['element'] as $idx => $element ) {
					// don't show sub-shortcode
					if ( ! isset( $element->config['name'] ) )
					continue;
					if ( $element->config['shortcode'] == $selected_value ) {
						$elements_html[] = '<option value="' . $element->config['shortcode'] . '" selected="selected">' . $element->config['name'] . '</option>';
						$title           = $element->config['name'];
					} else {
						$elements_html[] = '<option value="' . $element->config['shortcode'] . '">' . $element->config['name'] . '</option>';
					}
				}
			}
			?>
<div class="jsn-bootstrap3">

	<div class="t4p-widget-setting">
	<?php
	if ( ! $elements ) {
		echo '<p>' . sprintf( __( 'No elements have been created yet!  ', 't4p-core' ) ) . '</p>';
		return;
	}
	?>
		<label
			for="<?php echo esc_attr( $this->get_field_id( 't4p_element' ) ); ?>"><?php _e( 'Element', 't4p-core' ) ?>
		</label>
		<div
			class="form-group control-group clearfix combo-group t4p-widget-box">
			<div class="controls">
				<div class="combo-item">
					<select class="t4p_widget_select_elm"
						id="<?php echo esc_attr( $this->get_field_id( 't4p_element' ) ); ?>"
						name="<?php echo esc_attr( $this->get_field_name( 't4p_element' ) ); ?>">
						<?php
						// shortcode elements
						foreach ( $elements_html as $idx => $element ) {
							echo balanceTags( $element );
						}
						?>
					</select>
				</div>
				<div class="combo-item">
					<a id="t4p_widget_edit_btn" class="t4p_widget_edit_btn btn btn-icon"
						data-shortcode="<?php echo esc_attr( $selected_value ) ?>"><i
						class="icon-pencil"></i><i class="jsn-icon16 jsn-icon-loading"
						id="t4p-widget-loading" style="display: none"></i> </a>
				</div>
				<input class="t4p_shortcode_widget" type="hidden"
					id="<?php echo esc_attr( $this->get_field_id( 't4p_widget_shortcode' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 't4p_widget_shortcode' ) ); ?>"
					value="<?php echo esc_attr( $t4p_widget_shortcode ); ?>" />
				<div class="jsn-section-content jsn-style-light hidden"
					id="form-design-content">
					<div class="t4p-pb-form-container jsn-layout">
						<input type="hidden" id="t4p-select-media" value="" />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
						<?php
		}

	}

}

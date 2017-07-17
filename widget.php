<?php
register_widget( 'Direction_Map_Widget' );
/**
 * Direction Map Widget class.
 * This class handles google map direction from source to destination value.
 * the settings, form, display, and update.  Nice!
 *
 * @since 1.3
 */
class Direction_Map_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Direction_Map_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Direction_Map', 'description' => __('This Wirdget is for display map on sidebar which is used to get direction.', 'direction_map') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'direction_map-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'direction_map-widget', __('Direction Map Widget', 'direction_map'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('Direction Map', $instance['title'] );
		$width = $instance['width'];
		$height = $instance['height'];		
		/* Before widget (defined by themes). */
		echo $before_widget;
		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
			
		/* Display name from widget settings if one was input. */
		include "map_widget.php";
		//to get address
		if($map_result->sCenterAddr!='')
			$address = $map_result->sCenterAddr;
	    else 
			$address ='';
	
			$data = '<div id="mapentry">
					Start : <input type="text" id="start" value="">  End : <input type="text" id="end" value="'.$address.'">
					<input type="button" value="Submit" onclick="calcRoute();"> 
					</div>';
    				if($map_result->sCenterAddr!='' && $map_result->nZoomLevel!=''){
    						$data.='<div id="map_canvas_widget" style="width:'.$width.'px;height:'.$height.'px"></div>';
					}
					else{
						$data .='Information to display is not setup from admin.';
					}
			echo $data;
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );		
		/* No need to strip tags for width and height. */
		$instance['width'] = $new_instance['width'];
		$instance['height'] = $new_instance['height'];
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Direction Map', 'direction_map'), 'title' => __('Direction Map', 'direction_map'), 'width' => '200', 'height' => '300' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
<!-- Widget Title: Text Input -->

<p>
  <label for="<?php echo $this->get_field_id( 'title' ); ?>">
  <?php _e('Title:', 'hybrid'); ?>
  </label>
  <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
</p>
<!-- Your Name: Text Input -->
<p> <span class="ttl01">
  <?php _e("Width : " ); ?>
  </span>
  <input id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $instance['width']; ?>" size="3" />
  px</p>
</p>
<p> <span class="ttl01">
  <?php _e("Height : " ); ?>
  </span>
  <input id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $instance['height']; ?>" size="3" />
  px</p>
</p>
<?php
	}
}
?>
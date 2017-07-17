<?php
/*
Contributors: softy.5454
Plugin Name: Direction Map
Plugin URI: http://www.creativedev.in
Description: plugin for get google map direction from source to destination value.
Version: 2.2
Author: Bhumi Shah
Author URI: http://www.creativedev.in
*/
wp_register_style('mapStyle',plugins_url('map.css',__FILE__));
wp_enqueue_style('mapStyle');
wp_register_script('mapjs','http://maps.googleapis.com/maps/api/js?sensor=false');
wp_enqueue_script('mapjs');
wp_enqueue_script('mapScript');
/* activate hook */
register_activation_hook( __FILE__, 'map_activate');
function map_activate(){
	global $wpdb;
    $table_name = $wpdb->prefix . "direction_map";
    if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
 		$sql = "CREATE TABLE  $table_name (
				 `nMapID` int(11) NOT NULL AUTO_INCREMENT,
				 `sCenterAddr` varchar(255) NOT NULL,
				 `nZoomLevel` int(3) NOT NULL,
				 `sTitle` varchar(255) NOT NULL,
				 `nWidth` int(4) NOT NULL,
				 `nHeight` int(4) NOT NULL,
				 `nDefaultViews` tinyint(1) NOT NULL COMMENT '1=ROADMAP,2=HYBRID,3=STYLED',
				 `sWaterBack` varchar(255) NOT NULL,
				 `sWaterText` varchar(255) NOT NULL,
				 `sLandBack` varchar(255) NOT NULL,
				 `sLandText` varchar(255) NOT NULL,
				 PRIMARY KEY (`nMapID`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8";
    	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    	dbDelta($sql);
	}
}

/* Deactivate hook */
register_deactivation_hook( __FILE__, 'map_deactivate');
function map_deactivate(){
	global $wpdb;
	$table_name = $wpdb->prefix . "direction_map";
	$wpdb->query("DROP TABLE IF EXISTS $table_name");
}
function map_direction($atts,$content=null)
{  

	include "map.php";
	global $wpdb;
	$tablename= $wpdb->prefix.'direction_map';
    $map_result = $wpdb->get_row( "SELECT * FROM $tablename");
	$width=$map_result->nWidth;
	$height=$map_result->nHeight;
	if($map_result->sCenterAddr!='')
			$address = $map_result->sCenterAddr;
	else 
			$address ='';
			$data = '<div id="mapentry">
					Start : <input type="text" id="start" value="">  End : <input type="text" id="end" value="'.$address.'">
					<input type="button" value="Submit" onclick="calcRoute();"> 
					</div>';
					if($map_result->sCenterAddr!='' && $map_result->nZoomLevel!=''){
    					$data.='<div id="map_canvas" ></div><style>#map_canvas {
height:'.$width.'px;
width:'.$height.'px;
}</style>';
					}
					else{
						$data .='Information to display is not setup from admin.';
					}
			return $data;
}
add_shortcode('map-data','map_direction');

function map_direction_admin() {
	include('map_direction_admin.php');
}
function map_direction_admin_actions() {
	add_options_page("Direction Map", "Direction Map", 'manage_options', "Map-Direction", "map_direction_admin");
}
add_action('admin_menu', 'map_direction_admin_actions');
/**
 * Register WP Sidebar widget.
 * 'Direction_Map_Widget' is the widget class used below.
 *
 * @since 1.3
 */
function direction_map_widgets() {
	include('widget.php');
}
add_action( 'widgets_init', 'direction_map_widgets' );
?>

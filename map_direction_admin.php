<?php 
	if($_POST['map_hidden'] == 'Y') { 
			 global $wpdb;
			$dm_address = $_POST['dm_address'];
			$dm_zoom = $_POST['dm_zoom'];
			$dm_title = $_POST['dm_title'];
			$dm_views = $_POST['dm_views'];
			$dm_width = $_POST['dm_width'];
			$dm_height = $_POST['dm_height'];	
			$dm_landtext = $_POST['dm_landtext'];
			$dm_landback = $_POST['dm_landback'];
			$dm_watertext = $_POST['dm_watertext'];
			$dm_waterback = $_POST['dm_waterback'];
			$tablename= $wpdb->prefix.'direction_map';
		    $type = $wpdb->get_row( "SELECT nMapID FROM $tablename",ARRAY_A);
			
                if(!empty($type['nMapID'])){
					if($dm_views=='3'){
                        $data = $wpdb->update( $tablename, array(
                                    'sCenterAddr'=>$dm_address,
                                    'nZoomLevel' => $dm_zoom,
									'sTitle'=>$dm_title,
									'nWidth' => $dm_width,'nHeight'=>$dm_height,
                                    'nDefaultViews' => $dm_views,
									'sWaterBack'=>$dm_waterback,'sWaterText'=>$dm_watertext,
                                    'sLandBack' => $dm_landback,
									'sLandText'=>$dm_landtext),array('nMapID'=>$type['nMapID']));
					}else{
						$data = $wpdb->update( $tablename, array(
                                    'sCenterAddr'=>$dm_address,
                                    'nZoomLevel' => $dm_zoom,
									'sTitle'=>$dm_title,
									'nWidth' => $dm_width,'nHeight'=>$dm_height,
                                    'nDefaultViews' => $dm_views,
									'sWaterBack'=>'','sWaterText'=>'',
                                    'sLandBack' => '',
									'sLandText'=>''),array('nMapID'=>$type['nMapID']));
					}
				}else{
					if($dm_views=='3'){
						$data = $wpdb->insert( $tablename, array(
                                    'sCenterAddr'=>$dm_address,
                                    'nZoomLevel' => $dm_zoom,
									'sTitle'=>$dm_title,
									'nWidth' => $dm_width,'nHeight'=>$dm_height,
                                    'nDefaultViews' => $dm_views,
									'sWaterBack'=>$dm_waterback,'sWaterText'=>$dm_watertext,
                                    'sLandBack' => $dm_landback,
									'sLandText'=>$dm_landtext));
					}else{
					$data = $wpdb->insert( $tablename, array(
                                    'sCenterAddr'=>$dm_address,
                                    'nZoomLevel' => $dm_zoom,
									'sTitle'=>$dm_title,
									'nWidth' => $dm_width,'nHeight'=>$dm_height,
                                    'nDefaultViews' => $dm_views,
									'sWaterBack'=>'','sWaterText'=>'',
                                    'sLandBack' => '',
									'sLandText'=>''));
					}
				}
		
		
?>

<div class="updated">
  <p><strong>
    <?php _e('Options saved.' ); ?>
    </strong></p>
</div>
<?php
	} else {
		//Normal page display
	
		
	}
	
	
?>
<?php global $wpdb;$tablename= $wpdb->prefix.'direction_map';
          $map_result = $wpdb->get_row( "SELECT * FROM $tablename");
?>
<div class="wrap">
  <?php    echo "<center><u><h2>" . __( 'How to Display On Site:') . "</h2></u></center>";
	echo "<p class='info'>This is Google Map Direction plugin used to display direction path in map or way for how you can go from source place to destination place.This will plugin will display dynamic path and user can view any direction by entering just both source place and destination place value.<br/>To display this functionality in your page just write <b>[map-data]</b> shortcode.</p>";
?>
  <?php    echo "<h2>" . __( 'Database Prefix change Display Options', 'map_dom' ) . "</h2>"; ?>
  <form name="map_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" class="map_form">
    <input type="hidden" name="map_hidden" value="Y">
    <?php    echo "<h4>" . __( 'Map Settings', 'map_dom' ) . "</h4>"; ?>
    <p>
      <span class="ttl01"> <?php _e("Center Address : " ); ?></span>
      <input type="text" name="dm_address" value="<?php echo $map_result->sCenterAddr; ?>" size="20">
      <?php _e(" ex: Country Name,Zip code" ); ?>
    </p>
    <p>
      <span class="ttl01"><?php _e("Zoom Level : " ); ?></span>
      <select id='wpgmza_start_zoom' name='dm_zoom' >
        <option value="1" <?php if($map_result->nZoomLevel=='1') echo 'selected="selected"'; ?>>1</option>
        <option value="2" <?php if($map_result->nZoomLevel=='2') echo 'selected="selected"'; ?>>2</option>
        <option value="3" <?php if($map_result->nZoomLevel=='3') echo 'selected="selected"'; ?>>3</option>
        <option value="4" <?php if($map_result->nZoomLevel=='4') echo 'selected="selected"'; ?>>4</option>
        <option value="5" <?php if($map_result->nZoomLevel=='5') echo 'selected="selected"'; ?>>5</option>
        <option value="6" <?php if($map_result->nZoomLevel=='6') echo 'selected="selected"'; ?>>6</option>
        <option value="7" <?php if($map_result->nZoomLevel=='7') echo 'selected="selected"'; ?>>7</option>
        <option value="8" <?php if($map_result->nZoomLevel=='8') echo 'selected="selected"'; ?>>8</option>
        <option value="9" <?php if($map_result->nZoomLevel=='9') echo 'selected="selected"'; ?>>9</option>
        <option value="10" <?php if($map_result->nZoomLevel=='10') echo 'selected="selected"'; ?>>10</option>
        <option value="11" <?php if($map_result->nZoomLevel=='11') echo 'selected="selected"'; ?>>11</option>
        <option value="12" <?php if($map_result->nZoomLevel=='12') echo 'selected="selected"'; ?>>12</option>
        <option value="13" <?php if($map_result->nZoomLevel=='13') echo 'selected="selected"'; ?>>13</option>
        <option value="14" <?php if($map_result->nZoomLevel=='14') echo 'selected="selected"'; ?>>14</option>
        <option value="15" <?php if($map_result->nZoomLevel=='15') echo 'selected="selected"'; ?>>15</option>
        <option value="16" <?php if($map_result->nZoomLevel=='16') echo 'selected="selected"'; ?>>16</option>
        <option value="17" <?php if($map_result->nZoomLevel=='17') echo 'selected="selected"'; ?>>17</option>
        <option value="18" <?php if($map_result->nZoomLevel=='18') echo 'selected="selected"'; ?>>18</option>
        <option value="19" <?php if($map_result->nZoomLevel=='19') echo 'selected="selected"'; ?>>19</option>
        <option value="20" <?php if($map_result->nZoomLevel=='20') echo 'selected="selected"'; ?>>20</option>
        <option value="21" <?php if($map_result->nZoomLevel=='21') echo 'selected="selected"'; ?>>21</option>
      </select>
    <p>
      <span class="ttl01"> <?php _e("Title : " ); ?></span>
      <input type="text" name="dm_title" value="<?php echo $map_result->sTitle; ?>" size="20">
    </p>
	<p>
       <span class="ttl01"><?php _e("Width : " ); ?></span>
      <input type="text" name="dm_width" value="<?php echo $map_result->nWidth; ?>" size="20">
	  <?php _e("Width accept integer value only. ex: 500" ); ?>
    </p>
    <p>
       <span class="ttl01"><?php _e("Height : " ); ?></span>
      <input type="text" name="dm_height" value="<?php echo $map_result->nHeight; ?>" size="20">
	   <?php _e("Height accept integer value only. ex: 500" ); ?>
    </p>
    <p>
      <span class="ttl01"> <?php _e("Default Views : " ); ?></span>
      <select type="text" name="dm_views" id="dm_views" >
        <option value="1" <?php if($map_result->nDefaultViews=='1'){ ?> selected="selected" <?php } ?>>ROADMAP</option>
        <option value="2" <?php if($map_result->nDefaultViews=='2'){ ?> selected="selected" <?php } ?>>HYBRID</option>
		<option value="3" <?php if($map_result->nDefaultViews=='3'){ ?> selected="selected" <?php } ?>>STYLED</option>
      </select>
    </p><div id="styledmap" style="display:none">
    <p>
       <span class="ttl01"><?php _e("Water Color in Map(Back) : " ); ?></span>
      <input type="text" name="dm_waterback" value="<?php echo $map_result->sWaterBack; ?>" size="20">
	   <?php _e("Color code with #,ex: #ff0000" ); ?>
    </p>
	 <p>
       <span class="ttl01"><?php _e("Water Color in Map(Text): " ); ?></span>
      <input type="text" name="dm_watertext" value="<?php echo $map_result->sWaterText; ?>" size="20">
    </p>
	 <p>
       <span class="ttl01"><?php _e("Landscape Color in Map(Back) : " ); ?></span>
      <input type="text" name="dm_landback" value="<?php echo $map_result->sLandBack; ?>" size="20">
    </p>
	<p>
       <span class="ttl01"><?php _e("Landscape Color in Map(Text): " ); ?></span>
      <input type="text" name="dm_landtext" value="<?php echo $map_result->sLandText; ?>" size="20">
    </p></div>
    <p class="submit">
      <input type="submit" name="Submit" class="button-primary" value="<?php _e('Save', 'map_dom' ) ?>" />
    </p>
  </form>
</div>
<script>
jQuery("#dm_views").change(function () {
  var val = jQuery("#dm_views").val();
  if(val=="3"){
    jQuery("#styledmap").css('display','block');
  }else
  	 jQuery("#styledmap").css('display','none');
});
(function($) {
  var val = jQuery("#dm_views").val();
  if(val=="3"){
    jQuery("#styledmap").css('display','block');
  }else
  	 jQuery("#styledmap").css('display','none');
})(jQuery);
</script>
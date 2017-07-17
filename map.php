<?php global $wpdb;$tablename= $wpdb->prefix.'direction_map';
          $map_result = $wpdb->get_row( "SELECT * FROM $tablename");
?>
<script type="text/javascript">
  var mygc = new google.maps.Geocoder();
	mygc.geocode({'address' :'<?php echo  $map_result->sCenterAddr; ?>'}, function(results, status){
    latitude = results[0].geometry.location.lat() ;
    longitude = results[0].geometry.location.lng() ;
});
var directionDisplay;
var directionsService = new google.maps.DirectionsService();

function initialize()
{
    directionsDisplay = new google.maps.DirectionsRenderer();
	<?php 
		/* for Water */
		$RGB = $map_result->sWaterBack;
		$R = intval(substr($RGB,0,2), 16)/255;
		$G = intval(substr($RGB,2,2), 16)/255;
		$B = intval(substr($RGB,4,2), 16)/255;
		$min = min(min($R,$G),$B);
		$max = max(max($R,$G),$B);
		$L = (($max+$min)/2)*100;
		$googleBaseValues = array("0"=>array("water", 45, 76));
		$Wbase = $googleBaseValues[0][2];
		if($L<$Wbase){
		$googleW = $L*100/$Wbase-100;
		}else if(L>Wbase){
		$googleW = ($L-$Wbase)*100/(100-$Wbase);
		}else{
		$googleW = $Wbase;
		}
		$googleW = round($googleW);
		/* for LandScape */
		$RGBL = $map_result->sLandBack;
		$RL = intval(substr($RGBL,0,2), 16)/255;
		$GL = intval(substr($RGBL,2,2), 16)/255;
		$BL = intval(substr($RGBL,4,2), 16)/255;
		$minL = min(min($RL,$GL),$BL);
		$maxL = max(max($RL,$GL),$BL);
		$LL = (($maxL+$minL)/2)*100;
		$googleBaseValuesL = array("0"=>array("landscape", 27, 89));
		$Lbase = $googleBaseValuesL[0][2];
		if($LL<$Lbase){
		$googleL = $LL*100/$Lbase-100;
		}else if(LL>Lbase){
		$googleL = ($LL-$Lbase)*100/(100-$Lbase);
		}else{
		$googleL = $Lbase;
		}
		$googleL = round($googleL);
	?>
	var styles = [
	{
		featureType: 'water',
		elementType: 'geometry',
		stylers: [
			{ hue: '<?php echo $map_result->sWaterBack;?>' },
			{ saturation: 100 },
			{ lightness: <?php echo $googleW; ?> },
			{ visibility: 'on' }
		]
	},{
		featureType: 'water',
		elementType: 'labels',
		stylers: [
			{ hue: '<?php echo $map_result->sWaterText;?>' },
			{ saturation: 100 },
			{ lightness: -36 },
			{ visibility: 'on' }
		]
	},{
		featureType: 'landscape',
		elementType: 'geometry',
		stylers: [
			{ hue: '<?php echo $map_result->sLandBack;?>' },
			{ saturation: 100 },
			{ lightness: <?php echo $googleL; ?> },
			{ visibility: 'on' }
		]
	},{
		featureType: 'landscape',
		elementType: 'labels',
		stylers: [
			{ hue: '<?php echo $map_result->sLandText;?>' },
			{ saturation: 100 },
			{ lightness: -33 },
			{ visibility: 'on' }
		]
	}
];
<?php if($map_result->nDefaultViews=='3'){
	$maptype='Styled';
}else if($map_result->nDefaultViews=='1'){
	$maptype='google.maps.MapTypeId.ROADMAP';
}else{
	$maptype='google.maps.MapTypeId.HYBRID';
}
?>
var options = {
<?php if($map_result->nDefaultViews=='3'){ ?>
	mapTypeControlOptions: {
		mapTypeIds: ['Styled']
	},
<?php } ?>
	 center: new google.maps.LatLng(latitude, longitude),
					mapTypeControl: true,
					mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
					navigationControl: true,
					navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
					mapTypeId: google.maps.MapTypeId.ROADMAP,
	zoom: <?php echo  $map_result->nZoomLevel; ?>,
	<?php if($map_result->nDefaultViews=='3'){ ?>
	mapTypeId: '<?php echo $maptype; ?>'
	<?php }else{ ?>
	mapTypeId: <?php echo $maptype; ?>
	<?php } ?>
};
var div = document.getElementById('map_canvas');
var map = new google.maps.Map(div, options);
<?php if($map_result->nDefaultViews=='3'){ ?>
var styledMapType = new google.maps.StyledMapType(styles, { name: 'Styled' });
map.mapTypes.set('Styled', styledMapType);
<?php } ?>
 var companyPos = new google.maps.LatLng(latitude, longitude);
 var companyMarker = new google.maps.Marker({
      position: companyPos,
      map: map,
      title: '<?php echo  $map_result->sTitle; ?>'
});
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById('directions-panel'));
    var control = document.getElementById('control');
    control.style.display = 'block';
    map.controls[google.maps.ControlPosition.TOP].push(control);
}
function calcRoute()
{
    var start = document.getElementById('start').value;
    var end = document.getElementById('end').value;
    var request = {
      origin: start,
      destination: end,
      travelMode: google.maps.DirectionsTravelMode.DRIVING 
    };
    directionsService.route(request, function(response, status){
    if (status != google.maps.DirectionsStatus.OK)
    {
		alert("Direction Path not found");
		return;
	}else{
	        directionsDisplay.setDirections(response);
    }
	
    });
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
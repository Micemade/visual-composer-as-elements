<?php
function vc_ase_as_gmap_func( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(
				'title'               => '',
				'subtitle'            => '',
				'sub_position'        => 'bellow',
				'title_style'         => 'center',
				'title_custom_css'    => '',
				'subtitle_custom_css' => '',
				'title_color'         => '',
				'subtitle_color'      => '',
				'title_size'          => '',
				'heading_css'         => '',

				'api_key'             => '',
				'enter_anim'          => 'none',
				'anim_delay'          => '',
				// 51.51379710359708 , -0.09957700967788696 this lat/long is London, St. Paul's cathedral ;) ...
				'latitude'            => '',
				'longitude'           => '',

				'address2'            => '',
				'address3'            => '',
				'address4'            => '',
				'attach_id'           => '',
				'width'               => '100%',
				'height'              => '450px',
				'gmap_styles'         => '',
				'zoom'                => '',
				'scroll_zoom'         => '',

				'css_classes'         => '',
				'block_id'            => apply_filters( 'vc_ase_randomString', 10 ),

			), $atts
		)
	);

	####################  OUTPUT STARTS HERE: #########################
	ob_start();

	if ( $api_key !== '' ) {

		wp_register_script( 'gmap', 'https://maps.googleapis.com/maps/api/js?v=3&key=' . $api_key );
		wp_enqueue_script( 'gmap', 'https://maps.googleapis.com/maps/api/js?v=3&key=' . $api_key, '1.0' );

		echo $css_classes ? '<div class="' . esc_attr( $css_classes ) . '">' : null;

		do_action( 'vc_ase_block_heading', $title, $subtitle, $title_style, $sub_position, $title_custom_css, $subtitle_custom_css, $title_color, $subtitle_color, $title_size, $heading_css );
		?>

	<div id="map-<?php echo esc_attr( $block_id ); ?>-holder" class="vc-ase-element content-block anim-wrap
							<?php
							echo ( $enter_anim != 'none' ) ? ' to-anim' : '';
							echo $css_classes ? ' ' . esc_attr( $css_classes ) : '';
							?>
	" >

		<?php
		$add_str  = '<div class="marker">';
		$add_str .= $title ? '<p><strong>' . esc_html( $title ) . '</strong></p>' : '';
		$add_str .= $address2 ? '<p>' . esc_html( $address2 ) . '</p>' : '';
		$add_str .= $address3 ? '<p>' . esc_html( $address3 ) . '</p>' : '';
		$add_str .= $address4 ? '<p>' . esc_html( $address4 ) . '</p>' : '';
		$add_str .= $attach_id ? '<div class="entry-image">' . wp_get_attachment_image( $attach_id, 'thumbnail' ) . '</div>' : '';
		$add_str .= '</div>';

		$add_str = wpautop( $add_str );

		// GET LONGITUDE AND LATITUDE BY USING ADDRESS:
		$address_flds = $address2 . ', ' . $address3;
		$prepAddr     = str_replace( ' ', '+', $address_flds );

		// IF THERE IS ADDRESS DATA AND NO "MANUAL" LONGITUDE/LATITUDE INPUT
		if ( $prepAddr && ! $latitude && ! $longitude ) {

			$geocode = file_get_contents( 'https://maps.google.com/maps/api/geocode/json?address=' . $prepAddr );

			$output = json_decode( $geocode );

			//	IF THERE'S AND ERROR IN ADDRESS, AND GOGLE CAN'T FIND IT
			if ( empty( $output->results ) || ( $output->status != 'OK' ) ) {
				echo '<h3 style="text-align:center">' . esc_html__( 'Google maps error', 'vc_ase' ) . ' :</h3>';
				echo '<p style="text-align:center">' . esc_html__( "Please check your address inputs - there's a probable error in data, or use manual longitude and latitude inputs.", 'vc_ase' ) . '</p>';
				return;
			}

			$lat  = $output->results[0]->geometry->location->lat;
			$long = $output->results[0]->geometry->location->lng;
		}

		// IF LATITUDE AND LONGITUDE ARE ENTERED MANUALLY:
		if ( $latitude && $longitude ) {
			$lat  = $latitude;
			$long = $longitude;
		}

		// GMAP STYLES:
		$json_styles = '';
		if ( $gmap_styles ) {

			$styles_url  = VC_ASE_URL . '/assets/js/gmap_styles/' . $gmap_styles . '.json';
			$json_data   = wp_remote_fopen( $styles_url );
			$json_styles = json_decode( $json_data, true );

		}
		?>

	<script type="text/javascript">
	function initialize_<?php echo esc_js( $block_id ); ?>() {

		var leeds = new google.maps.LatLng( <?php echo esc_js( $lat ); ?>, <?php echo esc_js( $long ); ?> );

		var firstLatlng = new google.maps.LatLng( <?php echo esc_js( $lat ); ?>, <?php echo esc_js( $long ); ?> );              

		var firstOptions = {
			scrollwheel: <?php echo esc_js( $scroll_zoom ) ? 'false' : 'true'; ?>,
			zoom: <?php echo $zoom ? esc_js( $zoom ) : '16'; ?>,
			center: firstLatlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP 
		};

		var map = new google.maps.Map(document.getElementById("map-<?php echo esc_js( $block_id ); ?>"), firstOptions);

		firstmarker_<?php echo esc_js( $block_id ); ?> = new google.maps.Marker({
			map:map,
			draggable:false,
			animation: google.maps.Animation.DROP,
			title: "<?php echo $title ? esc_js( $title ) : ''; ?>",
			position: leeds
		});

		
		var contentString1 = <?php echo wp_json_encode( $add_str ); ?>;

		var infowindow1 = new google.maps.InfoWindow({
			content: contentString1
		});

		google.maps.event.addListener(firstmarker_<?php echo esc_js( $block_id ); ?>, 'click', function() {
			infowindow1.open(map,firstmarker_<?php echo esc_js( $block_id ); ?>);
		});
		
		<?php if ( $json_styles !== null ) { ?>
		
		var styles = <?php echo json_encode( $json_styles ); ?>;
		map.setOptions({styles: styles});
		
		<?php } ?>

	}
	</script>

	<div class="google-map">

		<div id="map-<?php echo  esc_attr( $block_id ); ?>" style="width: <?php echo esc_attr( $width ); ?>; height:<?php echo esc_attr( $height ); ?>"></div>  

	</div>

	</div>  

		<?php $delay = $anim_delay ? $anim_delay : 100; ?>

	<script>
	jQuery(document).ready( function($) {

		var thisBlock = $('#map-<?php echo esc_js( $block_id ); ?>-holder');

		if ( !window.vcase_isMobile && !window.isIE9 ) {

			thisBlock.waypoint(
			
				function(direction) {
					
					if( direction === "up" ) {	
						
						thisBlock.removeClass('animated <?php echo esc_js( $enter_anim ); ?>').addClass('to-anim');
						
					}else if( direction === "down" ) {
						
						setTimeout(function(){
						   thisBlock.addClass('animated <?php echo esc_js( $enter_anim ); ?>').removeClass('to-anim');
						}, <?php echo esc_js( $delay ); ?>);
					}
				}, 
				{ offset: "98%" }	
			
			);

		}else{

			thisBlock.each( function() {
				
				$(this).removeClass('to-anim');
			
			});
			
	}

	});
	jQuery(window).load( function($){
		initialize_<?php echo esc_js( $block_id ); ?>(); 
	});
	</script>


		<?php
		####################  HTML ENDS HERE: ###########################
		echo $css_classes ? '</div>' : null;

		//IF NO API KEY PROVIDED:
	} else {

		echo '<p class="warning">' . __( 'No Google Maps API key provided.', 'vc_ase' ) . '</p>';

	}

	$output_string = ob_get_contents();

	ob_end_clean();

	return $output_string;
	####################  HTML ENDS HERE: ###########################

}

add_shortcode( 'as_gmap', 'vc_ase_as_gmap_func' );
?>

<?php

	$pd_map_open_street_map = get_option('pd_map_open_street_map') ? get_option('pd_map_open_street_map') : '';

	if( $pd_map_open_street_map == 'on' ) {

		wp_enqueue_script( 'qcpnd-custom-maponly-script', qcpnd_ASSETS_URL . '/js/directory-openstreet-maponly-script.js', array('jquery' ),'',true);

	}else{
		wp_enqueue_script( 'qcpnd-custom-maponly-script', qcpnd_ASSETS_URL . '/js/directory-maponly-script.js', array('jquery'),'',true);
	}

	$pd_lan_view_site = get_option('pd_lan_view_site')  ? get_option('pd_lan_view_site') :'View Site';
	$pd_lan_provide_location = get_option('pd_lan_provide_location')  ? get_option('pd_lan_provide_location') :'Please provide location';
	$pd_lan_distance_value = get_option('pd_lan_distance_value')  ? get_option('pd_lan_distance_value') :'Please provide Distance value';
	$pd_lan_no_result_found = get_option('pd_lan_no_result_found')  ? get_option('pd_lan_no_result_found') :'No result found!';
	$pd_lan_gdpr_policies = get_option('pd_lan_gdpr_policies') ? get_option('pd_lan_gdpr_policies') : esc_html('I agree with the website\'s GDPR policies.');
	$pd_lan_gdpr_load_map_lang = get_option('pd_lan_gdpr_load_map_lang') ? get_option('pd_lan_gdpr_load_map_lang') : esc_html('Please load the map');
	$enable_gdpr_policies = get_option('pd_enable_gdpr_policies') ? get_option('pd_enable_gdpr_policies') : '';
		
	$sld_variables_maponly = array(
		'distance_location_text' 	=>	$pd_lan_provide_location,
		'distance_value_text'		=>	$pd_lan_distance_value,
		'distance_no_result_text' 	=> $pd_lan_no_result_found,
		'radius_circle_color'		=> '#FF0000',
		'zoom'						=> '13',
		'popup_zoom'				=> '13',
		'cluster'					=> false,
		'image_infowindow'			=> false,
		'latitute'					=> '37.090240',
		'longitute'					=> '-95.712891',
		'paid_marker_default'		=> qcpnd_ASSETS_URL.'/Pink-icon.png',
		'view_site_lan' 			=> $pd_lan_view_site,
		'gdpr_policies'    			=> $pd_lan_gdpr_policies,
		'gdpr_load_map_lang'    	=> $pd_lan_gdpr_load_map_lang,
		'enable_gdpr_policies'    	=> $enable_gdpr_policies
	);
	wp_enqueue_script( 'qcopd-google-map-scriptasd', qcpnd_ASSETS_URL.'/js/oms.min.js', null, null, false );

	wp_localize_script('qcpnd-custom-maponly-script', 'sld_variables_maponly', $sld_variables_maponly);

// The Loop
if ( $list_query->have_posts() ){

	if(get_option('pd_enable_top_part')=='on') :
		
	 do_action('qcpnd_attach_embed_btn', $shortcodeAtts);
	
	endif;

	//Check if border should be set
	$borderClass = "";

	echo '<div class="sbd_maponly_parent"><div id="sbd_maponly_container" class="sbd_maponly" style="width:100%;height:450px;overflow:hidden;display:block;margin-bottom:20px;"></div>';
		
	echo '</div>';
	do_action( 'qcpnd_after_main_list', $shortcodeAtts);
	global $wpdb;


?>
<script type="text/javascript">
var all_items = [];
<?php
	while ( $list_query->have_posts() )
	{
		$list_query->the_post();
		
		$lists = array();
		//$results = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE post_id = ".get_the_ID()." AND meta_key = 'qcpnd_list_item01' order by `meta_id` ASC");
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->postmeta WHERE post_id = %d AND meta_key = 'qcpnd_list_item01' order by `meta_id` ASC", get_the_ID() ) );
				
		if(!empty($results)){
			$count = 1;
			foreach($results as $result){
				$unserialize = unserialize($result->meta_value);	
				$img = '';
				?>
				all_items.push({
					map_marker_id: "item-<?php echo get_the_ID(); ?>-<?php echo $count++; ?>",
					title: "<?php if(isset($unserialize['qcpnd_item_title'])){ echo htmlspecialchars($unserialize['qcpnd_item_title']); } ?>",
					link: "<?php echo $unserialize['qcpnd_item_link']; ?>",
					description: "<?php if(isset($unserialize['qcpnd_item_description'])){ echo htmlspecialchars($unserialize['qcpnd_item_description']); } ?>",
					latitude: "<?php if(isset($unserialize['qcpd_item_latitude'])){ echo $unserialize['qcpd_item_latitude']; } ?>",
					longitude: "<?php if(isset($unserialize['qcpd_item_longitude'])){ echo $unserialize['qcpd_item_longitude']; } ?>",
					location: "",
					fulladdress: "<?php if(isset($unserialize['qcpd_item_full_address'])){ echo $unserialize['qcpd_item_full_address']; } ?>",
					markericon: "<?php echo (isset($unserialize['qcpnd_item_marker'])&&$unserialize['qcpnd_item_marker']!=''?wp_get_attachment_image_src($unserialize['qcpnd_item_marker'])[0]:''); ?>",
				});
				<?php	
			}
		}

	}
	wp_reset_postdata();
?>

</script>
<?php
}

?>


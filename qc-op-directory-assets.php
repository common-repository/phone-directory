<?php

defined('ABSPATH') or die("You can't access this file directly.");

add_action('init', 'qcpd_load_resources');

function qcpd_load_resources(){
	add_action('wp_enqueue_scripts', 'qcpnd_load_all_scripts');
	add_action( 'admin_enqueue_scripts', 'qc_phone_directory_admin_css' );

}

function qcpnd_load_all_scripts(){

	//Scripts
	wp_enqueue_script( 'jquery', 'jquery');
    wp_register_script( 'qcpnd-grid-packery', qcpnd_ASSETS_URL . '/js/packery.pkgd.js', array('jquery'));

	//StyleSheets
	wp_register_style( 'qcpnd-custom-css', qcpnd_ASSETS_URL . '/css/directory-style.css');
	
	wp_register_style( 'qcpnd-custom-rwd-css', qcpnd_ASSETS_URL . '/css/directory-style-rwd.css');
	
	wp_register_style( 'qcpnd-fontawesome-rwd-css', qcpnd_ASSETS_URL . '/css/font-awesome.min.css');
	
	
	$pd_map_open_street_map = get_option('pd_map_open_street_map') ? get_option('pd_map_open_street_map') : '';

	if($pd_map_open_street_map == 'on'){

		wp_enqueue_script( 'qcpd-markercluster-sbd', 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js', array(),'',false);

		wp_enqueue_style( 'jq-openstreet-theme-css', 'https://unpkg.com/leaflet@1.3.1/dist/leaflet.css');
		wp_enqueue_style( 'jq-openstreet-marker-css', 'https://unpkg.com/leaflet.markercluster@1.3.0/dist/MarkerCluster.css');
		wp_enqueue_style( 'jq-openstreet-MarkerCluster-css', 'https://unpkg.com/leaflet.markercluster@1.3.0/dist/MarkerCluster.Default.css');

		wp_enqueue_script( 'qcpd-openstreet-sbd', 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.4.0/leaflet.js', array('jquery' ),'',true);
		wp_enqueue_script( 'qcpd-openstreet-marker-sbd', 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/leaflet.markercluster.js', array('jquery' ),'',true);

		wp_register_script( 'qcpnd-google-map-script', qcpnd_ASSETS_URL . '/js/directory-openstreet-script-for-map.js', array('jquery' ),'',true);
		wp_register_script( 'qcpnd-custom-script', qcpnd_ASSETS_URL . '/js/directory-script.js', array('jquery', 'qcpnd-grid-packery', 'qcpnd-google-map-script'));

	}
	
	
	$mapapi = 'AIzaSyBACyZ4vA8pQybj9ZdZP-J5zQHqfQkqOXY';
	if( (get_option('sbd_map_api_key')!='') && ($pd_map_open_street_map != 'on') ){

		$mapapi = get_option('sbd_map_api_key');
		wp_register_script( 'qcopd-google-map-script','https://maps.google.com/maps/api/js?key='.$mapapi.'&libraries=geometry,places', null, null, false );

		wp_register_script( 'qcpnd-google-map-script', qcpnd_ASSETS_URL . '/js/directory-script-for-map.js', array('jquery'));
		wp_register_script( 'qcpnd-custom-script', qcpnd_ASSETS_URL . '/js/directory-script.js', array('jquery', 'qcpnd-grid-packery', 'qcpnd-google-map-script'));
		
	}else{
		wp_register_script( 'qcpnd-custom-script', qcpnd_ASSETS_URL . '/js/directory-script.js', array('jquery', 'qcpnd-grid-packery'));
	}

	

	$pd_enable_rtl = ( get_option('pd_enable_rtl') == 'on' ) ? false:true;
	$pd_lan_view_site = get_option('pd_lan_view_site') ? get_option('pd_lan_view_site') : esc_html('View Site');
	$pd_lan_gdpr_policies = get_option('pd_lan_gdpr_policies') ? get_option('pd_lan_gdpr_policies') : esc_html('I agree with the website\'s GDPR policies.');
	$pd_lan_gdpr_load_map_lang = get_option('pd_lan_gdpr_load_map_lang') ? get_option('pd_lan_gdpr_load_map_lang') : esc_html('Please load the map');
	$enable_gdpr_policies = get_option('pd_enable_gdpr_policies') ? get_option('pd_enable_gdpr_policies') : '';

	$params = array(
	  'originLeft' 				=> $pd_enable_rtl,
	  'view_site_lan' 			=> $pd_lan_view_site,
	  'gdpr_policies'    		=> $pd_lan_gdpr_policies,
	  'gdpr_load_map_lang'    	=> $pd_lan_gdpr_load_map_lang,
	  'enable_gdpr_policies'    => $enable_gdpr_policies,
	);

	wp_localize_script( 'qcpnd-google-map-script', 'sbd_ajax_object', $params );
	
	wp_localize_script( 'qcpnd-custom-script', 'sbd_ajax_object', $params );
	
	
}


function qc_phone_directory_admin_css(){
	global $post_type;
	
	wp_register_style( 'qcpnd-custom-css', qcpnd_ASSETS_URL . '/css/admin-style.css');
	wp_enqueue_style( 'qcpnd-custom-css' );
	
	$css = '';
    if ($post_type == 'pnd') {
        $css .= "#edit-slug-box {display:none;}";
    }
    
    $css .= '.button.qcpnd-promo-link {
	  color: #ff0000;
	  font-weight: normal;
	  margin-left: 0;
	  margin-top: 1px;
	}
	.clear{ clear: both; }';
	
	$css .= ".wpb-form-active .wpb-goodbye-form-bg{background:rgba(0,0,0,.5);position:fixed;top:0;left:0;width:100%;height:100%}.wpb-goodbye-form-wrapper{position:relative;z-index:999;display:none}.wpb-form-active .wpb-goodbye-form-wrapper{display:block}.wpb-goodbye-form{display:none}.wpb-form-active .wpb-goodbye-form{position:fixed;max-width:400px;background:#fff;white-space:normal;z-index:99;top:50%;left:50%;transform:translate(-50%,-50%);border-radius:5px}.wpb-goodbye-form-head{background:#7a00aa;color:#fff;padding:8px 18px;text-align:center;border-radius:5px 5px 0 0}.wpb-goodbye-form-body{padding:8px 18px;color:#444}.deactivating-spinner{display:none}.deactivating-spinner .spinner{float:none;margin:4px 4px 0 18px;vertical-align:bottom;visibility:visible}.wpb-goodbye-form-footer{padding:8px 18px}";

	wp_add_inline_style( 'qcpnd-custom-css', $css );
	
	
	$mapapi = 'AIzaSyBACyZ4vA8pQybj9ZdZP-J5zQHqfQkqOXY';
	if(get_option('sbd_map_api_key')!=''){
		$mapapi = get_option('sbd_map_api_key');
	}
	
	$pd_map_open_street_map = get_option('pd_map_open_street_map') ? get_option('pd_map_open_street_map') : '';

	if($pd_map_open_street_map == 'on'){

		wp_enqueue_style( 'jq-openstreet-theme-css', 'https://unpkg.com/leaflet@1.3.1/dist/leaflet.css');
		wp_enqueue_script( 'qcpd-openstreet-sbd', 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.4.0/leaflet.js');

	}else{
		wp_enqueue_script( 'qcopd-google-map-script','https://maps.google.com/maps/api/js?key='.$mapapi.'&libraries=geometry,places', null, null, false );
	}
	
	
	wp_enqueue_style( 'jq-slick.css-css', qcpnd_ASSETS_URL . '/css/slick.css');
	wp_enqueue_style( 'jq-slick-theme-css', qcpnd_ASSETS_URL . '/css/slick-theme.css', array(), '1.0.1');
	wp_enqueue_script( 'jq-slick.min-js', qcpnd_ASSETS_URL . '/js/slick.min.js', array('jquery'));
	wp_register_script( 'sbd_custom_scrpt_admin', qcpnd_ASSETS_URL . '/js/qcpd-admin-common.js', array('jquery'));
	wp_enqueue_script( 'sbd_custom_scrpt_admin' );
	$customjs = "jQuery(document).ready(function($){
		$('.qc-up-pro-link').parent('a').on('click', function(e){
			e.preventDefault();
			var link = $(this).attr('href');
			window.open(link, '_blank');
		});
	});";

	$customjs .='var pd_map_open_street_map = "'.esc_attr($pd_map_open_street_map).'";';

	wp_add_inline_script( 'sbd_custom_scrpt_admin', ($customjs) );



}

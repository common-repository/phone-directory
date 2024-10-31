<?php

defined('ABSPATH') or die("You can't access this file directly.");

define('QCPND_TPL_DIR', qcpnd_DIR . "/templates");
define('OCPD_TPL_URL', qcpnd_URL . "templates");

/*Custom Item Sort Logic*/
function pcpnd_custom_sort_by_tpl_upvotes($a, $b) {
   // return $a['qcpnd_upvote_count'] * 1 < $b['qcpnd_upvote_count'] * 1;
	$aTime = isset($a['qcpnd_upvote_count']) && !empty( $a['qcpnd_upvote_count'] ) ? (int)$a['qcpnd_upvote_count'] : 0;
	$bTime = isset($b['qcpnd_upvote_count']) && !empty( $b['qcpnd_upvote_count'] ) ? (int)$b['qcpnd_upvote_count'] : 0;

	if( $aTime === $bTime ){
		return 0;
	}

	return $aTime < $bTime  ? 1 : -1;
}

function pcpnd_custom_sort_by_tpl_title($a, $b) {
    //return $a['qcpnd_item_title'] > $b['qcpnd_item_title'];
    return strnatcasecmp($a['qcpnd_item_title'], $b['qcpnd_item_title']);
}

//For all list elements
add_shortcode('qcpnd-directory', 'qcpnd_directory_full_shortcode');

function qcpnd_directory_full_shortcode( $atts = array() )
{
	ob_start();
    show_qcpnd_full_list( $atts );
    $content = ob_get_clean();
    return $content;
}

function show_qcpnd_full_list( $atts = array() )
{
	
	$template_code = "";

	//Defaults & Set Parameters
	extract( shortcode_atts(
		array(
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'mode' => 'all',
			'list_id' => '',
			'column' => '1',
			'style' => 'simple',
			'list_img' => 'true',
			'search' => 'true',
			'category' => "",
			'upvote' => "on",
			'item_count' => "on",
			'top_area' => "on",
			'item_orderby' => "",
			'item_order' => "",
			'mask_url' => "off",
			'enable_embedding' => 'false',
			'show_phone_icon'=>1,
			'show_link_icon'=>1,
			'main_click_action'=>1,
			'phone_number'=>1,
			'map'	=> 'hide',
			'showmaponly' => 'no'
		), $atts
	));

	//ShortCode Atts
	$shortcodeAtts = array(
		'orderby' => $orderby,
		'order' => $order,
		'mode' => $mode,
		'list_id' => $list_id,
		'column' => $column,
		'style' => $style,
		'list_img' => $list_img,
		'search' => $search,
		'category' => $category,
		'upvote' => $upvote,
		'item_count' => $item_count,
		'top_area' => $top_area,
		'item_orderby' => $item_orderby,
		'item_order' => $item_order,
		'mask_url' => $mask_url,
		'enable_embedding' => $enable_embedding,
		'show_phone_icon'=>$show_phone_icon,
		'show_link_icon'=>$show_link_icon,
		'showmaponly' => $showmaponly
	);

		wp_enqueue_style( 'qcpnd-custom-css' );
		wp_enqueue_style( 'qcpnd-custom-rwd-css' );
		wp_enqueue_style( 'qcpnd-fontawesome-rwd-css' );
		wp_enqueue_script( 'qcopd-google-map-script' );
	if( $showmaponly == 'no' ){
		wp_enqueue_script( 'qcpnd-grid-packery' );
		wp_enqueue_script( 'qcpnd-custom-script' );
	}

	$limit = -1;

	if( $mode == 'one' )
	{
		$limit = 1;	
	}

	//Query Parameters
	$list_args = array(
		'post_type' => 'pnd',
		'posts_per_page' => $limit,
	);
	if($orderby!='none' or $order!='none'){
		$list_args['orderby'] = $orderby;
		$list_args['order'] = $order;
	}

	if( $list_id != "" && $mode == 'one' )
	{
		$list_args = array_merge($list_args, array( 'p' => $list_id ));
	}
	
	if( $category != "" )
	{
		$taxArray = array(
			array(
				'taxonomy' => 'pnd_cat',
				'field'    => 'slug',
				'terms'    => $category
			),
		);
		
		$list_args = array_merge($list_args, array( 'tax_query' => $taxArray ));
		
	}

	// The Query
	$list_query = new WP_Query( $list_args );
	
    if ( isset($atts["style"]) && $atts["style"] )
        $template_code = $atts["style"];

    if (!$template_code)
        $template_code = "simple";

    if( $mode == 'one' ){
    	$column = '1';
    }
?>


<?php
	
	echo '<!--  Starting Simple Business Directory Plugin Output -->';
	if ( file_exists( QCPND_TPL_DIR . "/".$template_code."/template.php" ) ) {
		$tempath = QCPND_TPL_DIR . "/".$template_code."/template.php";
	}
	if($showmaponly=='yes'){
		if ( file_exists( QCPND_TPL_DIR ."/maponly/template.php" ) ) {
			$tempath = QCPND_TPL_DIR ."/maponly/template.php";
		}
	}
	if( isset($tempath) && !empty( $tempath ) ) {
	    require ( $tempath );
	}
	wp_reset_query();
}


function qcpnd_custom_script_styles(){
	if(get_option('pd_custom_style')!=''){
		wp_add_inline_style( 'qcpnd-custom-css', get_option('pd_custom_style') );
	}

	$customjs = get_option( 'pd_custom_js' );
	if(trim($customjs)!=''){
		wp_add_inline_script( 'qcpnd-custom-script', trim($customjs) );
	}
}
add_action('wp_footer', 'qcpnd_custom_script_styles');
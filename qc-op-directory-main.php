<?php
/**
 * Plugin Name: Simple Business Directory
 * Plugin URI: https://wordpress.org/plugins/phone-directory
 * Description: Business Directory plugin to create elegant yellow pages or white pages for local and international business listings with advanced local business directory options.
 * Version: 6.4.3
 * Author: Business Directory
 * @author    QuantumCloud
 * Author URI: https://www.quantumcloud.com/products/simple-business-directory/
 * Requires at least: 4.6
 * Tested up to: 6.6.2
 * Text Domain: qc-opd
 * Domain Path: /lang/
 * License: GPL2
 */


defined('ABSPATH') or die("No direct script access!");

//Custom Constants
define('qcpnd_URL', plugin_dir_url(__FILE__));
define('qcpnd_IMG_URL', qcpnd_URL . "assets/images");
define('qcpnd_ASSETS_URL', qcpnd_URL . "assets");

define('qcpnd_DIR', dirname(__FILE__));
define('qcpnd_INC_DIR', qcpnd_DIR . "/inc");

//Include files and scripts
require_once( 'qc-op-directory-post-type.php' );
require_once( 'qc-op-directory-assets.php' );
require_once( 'qc-op-directory-shortcodes.php' );
require_once( 'qc-opd-setting-options.php' );
require_once( 'embed/embedder.php' );
require_once( 'qcpnd-shortcode-generator.php' );
require_once('qc-support-promo-page/class-qc-support-promo-page.php');
require_once('qc-rating-feature/qc-rating-class.php');
require_once('class-qc-free-plugin-upgrade-notice.php');
require_once('qc-op-directory-import.php');


/*Add Promotional Link - Bue Pro - 12-30-2016*/
add_action( 'manage_posts_extra_tablenav', 'pcpnd_promo_link_in_cpt_table' );

function pcpnd_promo_link_in_cpt_table()
{
	$screen = get_current_screen();
	
	$current_screen = $screen->id;
	
	$link = "";
	
	if( $current_screen == 'edit-pnd' )
	{	
		//$link = '<div class="alignleft actions"><a href="https://www.quantumcloud.com/simple-link-directory/" target="_blank" class="button qcpnd-promo-link">Get More Features!</a></div>';
	}
	
	echo $link;
	
}

add_action( 'buypro_promotional_link', 'pcpnd_promo_link_in_settings_page' );

function pcpnd_promo_link_in_settings_page()
{
	$screen = get_current_screen();
	
	$current_screen = $screen->id;
	
	$link = "";
	
	//$link = '<div class="alignleft actions"><a href="https://www.quantumcloud.com/simple-link-directory/" target="_blank" class="button qcpnd-promo-link">Get More Features!</a></div>';
	
	echo $link;
	
}

/**
 * Submenu filter function. Tested with Wordpress 4.1.1
 * Sort and order submenu positions to match your custom order.
 *
 * @author Hendrik Schuster <contact@deviantdev.com>
 */
function qclpndf_order_index_catalog_menu_page( $menu_ord ) 
{

  global $submenu;

  // Enable the next line to see a specific menu and it's order positions
  // echo '<pre>'; print_r( $submenu['edit.php?post_type=pnd'] ); echo '</pre>'; exit();

  	$arr = array();

	if( current_user_can('edit_posts') ){ 

		if(isset($submenu['edit.php?post_type=pnd'][5]))
			$arr[] = $submenu['edit.php?post_type=pnd'][5];

		if(isset($submenu['edit.php?post_type=pnd'][10]))
			$arr[] = $submenu['edit.php?post_type=pnd'][10];

		if(isset($submenu['edit.php?post_type=pnd'][15]))
			$arr[] = $submenu['edit.php?post_type=pnd'][15];

		if(isset($submenu['edit.php?post_type=pnd'][16]))
			$arr[] = $submenu['edit.php?post_type=pnd'][16];

		if(isset($submenu['edit.php?post_type=pnd'][18]))
			$arr[] = $submenu['edit.php?post_type=pnd'][18];

		if(isset($submenu['edit.php?post_type=pnd'][17]))
			$arr[] = $submenu['edit.php?post_type=pnd'][17];

		if(isset($submenu['edit.php?post_type=pnd'][250]))
			$arr[] = $submenu['edit.php?post_type=pnd'][250];

		if(isset($submenu['edit.php?post_type=pnd'][300]))
			$arr[] = $submenu['edit.php?post_type=pnd'][300];
		
	}

  $submenu['edit.php?post_type=pnd'] = $arr;

  return $menu_ord;

}
// add the filter to wordpress
add_filter( 'custom_menu_order', 'qclpndf_order_index_catalog_menu_page' );

add_action( 'admin_menu' , 'qcpd_help_link_submenu', 20 );
function qcpd_help_link_submenu(){
	global $submenu;
	
	$link_text = "Help";
	$submenu["edit.php?post_type=pnd"][250] = array( $link_text, 'activate_plugins' , admin_url('edit.php?post_type=pnd&page=sbd_settings#help') );
	ksort($submenu["edit.php?post_type=pnd"]);
	
	return ($submenu);
}



function pd_show_api_notice(){
	global $my_admin_page;
    $screen = get_current_screen();

    $pd_map_open_street_map = get_option('pd_map_open_street_map') ? get_option('pd_map_open_street_map') : '';

    if ( is_admin() && $screen->post_type == 'pnd' && ($screen->base=='post' || $screen->base=='edit') && ($pd_map_open_street_map != 'on') ) {

        ?>
        <div class="notice notice-error is-dismissible"> 
			<p style="color:red"><strong><?php echo esc_html('Google map API key is not added. Google Map API key is required for map to work. Please set google map api key from'); ?> <a href="<?php echo admin_url('edit.php?post_type=pnd&page=sbd_settings') ?>"><?php echo esc_html('settings page'); ?></a>. </strong></p>
			<button type="button" class="notice-dismiss">
				<span class="screen-reader-text"><?php echo esc_html('Dismiss this notice.'); ?></span>
			</button>
        </div>
        <?php
    }
}



/*
* Google map api key notice
*/
add_action('init', 'pd_map_api_key_notice');
function pd_map_api_key_notice(){
	if(get_option('sbd_map_api_key')==''){
		add_action( 'admin_notices', 'pd_show_api_notice' );
	}
}


/*
* Tips section
*/
function pd_options_instructions_example() {
    global $my_admin_page;
    $screen = get_current_screen();
    
    if ( is_admin() && ($screen->post_type == 'pnd') ) {

        ?>
        <div class="notice notice-info is-dismissible pd-notice" style="display:none"> 
            <div class="pd_info_carousel">

                <div class="pd_info_item"><?php echo esc_html('**SBD Pro Tip: Did you know that you can'); ?> <strong style="color: yellow"><?php echo esc_html('Auto Generate Title, Subtitle, Thumbnail,'); ?></strong>  <?php echo esc_html('Latitude and Longitude with the Pro Version in Just 2 Clicks?'); ?> <strong style="color: yellow"><?php echo esc_html('Triple Your Business Entry Speed!'); ?></strong></div>
                
                <div class="pd_info_item"><?php echo esc_html('**SBD Tip: Lists are the base pillars of SBD, not individual businesses. Group your businesses into different Lists for the best performance.'); ?></div>
                
                <div class="pd_info_item"><?php echo esc_html('**SBD Tip: SBD looks the best when you create multiple Lists and use the Show All Lists mode.'); ?></div>

                <div class="pd_info_item"><?php echo esc_html('**SBD Pro Tip: Did you know that SBD Pro version lets you monetize your directory and earn'); ?> <strong style="color: yellow"><?php echo esc_html('passive income?'); ?></strong> <?php echo esc_html('Upgrade now!'); ?></div>
                
                <div class="pd_info_item"><?php echo esc_html('**SBD Tip: Try to keep the maximum number of businesses below 30 per list. Create multiple Lists as needed.'); ?></div>

                <div class="pd_info_item"><?php echo esc_html('**SBD Tip: Use the handy shortcode generator to make life easy. It is a small, blue [SBD] button found at the toolbar of any page\'s visual editor.'); ?></div>
                
                <div class="pd_info_item"><?php echo esc_html('**SBD Pro Tip: You can display your'); ?> <strong style="color: yellow"><?php echo esc_html('Lists by category'); ?> </strong><?php echo esc_html('with the SBD pro version.'); ?> <strong style="color: yellow"><?php echo esc_html('16+ Templates, Multi page mode'); ?></strong><?php echo esc_html(', Widgets are also available.'); ?></div>
                
                <div class="pd_info_item"><?php echo esc_html('**SBD Tip: You can create a page with a contact form and link the Add Business button to that page so people can submit links to your directory by email.'); ?></div>

                <div class="pd_info_item"><?php echo esc_html('**SBD Tip: If you are having problem with adding more businesses or saving a list then you may need to increase max_input_vars value in server. Check the help section for more details.'); ?></div>
                
                <div class="pd_info_item"><?php echo esc_html('**SBD Pro Tip: SBD pro version has'); ?> <strong style="color: yellow"><?php echo esc_html('front end dashboard'); ?></strong> <?php echo esc_html('for user registration and business management. As well as tags and instant search.'); ?> <strong style="color: yellow"><?php echo esc_html('Upgrade to the Pro version now!'); ?></strong></div>

            </div>

        </div>
        <?php
    }
}

add_action( 'admin_notices', 'pd_options_instructions_example' );

add_action( 'admin_menu' , 'qcsbd_help_link_submenu', 20 );
function qcsbd_help_link_submenu(){
	global $submenu;
	
	$link_text = esc_html("Help");
	$submenu["edit.php?post_type=pnd"][250] = array( $link_text, 'activate_plugins' , admin_url('edit.php?post_type=pnd&page=sbd_settings#help') );
	ksort($submenu["edit.php?post_type=pnd"]);
	
	return ($submenu);
}


add_action( 'add_meta_boxes', 'sbd_meta_box_video' );
function sbd_meta_box_video()
{					                  // --- Parameters: ---
    add_meta_box( 'qc-sbd-meta-box-id', // ID attribute of metabox
                  esc_html('Shortcode Generator for SBD'),       // Title of metabox visible to user
                  'sbd_meta_box_callback', // Function that prints box in wp-admin
                  'page',              // Show box for posts, pages, custom, etc.
                  'side',            // Where on the page to show the box
                  'high' );            // Priority of box in display order
}

function sbd_meta_box_callback( $post )
{
    ?>
    <p>
        <label for="sh_meta_box_bg_effect"><p><?php echo esc_html('Click the button below to generate shortcode'); ?></p></label>
		<input type="button" id="sbd_shortcode_generator_meta" class="button button-primary button-large" value="<?php echo esc_attr('Generate Shortcode'); ?>" />
    </p>
    
    <?php
}
add_action( 'plugins_loaded', 'sbd_plugin_loaded_fnc' );
function sbd_plugin_loaded_fnc(){

	if(!get_option('sbd_ot_convrt')){
		$prevOptions = get_option('option_tree');		
		if(!empty($prevOptions) && @array_key_exists('pd_enable_top_part', $prevOptions)){
			
			foreach($prevOptions as $key=>$val){
				
				update_option( $key, $val);
			}
		}		
		add_option( 'sbd_ot_convrt', 'yes');
	}

}

function sbd_activation_redirect( $plugin ) {

    $screen = get_current_screen();

    if( ( isset( $screen->base ) && $screen->base == 'plugins' ) && $plugin == plugin_basename( __FILE__ ) ) {
    //if( $plugin == plugin_basename( __FILE__ ) ) {
    	if( 'cli' !== php_sapi_name() ){
        	exit( wp_redirect( admin_url( 'edit.php?post_type=pnd&page=sbd_settings#help') ) );
    	}
    }
}
add_action( 'activated_plugin', 'sbd_activation_redirect' );

if( function_exists('register_block_type') ){
	function qcpd_sbd_gutenberg_block() {
	    require_once plugin_dir_path( __FILE__ ).'/gutenberg/sbd-block/plugin.php';
	}
	add_action( 'init', 'qcpd_sbd_gutenberg_block' );
}

// Remove view from custom post type.
add_filter( 'post_row_actions', 'qc_sbd_remove_row_actions', 10, 1 );
function qc_sbd_remove_row_actions( $actions )
{
	if( get_post_type() === 'pnd' ){
	 unset( $actions['view'] );
	}
	 
	return $actions;
}
// Remove view from taxonomies
add_filter( 'pnd_cat_row_actions', 'qc_sbd_category_remove_row_actions', 10, 1 );
function qc_sbd_category_remove_row_actions($actions){
	unset($actions['view']);
	return $actions;
}

if( is_admin() ){
    require_once('class-plugin-deactivate-feedback.php');
    $SBD_feedback = new SBD_Usage_Feedback( __FILE__, 'plugins@quantumcloud.com', false, true );
}

function sbd_remove_admin_menu_items() {
    if( !current_user_can( 'edit_posts' ) ):
        remove_menu_page( 'edit.php?post_type=pnd' );
    endif;
}
add_action( 'admin_menu', 'sbd_remove_admin_menu_items' );


add_action( 'admin_notices', 'qcpds_wp_pro_shortcode_notice',100 );

function qcpds_wp_pro_shortcode_notice(){

    global $pagenow, $typenow;

    if ( isset($typenow) && $typenow == 'pnd'  ) {
    ?>

	  	<div id="message-sbd" class="notice notice-info is-dismissible">
	        <?php
	            printf(
	                __('%s  %s  %s', 'dna88-wp-notice'),
	                '<a href="'.esc_url('https://www.quantumcloud.com/products/simple-business-directory/').'" target="_blank">',
	                '<img src="'.esc_url(qcpnd_ASSETS_URL).'/images/halloween-sbd1.jpg" >',
	                '</a>'
	            );

	        ?>
	    </div>

        <div id="message" class="notice notice-info is-dismissible">
            <p>
                <?php
                printf(
                    __('%s Simple Business Directory %s works the best when you create multiple Lists and show them all in a page. Use the following shortcode to display All lists on any page:  %s %s %s  Use the %s shortcode generator %s to select style and other options.', 'dna88-wp-notice'),
                    '<strong>',
                    '</strong>',
                    '<code>',
                    '[qcpnd-directory mode="all" style="simple" map="show"]',
                    '</code>',
                    '<strong>',
                    '</strong>'
                );
                ?>
            </p>
        </div>
        <?php 
        
    }

}
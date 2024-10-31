<?php

defined('ABSPATH') or die("You can't access this file directly.");

//Registering custom post for Team
function qcpnd_register_cpt_pnd() {
	
	$qc_list_labels = array(
		'name'               => _x( 'Manage List Items', 'qc-opd' ),
		'singular_name'      => _x( 'Manage List Item', 'qc-opd' ),
		'add_new'            => _x( 'New List', 'qc-opd' ),
		'add_new_item'       => __( 'Add New List Item' ),
		'edit_item'          => __( 'Edit List Item' ),
		'new_item'           => __( 'New List Item' ),
		'all_items'          => __( 'Manage List Items' ),
		'view_item'          => __( 'View List Item' ),
		'search_items'       => __( 'Search List Item' ),
		'not_found'          => __( 'No List Item found' ),
		'not_found_in_trash' => __( 'No List Item found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Simple Business Directory'
	);
	
	$qc_list_args = array(
		'labels'        		=> $qc_list_labels,
		'description'   		=> 'This post type holds all posts for your directory items.',
		'public'        		=> true,
		'publicly_queryable' 	=> false,
		'menu_position' 		=> 25,
		'exclude_from_search' 	=> true,
		'show_in_nav_menus' 	=> false,
		'supports'      		=> array( 'title' ),
		'has_archive'   		=> true,
		'menu_icon' 			=> qcpnd_IMG_URL . '/phonedirectory.png',
	);
	
	register_post_type( 'pnd', $qc_list_args );	
	
	//Register New Taxonomy for Our New Post Type
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'List Categories', 'List Categories', 'qc-opd' ),
		'singular_name'     => _x( 'Category', 'taxonomy singular name', 'qc-opd' ),
		'search_items'      => __( 'Search List Categories', 'qc-opd' ),
		'all_items'         => __( 'All List Categories', 'qc-opd' ),
		'parent_item'       => __( 'Parent List Categories', 'qc-opd' ),
		'parent_item_colon' => __( 'Parent List Category:', 'qc-opd' ),
		'edit_item'         => __( 'Edit List Category', 'qc-opd' ),
		'update_item'       => __( 'Update List Category', 'qc-opd' ),
		'add_new_item'      => __( 'Add New List Category', 'qc-opd' ),
		'new_item_name'     => __( 'New List Category Name', 'qc-opd' ),
		'menu_name'         => __( 'List Categories', 'qc-opd' )
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'pnd_cat' )
	);

	register_taxonomy( 'pnd_cat', array( 'pnd' ), $args );
	
}

add_action( 'init', 'qcpnd_register_cpt_pnd' );

//Require CMB Metabox
if ( ! class_exists( 'CMB_Meta_Box' ) )
{
	require_once qcpnd_INC_DIR . '/cmb/custom-meta-boxes.php';
}

//Metabox Fields
function cmb_qcpnd_dir_fields( array $meta_boxes ) {
	
	//Repeatable Fields
	$qcpnd_item_fields = array(
		array( 'id' => 'qcpnd_item_title',  'name' => 'Title', 'type' => 'text', 'cols' => 4, 'desc' => 'Title of the list item' ),
		array( 'id' => 'qcpnd_item_link',  'name' => 'Link', 'type' => 'text', 'cols' => 4, 'desc' => 'Ex: http://www.google.com' ),
		
		array( 'id' => 'qcpnd_item_phone',  'name' => 'Main Phone Number', 'type' => 'text', 'cols' => 4, 'desc' => 'EX: 202-555-0178' ),
		
		array( 'id' => 'qcpd_item_full_address',  'name' => 'Full Address (For  map)', 'type' => 'text', 'cols' => 4 ),
		array( 'id' => 'qcpd_item_latitude', 'desc'=>'', 'name' => 'Latitude', 'type' => 'text', 'cols' => 4 ),
		array( 'id' => 'qcpd_item_longitude', 'desc'=>'', 'name' => 'Longitude', 'type' => 'text', 'cols' => 4 ),
		
		array( 'id' => 'qcpnd_item_img', 'name' => 'Image', 'type' => 'image', 'repeatable' => false, 'show_size' => false, 'cols' => 3, 'desc' => 'Preferred Size: 100X100px'  ),
		
		//array( 'id' => 'qcpnd_item_gotoweb',  'name' => 'Go to Website', 'type' => 'checkbox', 'cols' => 3, 'default' => 0 ),
		array( 'id' => 'qcpnd_open_new_window',  'name' => 'Open in new window', 'type' => 'checkbox', 'cols' => 3, 'default' => 0 ),
		//array( 'id' => 'show_phone_number',  'name' => 'Show Phone Number', 'type' => 'checkbox', 'cols' => 2, 'default' => 0 ),
		array( 'id' => 'qcpnd_item_description',  'name' => 'Description', 'type' => 'text', 'cols' => 9 ),
		array( 'id' => 'qcpnd_item_subtitle',  'name' => 'Location', 'type' => 'text', 'cols' => 9 )
		
		
	);

	$meta_boxes[] = array(
		'title' 	=> __('List Elements'),
		'pages' 	=> 'pnd',
		'fields' 	=> array(
			array(
				'id' 			=> 'qcpnd_list_item01',
				'name' 			=> __('Create List Elements'),
				'type' 			=> 'group',
				'repeatable' 	=> true,
				'sortable' 		=> true,
				'fields' 		=> $qcpnd_item_fields,
				'desc' 			=> __('Please add your list items here.'). '<br><br><i style="color:indianred;font-size:15px !important">'.esc_html('If you are unable to save a long List, please increase the value of max_input_vars to 15000 on your server.').'</i>'
			)
		)
	);

	return $meta_boxes;

}

add_filter( 'cmb_meta_boxes', 'cmb_qcpnd_dir_fields' );

//Custom Columns for Directory Listing
function qcpnd_list_columns_head($defaults) {

    $new_columns['cb'] = '<input type="checkbox" />';
    $new_columns['title'] = __('Title');

    $new_columns['qcpnd_item_count'] = __('Number of Elements');
    $new_columns['shortcode_col'] = __('Shortcode');

    $new_columns['date'] = __('Date');

    return $new_columns;
}
 
//Custom Columns Data for Backend Listing
function qcpnd_list_columns_content($column_name, $post_ID) {
    

    if ($column_name == 'qcpnd_item_count') {
        echo count(get_post_meta( $post_ID, 'qcpnd_list_item01' ));
    }

    if ($column_name == 'shortcode_col') {
    	echo '<p>'.esc_html("Single List Shortcode: ");
        echo '[qcpnd-directory mode="one" style="simple" list_id="'.$post_ID.'" map="show"]';
    	echo '</p>';
    	echo '<p>'.esc_html("All Lists Shortcode: ");
        echo '[qcpnd-directory mode="all" style="simple" map="show"]';
    	echo '</p>';
    }
}

add_filter('manage_pnd_posts_columns', 'qcpnd_list_columns_head');
add_action('manage_pnd_posts_custom_column', 'qcpnd_list_columns_content', 10, 2);



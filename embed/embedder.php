<?php


$embed_link_button = 1;

/*Load Embed Scripts*/
add_action('wp_enqueue_scripts', 'qcpnd_load_embed_scripts');

function qcpnd_load_embed_scripts()
{
	
	wp_enqueue_style('qcpnd-embed-form-css', qcpnd_URL . 'embed/css/embed-form.css');

    wp_enqueue_script('qcpnd-embed-form-script', qcpnd_URL . 'embed/js/embed-form.js', array('jquery'));

}


// Load template for embed link page url
function qcpnd_load_embed_link_template($template)
{
    if (is_page('embed-link')) {
        return dirname(__FILE__) . '/qcpnd-embed-link.php';
    }
    return $template;
}

add_filter('template_include', 'qcpnd_load_embed_link_template', 99);


// Create embed page when plugin install or activate

//register_activation_hook(__FILE__, 'qcpnd_create_embed_page');
add_action('init', 'qcpnd_create_embed_page');

function qcpnd_create_embed_page()
{

    $query = new WP_Query(
        array(
            'post_type'              => 'page',
            'title'                  => 'Embed Link',
            'post_status'            => 'all',
            'posts_per_page'         => 1,
            'no_found_rows'          => true,
            'ignore_sticky_posts'    => true,
            'update_post_term_cache' => false,
            'update_post_meta_cache' => false,
            'orderby'                => 'post_date ID',
            'order'                  => 'ASC',
        )
    );
     
    $page_got_by_title = ! empty( $query->post ) ? $query->post : null;

    if ( $page_got_by_title == NULL && FALSE === get_post_status( get_option('pdhclpage') )) {
        //post status and options
        $post = array(
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_author' => get_current_user_id(),
            'post_date' => date('Y-m-d H:i:s'),
            'post_status' => 'publish',
            'post_title' => 'Embed List',
            'post_type' => 'page',
        );
        //insert page and save the id
        $embedPost = wp_insert_post($post, false);
        //save the id in the database
        update_option('pdhclpage', $embedPost);
    }
}

if ($embed_link_button == 1) {
    add_action('qcpnd_attach_embed_btn', 'pcpnd_custom_embedder');
}

function pcpnd_custom_embedder($shortcodeAtts)
{
    global $post;

    $pagename = $post->post_name;

    if ($pagename != 'embed-link') {
	
        ?>
<div class="pd_share_container" style="text-align: right;border-bottom: 1px solid #ddd;padding-bottom: 10px;margin-bottom: 10px;">

<?php if(get_option( 'pd_add_new_button' )=='on' && get_option( 'pd_add_item_link' )!=''): ?>
<a style="" href="<?php echo esc_url(get_option( 'pd_add_item_link' )); ?>" class="button-link button-link-pd">
<?php 
	if(get_option('pd_lan_add_link')!=''){
		echo esc_html(get_option('pd_lan_add_link'));
	}else{
		esc_html_e( 'Add Business', 'qc-pd' ); 
	}
?>
</a>
<?php endif; ?>
<?php if($shortcodeAtts['enable_embedding'] == 'true'): ?>
<a class="button-link-pd js-open-modal" href="#" data-modal-id="popup"
           data-url="<?php bloginfo('url'); ?>/embed-link"
           data-order="<?php echo $shortcodeAtts['order']; ?>"
           data-mode="<?php echo $shortcodeAtts['mode']; ?>"
           data-list-id="<?php echo $shortcodeAtts['list_id']; ?>"
           data-column="<?php echo $shortcodeAtts['column']; ?>"
           data-style="<?php echo $shortcodeAtts['style']; ?>"
           data-category="<?php echo $shortcodeAtts['category']; ?>"> 
			<?php 
				if(get_option('pd_lan_share_list')!=''){
					echo esc_html(get_option('pd_lan_share_list'));
				}else{
					echo esc_html__('Share List', 'qc-opd') ;
				}
			?>
		   <i class="fa fa-share-alt"></i>  </a>
<?php endif; ?>

<?php
	add_action( 'wp_footer', 'pd_share_modal_1' );
?>
</div>


<?php 
if(!function_exists('pd_share_modal_1')){
function pd_share_modal_1(){
?>
<div id="popup" class="modal-box">
  <header> <a href="#" class="js-modal-close close">×</a>
    <h3><?php esc_html_e('Generate Embed Code For This List'); ?></h3>
  </header>
  <div class="modal-body">
    <div class="iframe-css">
      <div class="iframe-main">
        <div class="ifram-row">
          <div class="ifram-sm">
			<span><?php esc_html_e("Width: (in '%' or 'px')"); ?></span>
			<input id="igwidth" name="igwidth" type="text" value="100">
		</div>
		<div class="ifram-sm" style="width: 70px;">
			<span>&nbsp;</span>
			<select name="igsizetype" class="iframe-main-select">
				<option value="%">%</option>
				<option value="px"><?php esc_html_e("px"); ?></option>
			</select>
		</div>
		<div class="ifram-sm">
			<span><?php esc_html_e("Height: (in 'px')"); ?></span>
			<input id="igheight" name="igheight" type="text" value="400">
		</div>
          <div class="ifram-sm"> <span>&nbsp;</span> <a class="btn icon icon-code" id="generate-igcode" onclick=""><?php esc_html_e('Generate & Copy'); ?></a>
            </select>
          </div>
        </div>
        <div class="ifram-row">
          <div class="ifram-lg"> <span class="pcpnd-span-label"><?php esc_html_e('Generated Code'); ?></span> <br>
            <textarea id="igcode_textarea" class="igcode_textarea" name="igcode" style="width:100%; height:120px;" readonly="readonly"></textarea>
            <p class="guideline"><?php esc_html_e('Hit "Generate & Copy" button to generate embed code. It will be copied
              to your Clipboard. You can now paste this embed code inside your website\'s HTML where
              you want to show the List.'); ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
	<?php }}
}

<?php

global $wpdb;

wp_enqueue_style( 'qcpnd-simeple-style', OCPD_TPL_URL . "/$template_code/template.css");

// The Loop
if ( $list_query->have_posts() ) 
{
	
	
	if(get_option('pd_enable_top_part')=='on') :
		
	 do_action('qcpnd_attach_embed_btn', $shortcodeAtts);
	
	endif;

	//Directory Wrap or Container

	if($map=='show'){
		echo '<div id="sbd_all_location" style="width:100%;height:450px;overflow:hidden;display:block;margin-bottom:20px;"></div>';
	}

	$pd_enable_rtl = ( get_option('pd_enable_rtl') == 'on' ) ? 'dir="rtl"':'';
	
	echo '<div class="qcpnd-list-wrapper" '.$pd_enable_rtl.'>
	<div id="opd-list-holder" class="qc-grid qcpnd-list-holder">';

	$listId = 1;

	while ( $list_query->have_posts() ) 
	{
		$list_query->the_post();

		//$lists = get_post_meta( get_the_ID(), 'qcpnd_list_item01' );
		$lists = array();
		//$results = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE post_id = ".get_the_ID()." AND meta_key = 'qcpnd_list_item01'");
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->postmeta WHERE post_id = %d AND meta_key = 'qcpnd_list_item01'", get_the_ID() ) );
		if(!empty($results)){
			foreach($results as $result){
				$unserialize = unserialize($result->meta_value);
				$lists[] = $unserialize;
			}
		}

		$conf = get_post_meta( get_the_ID(), 'qcpnd_list_conf', true );

		?>

		<?php if( $style == "simple" ): ?>

		<!-- Individual List Item -->
		<div id="list-item-<?php echo esc_attr($listId) .'-'. esc_attr(get_the_ID()); ?>" class="qc-grid-item qcpnd-list-column opd-column-<?php echo esc_attr($column); echo " " . esc_attr($style);?> <?php echo "opd-list-id-" . esc_attr(get_the_ID()); ?>">
			<div class="qcpnd-single-list">
				
				<h3>
					<?php echo esc_html(get_the_title()); ?>
				</h3>
				<ul>
					<?php 
						
						if( $item_orderby == 'upvotes' )
						{
    						usort($lists, "pcpnd_custom_sort_by_tpl_upvotes");
						}

						if( $item_orderby == 'title' )
						{
    						usort($lists, "pcpnd_custom_sort_by_tpl_title");
						}

						$count = 1;
						foreach( $lists as $list ) : 
						
						$list['qcpnd_item_gotoweb'] = $main_click_action;
						$list['show_phone_number'] = $phone_number;
						
						
						$latlon = '';
						if(isset($list['qcpd_item_latitude']) && $list['qcpd_item_latitude']!='' && isset($list['qcpd_item_longitude']) && $list['qcpd_item_longitude']!=''){
							$latlon = $list['qcpd_item_latitude'].','.$list['qcpd_item_longitude'];
						}
						
					?>

					<li id="item-<?php echo esc_attr(get_the_ID()) ."-". esc_attr($count); ?>" data-latlon="<?php echo esc_html($latlon); ?>" data-title="<?php echo esc_html($list['qcpnd_item_title']); ?>" data-phone="<?php echo esc_html($list['qcpnd_item_phone']); ?>" data-address="<?php echo esc_html($list['qcpd_item_full_address']); ?>" data-url="<?php echo esc_url($list['qcpnd_item_link']); ?>">
						<?php 
							$item_url = esc_url($list['qcpnd_item_link']);
							$masked_url = esc_url($list['qcpnd_item_link']);
						?>
						<!-- List Anchor -->
						<a <?php if( $mask_url == 'on') { echo 'onclick="document.location.href = \''.$item_url.'\'; return false;"'; } ?>
							<?php echo (isset($list['qcpnd_item_gotoweb']) && $list['qcpnd_item_gotoweb'] == 1) ? 'href="'.esc_url($masked_url).'" target="_blank"' : ''; ?> <?php echo (isset($list['qcpnd_item_gotoweb']) && $list['qcpnd_item_gotoweb'] == 0) ? 'href="tel:'.preg_replace("/[^0-9]/", "",$list['qcpnd_item_phone']).'"' : ''; ?> >

							<!-- Image, If Present -->
							<?php if( ($list_img == "true") && isset($list['qcpnd_item_img'])  && $list['qcpnd_item_img'] != "" ) : ?>
								<span class="list-img">
									<?php 
										$img = wp_get_attachment_image_src($list['qcpnd_item_img']);
									?>
									<img src="<?php echo ( isset( $img[0] ) ? esc_url($img[0]) : '' ); ?>" alt="">
								</span>
							<?php else : ?>
								<span class="list-img">
									<img src="<?php echo esc_url( qcpnd_IMG_URL ); ?>/list-image-placeholder.png" alt="">
								</span>
							<?php endif; ?>
							
								
							
							<div style="display:inline-block;width: 80%;<?php echo (!isset($list['show_phone_number'])|| $list['show_phone_number']==0)?'position: relative;top: -5px;':'' ?>">
							<!-- Link Text -->
							<?php echo esc_html($list['qcpnd_item_title']); ?>
							<?php 
								if(isset($list['qcpnd_item_description']) and $list['qcpnd_item_description']!=''){
									echo '<span style="display:block;font-size:11px">'.esc_html($list['qcpnd_item_description']).'</span>';
								}
							?>
							<?php if(isset($list['qcpnd_item_phone'])&&$list['qcpnd_item_phone']!='' && isset($list['show_phone_number']) && $list['show_phone_number']==1){
							
								echo '<span style="display:block;font-size:11px"> <i class="fa fa-phone"></i> '.str_replace(array('(',')'),array('',''),esc_html($list['qcpnd_item_phone']));
								if(isset($list['qcpnd_item_subtitle']) and $list['qcpnd_item_subtitle']!=''){
									echo ' - <i class="fa fa-location-arrow"></i> '.esc_html($list['qcpnd_item_subtitle']).'';
								}
								echo '</span>';
								
							} ?>
							
							
							</div>
							
							<div class="pd-bottom-area">
						
								<?php if( $show_phone_icon == '1' and isset($list['qcpnd_item_phone']) and $list['qcpnd_item_phone']!='' ) : ?>
									<p><a style="" href="tel:<?php echo preg_replace("/[^0-9]/", "",@$list['qcpnd_item_phone']); ?>">
								 <i class="fa fa-phone"></i>
							   </a></p>
								<?php endif; ?>
								<?php if( $masked_url != '' && $show_link_icon==1 ) : ?>
								<p><a style="" href="<?php echo $masked_url; ?>" <?php echo (isset($list['qcpnd_open_new_window']) && $list['qcpnd_open_new_window'] == 1) ? 'target="_blank"' : ''; ?>>
									 <i class="fa fa-link"></i>
								</a></p>
								<?php endif; ?>
								
								
							
							</div>
							
						</a>

					</li>
					<?php $count++; endforeach; ?>
				</ul>

			</div>

		</div>
		<!-- /Individual List Item -->

		<?php endif; ?>

		<?php

		$listId++;
	}

	echo '<div class="clearfix"></div>
			</div>
		<div class="clearfix"></div>
	</div>';

}

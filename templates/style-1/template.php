<?php
global $wpdb;
wp_enqueue_style( 'qcpnd-style-1', OCPD_TPL_URL . "/$template_code/template.css");

$pd_enable_rtl = ( get_option('pd_enable_rtl') == 'on' ) ? 'on':'';

if($pd_enable_rtl =='on'){
	$css = '.qcpnd-list-wrapper .style-1 .ca-content {text-align: right;}';
	wp_add_inline_style( 'qcpnd-style-1', $css );

}
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

	echo '<div class="qcpnd-list-wrapper" '.$pd_enable_rtl.'><div id="opd-list-holder" class="qc-grid qcpnd-list-holder">';

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

		if( $item_orderby == 'upvotes' )
		{
			usort($lists, "pcpnd_custom_sort_by_tpl_upvotes");
		}

		if( $item_orderby == 'title' )
		{
			usort($lists, "pcpnd_custom_sort_by_tpl_title");
		}

		?>

		<?php if( $style == "style-1" ) : ?>

		<div id="qcpnd-list-<?php echo esc_attr($listId) .'-'. esc_attr(get_the_ID()); ?>" class="qc-grid-item qcpnd-list-column opd-column-<?php echo esc_attr($column); echo " " . $style;?> <?php echo "opd-list-id-" . esc_attr(get_the_ID()); ?>">

			<div class="qcpnd-single-list-1">
				
				<h3>
					<?php echo esc_html(get_the_title()); ?>
				</h3>
				<ul class="ca-menu">
					<?php $count = 1; ?>
					<?php foreach( $lists as $list ) : 
					
					$list['qcpnd_item_gotoweb'] = $main_click_action;
					$list['show_phone_number'] = $phone_number;
					?>
					<?php 
						$canContentClass = "subtitle-present";

						if( !isset($list['qcpnd_item_subtitle']) || $list['qcpnd_item_subtitle'] == "" )
						{
							$canContentClass = "subtitle-absent";
						}
						$latlon = '';
						if(isset($list['qcpd_item_latitude']) && $list['qcpd_item_latitude']!='' && isset($list['qcpd_item_longitude']) && $list['qcpd_item_longitude']!=''){
							$latlon = esc_html($list['qcpd_item_latitude'].','.$list['qcpd_item_longitude']);
						}
					?>

					<li id="item-<?php echo esc_attr(get_the_ID()) ."-". esc_attr($count); ?>" data-latlon="<?php echo esc_attr($latlon); ?>" data-title="<?php echo esc_html($list['qcpnd_item_title']); ?>" data-phone="<?php echo esc_html($list['qcpnd_item_phone']); ?>" data-address="<?php echo esc_html($list['qcpd_item_full_address']); ?>" data-url="<?php echo esc_url($list['qcpnd_item_link']); ?>">
						<?php 
							$item_url = esc_url($list['qcpnd_item_link']);
							$masked_url = esc_url($list['qcpnd_item_link']);
						?>
						<!-- List Anchor -->
						<a <?php echo (isset($list['qcpnd_item_gotoweb']) && $list['qcpnd_item_gotoweb'] == 1) ? 'href="'.esc_url($masked_url).'" target="_blank"' : ''; ?> <?php echo (isset($list['qcpnd_item_gotoweb']) && $list['qcpnd_item_gotoweb'] == 0) ? 'href="tel:'.preg_replace("/[^0-9]/", "",$list['qcpnd_item_phone']).'"' : ''; ?> >

							<!-- Image, If Present -->
							<?php if( ($list_img == "true") && isset($list['qcpnd_item_img'])  && $list['qcpnd_item_img'] != "" ) : ?>
								<span class="ca-icon list-img list-img-1">
									<?php 
										$img = wp_get_attachment_image_src($list['qcpnd_item_img']);
									?>
									<img src="<?php echo ( isset( $img[0] ) ? esc_url($img[0]) : '' ); ?>" alt="">
								</span>
							<?php else : ?>
								<span class="ca-icon list-img list-img-1">
									<img src="<?php echo esc_url( qcpnd_IMG_URL ); ?>/list-image-placeholder.png" alt="">
								</span>
							<?php endif; ?>

							<!-- Link Text -->
							<div class="ca-content">
                                <h2 class="ca-main <?php echo $canContentClass; ?>">
								<?php 
									echo esc_html(trim($list['qcpnd_item_title'])); 
								?>
                                </h2>
                                <?php if( isset($list['qcpnd_item_subtitle']) ) : ?>
	                                <h3 class="ca-sub">
									
								<?php 
								if(isset($list['qcpnd_item_description']) and $list['qcpnd_item_description']!=''){
									echo ' <span style="display:block"> '.esc_html($list['qcpnd_item_description']).'</span>';
								}
								
								if(isset($list['qcpnd_item_phone'])&&$list['qcpnd_item_phone']!='' && isset($list['show_phone_number']) && $list['show_phone_number']==1){
									echo '<i class="fa fa-phone"></i> '.str_replace(array('(',')'),array('',''),esc_html($list['qcpnd_item_phone'])).'';
								}
								
								if(isset($list['qcpnd_item_subtitle']) and $list['qcpnd_item_subtitle']!=''){
									echo ' <span style="margin-left: 10px;"> <i class="fa fa-location-arrow"></i> '.esc_html($list['qcpnd_item_subtitle']).'</span>';
								}
								
								
									
								
								
								 ?>
	                                </h3>
	                            <?php endif; ?>
                            </div>
							
						</a>
						
						<div class="pd-bottom-area">
							<?php if( $show_phone_icon == '1' ) : ?>
							   <p><a class="style1_phone_icon" href="tel:<?php echo preg_replace("/[^0-9]/", "",@esc_html($list['qcpnd_item_phone'])); ?>">
								 <i class="fa fa-phone"></i>
							   </a></p>
							<?php endif; ?>
							
							<?php if( $masked_url != '' && $show_link_icon==1 ) : ?>
							   <p><a class="style1_link_icon" href="<?php echo esc_url($masked_url); ?>" <?php echo (isset($list['qcpnd_open_new_window']) && $list['qcpnd_open_new_window'] == 1) ? 'target="_blank"' : ''; ?>>
								 <i class="fa fa-link"></i>
							   </a></p>
							<?php endif; ?>
						</div>
							
					</li>
					<?php $count++; endforeach; ?>
				</ul>

			</div>
		</div>

		<?php endif; ?>

		<?php

		$listId++;
	}

	echo '<div class="clearfix"></div>
			</div>
		<div class="clearfix"></div>
	</div>';

}

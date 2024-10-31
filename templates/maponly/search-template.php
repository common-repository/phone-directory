<div class="pd-top-area <?php echo $borderClass; ?>">

	<?php if( $searchSettings == 'on' ) : ?>
        <div class="pd-half">
            <form id="live-search" action="" class="styled" method="post">
				<?php 
					
					if(pd_ot_get_option('sbd_lan_live_search')!=''){
						$srcplaceholder = pd_ot_get_option('sbd_lan_live_search');
					}else{
						$srcplaceholder = __('Live Search Items', 'qc-pd');
					}
				?>
                <input type="text" class="text-input pd-maponly-search pd_maponly_search_filter" placeholder="<?php echo $srcplaceholder; ?>"/>
            </form>
        </div>
	<?php endif; ?>



    <div class="pd-half pd-add">
		
		<?php if(pd_ot_get_option('sbd_enable_claim_listing')=='on' and pd_ot_get_option('sbd_show_claim_listing_button')=='on'): 
		$claim_page = qc_sbd_login_page()->pdcustom_login_get_translated_option_page('sbd_claim_url');
		if($claim_page==''){
			$claim_page = qc_sbd_login_page()->pdcustom_login_get_translated_option_page('sbd_dashboard_url').'?action=claim';
		}
		if(is_user_logged_in()){
			$claim_page = qc_sbd_login_page()->pdcustom_login_get_translated_option_page('sbd_dashboard_url').'?action=claim';
		}
	?>

		<a href="<?php echo $claim_page; ?>" class="pd-add-btn">
			<?php 
				if(pd_ot_get_option('sbd_lan_claim_listing')!=''){
					echo pd_ot_get_option('sbd_lan_claim_listing');
				}else{
					esc_html_e( 'Claim Listing', 'qc-pd' ); 
				}
			?>
		</a>

	<?php endif; ?>
		
		
		<?php if(pd_ot_get_option('pd_enable_add_new_item')=='on' || pd_ot_get_option('pd_add_new_behave')=='on'): ?>
		<?php if(pd_ot_get_option('pd_enable_add_new_item')=='on'): ?>
		
			<?php if(pd_ot_get_option('pd_enable_add_new')!='off'): ?>
				<?php if(is_user_logged_in()): ?>
					<a style="" href="<?php echo qc_sbd_login_page()->pdcustom_login_get_translated_option_page('sbd_dashboard_url'); ?>" class="pd-add-btn">

				<?php else: ?>
					<a href="<?php echo qc_sbd_login_page()->pdcustom_login_get_translated_option_page('sbd_login_url'); ?>" class="pd-add-btn">

				<?php endif; ?>
			<?php endif; ?>

		<?php elseif(pd_ot_get_option('pd_add_new_behave')=='on'): ?>
                <a href="<?php echo $itemAddLink; ?>" class="pd-add-btn">
		<?php endif; ?>
				<?php if(pd_ot_get_option('pd_enable_add_new_item')=='on' && pd_ot_get_option('pd_enable_add_new')!='off'): ?>
					<?php 
						
						if(pd_ot_get_option('sbd_lan_add_link')!=''){
							echo pd_ot_get_option('sbd_lan_add_link');
						}else{
							esc_html_e( 'Add Listing', 'qc-pd' ); 
						}
					
					?>
                    <i class="fa fa-plus"></i>
                </a>
				<?php endif; ?>
				<?php if(pd_ot_get_option('pd_enable_add_new_item')=='off' && pd_ot_get_option('pd_add_new_behave')!='off'): ?>
					<?php 
						
						if(pd_ot_get_option('sbd_lan_add_link')!=''){
							echo pd_ot_get_option('sbd_lan_add_link');
						}else{
							esc_html_e( 'Add Listing', 'qc-pd' ); 
						}
					
					?>
                    <i class="fa fa-plus"></i>
				<?php endif; ?>

		<?php endif; ?>
		

				<?php

				//Hook - Before Search Template
				if($enable_embedding=='true'){
					do_action( 'qcpd_after_add_btn', $shortcodeAtts);
				}
					

				?>

    </div>



</div>

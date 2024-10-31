<?php

$args = array(
	'numberposts' => -1,
	'post_type'   => 'pd',
	'orderby'     => $filterorderby,
	'order'       => $filterorder
);

if( !empty($category) )
{
	$taxArray = array(
		array(
			'taxonomy' => 'pd_cat',
			'field'    => 'slug',
			'terms'    => $category
		)
	);

	$args = array_merge($args, array( 'tax_query' => $taxArray ));

}

$listItems = get_posts( $args );

$filterType = pd_ot_get_option( 'pd_filter_ptype' ); //normal, carousel
if($cattabid!=''){
	$filterType = 'normal';
}
//If FILTER TYPE is NORMAL

if( $filterType == 'normal' ) :

	?>

    <div class="sbd-maponly-filter-area">

					<?php 
						$item_count_disp_all = 0;
						foreach ($listItems as $item){
							if( $item_count == "on" ){
								@$item_count_disp_all += @count(get_post_meta( $item->ID, 'qcpd_list_item01' ));
							}
						}
					?>
					<a href="#" class="filter-btn" data-filter="all">
						<?php 
							if(pd_ot_get_option('sbd_lan_show_all')!=''){
								echo pd_ot_get_option('sbd_lan_show_all');
							}else{
								_e('Show All', 'qc-pd'); 
							}
						?>
						<?php
							if($item_count == 'on' and $infinityscroll!=1){
								echo '<span class="opd-item-count-fil">('.$item_count_disp_all.')</span>';
							}
						?>
					</a>

		<?php foreach ($listItems as $item) :
			$config = get_post_meta( $item->ID, 'qcpd_list_conf' );
			$filter_background_color = '';
			$filter_text_color = '';
			if(isset($config[0]['filter_background_color']) and $config[0]['filter_background_color']!=''){
				$filter_background_color = $config[0]['filter_background_color'];
			}
			if(isset($config[0]['filter_text_color']) and $config[0]['filter_text_color']!=''){
				$filter_text_color = $config[0]['filter_text_color'];
			}
			?>

			<?php
			$item_count_disp = "";

			if( $item_count == "on" ){
				$item_count_disp = count(get_post_meta( $item->ID, 'qcpd_list_item01' ));
			}
			?>

            <a href="#" class="filter-btn" data-filter="opd-list-id-<?php echo $item->ID; ?>" style="background:<?php echo $filter_background_color ?>;color:<?php echo $filter_text_color ?>">
				<?php echo $item->post_title; ?>
				<?php
				if($item_count == 'on'){
					echo '<span class="opd-item-count-fil">('.$item_count_disp.')</span>';
				}
				?>
            </a>

		<?php endforeach; ?>

    </div>

<?php endif; ?>

<?php
//If FILTER TYPE is CAROUSEL

if( $filterType == 'carousel' ) :
	?>

    <style>
        .sbd-maponly-filter-area {

            position: relative;
        }

        .slick-prev::before, .slick-next::before {
            color: #489fdf;
        }

        .slick-prev, .slick-next {
            transform: translate(0px, -80%);
        }
    </style>
    <div class="sbd-filter-area-main">
        <div class="sbd-maponly-filter-area" style="width: 100%;">

            <div class="filter-carousel">
                <div class="item">
					<?php 
						$item_count_disp_all = 0;
						foreach ($listItems as $item){
							if( $item_count == "on" ){
								@$item_count_disp_all += @count(get_post_meta( $item->ID, 'qcpd_list_item01' ));
							}
						}
					?>
					<a href="#" class="filter-btn" data-filter="all">
						<?php 
							if(pd_ot_get_option('sbd_lan_show_all')!=''){
								echo pd_ot_get_option('sbd_lan_show_all');
							}else{
								_e('Show All', 'qc-pd'); 
							}
						?>
						<?php
							if($item_count == 'on'){
								echo '<span class="opd-item-count-fil">('.$item_count_disp_all.')</span>';
							}
						?>
					</a>
                </div>

				<?php foreach ($listItems as $item) :
					$config = get_post_meta( $item->ID, 'qcpd_list_conf' );
					$filter_background_color = '';
					$filter_text_color = '';
					if(isset($config[0]['filter_background_color']) and $config[0]['filter_background_color']!=''){
						$filter_background_color = $config[0]['filter_background_color'];
					}
					if(isset($config[0]['filter_text_color']) and $config[0]['filter_text_color']!=''){
						$filter_text_color = $config[0]['filter_text_color'];
					}
					?>

					<?php
					$item_count_disp = "";

					if( $item_count == "on" ){
						$item_count_disp = count(get_post_meta( $item->ID, 'qcpd_list_item01' ));
					}
					?>

                    <div class="item">
                        <a href="#" class="filter-btn" data-filter="opd-list-id-<?php echo $item->ID; ?>" style="background:<?php echo $filter_background_color ?>;color:<?php echo $filter_text_color ?>">
							<?php echo $item->post_title; ?>
							<?php
							if($item_count == 'on'){
								echo '<span class="opd-item-count-fil">('.$item_count_disp.')</span>';
							}
							?>
                        </a>
                    </div>

				<?php endforeach; ?>

            </div>

            <script>
                jQuery(document).ready(function($){

                    var fullwidth = window.innerWidth;
                    if(fullwidth < 479){
                        $('.filter-carousel').not('.slick-initialized').slick({


                            infinite: false,
                            speed: 500,
                            slidesToShow: 1,


                        });
                    }else{
                        $('.filter-carousel').not('.slick-initialized').slick({

                            dots: false,
                            infinite: false,
                            speed: 500,
                            slidesToShow: 1,
                            centerMode: false,
                            variableWidth: true,
                            slidesToScroll: 3,

                        });
                    }

                });
            </script>

        </div>
    </div>

<?php endif; ?>
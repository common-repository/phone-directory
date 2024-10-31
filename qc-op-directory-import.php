<?php

defined('ABSPATH') or die("You can't access this file directly.");

class qcpnd_BulkImportFree
{

    function __construct()
    {
        add_action('admin_menu', array($this, 'qcpnd_info_menu'));
    }

    public $post_id;

    function qcpnd_info_menu()
    {
        add_submenu_page(
            'edit.php?post_type=pnd',
            'Bulk Import',
            'Import',
            'manage_options',
            'qcpnd_bimport_page',
            array(
                $this,
                'qcpnd_bimport_page_content'
            )
        );
    }

    function qcpnd_bimport_page_content()
    {
        ?>
        <div class="wrap">

            <div id="poststuff">

                <div id="post-body" class="metabox-holder columns-3">

                    <div id="post-body-content" style="position: relative;">

                        <u>
                            <h1><?php esc_html_e('Bulk Import'); ?></h1>
                        </u>

                        <div style="display:none">
                            
                            <p>
								<strong><?php esc_html_e('Please Note:'); ?></strong> <?php esc_html_e('The import feature is still under development. Right now it only allows importing and creating new Lists. Existing Lists will not get updated. Also, export feature is not available in free version.'); ?>
							</p>
							
							<p>
                                <strong><?php esc_html_e('Sample CSV File:'); ?></strong>
                                <a href="<?php echo esc_url(qcpnd_ASSETS_URL . '/file/sample-csv-file.csv'); ?>" target="_blank">
                                    <?php esc_html_e('Download'); ?>
                                </a>
                            </p>

                            <p><strong><?php esc_html_e('PROCESS:'); ?></strong></p>

                            <p>
                                <ol>
                                    <li><?php esc_html_e('First download the above CSV file.'); ?></li>
                                    <li><?php esc_html_e('Add/Edit rows on the top of it, by maintaing proper provided format/fields.'); ?></li>
                                    <li><?php esc_html_e('Finally, upload file in the below form.'); ?></li>
                                </ol>
                            </p>



                            <p><strong><?php esc_html_e('NOTES:'); ?></strong></p>

                            <p>
                                <ol>
                                    <li><?php esc_html_e('It should be a simple CSV file.'); ?></li>
                                    <li><?php esc_html_e('File encoding should be in UTF-8'); ?></li>
                                    <li><?php esc_html_e('File must be prepared as per provided sample CSV file.'); ?></li>
                                </ol>
                            </p>
                            
                        </div>

                        <div style="border: 1px solid #ccc; padding: 10px; margin: 10px 0;">

                        <!-- Handle CSV Upload -->

                        <?php

                        $randomNum = substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 5);

                        if( !empty($_POST) && isset($_POST['upload_csv']) ) 
                        {

                            if ( function_exists('is_user_logged_in') && is_user_logged_in() ) 
							{

                                if ( ! function_exists( 'wp_handle_upload' ) ) {
									require_once( ABSPATH . 'wp-admin/includes/file.php' );
								}

								$uploadedfile = $_FILES['csv_upload'];

								$upload_overrides = array( 'test_form' => false );

								$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

								if ( $movefile && ! isset( $movefile['error'] ) ) {
									

									$tmpName = $movefile['file'];
									$file = fopen($tmpName, "r");
									$flag = true;
									
									//Reading file and building our array
									
									$baseData = array();

									$count = 0;

									while(($data = fgetcsv($file)) !== FALSE) 
									{
										if ($flag) {
											$flag = false;
											continue;
										}
										
										$baseData[$data[0]][] = array(
											'list_title' => $data[0],
											'qcpnd_item_title' => $data[1],
											'qcpnd_item_link' => $data[2],
											'qcpnd_item_img' => '',
											'qcpnd_item_phone' => $data[3],
											'qcpnd_item_gotoweb' => $data[4],
											'qcpnd_item_description' => $data[5]
										);

										$count++;

									}
									
									fclose($file);
									
									//Inserting Data from our built array
									
									$keyCounter = 0;
									$metaCounter = 0;
									
									global $wpdb;
									
									foreach( $baseData as $key => $data ){
									
										$post_arr = array(
											'post_title' => trim($key),
											'post_status' => 'publish',
											'post_author' => get_current_user_id(),
											'post_type' => 'pnd',
										);

										wp_insert_post($post_arr);

										$newest_post_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_type = 'pnd' ORDER BY ID DESC LIMIT 1");

										foreach( $data as $k => $item ){										
											add_post_meta(
												$newest_post_id, 
												'qcpnd_list_item01', array(
													'qcpnd_item_title' => sanitize_text_field($item['qcpnd_item_title']),
													'qcpnd_item_link' => esc_url_raw($item['qcpnd_item_link']),
													'qcpnd_item_img' => '',
													'qcpnd_item_phone' => sanitize_text_field($item['qcpnd_item_phone']),
													'qcpnd_item_gotoweb' => sanitize_text_field($item['qcpnd_item_gotoweb']),
													'qcpnd_item_description' => sanitize_text_field($item['qcpnd_item_description'])
												)
											);
											
											$metaCounter++;
											
										} //end of inner-foreach
										
										$keyCounter++;
									
									} //end of outer-foreach

									if( $keyCounter > 0 && $metaCounter > 0 )
									{
										echo  '<div><span style="color: red; font-weight: bold;">RESULT:</span> <strong>'.$keyCounter.'</strong> entry with <strong>'.$metaCounter.'</strong> element(s) was made successfully.</div>';
									}
								}
                            }

                        } 
                        else 
                        {
							// echo "Attached file is invalid!";
                        }

                        ?>
                            
                            <p style="display:none">
                                <strong>
                                    <?php echo esc_html__('Upload csv file to import'); ?>
                                </strong>
                            </p>

                            <form name="uploadfile" id="uploadfile_form" method="POST" enctype="multipart/form-data" action="" accept-charset="utf-8"  style="display:none">
                                <?php wp_nonce_field('qcpnd_import_nonce', 'qc-opd'); ?>

                                <p>
                                    <?php echo esc_html__('Select file to upload') ?>
                                    <input type="file" name="csv_upload" id="csv_upload" size="35" class="uploadfiles"/>
                                </p>
                                <p>
                                    <input class="button-primary" type="submit" name="upload_csv" id="" value="<?php echo esc_html__('Upload & Process'); ?>"/>
                                </p>

                            </form>

                            <p style="color:indianred;font-weight: bold"><i><?php esc_html_e('We have found some bugs with the Import feature in the free version. We are working on it. The import feature is currently unavailable in the free version.'); ?></i></p>
                            <p  style="color:indianred;font-weight: bold"><i><?php esc_html_e('Import and Export features are fully functional in the'); ?> <a href="<?php echo esc_url('https://www.quantumcloud.com/products/simple-business-directory/'); ?>" target="_blank"><?php  esc_html_e('Pro version.'); ?></a></i></p>

                        </div>


                        <div style="padding: 15px 10px; border: 1px solid #ccc; text-align: center; margin-top: 20px;">
                            <?php  esc_html_e('Crafted By:'); ?> <a href="<?php echo esc_url('http://www.quantumcloud.com'); ?>" target="_blank"><?php  esc_html_e('Web Design Company'); ?></a> -
                             <?php  esc_html_e('QuantumCloud'); ?>
                        </div>

                    </div>
                    <!-- /post-body-content -->

                </div>
                <!-- /post-body-->

            </div>
            <!-- /poststuff -->


        </div>
        <!-- /wrap -->

        <?php
    }
}

new qcpnd_BulkImportFree;

<?php

defined('ABSPATH') or die("You can't access this file directly.");

//Setting options page
/*******************************
 * Callback function to add the menu
 *******************************/
function sbd_show_settngs_page_callback_func()
{
	add_submenu_page(
		'edit.php?post_type=pnd',
		'Settings',
		'Settings',
		'manage_options',
		'sbd_settings',
		'qc_sbd_settings_page_callback_func'
	);
	add_action( 'admin_init', 'sbd_register_plugin_settings' );
} //show_settings_page_callback_func
add_action( 'admin_menu', 'sbd_show_settngs_page_callback_func');

function sbd_register_plugin_settings() {


    $args = array(
      'type'              => 'string', 
      'sanitize_callback' => 'sanitize_text_field',
      'default'           => NULL,
    );  

    $args_email = array(
      'type'              => 'string', 
      'sanitize_callback' => 'sanitize_email',
      'default'           => NULL,
    );  

  	//register our settings
  	//general Section
  	register_setting( 'qc-sbd-plugin-settings-group', 'sbd_map_api_key', $args );
  	register_setting( 'qc-sbd-plugin-settings-group', 'pd_enable_top_part', $args );
    register_setting( 'qc-sbd-plugin-settings-group', 'pd_map_open_street_map', $args );
  	register_setting( 'qc-sbd-plugin-settings-group', 'pd_add_new_button', $args );
  	register_setting( 'qc-sbd-plugin-settings-group', 'pd_add_item_link', $args );
    register_setting( 'qc-sbd-plugin-settings-group', 'pd_enable_rtl', $args );

  	//Language Settings
  	register_setting( 'qc-sbd-plugin-settings-group', 'pd_lan_add_link', $args );
  	register_setting( 'qc-sbd-plugin-settings-group', 'pd_lan_share_list', $args );
    register_setting( 'qc-sbd-plugin-settings-group', 'pd_lan_view_site', $args );
    register_setting( 'qc-sbd-plugin-settings-group', 'pd_lan_provide_location', $args );
    register_setting( 'qc-sbd-plugin-settings-group', 'pd_lan_distance_value', $args );
    register_setting( 'qc-sbd-plugin-settings-group', 'pd_lan_no_result_found', $args );
    register_setting( 'qc-sbd-plugin-settings-group', 'pd_enable_gdpr_policies', $args );
    register_setting( 'qc-sbd-plugin-settings-group', 'pd_lan_gdpr_policies', $args );
    register_setting( 'qc-sbd-plugin-settings-group', 'pd_lan_gdpr_load_map_lang', $args );
  	//custom css section
  	register_setting( 'qc-sbd-plugin-settings-group', 'pd_custom_style', $args );
  	//custom js section
  	register_setting( 'qc-sbd-plugin-settings-group', 'pd_custom_js', $args );
  	//help sectio
	
}

function qc_sbd_settings_page_callback_func(){
	
	?>

<div class="wrap swpm-admin-menu-wrap">
  <h1><?php echo esc_html('SBD Settings Page'); ?></h1>
  <h2 class="nav-tab-wrapper sbd_nav_container"> 
    <a class="nav-tab sbd_click_handle nav-tab-active" href="#getting_started"><?php echo esc_html('Getting Started'); ?></a> 
    <a class="nav-tab sbd_click_handle" href="#general_settings"><?php echo esc_html('General Settings'); ?></a> 
    <a class="nav-tab sbd_click_handle" href="#language_settings"><?php echo esc_html('Language Settings'); ?></a> 
    <a class="nav-tab sbd_click_handle" href="#custom_css"><?php echo esc_html('Custom CSS'); ?></a> 
    <a class="nav-tab sbd_click_handle" href="#custom_js"> <?php echo esc_html('Custom Javascript'); ?></a> 
    <a id="sbd_help_tab" class="nav-tab sbd_click_handle" href="#help"><?php echo esc_html('Help'); ?></a> 
  </h2>
<form method="post" action="options.php">
  <?php settings_fields( 'qc-sbd-plugin-settings-group' ); ?>
  <?php do_settings_sections( 'qc-sbd-plugin-settings-group' ); ?>
  <div id="getting_started">
    <div class="is-dismissible sbd-notice" style="display:none"> 
      <div class="sbd_info_carousel slick-slider">
      
        <div class="pd_info_item">
          <div class="serviceBox">
            <div class="service-count"> <?php echo esc_html('Step 1'); ?></div>
            <div class="service-icon"><span><i class="fa fa-thumbs-up"></i></span></div>
            <div class="sldslider-Details">
              <div class="description">
                <h3> <?php echo esc_html('Select Map API'); ?></h3>
                
                  <?php echo esc_html('From the Settings page add Google Map API key or select to use OpenStreetMap. Note that OpenStreetMap has less data and locations. So some addresses may not be found there. If you select to go with Google Map, follow the steps carefully on the'); ?> <a class="sbd_help_links" href="<?php echo get_site_url().'/wp-admin/edit.php?post_type=pnd&page=sbd_settings#help'; ?>"> <?php echo esc_html('Help page'); ?></a>. <?php echo esc_html('If you do not want to use maps, you can ignore these settings.'); ?>
                
                </div>
              <div class="Getting_Started_img"> <img src="<?php echo esc_url(qcpnd_IMG_URL); ?>/sbd-step1.jpg"> </div>
            </div>
          </div>
        </div>     
        
        <div class="pd_info_item">
          <div class="serviceBox">
            <div class="service-count"> <?php echo esc_html('Step 2'); ?></div>
            <div class="service-icon"><span><i class="fa fa-thumbs-up"></i></span></div>
            <div class="sldslider-Details">
              <div class="description">
                <h3><?php echo esc_html('Create Lists with Listing Details'); ?></h3>
                 <?php echo esc_html('Go to New List and create one by giving it a name. Then simply start adding List items or businesses by filling up the fields you want. Use the Add New button to add more Listings in your list. When you start typing a full address, the Auto Complete feature will start showing matching addresses in a drop down if API is set up correctly.'); ?></div>
                <div class="Getting_Started_img"> <img src="<?php echo esc_url(qcpnd_IMG_URL); ?>/sbd-step2.jpg"> </div>
              </div>
          </div>
        </div>

          <div class="pd_info_item">
          <div class="serviceBox">
            <div class="service-count"><?php echo esc_html('Step 3'); ?></div>
            <div class="service-icon"><span><i class="fa fa-thumbs-up"></i></span></div>
            <div class="sldslider-Details">
              <div class="description">
                <h3> <?php echo esc_html('Create More Lists'); ?></h3>
                <?php echo esc_html('Though you can just create one list and use the Single List mode. This directory plugin works the best when you create a few Lists each conatining about 15-20 List items . This is the most usual use case scenario. But you can do differently once you get the idea.'); ?></div>
              <div class="Getting_Started_img"> <img src="<?php echo esc_url(qcpnd_IMG_URL); ?>/sbd-step3.jpg"> </div>
            </div>
          </div>
        </div>  
        
          <div class="pd_info_item">
          <div class="serviceBox">
            <div class="service-count"><?php echo esc_html('Step 4'); ?></div>
            <div class="service-icon"><span><i class="fa fa-thumbs-up"></i></span></div>
            <div class="sldslider-Details">
              <div class="description">
                <h3><?php echo esc_html('Generate and Paste Shortcode on a Page'); ?></h3>
                <?php echo esc_html('Now go to a page or post where you want to display the directory. On the right sidebar you will see a ShortCode Generator block. Click the button and a Popup LightBox will appear with all the options that you can select. Choose All Lists, and select a Style. Then Click Add Shortcode button. Shortcode will be generated. Simply copy paste that to a location on your page where you want the directory to show up.'); ?></div>
              <div class="Getting_Started_img"> <img src="<?php echo esc_url(qcpnd_IMG_URL); ?>/step2.png"> </div>
            </div>
          </div>
        </div>          
        
      </div>
    </div>
  </div>
  <div id="general_settings" style="display:none">
    <p style="color: indianred;background: #ffcc4d;padding: 10px 10px;font-weight: bold;display: inline-block;"><i> <?php echo esc_html('** Please check the'); ?> <a class="sbd_help_links" href="<?php echo esc_url( admin_url('edit.php?post_type=pnd&page=sbd_settings#help') ); ?>"> <?php echo esc_html('Help page'); ?> </a> <?php echo esc_html('for details on how to get started with creating Link Lists and how to use the Shortcode Generator.'); ?></i></p>
    <table class="form-table">
      <tr valign="top">
            <th scope="row"> <?php echo esc_html('Google Map API Key'); ?></th>
            <td>
              <input type="text" name="sbd_map_api_key" size="100" value="<?php echo esc_attr( get_option('sbd_map_api_key') ); ?>"  />
              <br><i><span style="color:red"> <?php echo esc_html('Google Map API key is required for Google Map to work. You can get google map api key from'); ?><a href="<?php echo esc_url('https://developers.google.com/maps/documentation/geocoding/get-api-key'); ?>"> <?php echo esc_html('here.'); ?></a></span></i>
              <p><span style="color:red"> <?php echo esc_html('Please check our'); ?><a class="pd-help-section-link" href="#help"> <?php echo esc_html('Help section'); ?></a>  <?php echo esc_html('for how to set up the Google Map API. Or, you can select OpenStreetMap without any API key.'); ?></span></p>
            </td>
      </tr>
      <tr valign="top">
        <th scope="row"> <?php echo esc_html('Use OpenStreetMap instead of Google Map'); ?></th>
        <td>
          <input type="checkbox" name="pd_map_open_street_map" value="on" <?php echo (esc_attr( get_option('pd_map_open_street_map') )=='on'?'checked="checked"':''); ?> />
          <i> <?php echo esc_html('Select if you want to use OpenStreetMap instead of Google Map. Note that OpenStreetMap has less data and locations. So some addresses may not be found there. You can insert Latitudes and Longitudes manually for them.'); ?></i>
        </td>
      </tr>
      <tr valign="top">
        <th scope="row"> <?php echo esc_html('Enable Top Area'); ?></th>
        <td><input type="checkbox" name="pd_enable_top_part" value="on" <?php echo (esc_attr( get_option('pd_enable_top_part') )=='on'?'checked="checked"':''); ?> />
          <i> <?php echo esc_html('Top area includes Embed button (more options coming soon)'); ?></i></td>
      </tr>
      <tr valign="top">
        <th scope="row"><?php echo esc_html('Enable Add New Button'); ?></th>
        <td><input type="checkbox" name="pd_add_new_button" value="on" <?php echo (esc_attr( get_option('pd_add_new_button') )=='on'?'checked="checked"':''); ?> />
          <i><?php echo esc_html('The button will link to a page of your choice where you can place a contact form or instructions to submit links to your directory. Links have to be manually added by the admin. '); ?></i></td>
      </tr>
      <tr valign="top">
        <th scope="row"> <?php echo esc_html('Add Button Link'); ?></th>
        <td><input type="text" name="pd_add_item_link" size="100" value="<?php echo esc_attr( get_option('pd_add_item_link') ); ?>"  />
          <i> <?php echo esc_html('Example:'); ?> <?php echo esc_url('http://www.yourdomain.com'); ?> </i></td>
      </tr>
      <tr valign="top">
        <th scope="row"><?php echo esc_html('Enable RTL Direction'); ?></th>
        <td><input type="checkbox" name="pd_enable_rtl" value="on" <?php echo (esc_attr( get_option('pd_enable_rtl') )=='on'?'checked="checked"':''); ?> />
          <i><?php echo esc_html('If you make this option ON, then list items will be arranged in Right-to-Left direction.'); ?></i></td>
      </tr>
      <tr valign="top">
        <th scope="row"><?php echo esc_html('Enable Privacy Policy Acceptance Before Loading Map'); ?></th>
        <td><input type="checkbox" name="pd_enable_gdpr_policies" value="on" <?php echo (esc_attr( get_option('pd_enable_gdpr_policies') )=='on'?'checked="checked"':''); ?> />
          <i><?php echo esc_html('Enable this option to accept Privacy policy before loading the map. You can change the Language and Link from Language Settings.'); ?></i></td>
      </tr>
    </table>
  </div>
  <div id="language_settings" style="display:none">
    <table class="form-table">
      <tr valign="top">
        <th scope="row"><?php echo esc_html('Add New'); ?></th>
        <td><input type="text" name="pd_lan_add_link" size="100" value="<?php echo esc_attr( get_option('pd_lan_add_link') ); ?>"  />
          <i> <?php echo esc_html('Change the language for Add New'); ?></i></td>
      </tr>
      <tr valign="top">
        <th scope="row"> <?php echo esc_html('Share List'); ?></th>
        <td><input type="text" name="pd_lan_share_list" size="100" value="<?php echo esc_attr( get_option('pd_lan_share_list') ); ?>"  />
          <i> <?php echo esc_html('Change the language for Share List'); ?></i></td>
      </tr>
      <tr valign="top">
        <th scope="row"> <?php echo esc_html('View Site'); ?></th>
        <td><input type="text" name="pd_lan_view_site" size="100" value="<?php echo esc_attr( get_option('pd_lan_view_site') ); ?>"  />
          <i> <?php echo esc_html('Change the language for View Site'); ?></i></td>
      </tr>
      <tr valign="top">
        <th scope="row"> <?php echo esc_html('Please provide location'); ?></th>
        <td><input type="text" name="pd_lan_provide_location" size="100" value="<?php echo esc_attr( get_option('pd_lan_provide_location') ); ?>"  />
          <i> <?php echo esc_html('Change the language for Please provide location'); ?></i></td>
      </tr>
      <tr valign="top">
        <th scope="row"> <?php echo esc_html('Please provide Distance value'); ?></th>
        <td><input type="text" name="pd_lan_distance_value" size="100" value="<?php echo esc_attr( get_option('pd_lan_distance_value') ); ?>"  />
          <i> <?php echo esc_html('Change the language for Please provide Distance value'); ?></i></td>
      </tr>
      <tr valign="top">
        <th scope="row"> <?php echo esc_html('No result found!'); ?></th>
        <td><input type="text" name="pd_lan_no_result_found" size="100" value="<?php echo esc_attr( get_option('pd_lan_no_result_found') ); ?>"  />
          <i> <?php echo esc_html('Change the language for No result found!'); ?></i></td>
      </tr>
      <tr valign="top">
        <th scope="row"> <?php echo esc_html('I agree with the website\'s Privacy Policies.'); ?></th>
        <td><input type="text" name="pd_lan_gdpr_policies" size="100" value="<?php echo ( get_option('pd_lan_gdpr_policies') != ''  ? esc_attr( get_option('pd_lan_gdpr_policies') ) : 'I agree with the website\'s <a href='.site_url().'>Privacy Policies.</a>'); ?>"  />
          <i> <?php echo esc_html('Change the language for - I agree with the website\'s Privacy Policies. Remember to update the Link to your actual Privacy Policy page'); ?></i></td>
      </tr>
      <tr valign="top">
        <th scope="row"> <?php echo esc_html('Please load the map'); ?></th>
        <td><input type="text" name="pd_lan_gdpr_load_map_lang" size="100" value="<?php echo esc_attr( get_option('pd_lan_gdpr_load_map_lang') ); ?>"  />
          <i> <?php echo esc_html('Change the language for - Please load the map'); ?></i></td>
      </tr>
    </table>
  </div>
  <div id="custom_css" style="display:none">
    <table class="form-table">
      <tr valign="top">
        <th scope="row"> <?php echo esc_html('Custom Css'); ?></th>
        <td><textarea name="pd_custom_style" rows="10" cols="100"><?php echo esc_attr( get_option('pd_custom_style') ); ?></textarea>
          <p><i> <?php echo esc_html('Write your custom CSS here. Please do not use'); ?> <b> <?php echo esc_html('style'); ?> </b> <?php echo esc_html('tag in this textarea.'); ?></i></p></td>
      </tr>
    </table>
  </div>
  <div id="custom_js" style="display:none">
    <table class="form-table">
      <tr valign="top">
        <th scope="row"> <?php echo esc_html('Custom Javascript'); ?></th>
        <td><textarea name="pd_custom_js" rows="10" cols="100"><?php echo esc_attr( get_option('pd_custom_js') ); ?></textarea>
          <p><i> <?php echo esc_html('Write your custom JS here. Please do not use'); ?><b> <?php echo esc_html('script'); ?> </b> <?php echo esc_html('tag in this textarea.'); ?></i></p></td>
      </tr>
    </table>
  </div>
  <div id="help" style="display:none">
  <table class="form-table">
    <tr valign="top">
      <th scope="row"><?php echo esc_html('Help'); ?></th>
      <td><div id="poststuff">
          <div id="post-body" class="metabox-holder columns-2">
            <div id="post-body-content" style="position: relative;">
              <h1> <?php echo esc_html('Welcome to the Simple Business Directory! You are'); ?><strong><?php echo esc_html('awesome'); ?></strong> <?php echo esc_html(', by the way'); ?><img draggable="false" class="emoji" alt="🙂" src="<?php echo esc_url(qcpnd_IMG_URL); ?>/1f642.svg"></h1>
              <div id="google-api-hint" class="qcld-sbd-section-block sbd-map-api-hint">
                <h3 class='shortcode-section-title sbd-color-red'><?php echo esc_html('For Google Map API key to work:'); ?></h3>
                <div class=" left_section">
                  <p class="list-element"><span style="font-weight:bold;">1.</span> <?php echo esc_html('Make sure to have both API and Application restriction set to None or restrict them to your domain name properly from Credentials->API Keys->Your API->Application restrictions'); ?></p>
                  <p class="list-element"><span style="font-weight:bold;">2.</span> <?php echo esc_html('Ensure that ALL the API libraries are enabled including Javascript, Geocoding and Places APIs.'); ?></p>
                  <p class="list-element"><span style="font-weight:bold;">3.</span><?php echo esc_html('Also, from the middle of 2018, Google requires you to add a Billing account. Although, for 99% cases you wont actually have to pay anything as the free usage limit is quite high for almost any use cases.'); ?></p>
                </div>
                <div class="image-container">
                  <div> <img src="<?php echo esc_url(qcpnd_IMG_URL); ?>/api-restrictions-list.png" alt="api-restrictions-list"> </div>
                  <div> <img src="<?php echo esc_url(qcpnd_IMG_URL); ?>/api-restrictions.jpg" alt="api-restrictions"> </div>
                  <div> <img src="<?php echo esc_url(qcpnd_IMG_URL); ?>/api-search.png" alt="api-search"> </div>
                  <!-- <img src="<?php echo esc_url(qcpnd_IMG_URL); ?>/enable-apis.jpg" alt="enable-apis"> -->
                  <div> <img src="<?php echo esc_url(qcpnd_IMG_URL); ?>/api-library-restrictions.png" alt="api-library-restrictions"> </div>
                </div>
              </div>
              <h3><?php echo esc_html('Getting Started'); ?></h3>
              <p><?php echo esc_html('Getting started with Simple Business Directory is super easy but the plugin works a little different from others - so an introduction is necessary.'); ?></p>
              <p> <?php echo esc_html('The plugin works a little different from others. The most important thing to remember is that the'); ?> <strong> <?php echo esc_html('base pillars of this plugin are Lists'); ?></strong>, <?php echo esc_html('not individual businessed or categories. A list is simply a niche or subtopic to group your relevant businesses or any type of Listings together. The most common use of SBD is to create and display multiple businesses or listings on specific topics or subtopics on the same page. Everything revolves around the Lists. Once you create a few Lists, you can then display them in many different ways.'); ?></p>
              <p><?php echo esc_html('With that in mind you should start with the following simple steps.'); ?></p>
              <p style="background: #ffcc4d;padding: 10px 10px 10px 10px;margin:15px 0px"> <?php echo esc_html('1. Go to New List and create one by giving it a name. Then simply start adding List items or businesses by filling up the fields you want. Use the'); ?> <strong><?php echo esc_html('Add New'); ?></strong> <?php echo esc_html('button to add more Listings in your list.'); ?></p>
              <p style="background: #ffcc4d;padding: 10px 10px 10px 10px;margin-bottom:15px"> <?php echo esc_html('2. Though you can just create one list and use the Single List mode. This directory plugin works the best when you'); ?> <strong><?php echo esc_html('create a few Lists'); ?></strong> <?php echo esc_html('each conatining about'); ?> <strong><?php echo esc_html('15-20 List items'); ?> </strong>. <?php echo esc_html('This is the most usual use case scenario. But you can do differently once you get the idea.'); ?></p>
              <p style="background: #ffcc4d;padding: 10px 10px 10px 10px;"> <?php echo esc_html('3. Now go to a page or post where you want to display the directory. On the right sidebar you will see a'); ?> <strong class="sbd_short_genarator_scroll"><?php echo esc_html('ShortCode Generator'); ?></strong> <?php echo esc_html('block. Click the button and a Popup LightBox will appear with all the options that you can select. Choose All Lists, and select a Style. Then Click Add Shortcode button. Shortcode will be generated. Simply'); ?> <strong> <?php echo esc_html('copy paste'); ?> </strong> <?php echo esc_html('that to a location on your page where you want the'); ?> <strong> <?php echo esc_html('directory to show up'); ?></strong>.</p>
              <p> <?php echo esc_html('That’s it!'); ?>
              <p> <?php echo esc_html('The above steps are for the basic usages. There are a lot of advanced options available with the'); ?> <a href="<?php echo esc_url('https://www.quantumcloud.com/products/simple-business-directory/'); ?>"> <?php echo esc_html('Professional version'); ?> </a> <?php echo esc_html('if you ever feel the need. If you had any specific questions about how something works, do not hesitate to contact us from the'); ?> <a href="<?php echo get_site_url().'/wp-admin/edit.php?post_type=pnd&page=qcpro-promo-page-pd-free-page-143pd'; ?>"><?php echo esc_html('Support Page'); ?></a>. <?php echo esc_html('We are very friendly and would be glad to answer any question you might have!'); ?> <img draggable="false" class="emoji" alt="🙂" src="<?php echo esc_url(qcpnd_IMG_URL); ?>/1f642.svg"></p>
              <h3><?php echo esc_html('Note'); ?></h3>
              <p><strong><?php echo esc_html('If you are having problem with adding more items or saving a list or your changes in the list are not getting saved then it is most likely because of a limitation set in your server. Your server has a limit for how many form fields it will process at a time. So, after you have added a certain number of links, the server refuses to save the List. The server’s configuration that dictates this is max_input_vars. You need to Set it to a high limit like max_input_vars = 15000. Since this is a server setting - you may need to contact your hosting companies support for this.'); ?></strong></p>
              <br>
              <p><b><?php echo esc_html('For Google Map API key to work, make sure to have both API and Application restriction set to None or restrict them to your domain name. Ensure that all the API libraries are enabled. Also, from the middle of 2018, Google requires you to add a Billing account. Although, for 99% cases you won�t actually have to pay anything as the free usage limit is quite high for most cases.'); ?></b></p>
              <h3 class="sbd_short_genarator_scroll_wrap"> <?php echo esc_html('Shortcode Generator'); ?></h3>
              <p> <?php echo esc_html('We encourage you to use the Shortcode generator found in the toolbar of your page/post editor in visual mode.'); ?></p>
              <img src="<?php echo esc_url(qcpnd_IMG_URL); ?>/classic.jpg" alt="shortcode generator" />
              <p><?php echo esc_html('See sample below for where to find it for Gutenberg.'); ?></p>
              <img src="<?php echo esc_url(qcpnd_IMG_URL); ?>/gutenburg.jpg" alt="shortcode generator" /> <img src="<?php echo esc_url(qcpnd_IMG_URL); ?>/gutenburg2.jpg" alt="shortcode generator" />
              <p><?php echo esc_html('This is how the shortcode generator will look like.'); ?></p>
              <img src="<?php echo esc_url(qcpnd_IMG_URL); ?>/shortcode-generator1.jpg" alt="shortcode generator" /> <br>
              <br>
              <h3><?php echo esc_html('Please take a quick look at our'); ?> <a href="<?php echo esc_url('https://dev.quantumcloud.com/simple-business-directory/tutorials/'); ?>" class="button button-primary"><?php echo esc_html('Video Tutorials'); ?></a></h3>
              <div>
                <h3><?php echo esc_html('Shortcode Example'); ?></h3>
                <p> <strong><?php echo esc_html('You can use our given SHORTCODE GENERATOR to generate and insert shortcode easily, titled as [SBD] with WordPress content editor.'); ?></strong> </p>
                <p> <strong><u><?php echo esc_html('For all the lists:'); ?></u></strong> <br>
                  [qcpnd-directory mode="all" style="simple" column="2" item_orderby="title" show_phone_icon="1" show_link_icon="1" enable_embedding="true" main_click_action="1" phone_number="1" map="show" showmaponly="no"  orderby="date" order="ASC"] <br>
                  <br>
                  <strong><u><?php echo esc_html('For only a single list:'); ?></u></strong> <br>
                  [qcpnd-directory mode="one" style="simple" column="2" list_id="240" item_orderby="title" show_phone_icon="1" show_link_icon="1" enable_embedding="true" main_click_action="1" phone_number="1" map="show" showmaponly="no" orderby="date" order="ASC"] <br>
                  <br>
                  <strong><u><?php echo esc_html('For List Category Mode:'); ?></u></strong> <br>
                  [qcpnd-directory category="cat-slug"style="style-1" column="2" showmaponly="no" item_orderby="title" show_phone_icon="1" show_link_icon="1" enable_embedding="true" main_click_action="1" phone_number="1" map="show" orderby="date" order="ASC"] <br>
                  <br>
                  <strong><u><?php echo esc_html('For Map Only Mode:'); ?></u></strong> <br>
                  [qcpnd-directory mode="maponly" showmaponly="yes"] <br>
                  <br>
                  <strong><u><?php echo esc_html('Available Parameters:'); ?></u></strong> <br>
                </p>
                <p> <strong><?php echo esc_html('1. mode'); ?></strong> <br>
                  <?php echo esc_html('Value for this option can be set as "one", "all", or "maponly".'); ?> </p>
                <p> <strong><?php echo esc_html('2. style'); ?></strong> <br>
                  <?php echo esc_html('Avaialble values: "simple", "style-1", "style-2", "style-3".'); ?> <br>
                  <strong style="color: red;"><?php echo esc_html('Only 4 templates are available in the free version. For more styles or templates, please purchase the'); ?> <a href="<?php echo esc_url('https://www.quantumcloud.com/products/simple-business-directory/'); ?>" target="_blank"><?php echo esc_html('premium version'); ?></a>. </strong> </p>
                <p> <strong><?php echo esc_html('3. column'); ?></strong> <br>
                  <?php echo esc_html('Avaialble values: "1", "2", "3" or "4".'); ?> </p>
                <p> <strong><?php echo esc_html('4. orderby'); ?></strong> <br>
                  <?php echo esc_html('Compatible order by values: "ID", "author", "title", "name", "type", "date", "modified", "rand" and "menu_order".'); ?> </p>
                <p> <strong><?php echo esc_html('5. order'); ?></strong> <br>
                  <?php echo esc_html('Value for this option can be set as "ASC" for Ascending or "DESC" for Descending order.'); ?> </p>
                <p> <strong><?php echo esc_html('6. list_id'); ?></strong> <br>
                  <?php echo esc_html('Only applicable if you want to display a single list [not all]. You can provide specific list id here as a value. You can also get ready shortcode for a single list under "Manage List Items" menu.'); ?> </p>
                <p> <strong><?php echo esc_html('6. category'); ?></strong> <br>
                  <?php echo esc_html('Supply the category slug of your specific directory category.'); ?> <br>
                  <?php echo esc_html('Example: category="designs"'); ?> </p>
                <p> <strong><?php echo esc_html('7. item_orderby'); ?></strong> <br>
                  <?php echo esc_html('Compatible Item order by values: "title", and "None".'); ?> </p>
                <p> <strong><?php echo esc_html('8. order'); ?></strong> <br>
                  <?php echo esc_html('Value for this option can be set as "ASC" for Ascending or "DESC" for Descending order.'); ?> </p>
                <p> <strong><?php echo esc_html('9. enable_embedding'); ?></strong> <br>
                  <?php echo esc_html('Allow visitors to embed list in other sites. Supported values - "true", "false".'); ?> <br>
                  <?php echo esc_html('Example: enable_embedding="true"'); ?> </p>
                <p> <strong><?php echo esc_html('10. show_phone_icon'); ?></strong> <br>
                  <?php echo esc_html('Allow to show a phone icon with each item . Supported values - "1", "0".'); ?> <br>
                  <?php echo esc_html('Example: show_phone_icon="1"'); ?> </p>
                <p> <strong><?php echo esc_html('11. show_link_icon'); ?></strong> <br>
                  <?php echo esc_html('Allow to show a link icon with each item . Supported values - "1", "0".'); ?> <br>
                  <?php echo esc_html('Example: show_link_icon="1"'); ?> </p>
                <p> <strong><?php echo esc_html('12. main_click_action'); ?></strong> <br>
                  <?php echo esc_html('Available values for this option "1", "0", "3"'); ?> </p>
                <p> <strong><?php echo esc_html('13. map'); ?></strong> <br>
                  <?php echo esc_html('Available values for this option "show", "hide"'); ?> </p>
                <p> <strong><?php echo esc_html('14. showmaponly'); ?></strong> <br>
                  <?php echo esc_html('You can use this value for use the maponly mode. Available values for this option "yes", "no".'); ?> </p>
              </div>
              <div>
                <h3><?php echo esc_html('How to style map with Snazzy Map'); ?></h3>
                <p><strong>1)</strong> <?php echo esc_html('Sign up for an account at'); ?> <a href="<?php echo esc_url('https://snazzymaps.com/account/developer'); ?>"><?php echo esc_html('SnazzyMaps.com'); ?></a>.</p>
                <p><strong>2)</strong> <?php echo esc_html('Click your email address in the top left corner.'); ?></p>
                <p><strong>3)</strong> <?php echo esc_html('Click the developer menu item on the left side.'); ?></p>
                <p><strong>4)</strong> <?php echo esc_html('Click the'); ?> <strong><?php echo esc_html('"Generate API Key"'); ?></strong> <?php echo esc_html('button.'); ?></p>
                <p><strong>5)</strong> <?php echo esc_html('Copy the long generated API Key.'); ?></p>
                <p><strong>6)</strong> <?php echo esc_html('Paste the key into the'); ?> <strong> <?php echo esc_html('"Settings"'); ?></strong> <?php echo esc_html('tab in the Snazzy Maps plugin.'); ?></p>
                <p><strong>7)</strong> <?php echo esc_html('You should now be able to access your favorites and private styles in the'); ?> <strong><?php echo esc_html('Explore'); ?></strong> <?php echo esc_html('tab by changing the first filter dropdown.'); ?></p>
              </div>
              <div style="padding: 15px 10px; border: 1px solid #ccc; text-align: center; margin-top: 20px;"> <?php echo esc_html('Crafted By:'); ?> <a href="<?php echo esc_url('http://www.quantumcloud.com'); ?>" target="_blank"><?php echo esc_html('Web Design Company'); ?></a> <?php echo esc_html('- QuantumCloud'); ?> </div>
            </div>
            <!-- /post-body-content --> 
            
          </div>
          <!-- /post-body--> 
          
        </div>
        
        <!-- /poststuff -->
        
      </div>
    
      </td>
    
      </tr>
    
  </table>
  </div>
  <?php submit_button(); ?>
</form>
</div>
<?php
	
}

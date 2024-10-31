(function($){
	"use strict";

jQuery(document).ready(function($){


    var sbdstoredNoticeId = localStorage.getItem('qcld_sbd_Notice_set');
    var qcld_sbd_Notice_time_set = localStorage.getItem('qcld_sbd_Notice_time_set');

    var notice_current_time = Math.round(new Date().getTime() / 1000);

    if ('sbd-msg' == sbdstoredNoticeId && qcld_sbd_Notice_time_set > notice_current_time  ) {
        $('#message-sbd').css({'display': 'none'});
    }

    $(document).on('click', '#message-sbd .notice-dismiss', function(e){

        var currentDom = $(this);
        var currentWrap = currentDom.closest('.notice');
        currentWrap.css({'display': 'none'});
        localStorage.setItem('qcld_sbd_Notice_set', 'sbd-msg');
        var ts = Math.round(new Date().getTime() / 1000);
        var tsYesterday = ts + (24 * 3600);
        localStorage.setItem('qcld_sbd_Notice_time_set', tsYesterday);
        //console.log(tsYesterday)

    });


	$('#sbd_shortcode_generator_meta').on('click', function(e){
		 $('#sbd_shortcode_generator_meta').prop('disabled', true);
		$.post(
			ajaxurl,
			{
				action : 'show_qcpnd_shortcodes'
				
			},
			function(data){
				$('#sbd_shortcode_generator_meta').prop('disabled', false);
				$('#wpwrap').append(data);
			}
		)
	})
	
	var selector = '';

	$(document).on( 'click', '.sbd_copy_close', function(){
		// if( !isGutenbergActive() ){
        	$(this).parent().parent().parent().parent().parent().remove();
		// }
    })
	
    $(document).on( 'click', '.modal-content .close', function(){
        // if( !isGutenbergActive() ){
        	$(this).parent().parent().remove();
        // }
    }).on( 'click', '#qcpnd_add_shortcode',function(){
		
	  var show_phone_icon = $('#show_phone_icon').val();
	  var show_link_icon = $('#show_link_icon').val();
      var mode = $('#pnd_mode').val();
      var column = $('#pnd_column').val();
      var style = $('#pnd_style').val();
      var upvote = $('.pnd_upvote:checked').val();
      var search = $('.pnd_search:checked').val();
      var count = $('.pnd_item_count:checked').val();
      var orderby = $('#pnd_orderby').val();
      var order = $('#pnd_order').val();
      var embed_option = $('#embed_option').val();
	  var main_click_action = $('#main_click_action').val();
	  var phone_number = $('#phone_number').val();
	  var pdmap = $('#pdmap:checked').val();
	  
	  var listId = $('#pnd_list_id').val();
	  var catSlug = $('#pnd_list_cat_id').val();
	  var pd_itemorderby = $('#pd_itemorderby').val();
	  
	  var shortcodedata = '[qcpnd-directory';
		  		  
		  if( mode !== 'category' ){
			  shortcodedata +=' mode="'+mode+'"';
		  }
		  
		  if( mode == 'one' && listId != "" ){
			  shortcodedata +=' list_id="'+listId+'"';
		  }
		  
		  if( mode == 'category' && catSlug != "" ){
			  shortcodedata +=' category="'+catSlug+'"';
		  }

		  if( mode == 'maponly' ){
			  shortcodedata +=' showmaponly="yes"';
		  }else{
		  	shortcodedata +=' showmaponly="no"';
		  }


		  if( pd_itemorderby !== '' ){
			  shortcodedata +=' item_orderby="'+pd_itemorderby+'"';
		  }
		  
		  if( style !== '' ){
			  shortcodedata +=' style="'+style+'"';
		  }
		  
		  if( show_phone_icon !== '' ){
			  shortcodedata +=' show_phone_icon="'+show_phone_icon+'"';
		  }
		  
		  if( show_link_icon !== '' ){
			  shortcodedata +=' show_link_icon="'+show_link_icon+'"';
		  }
		  
		  if( embed_option !== '' ){
			  shortcodedata +=' enable_embedding="'+embed_option+'"';
		  }
		  
		  if(typeof(main_click_action)!=="undefined" && main_click_action!==""){
			  shortcodedata +=' main_click_action="'+main_click_action+'"';
		  }
		  
		  if(typeof(phone_number)!=="undefined" && phone_number!==""){
			  shortcodedata +=' phone_number="'+phone_number+'"';
		  }
		  if( typeof(pdmap) != 'undefined' && pdmap !== '' ){
			  shortcodedata +=' map="'+pdmap+'"';
		  }
		  
		  var style = $('#pnd_style').val();
		
		  if( style == 'simple' || style == 'style-1' || style == 'style-2' || style == 'style-8' || style == 'style-9' ){
		  
			  if( column !== '' ){
				  shortcodedata +=' column="'+column+'"';
			  }
		  
		  }
		  
		  if( typeof(upvote) != 'undefined' ){
			  shortcodedata +=' upvote="'+upvote+'"';
		  }
		  
		  if( typeof(search)!= 'undefined' ){
			  shortcodedata +=' search="'+search+'"';
		  }
		  
		  if( typeof(count)!= 'undefined' ){
			  shortcodedata +=' item_count="'+count+'"';
		  }
		  
		  if( orderby !== '' ){
			  shortcodedata +=' orderby="'+orderby+'"';
		  }
		  
		  if( order !== '' ){
			  shortcodedata +=' order="'+order+'"';
		  }
		  
		  shortcodedata += ']';
		/*
		  tinyMCE.activeEditor.selection.setContent(shortcodedata);
		  
		  $('#sm-modal').remove();
		*/
		$('.sm_shortcode_list').hide();
		$('.sbd_shortcode_container').show();
		$('#sbd_shortcode_container').val(shortcodedata);
		$('.sbd_copy_close').attr('short-data', shortcodedata);
		$('#sbd_shortcode_container').select();
		document.execCommand('copy');


    }).on( 'change', '#pnd_mode',function(){
	
		var mode = $('#pnd_mode').val();

		if( mode == 'maponly' ){
			$('#pnd_style').parents('.qcpnd_single_field_shortcode').hide();
			$('#pnd_column').parents('.qcpnd_single_field_shortcode').hide();
			$('#pd_show_map').hide();
			$('#pnd_orderby').parents('.qcpnd_single_field_shortcode').hide();
			$('#pnd_order').parents('.qcpnd_single_field_shortcode').hide();
			$('#show_phone_icon').parents('.qcpnd_single_field_shortcode').hide();
			$('#show_link_icon').parents('.qcpnd_single_field_shortcode').hide();
			$('#main_click_action').parents('.qcpnd_single_field_shortcode').hide();
			$('#phone_number').parents('.qcpnd_single_field_shortcode').hide();
			$('#embed_option').parents('.qcpnd_single_field_shortcode').hide();
			$('#pd_itemorderby').parents('.qcpnd_single_field_shortcode').hide();
		}else{
			$('#pnd_style').parents('.qcpnd_single_field_shortcode').show();
			$('#pnd_column').parents('.qcpnd_single_field_shortcode').show();
			$('#pd_show_map').show();
			$('#pnd_orderby').parents('.qcpnd_single_field_shortcode').show();
			$('#pnd_order').parents('.qcpnd_single_field_shortcode').show();
			$('#show_phone_icon').parents('.qcpnd_single_field_shortcode').show();
			$('#show_link_icon').parents('.qcpnd_single_field_shortcode').show();
			$('#main_click_action').parents('.qcpnd_single_field_shortcode').show();
			$('#phone_number').parents('.qcpnd_single_field_shortcode').show();
			$('#embed_option').parents('.qcpnd_single_field_shortcode').show();
			$('#pd_itemorderby').parents('.qcpnd_single_field_shortcode').show();
		}
		
		if( mode == 'one' ){
			$('#pnd_list_div').css('display', 'block');
			$('#pnd_list_cat').css('display', 'none');
		}
		else if( mode == 'category' ){
			$('#pnd_list_cat').css('display', 'block');
			$('#pnd_list_div').css('display', 'none');
		}
		else{
			$('#pnd_list_div').css('display', 'none');
			$('#pnd_list_cat').css('display', 'none');
		}
		
	}).on( 'change', '#pnd_style',function(){
	
		var style = $('#pnd_style').val();
		
		if( style == 'simple' || style == 'style-1' ){
			$('#pnd_column_div').css('display', 'block');
		}
		else{
			$('#pnd_column_div').css('display', 'none');
		}
		
		/*if( style == 'simple' ){
		   $('#demo-preview-link #demo-url').html('<a href="http://dev.quantumcloud.com/pnd/" target="_blank">http://dev.quantumcloud.com/pnd/</a>');
		}
		else if( style == 'style-1' ){
		   $('#demo-preview-link #demo-url').html('<a href="http://dev.quantumcloud.com/pnd/style-1/" target="_blank">http://dev.quantumcloud.com/pnd/style-1/</a>');
		}
		else if( style == 'style-2' ){
		   $('#demo-preview-link #demo-url').html('<a href="http://dev.quantumcloud.com/pnd/style-2/" target="_blank">http://dev.quantumcloud.com/pnd/style-3/</a>');
		}
		else if( style == 'style-3' ){
		   $('#demo-preview-link #demo-url').html('<a href="http://dev.quantumcloud.com/pnd/style-3/" target="_blank">http://dev.quantumcloud.com/pnd/style-5/</a>');
		}
		else{
		   $('#demo-preview-link #demo-url').html('<a href="http://dev.quantumcloud.com/pnd/" target="_blank">http://dev.quantumcloud.com/pnd/</a>');
		}*/		
		
	});
	
})

jQuery(document).ready( function($) {

		
	$("body").on('focusout', "input[name*='[qcpd_item_full_address]']", function(e){
		var objc = $(this);

		if(pd_map_open_street_map == 'on'){
			return;
		}
		
		var geocoder = new google.maps.Geocoder();
		var address = objc.val();

		geocoder.geocode( { 'address': address}, function(results, status) {

		if (status == google.maps.GeocoderStatus.OK) {
			var latitude = results[0].geometry.location.lat();
			var longitude = results[0].geometry.location.lng();
			
			objc.closest('.cmb_metabox').find('#qcpd_item_latitude input').val(latitude);
			objc.closest('.cmb_metabox').find('#qcpd_item_longitude input').val(longitude);
			
			
		}else{
			console.log('Unable to retrive lat, lng from this address');
		}
		
		}); 
		
	})
	
	$("body").on('focus', "input[name*='[qcpd_item_full_address]']", function(e){
		if(pd_map_open_street_map == 'on'){
			return;
		}
		
		var objc = $(this);
		var input = document.getElementById(objc.attr('id'));
		var autocomplete = new google.maps.places.Autocomplete(input);
		var geocoder = new google.maps.Geocoder;
		autocomplete.addListener('place_changed', function() {
          
			var place = autocomplete.getPlace();

			if (!place.place_id) {
				return;
			}

			geocoder.geocode({'placeId': place.place_id}, function(results, status) {

				if (status !== 'OK') {
				  alert('Geocoder failed due to: ' + status);
				  return;
				}
				//console.log(results[0].geometry.location.lat());
				var latitude = results[0].geometry.location.lat();
				var longitude = results[0].geometry.location.lng();
				
				objc.closest('.cmb_metabox').find('#qcpd_item_latitude input').val(latitude);
				objc.closest('.cmb_metabox').find('#qcpd_item_longitude input').val(longitude);

			})
			
		})
		
	});


	$('.cmb_metabox').addClass('sbd_openstreet_map');

	function qcpd_openstreet_view_map_Function(arr, currentDom){

		var out = "";
		var i;
		$('.sbd_street_map_results').remove();
		currentDom.closest('#qcpd_item_full_address').append('<div class="sbd_street_map_results"></div>');

		if(arr.length > 0){
		 
			for(i = 0; i < arr.length; i++){
		  
				var display_name = '"' + arr[i].display_name + '"';
				out += "<div class='sbd_address' title='"+ arr[i].display_name +"' data-lat='"+ arr[i].lat +"' data-lon='"+ arr[i].lon +"' data-name='"+ arr[i].display_name +"' >" + arr[i].display_name + "</div>";
			}
			$('.sbd_street_map_results').html(out);

		}else{
			$('.sbd_street_map_results').html("Sorry, no results...");
			$('.sbd_street_map_results').show();
			$(".cmb_metabox.sbd_openstreet_map .cmb-row").css({"overflow": "visible"});

			setTimeout(function(){
				$('.sbd_street_map_results').fadeOut();
			},3000)
			return;

		}
		
		$('.sbd_street_map_results').show();
		$(".cmb_metabox.sbd_openstreet_map .cmb-row").css({"overflow": "visible"});

	}


	$("body").on('focus', "input[name*='qcpd_item_full_address']", function(e){

		var objc = $(this);

		if(pd_map_open_street_map == 'on' && objc != ''){

			var currentDom = $(this);
			var inp = currentDom.val();
			var xmlhttp = new XMLHttpRequest();
			var url = "https://nominatim.openstreetmap.org/search?format=json&limit=10&q=" + inp;
			 xmlhttp.onreadystatechange = function()
			 {
			   if (this.readyState == 4 && this.status == 200)
			   {
				var myArr = JSON.parse(this.responseText);
				qcpd_openstreet_view_map_Function(myArr, currentDom);
			   }
			 };
			 xmlhttp.open("GET", url, true);
			 xmlhttp.send();

		}
		
	});


	$(document).on('keyup', "input[name*='qcpd_item_full_address']", function(e){

		if(pd_map_open_street_map == 'on'){

			var currentDom = $(this);
			var inp = currentDom.val();
			var xmlhttp = new XMLHttpRequest();
			var url = "https://nominatim.openstreetmap.org/search?format=json&limit=10&q=" + inp;
			 xmlhttp.onreadystatechange = function()
			 {
			   if (this.readyState == 4 && this.status == 200)
			   {
				var myArr = JSON.parse(this.responseText);
				qcpd_openstreet_view_map_Function(myArr, currentDom);
			   }
			 };
			 xmlhttp.open("GET", url, true);
			 xmlhttp.send();

		}
		
	});


	$(document).on('click', '.sbd_address', function(e){
		var currentDom = $(this);
		var latVal = currentDom.attr('data-lat');
		var lonVal = currentDom.attr('data-lon');
		var nameVal = currentDom.attr('data-name');
		
		currentDom.closest('.cmb_metabox').find('#qcpd_item_latitude input').val(latVal);
		currentDom.closest('.cmb_metabox').find('#qcpd_item_longitude input').val(lonVal);
		currentDom.closest('.cmb_metabox').find('#qcpd_item_full_address input').val(nameVal);
		
		$('.sbd_street_map_results').hide();
		$(".cmb_metabox.sbd_openstreet_map .cmb-row").css({"overflow": "hidden"});
		
		
	});
		
		
		
		
});


function isGutenbergActive() {
    return typeof wp !== 'undefined' && typeof wp.blocks !== 'undefined';
}
jQuery(document).ready(function($){
	if($('.pd-notice').length>0){
		$('.pd-notice').show();
		$('.pd_info_carousel').slick({
			dots: false,
			infinite: true,
			speed: 1200,
			slidesToShow: 1,
			autoplaySpeed: 11000,
			autoplay: true,
			slidesToScroll: 1
			
		});
	}
	
});


jQuery(document).ready(function($){
	if($('.sbd-notice').length>0){
		$('.sbd-notice').show();
		$('.sbd_info_carousel').slick({
			dots: false,
			infinite: true,
			speed: 1200,
			slidesToShow: 1,
			autoplaySpeed: 11000,
			autoplay: false,
			draggable:false,
			zIndex:2000,
			slidesToScroll: 1,
			variableWidth: true,
			
   		    //draggable: true,
			
		});
	}
	
});

	
	

	

jQuery(document).ready(function($){
	$('.sbd_click_handle').on('click', function(e){
		e.preventDefault();
		var obj = $(this);
		var container_id = obj.attr('href');
		$('.sbd_click_handle').each(function(){
			$(this).removeClass('nav-tab-active');
			$($(this).attr('href')).hide();
		})
		obj.addClass('nav-tab-active');
		$(container_id).show();
        window.history.replaceState(null, null, container_id);
	});

	$('.pd-help-section-link').on('click', function(e){
		e.preventDefault();
		var obj = $(this);
		var container_id = obj.attr('href');
		$('.sbd_click_handle').each(function(){
			$(this).removeClass('nav-tab-active');
			$($(this).attr('href')).hide();
		})
		jQuery('#sbd_help_tab').addClass('nav-tab-active');
		$(container_id).show();
        window.history.replaceState(null, null, container_id);
	});

	var hash = window.location.hash;
	if(hash!=''){
		$('.sbd_click_handle').each(function(){
			
			$($(this).attr('href')).hide();
			if($(this).attr('href')==hash){
				$(this).removeClass('nav-tab-active').addClass('nav-tab-active');
			}else{
				$(this).removeClass('nav-tab-active');
			}
		})
		$(hash).show();
	}

	$('.sbd_help_links').on('click', function(e){
		e.preventDefault();
		var obj = $(this);
		var container_id = obj.attr('href');
		window.history.replaceState(null,null, container_id);
		location.reload(true);
	});
	

	$(".sbd_short_genarator_scroll").click(function() {
	    $("html, body").animate({ scrollTop: $(".sbd_short_genarator_scroll_wrap").offset().top }, 1500);
	});
	
	
});


//Validation for Latitude and Longitude on admin edit post
jQuery(document).ready(function($){
	jQuery("body").on('keyup focusout keypress', "input[name*='[qcpd_item_latitude]']", function(e){
		var val = jQuery(this).val();
		var error = 0;
		var error_code = '';

		if( val.trim() ){
			if( !jQuery(this).parent('.field-item').next().hasClass('sbd_error_field') ){
				jQuery(this).parent('.field-item').after('<p class="sbd_error_field"></p>');
			}
			if( isNaN(val) ){
				error = 1;
				error_code = 'NaN';
			}
			if( error == 1 && error_code == 'NaN' ){

			}else{
				if( val > -90 && val < 90 ){
					//console.log('latitude is valid');
				}else{
					error = 1;
					error_code = 'invalid_lat';
				}
			}
			if( error == 1 ){
				console.log(error_code);
				jQuery(this).parent('.field-item').next('.sbd_error_field').html('Please enter a valid Latitude');
				jQuery(this).parents('form#post').attr('onsubmit', 'return false');
				jQuery(this).parents('form#post').find('#publish').attr('disabled', true);
			}
		}
		if( error == 0 ){
			jQuery(this).parent('.field-item').next('.sbd_error_field').remove();
			if( !jQuery("input[name*='[qcpd_item_longitude]']").parent('.field-item').next().hasClass('sbd_error_field') ){			
				jQuery(this).parents('form#post').removeAttr('onsubmit');
				jQuery(this).parents('form#post').find('#publish').removeAttr('disabled').removeClass('disabled');
			}
		}
	});

	jQuery("body").on('keyup focusout keypress', "input[name*='[qcpd_item_longitude]']", function(e){
		var val = jQuery(this).val();
		var error = 0;
		var error_code = '';

		if( val.trim() ){
			if( !jQuery(this).parent('.field-item').next().hasClass('sbd_error_field') ){
				jQuery(this).parent('.field-item').after('<p class="sbd_error_field"></p>');
			}
			if( isNaN(val) ){
				error = 1;
				error_code = 'NaN';
			}
			if( error == 1 && error_code == 'NaN' ){

			}else{
				if( val > -180 && val < 180 ){
					//console.log('longitude is valid');
				}else{
					error = 1;
					error_code = 'invalid_long';
				}
			}
			if( error == 1 ){
				console.log(error_code);
				jQuery(this).parent('.field-item').next('.sbd_error_field').html('Please enter a valid Longitude');
				jQuery(this).parents('form#post').attr('onsubmit', 'return false');
				jQuery(this).parents('form#post').find('#publish').attr('disabled', true);
			}
		}
		if( error == 0){
			jQuery(this).parent('.field-item').next('.sbd_error_field').remove();
			if( !jQuery("input[name*='[qcpd_item_latitude]']").parent('.field-item').next().hasClass('sbd_error_field') ){
				jQuery(this).parents('form#post').removeAttr('onsubmit');
				jQuery(this).parents('form#post').find('#publish').removeAttr('disabled').removeClass('disabled');
			}
		}
	});


})



jQuery('#Reloadpage').click(function() {
    location.reload();
});


})(jQuery);
(function($){
    "use strict";

    jQuery(window).on('load',function(){

        //var sbd_originLeft = sbd_ajax_object.originLeft;

        //console.log(sbd_originLeft);
        
        jQuery('.qc-grid').packery({
            itemSelector: '.qc-grid-item',
            gutter: 10,
            originLeft: sbd_ajax_object.originLeft ? sbd_ajax_object.originLeft : false
        });
        setTimeout(function(){
    		jQuery(window).trigger('resize');    
        },200);

    });

    jQuery(window).resize(function()
    {
        
        jQuery('.qc-grid').packery({
            itemSelector: '.qc-grid-item',
            gutter: 10,
            originLeft: sbd_ajax_object.originLeft ? sbd_ajax_object.originLeft : false
        });

    });

        if(localStorage.getItem("qcld_google_undefined_check") != 1 && sbd_ajax_object.enable_gdpr_policies == 'on' ){

            jQuery('#sbd_all_location').after('<div class="qcld_gdpr_check"> <span>'+ sbd_ajax_object.gdpr_policies +'</span> <span class="qcld_gdpr_check_click"> '+ sbd_ajax_object.gdpr_load_map_lang +' </span></div>');
            jQuery('#sbd_all_location').hide();

            jQuery('#sbd_maponly_container').after('<div class="qcld_gdpr_check"> <span>'+ sbd_ajax_object.gdpr_policies +'</span> <span class="qcld_gdpr_check_click"> '+ sbd_ajax_object.gdpr_load_map_lang +' </span></div>');
            jQuery('#sbd_maponly_container').hide();
        }


    jQuery(document).ready(function($){


        $(document).on("click",".qcld_gdpr_check_click", function(event){

            localStorage.setItem("qcld_google_undefined_check", 1);
            location.reload(true);
        });


    	$("#filter").keyup(function(){
     
            // Retrieve the input field text and reset the count to zero
            var filter = $(this).val(), count = 0;
     
            // Loop through the comment list
            $("#opd-list-holder ul li").each(function(){
     
                // If the list item does not contain the text phrase fade it out
                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                    $(this).fadeOut();
     
                // Show the list item if the phrase matches and increase the count by 1
                } else {
                    $(this).show();
                    count++;
                }
            });
     
        });

    });


})(jQuery);
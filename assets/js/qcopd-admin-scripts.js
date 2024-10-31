(function($){
	"use strict";

	jQuery(function($) {

		var check_val = $('#qcpnd-sortable-table').length;

	    if(check_val > 0){

			$('#qcpnd-sortable-table tbody').sortable({
				axis: 'y',
				handle: '.column-order img',
				placeholder: 'ui-state-highlight',
				forcePlaceholderSize: true,
				update: function(event, ui) {
					var theOrder = $(this).sortable('toArray');

					var data = {
						action: 'pnd_update_post_order',
						postType: $(this).attr('data-post-type'),
						order: theOrder
					};

					$.post(ajaxurl, data);
				}
			}).disableSelection();

		}


	});

})(jQuery);
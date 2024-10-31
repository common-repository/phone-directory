(function($){
    "use strict";

	var geocoder;
	var map;
	var markers=[];
	var bounds = new google.maps.LatLngBounds();
	var iw;

	google.maps.event.addDomListener(window, "load", initialize);

	function initialize() {
		
		map = new google.maps.Map(
	    document.getElementById("sbd_all_location"), {
	      center: new google.maps.LatLng(37.4419, -122.1419),
	      zoom: 13,
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    });
		geocoder = new google.maps.Geocoder();
		myLoop();

	}



	var i = 0;                     

	function myLoop () {

		jQuery("#opd-list-holder ul li").each(function(){
			var obj = jQuery(this);
			if(obj.attr('data-latlon')!=='' && typeof(obj.attr('data-latlon'))!=='undefined'){
				i++;
				
				var locations = obj.attr('data-latlon');
				var latlng = locations.split(',');
				var title = obj.attr('data-title');
				var address = obj.attr('data-address');
				var url = obj.attr('data-url');
				var phone = obj.attr('data-phone');
				var img = obj.find('.list-img').html();

				//console.log(img);
				
				var map_marker_id = jQuery(this).attr('id');
				var marker = new google.maps.Marker({
					map: map,
					
					position:  new google.maps.LatLng(latlng[0],latlng[1]),
					title: title,
					animation: google.maps.Animation.DROP,
					address: address,
					url: url,
					mapSelectorID: map_marker_id
				});
				markers.push(marker);
				infoWindow(marker, map, title, address, url, phone, img);
				bounds.extend(marker.getPosition());
				map.fitBounds(bounds);
				
				
			}
			
		})

		/*for(var i=0;i<all_locations.length;i++){
			markerAddress(all_locations, i);
		}*/

	}


	function infoWindow( marker, map, title, address, url, phone, img ) {
	    google.maps.event.addListener(marker, 'mouseover', function () {
	    	if (iw) {
	  			iw.close();
	  		}

	        var html = "<div class='sbd_map_popup_view'>";
	        	html += "<h3>" + title + "</h3>";
	        	html += "<p class='sbd_map_img'>"+img+"<p><p>" + address + "</p><p>" + phone + "</p>";
	        	if(url!='' && url.length > 2){
		        	html += "<a href='" + url + "' target='_blank'>" + sbd_ajax_object.view_site_lan + "</a>";
		        }
	        	html += "</div>";

	        iw = new google.maps.InfoWindow({
	            content: html,
	            maxWidth: 350
	        });
	        marker.setAnimation(google.maps.Animation.BOUNCE);
			    iw.setZIndex(9999);
	        iw.open(map, marker);
	    });

	    google.maps.event.addListener(marker, 'click', function () {
	      marker.setAnimation(null);
	      if (iw) {
	        iw.close();
	      }
	        var html = "<div class='sbd_map_popup_view'>";
	        	html += "<h3>" + title + "</h3>";
	        	html += "<p class='sbd_map_img'>"+img+"<p><p>" + address + "</p><p>" + phone + "</p>";
	        	if(url!='' && url.length > 2){
		        	html += "<a href='" + url + "' target='_blank'>" + sbd_ajax_object.view_site_lan + "</a>";
		        }
	        	html += "</div>";

	        iw = new google.maps.InfoWindow({
	            content: html,
	            maxWidth: 350
	        });
	        // marker.setAnimation(google.maps.Animation.BOUNCE);
	        iw.setZIndex(9999);
	        iw.open(map, marker);
	    });

	    google.maps.event.addListener(marker, 'mouseout', function(){
	    	// iw.close();
	    	marker.setAnimation(null);
	    });
	}

	jQuery('.qc-grid-item ul li a:first-of-type').on('mouseover mousemove', function(){
		var selectorID = jQuery(this).parent('li').attr('id');
		SBDselectMarker( selectorID, 'start');
	});

	jQuery('.qc-grid-item ul li a:first-of-type').on('mouseout', function(){
		var selectorID = jQuery(this).parent('li').attr('id');
		SBDselectMarker( selectorID, 'stop');
	});

	function SBDselectMarker(mapSelectorID, status) {
	  var i, len, map_marker;
	  // Find the correct map_marker to change based on the storeId.
	  for (i = 0; i < markers.length; i++) {
	    // console.log(mapSelectorID);
	    if ( markers[i].mapSelectorID == mapSelectorID ) {
	      map_marker = markers[i];
	      if ( status == "start" ) {
	        map_marker.setAnimation(google.maps.Animation.BOUNCE);
	        google.maps.event.trigger(map_marker, 'mouseover');
	        // map.setCenter(map_marker.getPosition());
	      } else {
	        map_marker.setAnimation(null);
	        // iw.close();
	      }
	    }
	  }
	}


})(jQuery);
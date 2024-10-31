(function($){
    "use strict";

	jQuery(document).ready(function($){

		if(localStorage.getItem("qcld_google_maponly_undefined_check") != 1  && sld_variables_maponly.enable_gdpr_policies == 'on' ){

	        jQuery('#sbd_maponly_container').after('<div class="qcld_gdpr_check"> <span>'+ sld_variables_maponly.gdpr_policies +'</span> <span class="qcld_gdpr_check_click"> '+ sld_variables_maponly.gdpr_load_map_lang +' </span></div>');
	        jQuery('#sbd_maponly_container').hide();
	    }


	    $(document).on("click",".qcld_gdpr_check_click", function(event){

	        localStorage.setItem("qcld_google_maponly_undefined_check", 1);
	        location.reload(true);
	    });

	});

})(jQuery);

var geocoder;
var map;
var circle = null;
var mapmarkers = [];
var iw;
var bounds = new google.maps.LatLngBounds();
if(document.getElementById("sbd_maponly_container")!==null){
	google.maps.event.addDomListener(window, "load", mapinitialize);
}
var oms;
function mapinitialize() {
	
	map = new google.maps.Map(
    document.getElementById("sbd_maponly_container"), {
      center: new google.maps.LatLng(37.4419, -122.1419),
      zoom: 13,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
	  gestureHandling: 'cooperative'
    });
	
	geocoder = new google.maps.Geocoder();
	oms = new OverlappingMarkerSpiderfier(map, {
	  markersWontMove: true,
	  markersWontHide: true,
	  basicFormatEvents: true
	});
	mymapLoop(all_items);
	
	google.maps.event.addListener(map, "click", function(event) {
		
		jQuery('.gm-style-iw').each(function(){
			jQuery(this).next().click();
		})
		
	});
	
}               

function mymapLoop (items) {
	
	var mapmarkers = [];
	
	items.forEach(function(item) {
		if(item.latitude!=''){
			
			var markericon = '';
			if(sld_variables_maponly.global_marker!=''){
				markericon = sld_variables_maponly.global_marker;
			}
			if(typeof(item.paid)!='undefined' && item.paid!=''){
				markericon = sld_variables_maponly.paid_marker_default; //default paid marker
				if(sld_variables_maponly.paid_marker!=''){
					markericon = sld_variables_maponly.paid_marker; // If paid marker is set then override the default
				}
			}

			if(typeof(item.markericon)!='undefined' && item.markericon!=''){
				markericon = item.markericon; // If icon is set in the item it self. Most priority.
			}
			
			
			var marker = new google.maps.Marker({
				map: map,
				icon: markericon,
				position:  new google.maps.LatLng(item.latitude,item.longitude),
				title: item.title,
				animation: google.maps.Animation.DROP,
				address: item.fulladdress,
				url: item.link
			})
			mapmarkers.push(marker);
			
			var icon_html = "";
	
			if(item.phone!=''){
				icon_html +='<p><a href="tel:'+item.phone+'"><i class="fa fa-phone"></i></a></p>';
			}

			
			var others_info = '';
			if(item.location!=''){
				others_info +="<p><b><i class='fa fa-location-arrow' aria-hidden='true'></i> </b>"+item.location+"</p>";
			}
			if(item.phone!=''){
				others_info +="<p><b><i class='fa fa-phone' aria-hidden='true'></i> </b>"+item.phone+"</p>";
			}

			/*if(item.fulladdress!=''){
				icon_html +='<p><a target="_blank" href="https://www.google.com/maps/dir/?api=1&origin=none&destination='+encodeURIComponent(item.fulladdress)+'&travelmode=driving"><i class="fa fa-map"></i></a></p>';
			}*/
			
			
			mapinfoWindow(marker, map, item.title, item.fulladdress, item.link, item.subtitle, item.image, icon_html, others_info);
			bounds.extend(marker.getPosition());
			map.fitBounds(bounds);
		}
		
	});
	if(sld_variables_maponly.cluster){
		markerCluster = new MarkerClusterer(map, mapmarkers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
	}
	

}

var iw = new google.maps.InfoWindow({
        content: '',
        maxWidth: 230,
    });
// function mapinfoWindow(marker, map, title, address, url, subtitle, imgurl='', icons, others_info) {
//     google.maps.event.addListener(marker, 'click', function () {
// 		var contentString = "<div>";
		
// 		if(imgurl!='' && !sld_variables_maponly.image_infowindow){
// 			contentString += "<div class='sbd_pop_img'><img src='"+imgurl+"' /></div>";
// 		}
		
//         contentString += "<div class='sbd_pop_text'><h3>" + title + "</h3><p>" + subtitle + "</p>";
		
// 		if(address!=''){
// 			contentString+="<p><b><i class='fa fa-map-marker fa-map-marker-alt' aria-hidden='true'></i> </b>" + address + "</p>";
// 		}
// 		if(others_info!=''){
// 			contentString+=others_info;
// 		}
		
//         /*if(url!='' && url.length > 2){
// 			contentString +="<a href='" + url + "' target='_blank'>View Site</a></div></div>"
// 		}*/
		
// 		contentString +="</div></div>"
// 		contentString +="<div class='sbd_bottom_area_marker'>"+icons+"</div>";
		
// 		contentString+="</div></div>";
// 		// iw = new google.maps.InfoWindow({
//   //           content: '',
//   //           maxWidth: 230,
			
//   //       });
// 		iw.close();
//         iw.setContent(contentString);
// 		iw.setZIndex(9999);
//         iw.open(map, marker);
//         console.log(marker);
//     });
// 	oms.addMarker(marker);
// }

function mapinfoWindow(marker, map, title, address, url) {
    google.maps.event.addListener(marker, 'mouseover', function () {
    	if (iw) {
			iw.close();
		}
        var html = "<div>";
        	html += "<h3>" + title + "</h3>";
        	html += "<p>" + address + "</p>";
        	if(url!='' && url.length > 2){
	        	html += "<a href='" + url + "'>"+sld_variables_maponly.view_site_lan+"</a>";
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
    	if (iw) {
			iw.close();
		}
        var html = "<div>";
        	html += "<h3>" + title + "</h3>";
        	html += "<p>" + address + "</p>";
        	if(url!='' && url.length > 2){
	        	html += "<a href='" + url + "'>"+sld_variables_maponly.view_site_lan+"</a>";
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

    google.maps.event.addListener(marker, 'mouseout', function(){
    	// iw.close();
    	marker.setAnimation(null);
    });
}

function clearmarker(){
	for (var i = 0; i < mapmarkers.length; i++) {
	  mapmarkers[i].setMap(null);
	}
}

function sbdradius_(){
	
	var address = jQuery('.sbd_location_name:visible').val();
	var radiusi = jQuery('.sbd_distance:visible').val();
	
	if(address==''){
		alert(sld_variables.distance_location_text);
		return;
	}
	
	if(radiusi==''){
		alert(sld_variables.distance_value_text);
		return;
	}
	
	if(jQuery('.sdb_distance_cal').val()=='miles'){
		 radiusi = radiusi * 1.60934;
	}
	

	var radius = parseInt( radiusi, 10 ) * 1000;
	

	//google map code
	map = new google.maps.Map(
	document.getElementById("sbd_maponly_container"), {
		center: new google.maps.LatLng(parseInt(sld_variables_maponly.latitute), parseInt(sld_variables_maponly.longitute)),
		zoom: parseInt(sld_variables.zoom),
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		gestureHandling: 'cooperative'
	});
	oms = new OverlappingMarkerSpiderfier(map, {
	  markersWontMove: true,
	  markersWontHide: true,
	  basicFormatEvents: true
	});
	
	geocoder.geocode( { 'address': address}, function(results, status) {
	  if (status == google.maps.GeocoderStatus.OK) {
		  

		map.setCenter(results[0].geometry.location);
		var searchCenter = results[0].geometry.location;
		
		if (circle) circle.setMap(null);
		circle = new google.maps.Circle({center:searchCenter,
			radius: radius,

			strokeColor: sld_variables.radius_circle_color,
			strokeOpacity: 0.8,
			strokeWeight: 2,
			fillColor: sld_variables.radius_circle_color,
			fillOpacity: 0.35,

			map: map});

		clearmarker();
		var mapmarkers=[];
		
		all_items.forEach(function(item){
			if(item.latitude!=''){
				if (google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(item.latitude,item.longitude),searchCenter) < radius) {
					
					var markericon = '';
					if(sld_variables_maponly.global_marker!=''){
						markericon = sld_variables_maponly.global_marker;
					}
					if(typeof(item.paid)!='undefined' && item.paid!=''){
						markericon = sld_variables_maponly.paid_marker_default; //default paid marker
						if(sld_variables_maponly.paid_marker!=''){
							markericon = sld_variables_maponly.paid_marker; // If paid marker is set then override the default
						}
					}

					if(typeof(item.markericon)!='undefined' && item.markericon!=''){
						markericon = item.markericon; // If icon is set in the item it self. Most priority.
					}
					
					var marker = new google.maps.Marker({
						map: map,
						icon: markericon,
						position:  new google.maps.LatLng(item.latitude,item.longitude),
						title: item.title,
						animation: google.maps.Animation.DROP,
						address: item.fulladdress,
						url: item.link
					})
					mapmarkers.push(marker);
					var icon_html = "";
					if(item.item_details_page!=''){
						icon_html +='<p><a href="'+item.item_details_page+'"><i class="fa fa-external-link-square fa-external-link-square-alt"></i></a></p>';
					}
					if(item.phone!=''){
						icon_html +='<p><a href="tel:'+item.phone+'"><i class="fa fa-phone"></i></a></p>';
					}
					if(item.link!=''){
						icon_html +='<p><a href="'+item.link+'" target="_blank"><i class="fa fa-link"></i></a></p>';
					}
					if(item.facebook!=''){
						icon_html +='<p><a target="_blank" href="'+item.facebook+'"><i class="fa fa-facebook"></i></a></p>';
					}
					if(item.yelp!=''){
						icon_html +='<p><a target="_blank" href="'+item.yelp+'"><i class="fa fa-yelp"></i></a></p>';
					}
					if(item.email!=''){
						icon_html +='<p><a href="mailto:'+item.email+'"><i class="fa fa-envelope"></i></a></p>';
					}
					if(item.linkedin!=''){
						icon_html +='<p><a target="_blank" href="'+item.linkedin+'"><i class="fa fa-linkedin-square fa-linkedin"></i></a></p>';
					}
					if(item.twitter!=''){
						icon_html +='<p><a target="_blank" href="'+item.twitter+'"><i class="fa fa-twitter-square"></i></a></p>';
					}
					if(item.custom_body_icon!=''){
						icon_html +=item.custom_body_icon;
					}
					
					var others_info = '';
					if(item.location!=''){
						others_info +="<p><b><i class='fa fa-location-arrow' aria-hidden='true'></i> </b>"+item.location+"</p>";
					}
					if(item.phone!=''){
						others_info +="<p><b><i class='fa fa-phone' aria-hidden='true'></i> </b>"+item.phone+"</p>";
					}
					if(item.business!=''){
						others_info +="<p><b><i class='fa fa-clock-o fa-clock' aria-hidden='true'></i> </b>"+item.business+"</p>";
					}
					if(item.custom_body_content!=''){
						others_info +=item.custom_body_content;
					}
					/*if(item.fulladdress!=''){
						icon_html +='<p><a target="_blank" href="https://www.google.com/maps/dir/?api=1&origin=none&destination='+encodeURIComponent(item.fulladdress)+'&travelmode=driving"><i class="fa fa-map"></i></a></p>';
					}*/
					
					
					mapinfoWindow(marker, map, item.title, item.fulladdress, item.link, item.subtitle, item.image, icon_html, others_info);
							bounds.extend(marker.getPosition());
							map.fitBounds(bounds);
							
						}
					}
						
				})
				
				map.fitBounds(circle.getBounds());
		
	  		} else {
				console.log('Geocode was not successful for the following reason: ' + status);
				setTimeout(function(){
					sbdradius_();
				}, 1500);
	  		}

		});

	google.maps.event.addListener(map, "click", function(event) {
		
		jQuery('.gm-style-iw').each(function(){
			jQuery(this).next().click();
		})
		
	});
	
}
function sbdclearradius_(){
	mapinitialize();
}


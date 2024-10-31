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

	if(document.getElementById("sbd_maponly_container")!==null){

		var geocoder;
		var map;
		var circle;
		var circle = null;
		var markers = [];
		var iw;

		var mapCreate = null;
		var markerClusters;

		var lat = parseInt(37.4419 );
		var lon = parseInt(-122.1419);

	  	mapCreate = L.map('sbd_maponly_container').setView([37.4419, -122.1419], 12);
	  	markerClusters = L.markerClusterGroup(); 

	  	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			minZoom: 1,
			maxZoom: 50,
			attribution: '',
			key: 'BC9A493B41014CAABB98F0471D759707'
		}).addTo(mapCreate);

		
		maponly_Loop(all_items);
		

		setTimeout(function () {
		   mapCreate.invalidateSize(true);
		}, 1000);

	}


	function maponly_Loop(items) {
		
		var mapmarkers = [];

		
		items.forEach(function(item) {
			if(item.latitude!=''){
			//console.log(items);
				
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

				var map_marker_id = item.map_marker_id;


					var maplatlang = maponly_infoWindow(marker, map, item.title, item.fulladdress, item.link, item.subtitle, item.image, icon_html, others_info);

					mapCreate.panTo(new L.LatLng(item.latitude, item.longitude), 13);

					var marker = L.marker([ item.latitude, item.longitude ],{title:map_marker_id} ); 
						
					marker.addTo(mapCreate).bindPopup(maplatlang, {closeOnClick: true, autoClose: true, showOnMouseOver: true, autoPan:false} ).closePopup();
						
					
					markerClusters.clearLayers();
					markers.push(marker);

					var isClicked = false;

					marker.on({
					    mouseover: function(e){
				        for (var i in markers){
				            var markerID = markers[i].options.title;
				            if (markerID == e.target.options.title ){
				                markers[i].openPopup();
				        		
				            }else{
				                markers[i].closePopup();
				            };
				        }

					    },
					    
					});

					var group = new L.featureGroup(markers);
					if(markers.length > 1){
						mapCreate.fitBounds(group.getBounds().pad(1));
					}


			}
			
		});
		

	}



	function maponly_infoWindow(marker, map, title, address, url) {
	
			
		var html = "<div>";
		html += "<h3>" + title + "</h3>";
		html += "<p>" + address + "</p>";
		if(url!='' && url.length > 2){
			html += "<a href='" + url + "'>"+sld_variables_maponly.view_site_lan+"</a>";
		}
		html += "</div>";

		return html;


	}


	function SBD_Maponly_Marker(id, status){

        for (var i in markers){
            var markerID = markers[i].options.title;
            if (markerID == id && status == "start"){
                markers[i].openPopup();
        		
            }else{
                markers[i].closePopup();
            };
        }
    }



	jQuery('.qc-grid-item ul li a:first-of-type').on('mouseover mousemove', function(){
		var selectorID = jQuery(this).parent('li').attr('id');
		SBD_Maponly_Marker( selectorID, 'start');
	});


})(jQuery);
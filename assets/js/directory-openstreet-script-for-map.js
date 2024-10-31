(function($){
    "use strict";
    
	if(document.getElementById("sbd_all_location")!==null){

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

	  	mapCreate = L.map('sbd_all_location').setView([37.4419, -122.1419], 13);
	  	markerClusters = L.markerClusterGroup(); 

	  	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			minZoom: 1,
			maxZoom: 50,
			attribution: '',
			key: 'BC9A493B41014CAABB98F0471D759707'
		}).addTo(mapCreate);

	
		initMapForSBD();
		

		setTimeout(function () {
		   mapCreate.invalidateSize(true);
		}, 1000);

	}

	function initMapForSBD() {

	  myLoopLatLangs(mapCreate);

	}

	var i = 0;  

	function myLoopLatLangs(){

			
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
				
				var map_marker_id = jQuery(this).attr('id');
				

				var maplatlang = infoWindow(marker, map, title, address, url, phone, img);

				mapCreate.panTo(new L.LatLng(latlng[0], latlng[1]), 13);

				var marker = L.marker([ latlng[0], latlng[1] ],{title:map_marker_id} ); 
					

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


			})
	

	}

	
	function infoWindow(marker, map, title, address, url, phone, img) {
	
			
		//var html = "<div><h3>" + title + "</h3><p>" + address + "</p><a href='" + url + "'>" + sbd_ajax_object.view_site_lan + "</a></div>";

		var html = "<div class='sbd_map_popup_view'><h3>" + title + "</h3><p class='sbd_map_img'>"+img+"<p><p>" + address + "</p><p>" + phone + "</p><a href='" + url + "' target='_blank'>" + sbd_ajax_object.view_site_lan + "</a></div>";

		return html;


	}


	function SBDselectOpenStreetMarker(id, status){

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
		SBDselectOpenStreetMarker( selectorID, 'start');


	});


})(jQuery);
// This example requires the Places library. Include the libraries=places
   // parameter when you first load the API. For example:
   // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
   var map ;
   function initMap() {

     var markersArray = [];
     var marker_lat = Number(document.getElementById('marker_lat').value); 
     var marker_long = Number(document.getElementById('marker_long').value); 
     
     var lat_input  =  document.getElementById('lat_input').value ; 
     var long_input =  document.getElementById('long_input').value; 
     
    if(lat_input !='' && long_input!='')
    { lat_input=Number(lat_input);long_input=Number(long_input); }
    else { var lat_input = 29.949470; var long_input = 31.267163; }
     

     
     map = new google.maps.Map(document.getElementById('map'), {
       center: {lat: lat_input, lng: long_input},
       zoom: 12
     });
     var card = document.getElementById('pac-card');
     var input = document.getElementById('pac-input');
     var countries = document.getElementById('country-selector');

     map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
     //place Marker in edit mode 
     if(marker_lat!='' && marker_long!='')
     { placeMarker({lat: marker_lat, lng: marker_long}); }
     AutoComplete(input,map);
     // Sets a listener on a given radio button. The radio buttons specify
     // the countries used to restrict the autocomplete search.
         google.maps.event.addListener(map, "click", function(event)
         {
             // place a marker
             placeMarker(event.latLng);
            //  // display the lat/lng in your form's lat/lng fields
             document.getElementById("marker_lat").value = event.latLng.lat();
             document.getElementById("marker_long").value = event.latLng.lng();
         });

         function placeMarker(location) {
             // first remove all markers if there are any
             deleteOverlays();

             var marker = new google.maps.Marker({
                 position: location,
                 map: map
             });
             // add marker in markers array
             markersArray.push(marker);
         }

         // Deletes all markers in the array by removing references to them
         function deleteOverlays() {
             if (markersArray) {
                 for (i in markersArray) {
                     markersArray[i].setMap(null);
                 }
             markersArray.length = 0;
             }
         }
   }
   
   function AutoComplete(input,map)
   {
       
        var autocomplete = new google.maps.places.Autocomplete(input,
        {types: ['(cities)'],componentRestrictions: {country: "eg"} });

     // Set initial restrict to the greater list of countries.
//     autocomplete.setComponentRestrictions(
//         {'country': ['eg']});

     var infowindow = new google.maps.InfoWindow();
     var infowindowContent = document.getElementById('infowindow-content');
     infowindow.setContent(infowindowContent);
     var marker = new google.maps.Marker({
       map: map,
       anchorPoint: new google.maps.Point(0, -29)
     });

     autocomplete.addListener('place_changed', function() {
       infowindow.close();
       marker.setVisible(false);
       var place = autocomplete.getPlace();
       if (!place.geometry) {
         // User entered the name of a Place that was not suggested and
         // pressed the Enter key, or the Place Details request failed.
         window.alert("No details available for input: '" + place.name + "'");
         return;
       }
       //
       var geocoder = new google.maps.Geocoder;
       for (var i = 0; i < place.address_components.length; i++)
       {
         var addr = place.address_components[i];
         switch(addr.types[0])
         {
             case 'country':
                GetAddressLatLng(addr.long_name,'country_lat_long');
             break;
             case 'administrative_area_level_1':
                GetAddressLatLng(addr.long_name,'city_lat_long');
             break;
             case 'administrative_area_level_2':
                  GetAddressLatLng(addr.long_name,'area_lat_long');
             break;
         }  
         var addr = place.address_components[i];
         if (addr.types[0] == "country")
         { $("#country_name").val(addr.long_name); }
         if (addr.types[0] == "administrative_area_level_1")
         {
         
            if (status == google.maps.GeocoderStatus.OK) {
                geocoder.geocode( {'address': addr.long_name}, function(results, status) {
                    results[0].geometry.location.lat().results[0].geometry.location.lng()
                });
            }
           $("#city_name").val(addr.long_name);
         }
       }
       $("#long_input").val(place.geometry.location.lng());
       $("#lat_input").val(place.geometry.location.lat());
       $("#formatted_address").val(place.formatted_address);
       //
       // If the place has a geometry, then present it on a map.
       if (place.geometry.viewport) {
         map.fitBounds(place.geometry.viewport);
       } else {
         map.setCenter(place.geometry.location);
         map.setZoom(17);  // Why 17? Because it looks good.
       }
       var address = '';
       if (place.address_components) {
         address = [
           (place.address_components[0] && place.address_components[0].short_name || ''),
           (place.address_components[1] && place.address_components[1].short_name || ''),
           (place.address_components[2] && place.address_components[2].short_name || '')
         ].join(' ');
       }

       infowindowContent.children['place-icon'].src = place.icon;
       infowindowContent.children['place-name'].textContent = place.name;
       infowindowContent.children['place-address'].textContent = address;
       infowindow.open(map, marker);
     });
   
       
   }
   
   function AutoCompleteSearch()
   {
    var input = document.getElementById('location');
    var autocomplete = new google.maps.places.Autocomplete(input,{types: ['(cities)'],componentRestrictions: {country: "eg"} });
    autocomplete.setComponentRestrictions({'country': ['eg']});
    autocomplete.addListener('place_changed', function() {
    var place = autocomplete.getPlace();
    if (!place.geometry) { window.alert("No details available for input: '" + place.name + "'"); return; }
   
    var LocationSearch=[];
       for (var i = 0; i < place.address_components.length; i++)
       {
         var addr = place.address_components[i];
         switch(addr.types[0])
         {
             case 'country':
                GetAddressLatLng(addr.long_name,'country_lat_long');
             break;
             case 'administrative_area_level_1':
                GetAddressLatLng(addr.long_name,'city_lat_long');
             break;
             case 'administrative_area_level_2':
                  GetAddressLatLng(addr.long_name,'area_lat_long');
             break;
         }
       }
       
     });
   
   }
   function AutoCompleteSearchCity(id,citylatlongid,formatted_address)
   {
    if(document.getElementById(id) !==null)   
    {
        var input = document.getElementById(id);
        var autocomplete = new google.maps.places.Autocomplete(input,{types: ['(cities)'],componentRestrictions: {country: "eg"} });
        autocomplete.setComponentRestrictions({'country': ['eg']});
        autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        if (!place.geometry) { window.alert("No details available for input: '" + place.name + "'"); return; }

        var LocationSearch=[];
           for (var i = 0; i < place.address_components.length; i++)
           {
             var addr = place.address_components[i];
             switch(addr.types[0])
             {
                 case 'administrative_area_level_1':
                    GetAddressLatLng(addr.long_name,citylatlongid);
                    $(formatted_address).val(place.formatted_address);
                 break;
             }
           }

         });
    }
   }
   function GetAddressLatLng(addressLongName,LocationName)
   {            
        var geocoder = new google.maps.Geocoder;
         geocoder.geocode( {'address': addressLongName}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) { $('#'+LocationName).val(results[0].geometry.location.lat()+','+results[0].geometry.location.lat()) ; }
         });
   }
   
//   function LocationRange()
//   {
//       var map = new google.maps.Map(document.getElementById('map'), {center: {lat: 30.044420, lng: 31.235712}, zoom: 5 });
//       var marker = new google.maps.Marker({
//       map: map,
//       position: new google.maps.LatLng(53, -2.5),
//       title: 'Some location'
//     });
//
//    // Add circle overlay and bind to marker
//    var circle = new google.maps.Circle({map: map,radius: 16093,fillColor: '#00a899'});
//    //circle.bindTo('center', marker, 'position');
//   }
  function RunMaps()
  {
      if (typeof findagigMapFunctions!="undefined") {
        findagigMapFunctions();
        if(typeof CustomMapFunctions === "function")
        {
            CustomMapFunctions();
        }
      }
      if (typeof postagigMapFunctions!="undefined") {
        postagigMapFunctions();
        if(typeof CustomMapFunctions === "function")
        {
            CustomMapFunctions();
        }
      }
      if (typeof CommonMapFunctions!="undefined") {
        CommonMapFunctions();
        if(typeof CustomMapFunctions === "function")
        {
            CustomMapFunctions();
        }
      }
      
  }

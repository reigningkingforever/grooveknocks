function MapboxLanguage(t){if(t=Object.assign({},t),!(this instanceof MapboxLanguage))throw new Error("MapboxLanguage needs to be called with the new keyword");this.setLanguage=this.setLanguage.bind(this),this._initialStyleUpdate=this._initialStyleUpdate.bind(this),this._defaultLanguage=t.defaultLanguage,this._isLanguageField=t.languageField||/^\{name/,this._getLanguageField=t.getLanguageField||function(t){return"mul"===t?"{name}":"{name_"+t+"}"},this._languageSource=t.languageSource||null,this._languageTransform=t.languageTransform||function(t,e){return"ar"===e?MapboxLngNoSpacing(t):MapboxLngStandardSpacing(t)},this._excludedLayerIds=t.excludedLayerIds||[],this.supportedLanguages=t.supportedLanguages||["ar","en","es","fr","de","ja","ko","mul","pt","ru","zh"]}function MapboxLngStandardSpacing(t){var e=t.layers.map(function(t){if(!(t.layout||{})["text-field"])return t;var e=0;return"state_label"===t["source-layer"]&&(e=.15),"marine_label"===t["source-layer"]&&(/-lg/.test(t.id)&&(e=.25),/-md/.test(t.id)&&(e=.15),/-sm/.test(t.id)&&(e=.1)),"place_label"===t["source-layer"]&&(/-suburb/.test(t.id)&&(e=.15),/-neighbour/.test(t.id)&&(e=.1),/-islet/.test(t.id)&&(e=.01)),"airport_label"===t["source-layer"]&&(e=.01),"rail_station_label"===t["source-layer"]&&(e=.01),"poi_label"===t["source-layer"]&&/-scalerank/.test(t.id)&&(e=.01),"road_label"===t["source-layer"]&&(/-label-/.test(t.id)&&(e=.01),/-shields/.test(t.id)&&(e=.05)),Object.assign({},t,{layout:Object.assign({},t.layout,{"text-letter-spacing":e})})});return Object.assign({},t,{layers:e})}function MapboxLngNoSpacing(t){var e=t.layers.map(function(t){if(!(t.layout||{})["text-field"])return t;return Object.assign({},t,{layout:Object.assign({},t.layout,{"text-letter-spacing":0})})});return Object.assign({},t,{layers:e})}function MapboxLngIsNameStringField(t,e){return"string"==typeof e&&t.test(e)}function MapboxLngIsNameFunctionField(t,e){return e.stops&&e.stops.filter(function(e){return t.test(e[1])}).length>0}function MapboxLngAdaptPropertyLanguage(t,e,i){if(MapboxLngIsNameStringField(t,e))return i;if(MapboxLngIsNameFunctionField(t,e)){var n=e.stops.map(function(e){return t.test(e[1])?[e[0],i]:e});return Object.assign({},e,{stops:n})}return e}function MapboxLngChangeLayerTextProperty(t,e,i,n){return e.layout&&e.layout["text-field"]&&-1===n.indexOf(e.id)?Object.assign({},e,{layout:Object.assign({},e.layout,{"text-field":MapboxLngAdaptPropertyLanguage(t,e.layout["text-field"],i)})}):e}function MapboxLngFindStreetsSource(t){return Object.keys(t.sources).filter(function(e){var i=t.sources[e];return/mapbox-streets-v\d/.test(i.url)})[0]}function MapboxLngBrowserLanguage(t){var e=navigator.languages?navigator.languages[0]:navigator.language||navigator.userLanguage,i=e.split("-"),n=e;return i.length>1&&(n=i[0]),t.indexOf(n)>-1?n:null}function MapboxLngIe11Polyfill(){"function"!=typeof Object.assign&&Object.defineProperty(Object,"assign",{value:function(t,e){"use strict";if(null===t)throw new TypeError("Cannot convert undefined or null to object");for(var i=Object(t),n=1;n<arguments.length;n++){var o=arguments[n];if(null!==o)for(var s in o)Object.prototype.hasOwnProperty.call(o,s)&&(i[s]=o[s])}return i},writable:!0,configurable:!0})}MyListing.Maps={options:{locations:[],zoom:12,minZoom:0,skin:"skin1",marker_type:"basic",gestureHandling:"greedy",cluster_markers:!0,draggable:!0,scrollwheel:!1},instances:[],skins:[],init:function(){},getInstance:function(t){var e=MyListing.Maps.instances.filter(function(e){return e.id==t});return!(!e||!e.length)&&e[0]}},jQuery(function(t){t('.form-location-autocomplete, input[name="job_location"], input[name="_job_location"]').each(function(t,e){new MyListing.Maps.Autocomplete(e)}),MyListing.Geocoder=new MyListing.Maps.Geocoder,t(".cts-get-location").click(function(e){e.preventDefault();var i=t(t(this).data("input")),n=t(this).data("map"),o=null;i.length&&(n.length&&(o=MyListing.Maps.getInstance(n))&&MyListing.Geocoder.setMap(o.instance),MyListing.Geocoder.getUserLocation({receivedAddress:function(t){if(i.val(t.address),i.data("autocomplete"))return i.data("autocomplete").fireChangeEvent(t)}}))})}),jQuery(function(t){t(document).on("maps:loaded",function(){if(document.getElementById("location-picker-map")){var e=MyListing.Maps.getInstance("location-picker-map").instance,i=t(".location-field-wrapper"),n=i.find(".location-coords"),o=i.find(".latitude-input"),s=i.find(".longitude-input"),a=i.find(".address-input"),r=i.find('.lock-pin input[type="checkbox"]'),p=i.find(".enter-coordinates-toggle > span");e.setCenter(new MyListing.Maps.LatLng(o.val(),s.val()));var u=new MyListing.Maps.Marker({position:new MyListing.Maps.LatLng(o.val(),s.val()),map:e,template:{type:"traditional"}});e.addListener("click",function(t){if(!r.prop("checked")){var i=e.getClickPosition(t);u.setPosition(i),o.val(i.getLatitude()),s.val(i.getLongitude()),MyListing.Geocoder.geocode(i.toGeocoderFormat(),function(t){t&&a.val(t.address)})}}),a.on("autocomplete:change",function(t){if(!r.prop("checked")&&t.detail.place&&t.detail.place.latitude&&t.detail.place.longitude){var i=new MyListing.Maps.LatLng(t.detail.place.latitude,t.detail.place.longitude);u.setPosition(i),o.val(t.detail.place.latitude),s.val(t.detail.place.longitude),e.panTo(i)}}),e.addListenerOnce("idle",function(t){o.val().trim()&&s.val().trim()&&e.setZoom(12)}),r.on("change",function(t){e.trigger("resize"),e.setCenter(new MyListing.Maps.LatLng(o.val(),s.val()))}).change(),p.click(function(t){n.toggleClass("hide")}),o.blur(c),s.blur(c)}function c(){var t=new MyListing.Maps.LatLng(o.val(),s.val());u.setPosition(t),o.val(t.getLatitude()),s.val(t.getLongitude()),e.panTo(t)}})}),MyListing.Maps.Autocomplete=function(t){jQuery(t).data("autocomplete",this),this.init(t)},MyListing.Maps.Autocomplete.prototype.init=function(t){},MyListing.Maps.Autocomplete.prototype.fireChangeEvent=function(t){var e=document.createEvent("CustomEvent");e.initCustomEvent("autocomplete:change",!1,!0,{place:t||!1}),this.el.dispatchEvent(e)},MyListing.Maps.Clusterer=function(t){this.init(t)},MyListing.Maps.Clusterer.prototype.init=function(t){},MyListing.Maps.Geocoder=function(){this.init()},MyListing.Maps.Geocoder.prototype.init=function(){},MyListing.Maps.Geocoder.prototype.geocode=function(t,e,i){},MyListing.Maps.Geocoder.prototype.formatFeature=function(t){},MyListing.Maps.Geocoder.prototype.getUserLocation=function(t){if(navigator.geolocation){t=jQuery.extend({shouldFetchAddress:!0,receivedCoordinates:!1,receivedAddress:!1,geolocationFailed:!1},t);navigator.geolocation.getCurrentPosition(function(e){if("function"==typeof t.receivedCoordinates&&t.receivedCoordinates(e),!1!==t.shouldFetchAddress){var i=new MyListing.Maps.LatLng(e.coords.latitude,e.coords.longitude);MyListing.Geocoder.geocode(i.toGeocoderFormat(),function(e){if(!e)return console.log("Couldn't determine your location."),void("function"==typeof t.geolocationFailed&&t.geolocationFailed());"function"==typeof t.receivedAddress&&t.receivedAddress(e)})}})}else alert("Geolocation is not supported by this browser.")},MyListing.Maps.Geocoder.prototype.setMap=function(t){this.map=t},MyListing.Maps.Map=function(t){this.init(t)},MyListing.Maps.Map.prototype.init=function(){},MyListing.Maps.Map.prototype.setZoom=function(t){},MyListing.Maps.Map.prototype.getZoom=function(){},MyListing.Maps.Map.prototype.setCenter=function(t){},MyListing.Maps.Map.prototype.fitBounds=function(t){},MyListing.Maps.Map.prototype.panTo=function(t){},MyListing.Maps.Map.prototype.getClickPosition=function(t){},MyListing.Maps.Map.prototype.addListener=function(t,e){},MyListing.Maps.Map.prototype.addListenerOnce=function(t,e){},MyListing.Maps.Map.prototype.trigger=function(t){},MyListing.Maps.Map.prototype.getSourceObject=function(){return this.map},MyListing.Maps.Map.prototype.getSourceEvent=function(t){return void 0!==this.events[t]?this.events[t]:t},MyListing.Maps.Map.prototype.closePopups=function(){for(var t=0;t<this.markers.length;t++)"object"==typeof this.markers[t].options.popup&&this.markers[t].options.popup.hide()},MyListing.Maps.Map.prototype.removeMarkers=function(){for(var t=0;t<this.markers.length;t++)this.markers[t].remove();this.markers.length=0,this.markers=[]},MyListing.Maps.Map.prototype._maybeAddMarkers=function(){var t=this;if(t.markers=[],t.trigger("updating_markers"),"custom-locations"==t.options.items_type&&t.options.locations.length){"basic"==t.options.marker_type&&t.options.locations.forEach(function(e){t._addBasicMarker(e)}),"advanced"==t.options.marker_type&&t.options.locations.forEach(function(e){var i=new MyListing.Maps.Marker({position:new MyListing.Maps.LatLng(e.marker_lat,e.marker_lng),map:t,popup:new MyListing.Maps.Popup,template:{type:"advanced",thumbnail:e.marker_image.url}});t.markers.push(i),t.bounds.extend(i.getPosition())});var e=function(t){this.getZoom()>15&&this.setZoom(this.options.zoom)};t.addListenerOnce("zoom_changed",e.bind(t)),t.addListenerOnce("bounds_changed",e.bind(t)),t.fitBounds(t.bounds),t.trigger("updated_markers")}"listings"==t.options.items_type&&t.options.listings_query.lat&&t.options.listings_query.lng&&t.options.listings_query.radius&&t.options.listings_query.listing_type&&t.options._section_id&&this._addMarkersThroughQuery()},MyListing.Maps.Map.prototype._addBasicMarker=function(t){var e=this;if(t.address)MyListing.Geocoder.geocode(t.address,function(i){if(!i)return!1;var n=new MyListing.Maps.Marker({position:new MyListing.Maps.LatLng(i.latitude,i.longitude),map:e,template:{type:"basic",thumbnail:t.marker_image.url}});e.markers.push(n),e.bounds.extend(n.getPosition()),e.fitBounds(e.bounds),e.setZoom(e.options.zoom)});else{var i=new MyListing.Maps.Marker({position:new MyListing.Maps.LatLng(t.marker_lat,t.marker_lng),map:e,template:{type:"basic",thumbnail:t.marker_image.url}});e.markers.push(i),e.bounds.extend(i.getPosition())}},MyListing.Maps.Map.prototype._addMarkersThroughQuery=function(){var t=this;jQuery.ajax({url:CASE27.ajax_url+"?action=get_listings&security="+CASE27.ajax_nonce,type:"POST",dataType:"json",data:{listing_type:t.options.listings_query.listing_type,form_data:{proximity:t.options.listings_query.radius,search_location_lat:t.options.listings_query.lat,search_location_lng:t.options.listings_query.lng,search_location:"radius search",per_page:t.options.listings_query.count}},success:function(e){jQuery("#"+t.options._section_id).find(".c27-map-listings").html(e.html),jQuery("#"+t.options._section_id).find(".c27-map-listings .lf-item-container").each(function(e,i){var n=jQuery(i);if(n.data("latitude")&&n.data("longitude")){var o=new MyListing.Maps.Marker({position:new MyListing.Maps.LatLng(n.data("latitude"),n.data("longitude")),map:t,popup:new MyListing.Maps.Popup({content:'<div class="lf-item-container lf-type-2">'+n.html()+"</div>"}),template:{type:"advanced",thumbnail:n.data("thumbnail"),icon_name:n.data("category-icon"),icon_color:n.data("category-text-color"),icon_background_color:n.data("category-color"),listing_id:n.data("id")}});t.markers.push(o),t.bounds.extend(o.getPosition())}}),jQuery(".lf-background-carousel").owlCarousel({margin:20,items:1,loop:!0}),t.fitBounds(t.bounds),t.trigger("updated_markers")}})},MyListing.Maps.Marker=function(t){this.options=jQuery.extend(!0,{position:!1,map:!1,popup:!1,template:{type:"basic",icon_name:"",icon_color:"",icon_background_color:"",listing_id:"",thumbnail:""}},t),this.init(t)},MyListing.Maps.Marker.prototype.init=function(t){},MyListing.Maps.Marker.prototype.getPosition=function(){},MyListing.Maps.Marker.prototype.setPosition=function(t){},MyListing.Maps.Marker.prototype.setMap=function(t){},MyListing.Maps.Marker.prototype.remove=function(){},MyListing.Maps.Marker.prototype.getTemplate=function(){var t=document.createElement("div");t.className="marker-container",t.style.position="absolute",t.style.cursor="pointer",t.style.zIndex=10;var e="";return"basic"==this.options.template.type&&(e=jQuery("#case27-basic-marker-template").html().replace("{{marker-bg}}",this.options.template.thumbnail)),"traditional"==this.options.template.type&&(e=jQuery("#case27-traditional-marker-template").html()),"advanced"==this.options.template.type&&(e=jQuery("#case27-marker-template").html().replace("{{icon}}",this.options.template.icon_name).replace("{{icon-bg}}",this.options.template.icon_background_color).replace("{{listing-id}}",this.options.template.listing_id).replace("{{marker-bg}}",this.options.template.thumbnail).replace("{{icon-color}}",this.options.template.icon_color)),jQuery(t).append(e),t},MyListing.Maps.Popup=function(t){this.options=jQuery.extend(!0,{content:"",classes:"cts-map-popup cts-listing-popup infoBox cts-popup-hidden",position:!1,map:!1},t),this.init(t)},MyListing.Maps.Popup.prototype.init=function(t){},MyListing.Maps.Popup.prototype.setContent=function(t){},MyListing.Maps.Popup.prototype.setPosition=function(t){},MyListing.Maps.Popup.prototype.setMap=function(t){},MyListing.Maps.Popup.prototype.remove=function(){},MyListing.Maps.Popup.prototype.show=function(){},MyListing.Maps.Popup.prototype.hide=function(){},MyListing.Maps.LatLng=function(t,e){this.init(t,e)},MyListing.Maps.LatLng.prototype.init=function(t,e){},MyListing.Maps.LatLng.prototype.getLatitude=function(){},MyListing.Maps.LatLng.prototype.getLongitude=function(){},MyListing.Maps.LatLng.prototype.toGeocoderFormat=function(){},MyListing.Maps.LatLng.prototype.getSourceObject=function(){return this.latlng},MyListing.Maps.LatLngBounds=function(t,e){this.init(t,e)},MyListing.Maps.LatLngBounds.prototype.init=function(t,e){},MyListing.Maps.LatLngBounds.prototype.extend=function(t){},MyListing.Maps.LatLngBounds.prototype.getSourceObject=function(){return this.bounds},MapboxLanguage.prototype.setLanguage=function(t,e){if(this.supportedLanguages.indexOf(e)<0)throw new Error("Language "+e+" is not supported");var i=this._languageSource||MapboxLngFindStreetsSource(t);if(!i)return t;var n=this._getLanguageField(e),o=this._isLanguageField,s=this._excludedLayerIds,a=t.layers.map(function(t){return t.source===i?MapboxLngChangeLayerTextProperty(o,t,n,s):t}),r=Object.assign({},t,{layers:a});return this._languageTransform(r,e)},MapboxLanguage.prototype._initialStyleUpdate=function(){var t=this._map.getStyle(),e=this._defaultLanguage||MapboxLngBrowserLanguage(this.supportedLanguages);this._map.off("styledata",this._initialStyleUpdate),this._map.setStyle(this.setLanguage(t,e))},MapboxLanguage.prototype.onAdd=function(t){return this._map=t,this._map.on("styledata",this._initialStyleUpdate),this._container=document.createElement("div"),this._container},MapboxLanguage.prototype.onRemove=function(){this._map.off("styledata",this._initialStyleUpdate),this._map=void 0},"undefined"!=typeof module&&void 0!==module.exports?module.exports=MapboxLanguage:(MapboxLngIe11Polyfill(),window.MapboxLanguage=MapboxLanguage),function(t,e){"object"==typeof exports&&"undefined"!=typeof module?module.exports=e():"function"==typeof define&&define.amd?define(e):t.supercluster=e()}(this,function(){"use strict";function t(t,i,n,o){e(t,n,o),e(i,2*n,2*o),e(i,2*n+1,2*o+1)}function e(t,e,i){var n=t[e];t[e]=t[i],t[i]=n}function i(t,e,i,n){var o=t-i,s=e-n;return o*o+s*s}function n(t,e,i,n,s){return new o(t,e,i,n,s)}function o(e,i,n,o,r){i=i||s,n=n||a,r=r||Array,this.nodeSize=o||64,this.points=e,this.ids=new r(e.length),this.coords=new r(2*e.length);for(var p=0;p<e.length;p++)this.ids[p]=p,this.coords[2*p]=i(e[p]),this.coords[2*p+1]=n(e[p]);!function e(i,n,o,s,a,r){if(!(a-s<=o)){var p=Math.floor((s+a)/2);!function e(i,n,o,s,a,r){for(;s<a;){if(600<a-s){var p=a-s+1,u=o-s+1,c=Math.log(p),g=.5*Math.exp(2*c/3),l=.5*Math.sqrt(c*g*(p-g)/p)*(u-p/2<0?-1:1);e(i,n,o,Math.max(s,Math.floor(o-u*g/p+l)),Math.min(a,Math.floor(o+(p-u)*g/p+l)),r)}var d=n[2*o+r],h=s,y=a;for(t(i,n,s,o),n[2*a+r]>d&&t(i,n,s,a);h<y;){for(t(i,n,h,y),h++,y--;n[2*h+r]<d;)h++;for(;n[2*y+r]>d;)y--}n[2*s+r]===d?t(i,n,s,y):t(i,n,++y,a),y<=o&&(s=y+1),o<=y&&(a=y-1)}}(i,n,p,s,a,r%2),e(i,n,o,s,p-1,r+1),e(i,n,o,p+1,a,r+1)}}(this.ids,this.coords,this.nodeSize,0,this.ids.length-1,0)}function s(t){return t[0]}function a(t){return t[1]}function r(t){this.options=l(Object.create(this.options),t),this.trees=new Array(this.options.maxZoom+1)}function p(t){return{type:"Feature",id:t.id,properties:u(t),geometry:{type:"Point",coordinates:[(n=t.x,360*(n-.5)),(e=t.y,i=(180-360*e)*Math.PI/180,360*Math.atan(Math.exp(i))/Math.PI-90)]}};var e,i,n}function u(t){var e=t.numPoints,i=1e4<=e?Math.round(e/1e3)+"k":1e3<=e?Math.round(e/100)/10+"k":e;return l(l({},t.properties),{cluster:!0,cluster_id:t.id,point_count:e,point_count_abbreviated:i})}function c(t){return t/360+.5}function g(t){var e=Math.sin(t*Math.PI/180),i=.5-.25*Math.log((1+e)/(1-e))/Math.PI;return i<0?0:1<i?1:i}function l(t,e){for(var i in e)t[i]=e[i];return t}function d(t){return t.x}function h(t){return t.y}return r.prototype={options:{minZoom:0,maxZoom:16,radius:40,extent:512,nodeSize:64,log:!(o.prototype={range:function(t,e,i,n){return function(t,e,i,n,o,s,a){for(var r,p,u=[0,t.length-1,0],c=[];u.length;){var g=u.pop(),l=u.pop(),d=u.pop();if(l-d<=a)for(var h=d;h<=l;h++)r=e[2*h],p=e[2*h+1],i<=r&&r<=o&&n<=p&&p<=s&&c.push(t[h]);else{var y=Math.floor((d+l)/2);r=e[2*y],p=e[2*y+1],i<=r&&r<=o&&n<=p&&p<=s&&c.push(t[y]);var M=(g+1)%2;(0===g?i<=r:n<=p)&&(u.push(d),u.push(y-1),u.push(M)),(0===g?r<=o:p<=s)&&(u.push(y+1),u.push(l),u.push(M))}}return c}(this.ids,this.coords,t,e,i,n,this.nodeSize)},within:function(t,e,n){return function(t,e,n,o,s,a){for(var r=[0,t.length-1,0],p=[],u=s*s;r.length;){var c=r.pop(),g=r.pop(),l=r.pop();if(g-l<=a)for(var d=l;d<=g;d++)i(e[2*d],e[2*d+1],n,o)<=u&&p.push(t[d]);else{var h=Math.floor((l+g)/2),y=e[2*h],M=e[2*h+1];i(y,M,n,o)<=u&&p.push(t[h]);var m=(c+1)%2;(0===c?n-s<=y:o-s<=M)&&(r.push(l),r.push(h-1),r.push(m)),(0===c?y<=n+s:M<=o+s)&&(r.push(h+1),r.push(g),r.push(m))}}return p}(this.ids,this.coords,t,e,n,this.nodeSize)}}),reduce:null,initial:function(){return{}},map:function(t){return t}},load:function(t){var e=this.options.log;e&&console.time("total time");var i="prepare "+t.length+" points";e&&console.time(i),this.points=t;for(var o,s,a=[],r=0;r<t.length;r++)t[r].geometry&&a.push((o=r,{x:c((s=t[r].geometry.coordinates)[0]),y:g(s[1]),zoom:1/0,index:o,parentId:-1}));this.trees[this.options.maxZoom+1]=n(a,d,h,this.options.nodeSize,Float32Array),e&&console.timeEnd(i);for(var p=this.options.maxZoom;p>=this.options.minZoom;p--){var u=+Date.now();a=this._cluster(a,p),this.trees[p]=n(a,d,h,this.options.nodeSize,Float32Array),e&&console.log("z%d: %d clusters in %dms",p,a.length,+Date.now()-u)}return e&&console.timeEnd("total time"),this},getClusters:function(t,e){var i=((t[0]+180)%360+360)%360-180,n=Math.max(-90,Math.min(90,t[1])),o=180===t[2]?180:((t[2]+180)%360+360)%360-180,s=Math.max(-90,Math.min(90,t[3]));if(360<=t[2]-t[0])i=-180,o=180;else if(o<i){var a=this.getClusters([i,n,180,s],e),r=this.getClusters([-180,n,o,s],e);return a.concat(r)}for(var u=this.trees[this._limitZoom(e)],l=u.range(c(i),g(s),c(o),g(n)),d=[],h=0;h<l.length;h++){var y=u.points[l[h]];d.push(y.numPoints?p(y):this.points[y.index])}return d},getChildren:function(t){var e=t>>5,i=t%32,n="No cluster with the specified id.",o=this.trees[i];if(!o)throw new Error(n);var s=o.points[e];if(!s)throw new Error(n);for(var a=this.options.radius/(this.options.extent*Math.pow(2,i-1)),r=o.within(s.x,s.y,a),u=[],c=0;c<r.length;c++){var g=o.points[r[c]];g.parentId===t&&u.push(g.numPoints?p(g):this.points[g.index])}if(0===u.length)throw new Error(n);return u},getLeaves:function(t,e,i){e=e||10,i=i||0;var n=[];return this._appendLeaves(n,t,e,i,0),n},getTile:function(t,e,i){var n=this.trees[this._limitZoom(t)],o=Math.pow(2,t),s=this.options.extent,a=this.options.radius/s,r=(i-a)/o,p=(i+1+a)/o,u={features:[]};return this._addTileFeatures(n.range((e-a)/o,r,(e+1+a)/o,p),n.points,e,i,o,u),0===e&&this._addTileFeatures(n.range(1-a/o,r,1,p),n.points,o,i,o,u),e===o-1&&this._addTileFeatures(n.range(0,r,a/o,p),n.points,-1,i,o,u),u.features.length?u:null},getClusterExpansionZoom:function(t){for(var e=t%32-1;e<this.options.maxZoom;){var i=this.getChildren(t);if(e++,1!==i.length)break;t=i[0].properties.cluster_id}return e},_appendLeaves:function(t,e,i,n,o){for(var s=this.getChildren(e),a=0;a<s.length;a++){var r=s[a].properties;if(r&&r.cluster?o+r.point_count<=n?o+=r.point_count:o=this._appendLeaves(t,r.cluster_id,i,n,o):o<n?o++:t.push(s[a]),t.length===i)break}return o},_addTileFeatures:function(t,e,i,n,o,s){for(var a=0;a<t.length;a++){var r=e[t[a]],p={type:1,geometry:[[Math.round(this.options.extent*(r.x*o-i)),Math.round(this.options.extent*(r.y*o-n))]],tags:r.numPoints?u(r):this.points[r.index].properties},c=r.numPoints?r.id:this.points[r.index].id;void 0!==c&&(p.id=c),s.features.push(p)}},_limitZoom:function(t){return Math.max(this.options.minZoom,Math.min(t,this.options.maxZoom+1))},_cluster:function(t,e){for(var i=[],n=this.options.radius/(this.options.extent*Math.pow(2,e)),o=0;o<t.length;o++){var s=t[o];if(!(s.zoom<=e)){s.zoom=e;var a=this.trees[e+1],r=a.within(s.x,s.y,n),p=s.numPoints||1,u=s.x*p,c=s.y*p,g=null;this.options.reduce&&(g=this.options.initial(),this._accumulate(g,s));for(var l=(o<<5)+(e+1),d=0;d<r.length;d++){var h=a.points[r[d]];if(!(h.zoom<=e)){h.zoom=e;var y=h.numPoints||1;u+=h.x*y,c+=h.y*y,p+=y,h.parentId=l,this.options.reduce&&this._accumulate(g,h)}}1===p?i.push(s):(s.parentId=l,i.push({x:u/p,y:c/p,zoom:1/0,id:l,parentId:-1,numPoints:p,properties:g}))}}return i},_accumulate:function(t,e){var i=e.numPoints?e.properties:this.options.map(this.points[e.index].properties);this.options.reduce(t,i)}},function(t){return new r(t)}}),MyListing.Maps.Marker.prototype.init=function(t){this.options=jQuery.extend(!0,{position:!1,map:!1,popup:!1,template:{type:"basic",icon_name:"",icon_color:"",icon_background_color:"",listing_id:"",thumbnail:""}},t),this.marker=new mapboxgl.Marker(this.template()),this.options.position&&this.setPosition(this.options.position),this.options.map&&this.setMap(this.options.map)},MyListing.Maps.Marker.prototype.getPosition=function(){return this.options.position},MyListing.Maps.Marker.prototype.setPosition=function(t){return this.marker.setLngLat(t.getSourceObject()),this},MyListing.Maps.Marker.prototype.setMap=function(t){return this.marker.addTo(t.getSourceObject()),this},MyListing.Maps.Marker.prototype.remove=function(){return this.options.popup&&this.options.popup.remove(),this.marker.remove(),this},MyListing.Maps.Marker.prototype.template=function(){var t=this.getTemplate();return t.addEventListener("click",function(t){t.preventDefault(),this.options.popup&&this.options.map&&this.options.position&&(this.options.popup.setPosition(this.options.position),setTimeout(function(){this.options.popup.setMap(this.options.map),this.options.popup.show(),this.fitPopupToScreen()}.bind(this),10))}.bind(this)),t},MyListing.Maps.Marker.prototype.fitPopupToScreen=function(){var t=130,e=360,i=130,n=this.options.map.getSourceObject(),o=n.getCanvas().getBoundingClientRect(),s=n.project(n.getCenter()),a=s.x,r=s.y,p=n.project(this.marker.getLngLat());o.width-p.x<e-1&&(s.x+=e-(o.width-p.x)),p.y<t-1&&(s.y-=t-p.y),o.height-p.y<i-1&&(s.y+=i-(o.height-p.y)),s.x===a&&s.y===r||n.panTo(n.unproject(s),{duration:200})},MyListing.Maps.Popup.prototype.init=function(t){this.options=jQuery.extend(!0,{content:"",classes:"cts-map-popup cts-listing-popup infoBox cts-popup-hidden listing-preview",position:!1,map:!1},t),this.popup=new mapboxgl.Popup({className:this.options.classes,closeButton:!1,closeOnClick:!1,anchor:"left"}),this.timeout=null,this.options.position&&this.setPosition(this.options.position),this.options.content&&this.setContent(this.options.content),this.options.map&&this.setMap(this.options.map)},MyListing.Maps.Popup.prototype.setContent=function(t){return this.popup.setHTML(t),this},MyListing.Maps.Popup.prototype.setPosition=function(t){return this.popup.setLngLat(t.getSourceObject()),this},MyListing.Maps.Popup.prototype.setMap=function(t){return this.options.map=t,this},MyListing.Maps.Popup.prototype.remove=function(){return this.popup.remove(),this},MyListing.Maps.Popup.prototype.show=function(){var t=this;return clearTimeout(t.timeout),t.popup.addTo(t.options.map.getSourceObject()),setTimeout(function(){t.popup._container.className=t.popup._container.className.replace("cts-popup-hidden","cts-popup-visible")},10),t},MyListing.Maps.Popup.prototype.hide=function(){var t=this;return clearTimeout(t.timeout),void 0!==t.popup._container&&(t.popup._container.className=t.popup._container.className.replace("cts-popup-visible","cts-popup-hidden")),t.timeout=setTimeout(function(){t.remove()},250),t},MyListing.Maps.LatLng.prototype.init=function(t,e){this.latitude=t,this.longitude=e,this.latlng=new mapboxgl.LngLat(e,t)},MyListing.Maps.LatLng.prototype.getLatitude=function(){return this.latlng.lat},MyListing.Maps.LatLng.prototype.getLongitude=function(){return this.latlng.lng},MyListing.Maps.LatLng.prototype.toGeocoderFormat=function(){return[this.getLongitude(),this.getLatitude()].join(",")},MyListing.Maps.LatLngBounds.prototype.init=function(t,e){this.southwest=t,this.northeast=e,this.bounds=new mapboxgl.LngLatBounds(t,e)},MyListing.Maps.LatLngBounds.prototype.extend=function(t){this.bounds.extend(t.getSourceObject())},MyListing.Maps.Clusterer.prototype.init=function(t){this.map=t,this.clusters={},this.clusterer=!1},MyListing.Maps.Clusterer.prototype.load=function(){this.clusterer=supercluster({radius:80,maxZoom:20}).load(this.getGeoJSON()),this.update()},MyListing.Maps.Clusterer.prototype.destroy=function(){this.clusterer=!1},MyListing.Maps.Clusterer.prototype.getGeoJSON=function(){return this.map.markers.map(function(t,e){return{type:"Feature",geometry:{type:"Point",coordinates:[t.getPosition().longitude,t.getPosition().latitude]},properties:{sID:e+1,scID:0,marker:{template:jQuery.extend(!0,{},t.options.template),popup:!!t.options.popup&&t.options.popup.options.content}}}})},MyListing.Maps.Clusterer.prototype.removeFeatures=function(){this.map.removeMarkers(),Object.keys(this.clusters).forEach(function(t){this.clusters[t].remove()}.bind(this))},MyListing.Maps.Clusterer.prototype.update=function(){var t=this;if(!t.clusterer)return!1;var e=t.map.getSourceObject().getBounds();features=t.clusterer.getClusters([e.getWest(),e.getSouth(),e.getEast(),e.getNorth()],Math.floor(t.map.getSourceObject().getZoom())),this.removeFeatures(),t.displayFeatures(features)},MyListing.Maps.Clusterer.prototype.displayFeatures=function(t){var e=this;t.forEach(function(t){if(t.properties.cluster){var i=document.createElement("div");i.className="cts-marker-cluster",i.innerHTML=t.properties.point_count_abbreviated;var n=new mapboxgl.Marker(i);n.setLngLat(t.geometry.coordinates),n.addTo(e.map.getSourceObject()),e.clusters[t.properties.cluster_id]=n,i.addEventListener("click",function(i){i.preventDefault(),e.map.getSourceObject().easeTo({center:t.geometry.coordinates,zoom:e.clusterer.getClusterExpansionZoom(t.properties.cluster_id)})})}else e.map.markers.push(new MyListing.Maps.Marker({map:e.map,popup:!!t.properties.marker.popup&&new MyListing.Maps.Popup({content:t.properties.marker.popup}),position:new MyListing.Maps.LatLng(t.geometry.coordinates[1],t.geometry.coordinates[0]),template:t.properties.marker.template}))})},MyListing.Maps.Geocoder.prototype.init=function(){},MyListing.Maps.Geocoder.prototype.geocode=function(t,e,i){var n=this,o=!1;if("function"==typeof e)i=e,e={};var s={access_token:MyListing.MapConfig.AccessToken,limit:1,language:MyListing.MapConfig.Language};MyListing.MapConfig.TypeRestrictions.length&&MyListing.MapConfig.TypeRestrictions.join(",").length&&(e.types=MyListing.MapConfig.TypeRestrictions.join(",")),MyListing.MapConfig.CountryRestrictions.length&&MyListing.MapConfig.CountryRestrictions.join(",").length&&(e.country=MyListing.MapConfig.CountryRestrictions.join(","));e=jQuery.extend(!0,{},s,e);if(!encodeURIComponent(t).length)return i(o);jQuery.get({url:"https://api.mapbox.com/geocoding/v5/mapbox.places/{query}.json".replace("{query}",encodeURIComponent(t)),data:e,dataType:"json",success:function(t,i){"success"===i&&t&&t.features.length&&(o=1!==e.limit?t.features.map(n.formatFeature):n.formatFeature(t.features[0]))},complete:function(){i(o)}})},MyListing.Maps.Geocoder.prototype.formatFeature=function(t){return{latitude:t.geometry.coordinates[1],longitude:t.geometry.coordinates[0],address:t.place_name}},MyListing.Maps.Autocomplete.prototype.init=function(t){if(!t instanceof Element)return!1;var e=this;this.el=t,this.input=jQuery(this.el),this.focusedItem=0,this.hasQueried=!1,this.attachDropdown(),this.input.on("input",MyListing.Helpers.debounce(this.querySuggestions.bind(this),300)),this.input.on("focusin",this.showDropdown.bind(this)),this.input.on("focusout",this.hideDropdown.bind(this)),this.input.on("keydown click",this.navigateDropdown.bind(this)),this.dropdown.on("click",".suggestion",function(t){e.selectItem(jQuery(this).index())})},MyListing.Maps.Autocomplete.prototype.querySuggestions=function(t){this.resetFocus(),this.showDropdown(),this.fireChangeEvent();MyListing.Geocoder.geocode(t.target.value,{limit:5},function(t){if(this.hasQueried=!0,this.removeSuggestions(),!t)return!1;t.forEach(this.addSuggestion.bind(this))}.bind(this))},MyListing.Maps.Autocomplete.prototype.navigateDropdown=function(t){this.hasQueried||this.input.trigger("input"),this.showDropdown(),40===t.keyCode&&(this.focusedItem++,this.focusItem()),38===t.keyCode&&(this.focusedItem--,this.focusItem()),13===t.keyCode&&(t.preventDefault(),0!==this.focusedItem&&this.selectItem(this.focusedItem-1))},MyListing.Maps.Autocomplete.prototype.focusItem=function(){this.dropdown.find(".suggestions-list .suggestion").removeClass("active");var t=this.dropdown.find(".suggestions-list .suggestion");this.focusedItem<0&&(this.focusedItem=t.length),this.focusedItem>t.length&&(this.focusedItem=0),0!==this.focusedItem&&this.dropdown.find(".suggestions-list .suggestion").eq(this.focusedItem-1).addClass("active")},MyListing.Maps.Autocomplete.prototype.resetFocus=function(t){this.focusedItem=0,this.dropdown.find(".suggestions-list .suggestion").removeClass("active")},MyListing.Maps.Autocomplete.prototype.showDropdown=function(t){this.dropdown.addClass("active");var e=this.input.get(0).getBoundingClientRect(),i=this.input.offset();this.dropdown.css({top:i.top+e.height+"px",left:i.left+"px",width:e.width+"px"})},MyListing.Maps.Autocomplete.prototype.hideDropdown=function(t){this.dropdown.removeClass("active")},MyListing.Maps.Autocomplete.prototype.selectItem=function(t){var e=this.dropdown.find(".suggestions-list .suggestion").eq(t).data("place");this.input.val(e.address),this.resetFocus(),this.hideDropdown(),this.fireChangeEvent(e)},MyListing.Maps.Autocomplete.prototype.attachDropdown=function(){this.dropdown=jQuery('<div class="cts-autocomplete-dropdown"><div class="suggestions-list"></div></div>'),this.input.addClass("cts-autocomplete-input").attr("autocomplete","off"),jQuery("body").append(this.dropdown)},MyListing.Maps.Autocomplete.prototype.removeSuggestions=function(){this.dropdown.find(".suggestions-list").html("")},MyListing.Maps.Autocomplete.prototype.addSuggestion=function(t){var e=jQuery(['<div class="suggestion">','<i class="mi location_on"></i>','<span class="suggestion--address"></span>',"</div>"].join(""));e.data("place",t),e.find(".suggestion--address").text(t.address),this.dropdown.find(".suggestions-list").append(e)},MyListing.Maps.Map.prototype.init=function(t){this.options=jQuery.extend({},MyListing.Maps.options,jQuery(t).data("options"));if(this.markers=[],this.bounds=new MyListing.Maps.LatLngBounds,this.id=!!jQuery(t).attr("id")&&jQuery(t).attr("id"),this.events={zoom_changed:"zoomstart",bounds_changed:"moveend"},this.map=new mapboxgl.Map({container:t,zoom:this.options.zoom,minZoom:this.options.minZoom,interactive:this.options.draggable,style:MyListing.Maps.skins[this.options.skin]?MyListing.Maps.skins[this.options.skin]:MyListing.Maps.skins.skin1,scrollZoom:this.options.scrollwheel}),this.map.addControl(new mapboxgl.NavigationControl({showCompass:!1})),this.map.addControl(new mapboxgl.FullscreenControl),this.addListenerOnce("load",function(){MyListing.Maps.MapboxSetLanguage(this)}.bind(this)),this.setZoom(3),this.setCenter(new MyListing.Maps.LatLng(0,0)),this.options.cluster_markers){function e(){this.clusterer.update()}this.clusterer=new MyListing.Maps.Clusterer(this),this.addListener("updating_markers",function(){this.clusterer.destroy()}.bind(this)),this.addListener("updated_markers",function(){this.clusterer.load()}.bind(this)),this.addListener("zoomend",e.bind(this)),this.addListener("dragend",e.bind(this))}this._maybeAddMarkers(),this.addListener("zoom_changed",this.closePopups.bind(this)),this.addListener("click",this.closePopups.bind(this)),MyListing.Maps.instances.push({id:this.id,map:this.map,instance:this})},MyListing.Maps.Map.prototype.setZoom=function(t){this.map.setZoom(t)},MyListing.Maps.Map.prototype.getZoom=function(){return this.map.getZoom()},MyListing.Maps.Map.prototype.setCenter=function(t){this.map.setCenter(t.getSourceObject())},MyListing.Maps.Map.prototype.fitBounds=function(t){this.map.fitBounds(t.getSourceObject(),{padding:85,animate:!1})},MyListing.Maps.Map.prototype.panTo=function(t){this.map.panTo(t.getSourceObject())},MyListing.Maps.Map.prototype.getClickPosition=function(t){return new MyListing.Maps.LatLng(t.lngLat.lat,t.lngLat.lng)},MyListing.Maps.Map.prototype.addListener=function(t,e){this.map.on(this.getSourceEvent(t),function(t){e(t)})},MyListing.Maps.Map.prototype.addListenerOnce=function(t,e){this.map.once(this.getSourceEvent(t),function(t){e(t)})},MyListing.Maps.Map.prototype.trigger=function(t){this.map.fire(this.getSourceEvent(t))},MyListing.Maps.skins={skin1:"mapbox://styles/mapbox/streets-v10",skin2:"mapbox://styles/mapbox/outdoors-v10",skin3:"mapbox://styles/mapbox/light-v9",skin4:"mapbox://styles/mapbox/dark-v9",skin6:"mapbox://styles/mapbox/satellite-streets-v10",skin7:"mapbox://styles/mapbox/navigation-preview-day-v4",skin8:"mapbox://styles/mapbox/navigation-preview-night-v4",skin9:"mapbox://styles/mapbox/navigation-guidance-day-v4",skin10:"mapbox://styles/mapbox/navigation-guidance-night-v4",skin12:""},function(){if("object"==typeof MyListing.MapConfig.CustomSkins){var t={};Object.keys(MyListing.MapConfig.CustomSkins).forEach(function(e){if(MyListing.MapConfig.CustomSkins[e])if("mapbox://"!==MyListing.MapConfig.CustomSkins[e].trim().substring(0,9))try{var i=JSON.parse(MyListing.MapConfig.CustomSkins[e]);i&&"object"==typeof i&&(t[e]=i)}catch(t){}else t[e]=MyListing.MapConfig.CustomSkins[e].trim()}),jQuery.extend(MyListing.Maps.skins,t)}}(),MyListing.Maps.init=function(){jQuery(function(t){MyListing.MapConfig.AccessToken.length||(MyListing.MapConfig.AccessToken="invalid_token"),mapboxgl.accessToken=MyListing.MapConfig.AccessToken,MyListing.Maps.MapboxLanguage=new MapboxLanguage,MyListing.MapConfig.Language&&MyListing.Maps.MapboxLanguage.supportedLanguages.indexOf(MyListing.MapConfig.Language)>-1||(MapboxLngBrowserLanguage(MyListing.Maps.MapboxLanguage.supportedLanguages)?MyListing.MapConfig.Language=MapboxLngBrowserLanguage(MyListing.Maps.MapboxLanguage.supportedLanguages):MyListing.MapConfig.Language="en"),"ar"===MyListing.MapConfig.Language&&mapboxgl.setRTLTextPlugin("https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.1.0/mapbox-gl-rtl-text.js"),MyListing.Maps.MapboxSetLanguage=function(t){var e=t.getSourceObject();e.setStyle(MyListing.Maps.MapboxLanguage.setLanguage(e.getStyle(),MyListing.MapConfig.Language))},t(".c27-map:not(.delay-init)").each(function(t,e){new MyListing.Maps.Map(e)}),t("#c27-explore-listings").length&&MyListing.Explore.setupMap(),t(document).trigger("maps:loaded"),t("body.single-listing .profile-menu li a").click(function(){setTimeout(function(){MyListing.Maps.instances.forEach(function(t){t.instance.map.resize()})},500)})})},MyListing.Maps.init();
//# sourceMappingURL=mapbox.js.map

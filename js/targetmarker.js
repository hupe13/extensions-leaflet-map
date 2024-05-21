/**
 * Javascript function for targetmarker
 *
 * @package Extensions for Leaflet Map
 */

// jump to leaflet-marker, leaflet-extramarker OR leaflet-geojson with lat and lng in query_string
function leafext_target_get_lanlng_js(lat,lng,target,zoom,debug) {
	console.log( "leafext_target_get_lanlng_js",lat,lng,target,zoom,debug );
	var map = window.WPLeafletMapPlugin.getCurrentMap();
	var markerClusterGroup;
	thismapbounds = [];

	if ( WPLeafletMapPlugin.markers.length > 0 ) {
		map.whenReady(
			function () {
				// console.log("ready target");
				let mapbounds = map.getBounds();
				if (debug) {
					L.circleMarker( L.latLng( lat,lng ), {radius: 3,color: "red"} ).bindPopup( "latlng" ).addTo( map );
					L.rectangle( mapbounds, {color: "yellow", weight: 1} ).addTo( map );
				}
				// with bounds because of abuse, POST is better
				if (mapbounds.contains( L.latLng( lat,lng ) )) {
					leafext_target_latlng_marker_do( map,lat,lng,target,zoom,debug );
				} else {
					console.log( "lat, lng not in marker bounds or no marker" );
				}
			}
		);
	} else {
		var geojsons = window.WPLeafletMapPlugin.geojsons;
		if (geojsons.length > 0) {
			// console.log("geojsons "+geojsons.length);
			var geocount = geojsons.length;
			for (var j = 0, len = geocount; j < len; j++) {
				var geojson = geojsons[j];
				// console.log(geojson);
				if (map._leaflet_id == geojson._map._leaflet_id) {
					// console.log("geojson");
					geojson.on(
						"ready",
						function () {
							// console.log("ready");
							let mapbounds = map.getBounds();
							// with bounds because of abuse, POST is better
							if (mapbounds.contains( L.latLng( lat,lng ) )) {
								leafext_target_latlng_geojson_do( map,lat,lng,this.layer,target,zoom,debug );
							}
						}
					); // geojson ready
				}
			}
		}
	}
}

/**
 * Jump to leaflet-marker, leaflet-extramarker OR leaflet-geojson
 * with lat and lng in a map on same site - does not work properly
 */
function leafext_target_same_lanlng_js(lat,lng,target,zoom,debug) {
	console.log( "leafext_target_same_lanlng_js",lat,lng,target,zoom,debug );
	window.WPLeafletMapPlugin = window.WPLeafletMapPlugin || [];
	window.WPLeafletMapPlugin.push(
		function () {
			var map = window.WPLeafletMapPlugin.getCurrentMap();
			var markerClusterGroup;
			thismapbounds = [];
			if ( WPLeafletMapPlugin.markers.length > 0 ) {
				if (debug) {
					L.circleMarker( L.latLng( lat,lng ), {radius: 3,color: "red"} ).bindPopup( "latlng" ).addTo( map );
					// L.rectangle( mapbounds, {color: "yellow", weight: 1} ).addTo( map );
				}
				leafext_target_latlng_marker_do( map,lat,lng,target,zoom,debug );
			} else {
				var geojsons = window.WPLeafletMapPlugin.geojsons;
				if (geojsons.length > 0) {
					console.log( "lat lng geojson" );
					var geocount = geojsons.length;
					for (var j = 0, len = geocount; j < len; j++) {
						var geojson = geojsons[j];
						leafext_target_latlng_geojson_do( map,lat,lng,geojson,target,zoom,debug )
					}
				}
			}
		}
	);
}

function leafext_target_latlng_marker_do(map,lat,lng,target,zoom,debug){
	console.log( 'leafext_target_latlng_marker_do',lat,lng,target,zoom,debug );
	var closest = Number.MAX_VALUE;
	var closestMarker;
	let latlng = L.latLng( lat,lng );
	map.eachLayer(
		function (layer) {
			if ( layer instanceof L.FeatureGroup ) {
				// console.log("L.FeatureGroup");
				if (layer._markerCluster) {
					// console.log("L.markerClusterGroup");
					markerClusterGroup = layer;
					layer.eachLayer(
						function (a) {
							if (a instanceof L.Marker) {
								// console.log(a.options.title,a.getLatLng());
								// console.log(a);
								// console.log(a.__parent._cLatLng);
								// let radius = a.getLatLng().distanceTo( latlng );
								let radius = a.__parent._cLatLng.distanceTo( latlng );
								if (radius < closest) {
									// console.log(a);
									closest       = radius;
									closestMarker = a;
									// console.log(radius);
									// console.log("closest in cluster");
								}
							}
						}
					);
				}
			}
		}
	);

	if (closest < Number.MAX_VALUE ) {
		if (debug) {
			// console.log(closestMarker);
			L.circle( latlng, {radius: closest,color: "red"} ).bindPopup( "radius" ).addTo( map );
			L.circle( closestMarker.getLatLng(), {radius: closest,color: "blue"} ).bindPopup( "closestMarker" ).addTo( map );
			var visibleOne = markerClusterGroup.getVisibleParent( closestMarker );
			L.circle( visibleOne.getLatLng(), {radius: closest,color: "green"} ).bindPopup( "visible" ).addTo( map );
			console.log( "closest marker in cluster" );
		}
		leafext_zoomto_clmarker( closestMarker, target, markerClusterGroup, map, debug );
	} else {
		var length = WPLeafletMapPlugin.markers.length;
		// console.log("length "+length);
		for (var i = 0; i < length; i++) {
			let a = WPLeafletMapPlugin.markers[i];
			// console.log(i, a);
			if ( a._map !== null ) {
				if (map._leaflet_id == a._map._leaflet_id) {
					let radius = a.getLatLng().distanceTo( latlng );
					// console.log(i,radius);
					if (radius < closest) {
						// console.log(a);
						closest       = radius;
						closestMarker = a;
						// console.log(radius);
						// console.log("closest");
					}
				}
			}
		}

		if (closest < Number.MAX_VALUE ) {
			if (debug) {
				L.circle( latlng, {radius: closest,color: "red"} ).bindPopup( "radius" ).addTo( map );
				L.circle( closestMarker.getLatLng(), {radius: closest,color: "blue"} ).bindPopup( "closestMarker" ).addTo( map );
				console.log( "closest marker not in cluster" );
			}
			leafext_zoomto_marker( closestMarker, target, zoom, map, debug );
		} else {
			if (debug) {
				console.log( closest );
				console.log( "not found" );
			}
		}
	}
}

function leafext_target_latlng_geojson_do(map,lat,lng,geolayer,target,zoom,debug) {
	console.log("leafext_target_latlng_geojson_do",lat,lng,target,zoom,debug)
	let latlng    = L.latLng( lat,lng );
	let mapbounds = map.getBounds();
	if (debug) {
		L.circleMarker( latlng, {radius: 3,color: "red"} ).bindPopup( "latlng" ).addTo( map );
		L.rectangle( mapbounds, {color: "yellow", weight: 1} ).addTo( map );
	}
	if (mapbounds.contains( latlng )) {
		var closest = Number.MAX_VALUE;
		var closestMarker;
		// console.log(a);
		let radius = Number.MAX_VALUE;
		geolayer.eachLayer(
			function (layer) {
				if (layer.feature.geometry.type == "Point" ) {
					// console.log(layer);
					// if (layer.__parent) {
					// 	console.log(layer.getPopup().getContent());
					// 	// radius = layer.__parent._cLatLng.distanceTo( latlng );
					// 	radius = layer.getLatLng().distanceTo( latlng );
					// 	console.log("cluster ",radius);
					// 	console.log(layer);
					// } else {
					// 	radius = layer.getLatLng().distanceTo( latlng );
					// 	console.log("no cluster ",radius);
					// }
					radius = layer.getLatLng().distanceTo( latlng );
					if (radius < closest) {
						closest       = radius;
						closestMarker = layer;
					}
				}
			}
		);

		if (closest < Number.MAX_VALUE ) {
			if (debug) {
				L.circle( latlng, {radius: closest,color: "red"} ).bindPopup( "radius" ).addTo( map );
				L.circle( closestMarker.getLatLng(), {radius: closest,color: "blue"} ).bindPopup( "closestMarker" ).addTo( map );
			}

			if (closestMarker.__parent) {
				if (debug) {
					L.circle( latlng, {radius: closest,color: "red"} ).bindPopup( "radius" ).addTo( map );
					L.circle( closestMarker.getLatLng(), {radius: closest,color: "blue"} ).bindPopup( "closestMarker" ).addTo( map );
					console.log( "closest geojson marker in cluster" );
				}
				markerClusterGroup = closestMarker.__parent._group;
				leafext_zoomto_clgeomarker( closestMarker, target, markerClusterGroup, map, debug );
			} else {
				if (debug) {
					console.log( "closest geojson marker not in cluster" );
				}
				leafext_zoomto_marker( closestMarker, target, zoom, map, debug );
			}
		} else {
			if (debug) {
				console.log( closest );
				console.log( "not found" );
			}
		}
	} else {
		console.log( "latlng not in geojson bounds" );
	}
}

// targetmarker same site - search with title
function leafext_target_same_title_js(title,target,zoom,debug) {
	console.log( "leafext_target_same_title_js",title,target,zoom,debug );
	window.WPLeafletMapPlugin = window.WPLeafletMapPlugin || [];
	window.WPLeafletMapPlugin.push(
		function () {
			var map = window.WPLeafletMapPlugin.getCurrentMap();
			leafext_target_marker_title_do( map,title,target,zoom,debug );
		}
	);
}

// targetmarker post remote - search with title
function leafext_target_post_title_js(title,target,zoom,debug) {
	console.log( "leafext_target_post_title_js",title,target,zoom,debug );
	var map = window.WPLeafletMapPlugin.getCurrentMap();
	map.whenReady(
		function () {
			leafext_target_marker_title_do( map,title,target,zoom,debug );
		}
	);
}

function leafext_target_marker_title_do(map,title,target,zoom,debug){
	console.log( 'leafext_target_marker_title_do',title,target,zoom,debug );
	if (debug) {
		map.on(
			"zoomend",
			function (e) {
				console.log( "zoomend zoom " + map.getZoom() );
			}
		);
	}
	var length = WPLeafletMapPlugin.markers.length;
	if ( length > 0 ) {
		thismapbounds = [];
		var markerClusterGroup;
		var closest = Number.MAX_VALUE;
		var closestMarker;
		map.eachLayer(
			function (layer) {
				if ( layer instanceof L.FeatureGroup ) {
					// console.log("L.FeatureGroup");
					if (layer._markerCluster) {
						markerClusterGroup = layer;
						layer.eachLayer(
							function (a) {
								if (a instanceof L.Marker) {
									// console.log(a.options.title);
									if ( a.options.title == title ) {
										if (debug) {
											console.log( title );
										}
										closestMarker = a;
										closest       = 0;
									}
								}
							}
						);
					}
				}
			}
		);

		if (closest < Number.MAX_VALUE ) {
			if (debug) {
				console.log( "closest marker in cluster" );
			}
			leafext_zoomto_clmarker( closestMarker, target, markerClusterGroup, map, debug );
		} else {
			for (var i = 0; i < length; i++) {
				let a = WPLeafletMapPlugin.markers[i];
				if ( a.options.title == title ) {
					closestMarker = a;
					closest       = 0;
				}
			}
			if (closest < Number.MAX_VALUE ) {
				if (debug) {
					console.log( "closest marker not in cluster" );
				}
				leafext_zoomto_marker( closestMarker, target, zoom, map, debug );
			} else {
				if (debug) {
					console.log( "title not found" );
				}
			}
		}
	}
}

// targetmarker geojsonproperty
function leafext_target_same_geojson_js(geojsonproperty,geojsonvalue,target,zoom,debug) {
	console.log( "leafext_target_same_geojson_js",geojsonproperty,geojsonvalue,target,zoom,debug );
	window.WPLeafletMapPlugin = window.WPLeafletMapPlugin || [];
	// console.log(window.WPLeafletMapPlugin);
	var markerClusterGroup;

	window.WPLeafletMapPlugin.push(
		function () {
			var map = window.WPLeafletMapPlugin.getCurrentMap();
			// console.log(map);
			// console.log(map.fitBounds,map._shouldFitBounds);
			thismapbounds = [];
			var map_id    = map._leaflet_id;
			if (zoom === false) {
				zoom = map.getZoom();
			}
			var geojsons = window.WPLeafletMapPlugin.geojsons;
			var geocount = geojsons.length;
			if (geocount > 0) {
				// console.log("geojsons "+geojsons.length);
				for (var j = 0, len = geocount; j < len; j++) {
					var geojson = geojsons[j];
					if (map_id == geojson._map._leaflet_id) {
						// console.log(geojson);
						geojson.eachLayer(
							function (geolayer) {
								// console.log(geolayer.feature);
								// console.log(geolayer.feature[geojsonproperty]);
								if (geolayer.feature[geojsonproperty] == geojsonvalue) {
									if (debug) {
										map.on(
											"zoomend",
											function (e) {
												console.log( "zoomend zoom " + map.getZoom() );
											}
										);
									}
									if (geolayer.__parent) {
										if (debug) {
											console.log( "closest geojson marker in cluster" );
										}
										var markerClusterGroup = geolayer.__parent._group;
										leafext_zoomto_clgeomarker( geolayer, target, markerClusterGroup, map, debug );
									} else {
										if (debug) {
											console.log( "closest geojson marker not in cluster" );
										}
										leafext_zoomto_marker( geolayer, target, zoom, map, debug );
									}
								}
							}
						);
					}
				}
			}
		}
	);
}

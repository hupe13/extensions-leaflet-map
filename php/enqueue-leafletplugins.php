<?php

// For checking to load awesome (Home character)
function leafext_plugin_stylesheet_installed($array_css) {
    global $wp_styles;
    foreach( $wp_styles->queue as $style ) {
        foreach ($array_css as $css) {
            if (false !== strpos( $style, $css ))
                return 1;
        }
    }
    return 0;
}

function leafext_enqueue_zoomhome () {
	wp_enqueue_script('zoomhome',
		plugins_url('leaflet-plugins/leaflet.zoomhome/leaflet.zoomhome.min.js',LEAFEXT_PLUGIN_FILE),
		array('wp_leaflet_map'), null);
	wp_enqueue_style('zoomhome',
		plugins_url('leaflet-plugins/leaflet.zoomhome/leaflet.zoomhome.css',LEAFEXT_PLUGIN_FILE),
		array('leaflet_stylesheet'), null);
	// Font awesome
	$font_awesome = array('font-awesome', 'fontawesome');
	if (leafext_plugin_stylesheet_installed($font_awesome) === 0) {
		wp_enqueue_style('font-awesome',
        plugins_url('css/font-awesome.min.css',LEAFEXT_PLUGIN_FILE),
		array('zoomhome'), null);
	}
}

function leafext_enqueue_markercluster () {
	wp_enqueue_style( 'markercluster.default',
		plugins_url('leaflet-plugins/leaflet.markercluster-1.5.1/css/MarkerCluster.Default.css',LEAFEXT_PLUGIN_FILE),
		array('leaflet_stylesheet'),null);
	wp_enqueue_style( 'markercluster',
		plugins_url('leaflet-plugins/leaflet.markercluster-1.5.1/css/MarkerCluster.css',LEAFEXT_PLUGIN_FILE),
		array('leaflet_stylesheet'),null);
	wp_enqueue_script('markercluster',
		plugins_url('leaflet-plugins/leaflet.markercluster-1.5.1/js/leaflet.markercluster.js',LEAFEXT_PLUGIN_FILE),
		array('wp_leaflet_map'),null );
}

define('LEAFEXT_ELEVATION_URL', LEAFEXT_PLUGIN_URL . '/leaflet-plugins/leaflet-elevation-1.6.9/');
function leafext_enqueue_elevation () {
	wp_enqueue_script( 'elevation_js',
		plugins_url('leaflet-plugins/leaflet-elevation-1.6.9/js/leaflet-elevation.min.js',
		LEAFEXT_PLUGIN_FILE),
		array('wp_leaflet_map'),null);
	wp_enqueue_style( 'elevation_css',
		plugins_url('leaflet-plugins/leaflet-elevation-1.6.9/css/leaflet-elevation.min.css',
		LEAFEXT_PLUGIN_FILE),
		array('leaflet_stylesheet'),null);
	wp_enqueue_style( 'elevation_leafext_css',
		plugins_url('css/elevation.css',
		LEAFEXT_PLUGIN_FILE),
		array('elevation_css'),null);
}

function leafext_enqueue_multielevation () {
	wp_enqueue_script('leaflet.gpx',
//		plugins_url('leaflet-plugins/leaflet-gpx-1.5.2/gpx-leafext.js',LEAFEXT_PLUGIN_FILE),
    plugins_url('leaflet-plugins/leaflet-gpx-1.6.0/gpx.min.js',LEAFEXT_PLUGIN_FILE),
		array('elevation_js'),null);
	wp_enqueue_script('leaflet.gpxgroup',
		plugins_url('leaflet-plugins/leaflet-elevation-1.6.9/libs/leaflet-gpxgroup.min.js',LEAFEXT_PLUGIN_FILE),
		array('leaflet.gpx'),null);
	wp_enqueue_style( 'my_elevation_css',
	 	plugins_url('css/multielevation.css',LEAFEXT_PLUGIN_FILE),
	 	array('elevation_css'), null);
}

function leafext_enqueue_clustergroup () {
	wp_enqueue_script('leaflet.subgroup',
		plugins_url(
		'leaflet-plugins\Leaflet.FeatureGroup.SubGroup-1.0.2/leaflet.featuregroup.subgroup.js',
		LEAFEXT_PLUGIN_FILE),
		array('markercluster'),null);
}

function leafext_enqueue_placementstrategies () {
	wp_enqueue_script('placementstrategies',
		plugins_url('leaflet-plugins/Leaflet.MarkerCluster.PlacementStrategies/leaflet-markercluster.placementstrategies.js',LEAFEXT_PLUGIN_FILE),
		array('markercluster'),null );
}

function leafext_enqueue_fullscreen () {
	wp_enqueue_style( 'leaflet.fullscreen',
		plugins_url('leaflet-plugins/leaflet.fullscreen-2.0.0/Control.FullScreen.css',LEAFEXT_PLUGIN_FILE),
		array('leaflet_stylesheet'),null);
	wp_enqueue_script('leaflet.fullscreen',
		plugins_url('leaflet-plugins/leaflet.fullscreen-2.0.0/Control.FullScreen.js',LEAFEXT_PLUGIN_FILE),
		array('wp_leaflet_map'),null);
}

function leafext_enqueue_gestures() {
	wp_enqueue_script('gestures_leaflet',
		plugins_url('leaflet-plugins/leaflet-gesture-handling-1.3.5/js/leaflet-gesture-handling-leafext.min.js',LEAFEXT_PLUGIN_FILE),
		array('wp_leaflet_map'), null);
	wp_enqueue_style('gestures_leaflet_styles',
		plugins_url('leaflet-plugins/leaflet-gesture-handling-1.3.5/css/leaflet-gesture-handling.min.css',LEAFEXT_PLUGIN_FILE),
		array('leaflet_stylesheet'),null);
}
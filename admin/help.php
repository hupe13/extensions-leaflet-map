<?php
function leafext_help () {
	$leafext_picts = WP_PLUGIN_URL.'/extensions-leaflet-map/pict/';
    $text =
	"<p>".
'<h3 id="shortcodes">Shortcodes</h3>
<h4 id="display-a-track-with-elevation-profile">'.__('Display a track with elevation profile','extensions-leaflet-map').'</h4>
<img src="'.$leafext_picts.'elevation.png">
<p>'.
__('You may go to','extensions-leaflet-map').' <a href="admin.php?page=extensions-leaflet-map&tab=elevation">'.__('Settings','extensions-leaflet-map').'</a> '.__('and select a color theme','extensions-leaflet-map').'.</p>
<pre>
[leaflet-map ....]
// at least one marker if you use it with zoomehomemap
[leaflet-marker lat=... lng=... ...]Start[/leaflet-marker]
[elevation gpx="url_gpx_file"]
// or
[elevation gpx="url_gpx_file" summary=1]
</pre>
<h4 id="leaflet.markercluster">Leaflet.markercluster</h4>
<img src="'.$leafext_picts.'cluster.png">
<p>'.__('Many markers on a map become confusing. That is why they are clustered','extensions-leaflet-map').'.</p>
<pre>
[leaflet-map ....]
// many markers
[leaflet-marker lat=... lng=... ...]poi1[/leaflet-marker]
[leaflet-marker lat=... lng=... ...]poi2[/leaflet-marker]
 ...
[leaflet-marker lat=... lng=... ...]poixx[/leaflet-marker]
[cluster]
[zoomhomemap]
</pre>
<h4 id="leaflet.featuregroup.subgroup">Leaflet.FeatureGroup.SubGroup</h4>
<img src="'.$leafext_picts.'clustergroup.png">
<p>'.__('dynamically add/remove groups of markers from Marker Cluster','extensions-leaflet-map').'.
Parameter:</p>
<ul>
<li>feat - '.__('possible meaningful values','extensions-leaflet-map').': iconUrl, title, ('.__('other','extensions-leaflet-map').'???)</li>
<li>strings - '.__('comma separated strings to distinguish the markers, e.g. an unique string in iconUrl or title','extensions-leaflet-map').'</li>
<li>groups - '.__('comma separated labels appear in the selection menu','extensions-leaflet-map').'</li>
<li>'.__('The number of strings and groups must match','extensions-leaflet-map').'.</li>
</ul>
<pre>
[leaflet-marker title="..." iconUrl="...red..." ... ] ... [/leaflet-marker]
[leaflet-marker title="..." iconUrl="...green..." ... ] ... [/leaflet-marker]
//many markers
[markerClusterGroup feat="iconUrl" strings="red,green" groups="rot,gruen"]
</pre>
<p>'.__('Here the groups are differentiated according to the color of the markers','extensions-leaflet-map').'.</p>
<h4 id="leaflet.zoomhome">leaflet.zoomhome</h4>
<img src="'.$leafext_picts.'home.png"><p>
&quot;Home&quot; '.__('button to reset the view. A must for clustering markers','extensions-leaflet-map').'.</p>
<pre>
[leaflet-map !zoomcontrol ....]
  ...
[zoomhomemap]
</pre>
<h4 id="fullscreen">Fullscreen</h4>
<img src="'.$leafext_picts.'fullscreen.png">
<pre>
[fullscreen]
</pre>
<h4 id="gesturehandling">GestureHandling</h4>
<pre>
[leaflet-map dragging ... ]
// or
[leaflet-map scrollwheel ... ]
// or
[leaflet-map dragging scrollwheel ... ]
</pre>
<h4 id="hide-markers">Hide Markers</h4>
<p>'.__('If a GPX track contains waypoints that you do not want to display','extensions-leaflet-map').'.</p>
<pre>
[leaflet-map ...]
[leaflet-gpx src="//url/to/file.gpx" ... ]
[hidemarkers]
</pre>
<h4 id="hovergeojson">hovergeojson</h4>
<img src="'.$leafext_picts.'hover.png">
<p>'.__('Use it to highlight a geojson area or line on mouse over','extensions-leaflet-map').'.</p>
<pre>
[leaflet-map ...]
[leaflet-geojson src="//url/to/file.geojson" color="..."]...[/leaflet-geojson]
//or / and
[leaflet-gpx src="//url/to/file.gpx" color="..."]...[/leaflet-gpx]
//or / and
[leaflet-kml src="//url/to/file.kml" color="..."]...[/leaflet-kml]
[hover]
</pre>
<h4 id="switching-tile-layers">'.__('Switching Tile Layers','extensions-leaflet-map').'</h4>
<img src="'.$leafext_picts.'layerswitch.png"><p>
<p>'.__('First go to','extensions-leaflet-map').' <a href="admin.php?page=extensions-leaflet-map&tab=tilelayers">'.__('Settings','extensions-leaflet-map').'</a> '.__('and configure tile layers','extensions-leaflet-map').'.</p>
<pre>
[leaflet-map mapid="..." ...]
[layerswitch]
</pre>
'
."</p>";
	return $text;
}

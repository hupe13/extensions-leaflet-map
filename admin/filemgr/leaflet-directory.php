<?php
// Direktzugriff auf diese Datei verhindern:
defined( 'ABSPATH' ) or die();
function leafext_directory_help_text() {
  $text='<h3>'.__('Tracks from all files in a directory','extensions-leaflet-map').'</h3>'."\n";
  $text=$text.'<pre><code>[leaflet-map fitbounds]'."\n";
  $text=$text.'[leaflet-directory url="..." src="..." elevation]'."\n";
  $text=$text.'[multielevation]</code></pre>';

  $text=$text.'<pre><code>[leaflet-map fitbounds]'."\n";
  $text=$text.'[leaflet-directory url="..." src="..." leaflet type="..." start]</code></pre>';

  $text=$text.'<ul>
  <li> url - '.__('url to directory, default: URL from upload directory.','extensions-leaflet-map').'</li>
  <li> src - '.__('(relative) path to directory, accessible both from path and from url','extensions-leaflet-map').'</li>
  <li> elevation - '.sprintf(__('(default) prepare the tracks for %1$s','extensions-leaflet-map'),' <code>multielevation</code>').'</li>
  <li> leaflet - '.sprintf(__('draw the content with %1$scommands ','extensions-leaflet-map'),'<code>leaflet-</code>').'</li>
  <li> type - '.sprintf(__('For %1$s it is ignored. For %2$s a list of %3$s. Default is %4$s.','extensions-leaflet-map'),'"elevation"','"leaflet"','gpx,kml,geojson,json','"gpx"').'</li>
  <li> start - (optional). '.sprintf(__('If %1$s and a file is a gpx file, display start point and cluster','extensions-leaflet-map'),'"leaflet"').'.</li>
  </ul>';
  if (is_singular() || is_archive() ) {
    //
  } else {
    $text=$text.'<p>'.sprintf(__('Use the %1$sdirectory listing%2$s for simplicity.','extensions-leaflet-map'),
    '<a href="?page='.LEAFEXT_PLUGIN_SETTINGS.'&tab=filemgr-list">','</a>').'</p>';
  }
  return $text;
}

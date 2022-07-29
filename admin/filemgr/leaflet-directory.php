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

  $text=$text.'<ul style="list-style: disc;">
  <li style="margin-left: 1.5em;"> url - '.__('url to directory, default: URL from upload directory.','extensions-leaflet-map').'
  <li style="margin-left: 1.5em;"> src - '.__('(relative) path to directory, accessible both from path and from url','extensions-leaflet-map').'
  <li style="margin-left: 1.5em;"> elevation - '.sprintf(__('(default) prepare the tracks for %s','extensions-leaflet-map'),' <code>multielevation</code>').'
  <li style="margin-left: 1.5em;"> leaflet - '.sprintf(__('draw the content with %scommands ','extensions-leaflet-map'),'<code>leaflet-</code>').'
  <li style="margin-left: 1.5em;"> type - '.sprintf(__('For %s it is ignored. For %s a list of %s. Default is %s.','extensions-leaflet-map'),'"elevation"','"leaflet"','gpx,kml,geojson,json','"gpx"').'
  <li style="margin-left: 1.5em;"> start - (optional). '.sprintf(__('If %s and a file is a gpx file, display start point and cluster','extensions-leaflet-map'),'"leaflet"').'.
  </ul>';
  if (is_singular() || is_archive() ) {
    //
  } else {
    $text=$text.'<p>'.sprintf(__('Use the %sdirectory listing%s for simplicity.','extensions-leaflet-map'),
    '<a href="?page='.LEAFEXT_PLUGIN_SETTINGS.'&tab=filemgr-list">','</a>').'</p>';
  }
  return $text;
}
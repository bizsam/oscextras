<?php
/*
  Plugin Name: Google Maps Plugin
  Plugin URI: https://osclasspoint.com/osclass-plugins/extra-fields-and-other/google-maps-osclass-plugin-i132
  Description: This plugin shows a Google Map on the location space of every item.
  Version: 3.2.2
  Author: MB Themes
  Author URI: https://osclasspoint.com
  Author Email: info@osclasspoint.com
  Short Name: google_maps
  Plugin update URI: google-maps-plugin
  Support URI: https://forums.osclasspoint.com/free-plugins/
  Product Key: NS4N953XMUYGVlbHXtod
*/

function google_maps_location() {
  $item = osc_item();
  osc_google_maps_header();
  require 'map.php';
}

// HELPER
function osc_google_maps_header() {
  echo '<script src="https://maps.google.com/maps/api/js?sensor=false&key='.osc_get_preference('maps_key', 'google_maps').'" type="text/javascript"></script>';
  echo '<style>#itemMap img { max-width: 140em; } </style>';
}

function gm_is_demo() {
  if(osc_logged_admin_username() == 'admin') {
    return false;
  } else if(isset($_SERVER['HTTP_HOST']) && (strpos($_SERVER['HTTP_HOST'],'mb-themes') !== false || strpos($_SERVER['HTTP_HOST'],'abprofitrade') !== false)) {
    return true;
  } else {
    return false;
  }
}

function gm_insert_geo_location($item) {
  $itemId = $item['pk_i_id'];
  $aItem = Item::newInstance()->findByPrimaryKey($itemId);
  $sAddress = (isset($aItem['s_address']) ? $aItem['s_address'] : '');
  $sCity = (isset($aItem['s_city']) ? $aItem['s_city'] : '');
  $sRegion = (isset($aItem['s_region']) ? $aItem['s_region'] : '');
  $sCountry = (isset($aItem['s_country']) ? $aItem['s_country'] : '');
  $address = sprintf('%s, %s, %s, %s', $sAddress, $sCity, $sRegion, $sCountry);
  $response = osc_file_get_contents(sprintf('http://maps.googleapis.com/maps/api/geocode/json?address=%s&sensor=false', urlencode($address)));
  $jsonResponse = json_decode($response);
  
  if (isset($jsonResponse->results[0]->geometry->location) && count($jsonResponse->results[0]->geometry->location) > 0) 		{
    $location = $jsonResponse->results[0]->geometry->location;
    $lat = $location->lat;
    $lng = $location->lng;
  
    ItemLocation::newInstance()->update (array('d_coord_lat' => $lat, 'd_coord_long' => $lng), array('fk_i_item_id' => $itemId));
  }
}

osc_add_hook('init',function() {
  if (osc_get_preference('include_maps_js', 'google_maps') != '0') {
    osc_add_hook('location', 'google_maps_location');
  }
});

osc_add_hook('posted_item', 'gm_insert_geo_location');
osc_add_hook('edited_item', 'gm_insert_geo_location');

osc_add_route('google_maps_settings', 'google_maps_settings', 'google_maps_settings', 'google_maps/admin/settings.php');
osc_add_hook('admin_menu_init', function() {
  osc_add_admin_submenu_divider('plugins', 'Google Maps Plugin', 'google_maps_divider', 'administrator');
  osc_add_admin_submenu_page('plugins', __('Settings', 'google_maps'), osc_route_admin_url('google_maps_settings'), 'google_maps_setting', 'administrator');
});

osc_add_hook('admin_header',  function() {
  if(Params::getParam('route')=='google_maps_settings') osc_remove_hook('admin_page_header', 'customPageHeader');
});

osc_add_hook('admin_page_header',  function() {
  if (Params::getParam('route') == 'google_maps_settings') {
    ?>
    <h1><?php _e('Google Maps Plugin', 'google_maps'); ?></h1>
    <?php
  }
});
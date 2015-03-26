<?php
/**
 * Includes resources for types
 *
 * @author Ernest Marcinko <ernest.marcinko@wp-dreams.com>
 * @version 4.0
 * @link http://wp-dreams.com, http://codecanyon.net/user/anago/portfolio
 * @copyright Copyright (c) 2012, Ernest Marcinko
 */

include(ASL_PATH."/backend/settings/functions.php");

// Include the types
include('class/type.class.php');
include('class/animations.class.php');
include('class/blogselect.class.php');
include('class/border.class.php');
include('class/borderradius.class.php');
include('class/boxshadow.class.php');
include('class/boxshadow-mini.class.php');
include('class/categories.class.php');
include('class/colorpicker.class.php');
include('class/colorpickerdummy.class.php');
include('class/customfields.class.php');
include('class/customposttypes.class.php');
include('class/customposttypeseditable.class.php');
include('class/customselect.class.php');
include('class/customfselect.class.php');
include('class/customtaxonomyterm.class.php');
include('class/four.class.php');
include('class/gradient.class.php');
include('class/hidden.class.php');
include('class/imageparser.class.php');
include('class/imageradio.class.php');
include('class/imagesettings.class.php');
include('class/labelposition.class.php');
include('class/languageselect.class.php');
include('class/numericunit.class.php');
include('class/onoff.class.php');
include('class/select.class.php');
include('class/text.class.php');
include('class/textarea.class.php');
include('class/textarea-isparam.class.php');
include('class/textsmall.class.php');
include('class/textshadow-mini.class.php');
include('class/themechooser.class.php');
include('class/upload.class.php');
include('class/uploadreset.class.php');
include('class/yesno.class.php');


add_action('admin_print_styles', 'admin_stylesV04');
add_action('admin_enqueue_scripts', 'admin_scriptsV04');;

if (!function_exists("admin_scriptsV04")) {
  function admin_scriptsV04() {

    wp_enqueue_media(); // For image uploader.
  	wp_enqueue_script('thickbox', false, array('jquery'));

  	wp_register_script('wpdreams-others', plugin_dir_url(__FILE__) . '/assets/others.js', array(
  		'jquery'
  	));
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-slider', array('jquery'));
  	wp_enqueue_script('jquery-ui-tabs', array('jquery'));
  	wp_enqueue_script('jquery-ui-sortable', array('jquery'));
  	wp_enqueue_script('jquery-ui-draggable', array('jquery'));
    wp_enqueue_script('jquery-ui-datepicker', array('jquery'));

  	wp_register_script('wpdreams-tabs', plugin_dir_url(__FILE__) . '/assets/tabs.js', array(
  		'jquery'
  	));
    wp_enqueue_script('wpdreams-tabs');
    
  	wp_register_script('wpdreams-upload', plugin_dir_url(__FILE__) . '/assets/upload.js', array(
  		'jquery',
  		'media-upload',
  		'thickbox'
  	));
  	wp_enqueue_script('wpdreams-upload');
  	wp_register_script('wpdreams-spectrum', plugin_dir_url(__FILE__) . '/assets/js/spectrum/spectrum.js', array(
  		'jquery'
  	));
    wp_register_script('wpdreams-fonts-jsapi', '//ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js');
    wp_enqueue_script('wpdreams-fonts-jsapi');

  	wp_enqueue_script('wpdreams-spectrum');
    
    wp_enqueue_script('wpdreams-others', array('jquery', 'jquery-ui-sortable'));    
    
  }
}

if (!function_exists("admin_stylesV04")) {
  function admin_stylesV04() {
  	wp_register_style('wpdreams-style', plugin_dir_url(__FILE__) . '/assets/style.css', array('wpdreams-tabs'));
  	wp_enqueue_style('wpdreams-style');
  	wp_enqueue_style('thickbox');
    wp_register_style('wpdreams-jqueryui', 'https://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css');
    wp_enqueue_style('wpdreams-jqueryui');
  	wp_register_style('wpdreams-tabs', plugin_dir_url(__FILE__) . '/assets/tabs.css');
  	wp_enqueue_style('wpdreams-tabs');
    wp_register_style('wpdreams-accordion', plugin_dir_url(__FILE__) . '/assets/accordion.css');
    wp_enqueue_style('wpdreams-accordion');
  	wp_register_style('wpdreams-spectrum', plugin_dir_url(__FILE__) . '/assets/js/spectrum/spectrum.css');
  	wp_enqueue_style('wpdreams-spectrum');
  	wp_register_style('wpdreams-animations', plugin_dir_url(__FILE__) . '/assets/animations.css');
  	wp_enqueue_style('wpdreams-animations');
  }
}

/* Extra Functions */
if (!function_exists("isEmpty")) {
  function isEmpty($v) {
  	if (trim($v) != "")
  		return false;
  	else
  		return true;
  }
}

if (!function_exists("in_array_r")) {
  function in_array_r($needle, $haystack, $strict = true) {
      foreach ($haystack as $item) {
          if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
              return true;
          }
      }
  
      return false;
  }
}

if (!function_exists("wpdreams_get_blog_list")) {
  function wpdreams_get_blog_list( $start = 0, $num = 10, $deprecated = '' ) {
  
  	global $wpdb;
    if (!isset($wpdb->blogs)) return array();
  	$blogs = $wpdb->get_results( $wpdb->prepare("SELECT blog_id, domain, path FROM $wpdb->blogs WHERE site_id = %d AND public = '1' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0' ORDER BY registered DESC", $wpdb->siteid), ARRAY_A );
  
  	foreach ( (array) $blogs as $details ) {
  		$blog_list[ $details['blog_id'] ] = $details;
  		$blog_list[ $details['blog_id'] ]['postcount'] = $wpdb->get_var( "SELECT COUNT(ID) FROM " . $wpdb->get_blog_prefix( $details['blog_id'] ). "posts WHERE post_status='publish' AND post_type='post'" );
  	}
  	unset( $blogs );
  	$blogs = $blog_list;
  
  	if ( false == is_array( $blogs ) )
  		return array();
  
  	if ( $num == 'all' )
  		return array_slice( $blogs, $start, count( $blogs ) );
  	else
  		return array_slice( $blogs, $start, $num );
  }
}
?>
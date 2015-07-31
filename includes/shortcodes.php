<?php
/* Prevent direct access */
defined('ABSPATH') or die("You can't access this file directly.");

add_shortcode('wpdreams_ajaxsearchlite_results', 'add_ajaxsearchlite_results');
add_shortcode( 'wpdreams_ajaxsearchlite', array( aslShortcodeContainer::get_instance(), 'wpdreams_asl_shortcode' ) );

class aslShortcodeContainer {

    protected static $instance = NULL;
    private static $instanceCount = 0;

    public static function get_instance() {
        // create an object
        NULL === self::$instance and self::$instance = new self;
        return self::$instance; // return the object
    }

    function wpdreams_asl_shortcode($atts) {
        $style = null;
        self::$instanceCount++;

        extract(shortcode_atts(array(
            'id' => 'something'
        ), $atts));

        $style = get_option('asl_options');
        $def_data = get_option('asl_defaults');

        $style = array_merge($def_data, $style);


        $settingsHidden = ((
            w_isset_def($style['show_frontend_search_settings'], 1) == 1
        ) ? false : true);

        do_action('asl_layout_before_shortcode', $id);

        $out = "";
        ob_start();
        include(ASL_PATH."includes/views/asl.shortcode.php");
        $out = ob_get_clean();

        do_action('asl_layout_after_shortcode', $id);

        return $out;
    }
}
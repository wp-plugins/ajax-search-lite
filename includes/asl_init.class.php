<?php
class aslInit {

    function ajaxsearchlite_activate() {
        $this->chmod();
    }

    function asl_init() {
        load_plugin_textdomain( 'ajax-search-lite', false, ASL_DIR . '/languages' );
    }

    function navigation_menu() {
        if (current_user_can('manage_options'))  {
            add_menu_page(
                __('Ajax Search Lite', 'ajax-search-lite'),
                __('Ajax Search Lite', 'ajax-search-lite'),
                'manage_options',
                ASL_DIR.'/backend/settings.php',
                '',
                ASL_URL.'icon.png',
                "207.9"
            );
            add_submenu_page(
                ASL_DIR.'/backend/settings.php',
                __("Ajax Search Lite", 'ajax-search-lite'),
                __("Analytics Integration", 'ajax-search-lite'),
                'manage_options',
                ASL_DIR.'/backend/analytics.php'
            );
        }
    }

    function styles() {

    }

    function scripts() {
        $prereq = 'wpdreams-asljquery';
        $js_source = 'nomin-scoped';
        wp_register_script('wpdreams-asljquery',  ASL_URL.'js/'.$js_source.'/asljquery.js');
        wp_enqueue_script('wpdreams-asljquery');
        wp_register_script('wpdreams-gestures', ASL_URL.'js/'.$js_source.'/jquery.gestures.js', array($prereq));
        wp_enqueue_script('wpdreams-gestures');
        wp_register_script('wpdreams-easing', ASL_URL.'js/'.$js_source.'/jquery.easing.js', array($prereq));
        wp_enqueue_script('wpdreams-easing');
        wp_register_script('wpdreams-mousewheel',ASL_URL.'js/'.$js_source.'/jquery.mousewheel.js', array($prereq));
        wp_enqueue_script('wpdreams-mousewheel');
        wp_register_script('wpdreams-scroll', ASL_URL.'js/'.$js_source.'/jquery.mCustomScrollbar.js', array($prereq, 'wpdreams-mousewheel'));
        wp_enqueue_script('wpdreams-scroll');
        wp_register_script('wpdreams-ajaxsearchlite', ASL_URL.'js/'.$js_source.'/jquery.ajaxsearchlite.js', array($prereq, "wpdreams-scroll"));
        wp_enqueue_script('wpdreams-ajaxsearchlite');


        wp_localize_script( 'wpdreams-ajaxsearchlite', 'ajaxsearchlite', array(
            'ajaxurl' => admin_url( 'admin-ajax.php'),
            'backend_ajaxurl' => admin_url( 'admin-ajax.php')
        ));

    }


    function chmod() {
        if (@chmod(ASL_CSS_PATH, 0777) == false)
            @chmod(ASL_CSS_PATH, 0755);
        if (@chmod(ASL_CACHE_PATH, 0777) == false)
            @chmod(ASL_CACHE_PATH, 0755);
        if (@chmod(ASL_TT_CACHE_PATH, 0777) == false)
            @chmod(ASL_TT_CACHE_PATH, 0755);
    }

    function footer() {

    }
}
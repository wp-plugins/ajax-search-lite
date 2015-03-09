<?php
function asl_search_stylesheets() {
    if (!is_admin()) {
        $asl_options = get_option('asl_options');
        wp_register_style('wpdreams-asl-basic', ASL_URL.'css/style.basic.css', true);
        wp_enqueue_style('wpdreams-asl-basic');
        wp_enqueue_style('wpdreams-ajaxsearchlite', plugins_url('css/style-'.w_isset_def($asl_options['theme'], 'polaroid').'.css', dirname(__FILE__)), false);
    }
}

add_action('wp_print_styles', 'asl_search_stylesheets');
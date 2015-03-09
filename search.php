<?php
add_action('wp_ajax_nopriv_ajaxsearchlite_search', 'ajaxsearchlite_search');
add_action('wp_ajax_ajaxsearchlite_search', 'ajaxsearchlite_search');

require_once(ASL_PATH . "/includes/imagecache.class.php");
require_once(ASL_PATH . "/includes/bfi_thumb.php");
require_once(ASL_PATH . "/includes/suggest.class.php");

require_once(ASL_PATH . "/includes/search.class.php");
require_once(ASL_PATH . "/includes/search_content.class.php");
require_once(ASL_PATH . "/includes/search_demo.class.php");

function ajaxsearchlite_search() {
    global $wpdb;
    global $search;

    /*print "in ajaxsearchlite_search();";
    print_r(array()); return;  */

    $s = $_POST['aslp'];
    $s = apply_filters('asl_search_phrase_before_cleaning', $s);

    $s = strtolower(trim($s));
    $s = preg_replace('/\s+/', ' ', $s);

    $s = apply_filters('asl_search_phrase_after_cleaning', $s);


    $def_data = get_option('asl_defaults');
    $search = array();
    $search['data'] = get_option('asl_options');
    $search['data'] = array_merge($def_data, $search['data']);

    $search['data']['image_options'] = array(
        'show_images' => $search['data']['show_images'],
        'image_bg_color' => '#FFFFFF',
        'image_transparency' => 1,
        'image_crop_location' => w_isset_def($search['data']['image_crop_location'], "c"),
        'image_width' => $search['data']['image_width'],
        'image_height' => $search['data']['image_height'],
        'image_source1' => $search['data']['image_source1'],
        'image_source2' => $search['data']['image_source2'],
        'image_source3' => $search['data']['image_source3'],
        'image_source4' => $search['data']['image_source4'],
        'image_source5' => $search['data']['image_source5'],
        'image_default' => $search['data']['image_default'],
        'image_custom_field' => $search['data']['image_custom_field']
    );

    // ----------------- Recalculate image width/height ---------------
    switch ($search['data']['resultstype']) {
        case "horizontal":
            /* Same width as height */
            $search['data']['image_options']['image_width'] = wpdreams_width_from_px($search['data']['image_options']['hreswidth']);
            $search['data']['image_options']['image_height'] = wpdreams_width_from_px($search['data']['image_options']['hreswidth']);
            break;
        case "polaroid":
            $search['data']['image_options']['image_width'] = intval($search['data']['preswidth']);
            $search['data']['image_options']['image_height'] = intval($search['data']['preswidth']);
            break;
        case "isotopic":
            $search['data']['image_options']['image_width'] = intval($search['data']['i_item_width'] * 1.5);
            $search['data']['image_options']['image_height'] = intval($search['data']['i_item_height'] * 1.5);
            break;
    }

    if (isset($search['data']['selected-imagesettings'])) {
        $search['data']['settings-imagesettings'] = $search['data']['selected-imagesettings'];
    }
    /*if (isset($search) && $search['data']['exactonly']!=1) {
      $_s = explode(" ", $s);
    }*/
    if (isset($_POST['options'])) {
        parse_str($_POST['options'], $search['options']);
    }


    $blogresults = array();


    $allpageposts = array();
    $pageposts = array();


    if (!isset($search['data']['selected-blogs']) || $search['data']['selected-blogs'] == null || count($search['data']['selected-blogs']) <= 0) {
        $search['data']['selected-blogs'] = array(0 => 1);
    }

    do_action('asl_before_search', $s);


    foreach ($search['data']['selected-blogs'] as $blog) {
        if (is_multisite()) switch_to_blog($blog);
        $params = array('data' => $search['data'], 'options' => $search['options']);

        $_posts = new wpdreams_searchContent($params);
        $pageposts = $_posts->search($s);
        $allpageposts = array_merge($allpageposts, $pageposts);

        do_action('asl_after_pagepost_results', $s, $pageposts);
    }

    if (is_multisite()) restore_current_blog();

    $allpageposts = apply_filters('asl_pagepost_results', $allpageposts);


    $results = array_merge(
        $allpageposts
    );


    /*if (count($results) <= 0) {
        $t = new keywordSuggest($search['data']['keywordsuggestionslang']);
        $keywords = $t->getKeywords($s);
        if ($keywords != false) {
            $results['keywords'] = $keywords;
            $results['nores'] = 1;
            $results = apply_filters('asl_only_keyword_results', $results);
        }
    }*/

    $results = apply_filters('asl_results', $results);

    do_action('asl_after_search', $s, $results);

    /* Clear output buffer, possible warnings */
    print "!!ASPSTART!!";
    //var_dump($results);die();  
    print_r(json_encode($results));
    print "!!ASPEND!!";
    die();

}
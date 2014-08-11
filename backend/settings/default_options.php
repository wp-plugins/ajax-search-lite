<?php
/**
 * Default option store
 *
 * The $options variable stores all the default values
 * for a new Ajax Search lite instance and for all the option pages.
 *
 * @author Ernest Marcinko <ernest.marcinko@wp-dreams.com>
 * @link http://wp-dreams.com, http://codecanyon.net/user/anago/portfolio
 * @copyright Copyright (c) 2012, Ernest Marcinko
 */

  /* Default caching options */
  $options = array();


$options['asl_analytics_def']['analytics'] = 0;
$options['asl_analytics_def']['analytics_string'] = "ajax_search-{asl_term}";


/* Default new search options */

// General options
$options['asl_defaults']['theme'] = 'simple-red';
$options['asl_defaults']['triggeronclick'] = 1;
$options['asl_defaults']['redirectonclick'] = 0;
$options['asl_defaults']['triggerontype'] = 1;
$options['asl_defaults']['searchinposts'] =  1;
$options['asl_defaults']['searchinpages'] =  1;
$options['asl_defaults']['customtypes'] = "";
$options['asl_defaults']['searchintitle'] =  1;
$options['asl_defaults']['searchincontent'] =  1;
$options['asl_defaults']['searchinexcerpt'] =  1;
$options['asl_defaults']['customfields'] = "";

$options['asl_defaults']['exactonly'] =  0;
$options['asl_defaults']['searchinterms'] =  0;

$options['asl_defaults']['charcount'] =  3;
$options['asl_defaults']['maxresults'] =  10;
$options['asl_defaults']['itemscount'] =  4;
$options['asl_defaults']['resultitemheight'] =  "70px";

$options['asl_defaults']['orderby_def'] = array(
    array('option'=>'Title descending', 'value'=>'post_title DESC'),
    array('option'=>'Title ascending', 'value'=>'post_title ASC'),
    array('option'=>'Date descending', 'value'=>'post_date DESC'),
    array('option'=>'Date ascending', 'value'=>'post_date ASC')
);
$options['asl_defaults']['orderby'] = 'post_date DESC';

// General/Image
$options['asl_defaults']['show_images'] = 1;
$options['asl_defaults']['image_transparency'] = 1;
$options['asl_defaults']['image_bg_color'] = "#FFFFFF";
$options['asl_defaults']['image_width'] = 70;
$options['asl_defaults']['image_height'] = 70;

$options['asl_defaults']['image_crop_location'] = 'c';
$options['asl_defaults']['image_crop_location_selects'] = array(
    array('option'=>'In the center', 'value'=>'c'),
    array('option'=>'Align top', 'value'=>'t'),
    array('option'=>'Align top right', 'value'=>'tr'),
    array('option'=>'Align top left', 'value'=>'tl'),
    array('option'=>'Align bottom', 'value'=>'b'),
    array('option'=>'Align bottom right', 'value'=>'br'),
    array('option'=>'Align bottom left', 'value'=>'bl'),
    array('option'=>'Align left', 'value'=>'l'),
    array('option'=>'Align right', 'value'=>'r')
);

$options['asl_defaults']['image_sources'] = array(
    array('option'=>'Featured image', 'value'=>'featured'),
    array('option'=>'Post Content', 'value'=>'content'),
    array('option'=>'Post Excerpt', 'value'=>'excerpt'),
    array('option'=>'Custom field', 'value'=>'custom'),
    array('option'=>'Page Screenshot', 'value'=>'screenshot'),
    array('option'=>'Default image', 'value'=>'default'),
    array('option'=>'Disabled', 'value'=>'disabled')
);

$options['asl_defaults']['image_source1'] = 'featured';
$options['asl_defaults']['image_source2'] = 'content';
$options['asl_defaults']['image_source3'] = 'excerpt';
$options['asl_defaults']['image_source4'] = 'custom';
$options['asl_defaults']['image_source5'] = 'default';

$options['asl_defaults']['image_default'] = ASL_URL."img/default.jpg";
$options['asl_defaults']['image_custom_field'] = '';
$options['asl_defaults']['use_timthumb'] = 1;


/* Frontend search settings Options */
$options['asl_defaults']['show_frontend_search_settings'] = 1;
$options['asl_defaults']['showexactmatches'] = 1;
$options['asl_defaults']['showsearchinposts'] = 1;
$options['asl_defaults']['showsearchinpages'] = 1;
$options['asl_defaults']['showsearchintitle'] = 1;
$options['asl_defaults']['showsearchincontent'] = 1;
$options['asl_defaults']['showcustomtypes'] = '';
$options['asl_defaults']['showsearchincomments'] = 1;
$options['asl_defaults']['showsearchinexcerpt'] = 1;
$options['asl_defaults']['showsearchinbpusers'] = 0;
$options['asl_defaults']['showsearchinbpgroups'] = 0;
$options['asl_defaults']['showsearchinbpforums'] = 0;

$options['asl_defaults']['exactmatchestext'] = "Exact matches only";
$options['asl_defaults']['searchinpoststext'] = "Search in posts";
$options['asl_defaults']['searchinpagestext'] = "Search in pages";
$options['asl_defaults']['searchintitletext'] = "Search in title";
$options['asl_defaults']['searchincontenttext'] = "Search in content";
$options['asl_defaults']['searchincommentstext'] = "Search in comments";
$options['asl_defaults']['searchinexcerpttext'] = "Search in excerpt";
$options['asl_defaults']['searchinbpuserstext'] = "Search in users";
$options['asl_defaults']['searchinbpgroupstext'] = "Search in groups";
$options['asl_defaults']['searchinbpforumstext'] = "Search in forums";

$options['asl_defaults']['showsearchincategories'] = 1;
$options['asl_defaults']['showuncategorised'] = 1;
$options['asl_defaults']['exsearchincategories'] = "";
$options['asl_defaults']['exsearchincategoriesheight'] = 200;
$options['asl_defaults']['showsearchintaxonomies'] = 1;
$options['asl_defaults']['showterms'] = "";
$options['asl_defaults']['showseparatefilterboxes'] = 1;
$options['asl_defaults']['exsearchintaxonomiestext'] = "Filter by";
$options['asl_defaults']['exsearchincategoriestext'] = "Filter by Categories";
$options['asl_defaults']['exsearchincategoriestextfont'] = 'font-weight:bold;font-family:--g--Open Sans;color:rgb(26, 71, 98);font-size:13px;line-height:15px;text-shadow:0px 0px 0px rgba(255, 255, 255, 0);';

/* Layout Options */
$options['asl_defaults']['resultstype_def'] = array(
    array('option'=>'Vertical Results', 'value'=>'vertical'),
    array('option'=>'Horizontal Results', 'value'=>'horizontal'),
    array('option'=>'Isotopic Results', 'value'=>'isotopic'),
    array('option'=>'Polaroid style Results', 'value'=>'polaroid')
);
$options['asl_defaults']['resultstype'] = 'vertical';
$options['asl_defaults']['resultsposition_def'] = array(
    array('option'=>'Hover - over content', 'value'=>'hover'),
    array('option'=>'Block - pushes content', 'value'=>'block')
);
$options['asl_defaults']['resultsposition'] = 'hover';
$options['asl_defaults']['resultsmargintop'] = '12px';

$options['asl_defaults']['defaultsearchtext'] = '';
$options['asl_defaults']['showmoreresults'] = 0;
$options['asl_defaults']['showmoreresultstext'] = 'More results...';
$options['asl_defaults']['showmorefont'] = 'font-weight:normal;font-family:--g--Open Sans;color:rgba(5, 94, 148, 1);font-size:12px;line-height:15px;text-shadow:0px 0px 0px rgba(255, 255, 255, 0);';
$options['asl_defaults']['scroll_to_results'] = 0;
$options['asl_defaults']['resultareaclickable'] = 1;
$options['asl_defaults']['close_on_document_click'] = 1;
$options['asl_defaults']['show_close_icon'] = 1;
$options['asl_defaults']['showauthor'] = 1;
$options['asl_defaults']['showdate'] = 1;
$options['asl_defaults']['showdescription'] = 1;
$options['asl_defaults']['descriptionlength'] = 100;
$options['asl_defaults']['noresultstext'] = "No results!";
$options['asl_defaults']['didyoumeantext'] = "Did you mean:";
$options['asl_defaults']['highlight'] = 0;
$options['asl_defaults']['highlightwholewords'] = 1;
$options['asl_defaults']['highlightcolor'] = "#d9312b";
$options['asl_defaults']['highlightbgcolor'] = "#eee";

/* Autocomplete options */
$options['asl_defaults']['autocomplete'] = 1;
$options['asl_defaults']['autocompleteexceptions'] = '';
$options['asl_defaults']['autocompletesource_def'] = array(
    array('option'=>'Search Statistics', 'value'=>0),
    array('option'=>'Google Keywords', 'value'=>1)
);
$options['asl_defaults']['autocompletesource'] = 1;


/* Advanced Options */
$options['asl_defaults']['striptagsexclude'] = '<span><a><abbr><b>';
$options['asl_defaults']['runshortcode'] = 1;
$options['asl_defaults']['stripshortcode'] = 0;
$options['asl_defaults']['pageswithcategories'] = 0;

$options['asl_defaults']['titlefield_def'] = array(
    array('option'=>'Post Title', 'value'=>0),
    array('option'=>'Post Excerpt', 'value'=>1)
);
$options['asl_defaults']['titlefield'] = 0;

$options['asl_defaults']['descriptionfield_def'] = array(
    array('option'=>'Post Description', 'value'=>0),
    array('option'=>'Post Excerpt', 'value'=>1),
    array('option'=>'Post Title', 'value'=>2)
);
$options['asl_defaults']['descriptionfield'] = 0;


$options['asl_defaults']['excludecategories'] = '';
$options['asl_defaults']['excludeposts'] = '';

$options['asl_defaults']['wpml_compatibility'] = 1;


  /* Save the defaul options if not exist */
  $_asl_ver = get_option('asl_version');

  // Update the default options if not exist/newer version available/debug mode is on
  foreach($options as $key=>$value) {
     if (get_option($key) === false || $_asl_ver != ASL_CURRENT_VERSION || ASL_DEBUG == 1) {
        update_option($key, $value);
     }
  }

  if (get_option('asl_options')===false || ASL_DEBUG == 1)
        update_option('asl_options', $options['asl_defaults']);

  update_option('asl_version', ASL_CURRENT_VERSION);

?>
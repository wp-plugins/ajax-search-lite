<?php
  /* Default options */
  $_search_default = array();
  
  $_search_default['asl_theme'] = "
     Minimal|style.css;
     Dashed Blue|style-dashedblue.css||
     style.css
  ";
  $_search_default['asl_theme_select'] = "style.css";
  
  $_search_default['asl_searchinposts'] =  1;
  $_search_default['asl_searchinpages'] =  1;
  $_search_default['asl_searchintitle'] =  1;
  $_search_default['asl_searchincontent'] =  1;
  $_search_default['asl_searchinexcerpt'] =  1;
  $_search_default['asl_exactonly'] =  0;

  $_search_default['asl_charcount'] =  3;
  $_search_default['asl_maxresults'] =  30;
  $_search_default['asl_itemscount'] =  4;

  $_search_default['asl_orderby'] = "
     Title descending|post_title DESC;
     Title ascending|post_title ASC;
     Date descending|post_date DESC;
     Date ascending|post_date ASC||
     post_date DESC
  ";
  $_search_default['asl_orderby_select'] = "post_date DESC";  
  
  
  /* Frontend search settings Options */
  $_search_default['asl_showexactmatches'] = 1;
  $_search_default['asl_showsearchinposts'] = 1;
  $_search_default['asl_showsearchinpages'] = 1;
  $_search_default['asl_showsearchintitle'] = 1;
  $_search_default['asl_showsearchincontent'] = 1;
  $_search_default['asl_showsearchinexcerpt'] = 1;
  
  $_search_default['asl_exactmatchestext'] = "Exact matches only";
  $_search_default['asl_searchinpoststext'] = "Search in posts";
  $_search_default['asl_searchinpagestext'] = "Search in pages";
  $_search_default['asl_searchintitletext'] = "Search in title";
  $_search_default['asl_searchincontenttext'] = "Search in content";
  $_search_default['asl_searchinexcerpttext'] = "Search in excerpt";

  $_search_default['asl_resultareaclickable'] = 0;
  $_search_default['asl_showauthor'] = 1;
  $_search_default['asl_showdate'] = 1;
  $_search_default['asl_showdescription'] = 1;
  $_search_default['asl_descriptionlength'] = 100;
  $_search_default['asl_noresultstext'] = "No results!";
  $_search_default['asl_didyoumeantext'] = "Did you mean:";
  $_search_default['asl_highlight'] = 1;
  $_search_default['asl_highlightwholewords'] = 1;

  $_search_default['asl_showauthor'] = 1;
  $_search_default['asl_showdate'] = 1;
  $_search_default['asl_showdescription'] = 1;
  $_search_default['asl_descriptionlength'] = 130;
  
  /* Save the defaul options if not exist */
  foreach($_search_default as $key=>$value) {
     if (get_option($key)===false)
      update_option($key, $value);
  }
?>
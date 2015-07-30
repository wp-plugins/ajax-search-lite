<?php
/* Prevent direct access */
defined('ABSPATH') or die("You can't access this file directly.");

if (!class_exists('wpdreams_searchDemo')) {
  class wpdreams_searchDemo extends wpdreams_search {  
    
    protected function do_search() { 
      global $wpdb;
      
      if (isset($wpdb->base_prefix)) {
        $_prefix = $wpdb->base_prefix;
      } else {
        $_prefix = $wpdb->prefix;
      } 
    
      $options = $this->options;
      $searchData = $this->searchData;     
  
    	$querystr = "
    		SELECT 
          $wpdb->posts.post_title as title,
          $wpdb->posts.ID as id,
          $wpdb->posts.post_date as date,
          $wpdb->posts.post_content as content,
          $wpdb->posts.post_excerpt as excerpt,
          $wpdb->users.user_nicename as author, 
          $wpdb->posts.post_type as post_type
    		FROM $wpdb->posts
        LEFT JOIN $wpdb->users ON $wpdb->users.ID = $wpdb->posts.post_author
    		ORDER BY ".$wpdb->posts.".post_date DESC
    		LIMIT 10";

  	 	$pageposts = $wpdb->get_results($querystr, OBJECT);
      
      $this->results = $pageposts;
      return $pageposts;
    
    } 
    
  }
}
?>
<?php
  /* Ajax functions here */

  add_action('wp_ajax_ajaxsearchpro_deletekeyword', 'ajaxsearchpro_deletekeyword');
  function ajaxsearchpro_deletekeyword() {
    global $wpdb;
    if (isset($wpdb->base_prefix)) {
      $_prefix = $wpdb->base_prefix;
    } else {
      $_prefix = $wpdb->prefix;
    }
    if (isset($_POST['keywordid'])) {
      $wpdb->query("DELETE FROM ".$_prefix."ajaxsearchpro_statistics WHERE id=".$_POST['keywordid']);
      print 1;
    }
    die();
  } 
  
?>
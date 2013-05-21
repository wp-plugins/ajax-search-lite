<?php
  add_action('wp_ajax_nopriv_ajaxsearchlite_search', 'ajaxsearchlite_search');
  add_action('wp_ajax_ajaxsearchlite_search', 'ajaxsearchlite_search');
  require_once(AJAXSEARCHLITE_PATH."/includes/imagecache.class.php");
   
  function ajaxsearchlite_search() {
  	global $wpdb;
    $like = "";
    $s = trim($_POST['s']);
    $s= preg_replace( '/\s+/', ' ', $s);
    if (isset($wpdb->base_prefix)) {
      $_prefix = $wpdb->base_prefix;
    } else {
      $_prefix = $wpdb->prefix;
    }

    if (get_option('asl_exactonly')!=1) {
      $_s = explode(" ", $s);
    }    
    if (isset($_POST['options'])) {
      parse_str($_POST['options'], $options);   
    } 
    $limit = get_option('asl_maxresults');
    $not_exactonly = (isset($options['set_exactonly'])?false:true);
    $searchintitle = (isset($options['set_intitle'])?true:false);
    $searchincontent = (isset($options['set_incontent'])?true:false);
    $searchinposts = (isset($options['set_inposts'])?true:false);
    $searchinpages = (isset($options['set_inpages'])?true:false);

    if ($searchintitle) {
     if ($not_exactonly) {
      $sr = implode("%' OR lower($wpdb->posts.post_title) like '%",$_s);
      $sr =  " lower($wpdb->posts.post_title) like '%".$sr."%'";
     } else {
      $sr =  " lower($wpdb->posts.post_title) like '%".$s."%'";
     }
     $like .= $sr;
    }
    
    if ($searchincontent) {
     if ($not_exactonly) {
      $sr = implode("%' OR lower($wpdb->posts.post_content) like '%",$_s);
      if ($like!="") {
        $sr =  " OR lower($wpdb->posts.post_content) like '%".$sr."%'";
      } else {
        $sr =  " lower($wpdb->posts.post_content) like '%".$sr."%'";
      }
     } else {
      if ($like!="") {
        $sr =  " OR lower($wpdb->posts.post_content) like '%".$s."%'";
      } else {
        $sr =  " lower($wpdb->posts.post_content) like '%".$s."%'";
      }
     }
     $like .= $sr;
    }
    

    if ($searchinposts) {
      $where = " $wpdb->posts.post_type='post'"; 
    }
    
    if ($searchinpages) {
      if ($where!="")
        $where.= " OR $wpdb->posts.post_type='page'";
      else
        $where.= "$wpdb->posts.post_type='page'"; 
    }
    
    if ($where=="") {
      $where = "$wpdb->posts.post_type=''";
    } 
    $orderby = get_option('asl_orderby_select');  
  	$s=strtolower(addslashes($_POST['s']));
  	$querystr = "
  		SELECT 
        $wpdb->posts.post_title as title,
        $wpdb->posts.ID as id,
        $wpdb->posts.post_date as date,
        $wpdb->posts.post_content as content,
        $wpdb->posts.post_excerpt as excerpt,
        $wpdb->users.user_nicename as author
  		FROM $wpdb->posts
      LEFT JOIN $wpdb->users ON $wpdb->users.ID = $wpdb->posts.post_author
      LEFT JOIN $wpdb->term_relationships ON $wpdb->posts.ID = $wpdb->term_relationships.object_id
      LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_taxonomy_id = $wpdb->term_relationships.term_taxonomy_id
      LEFT JOIN $wpdb->terms ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id
  		WHERE
      ($wpdb->posts.post_status='publish' $searchin) AND
      (".$where.")			    
      AND (".$like.")
      GROUP BY
        $wpdb->posts.ID
  		ORDER BY ".$wpdb->posts.".".$orderby."
  		LIMIT $limit;
  	 ";
	 	$pageposts = $wpdb->get_results($querystr, OBJECT);
    foreach ($pageposts as $k=>$v) {
       $pageposts[$k]->link = get_permalink($v->id);
       $img = new wpdreamsImageCache($v->content, AJAXSEARCHLITE_PATH.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR, 70, 70, 1);
       $res = $img->get_image();
       if ($res!='') {
         $pageposts[$k]->image = plugins_url('/cache/'.$res , __FILE__);
       }
       if ($pageposts[$k]->content!='')
        $pageposts[$k]->content = substr(strip_tags($pageposts[$k]->content), 0, 130)."...";
    }

    $results = $pageposts;      
    
    print_r(json_encode($results));
  	die(); 
  }

  
?>
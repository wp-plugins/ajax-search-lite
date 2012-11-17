<?php
  add_action('wp_ajax_nopriv_ajaxsearchlite_search', 'ajaxsearchlite_search');
  add_action('wp_ajax_ajaxsearchlite_search', 'ajaxsearchlite_search');
  require_once(AJAXSEARCHLITE_PATH."/includes/imagecache.class.php");
   
  function ajaxsearchlite_search() {
  	global $wpdb;
    $like = "";
    $s = trim($_POST['s']);
    $s= preg_replace( '/\s+/', ' ', $s);

    $search = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ajaxsearchlite", ARRAY_A);
    
    $search['data'] = json_decode($search['data'], true);
    if (isset($search) && $search['data']['exactonly']!=1) {
      $_s = explode(" ", $s);
    }    
    if (isset($_POST['options'])) {
      parse_str($_POST['options'], $options);   
    } 
    $limit = $search['data']['maxresults'];
    $not_exactonly = ((isset($search['data']['exactonly']) && $search['data']['exactonly']!=1 && !(isset($options['set_exactonly'])))?true:false);
    $searchintitle = (($search['data']['searchintitle']==1)?true:false);
    $searchincontent = (($search['data']['searchincontent']==1)?true:false);
    $searchinposts = (($search['data']['searchinposts']==1 && (isset($options['set_inposts']) || $options['set_inposts']=='checked'))?true:false);
    $searchinpages = (($search['data']['searchinpages']==1 && (isset($options['set_inpages']) || $options['set_inpages']=='checked'))?true:false);

    
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
    $orderby = ((isset($search['data']['selected-orderby']) && $search['data']['selected-orderby']!='')?$search['data']['selected-orderby']:"post_date DESC");   
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
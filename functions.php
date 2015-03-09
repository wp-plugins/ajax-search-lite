<?php
if (!function_exists("mysql_escape_mimic")) {
  function mysql_escape_mimic($inp) { 
      if(is_array($inp)) 
          return array_map(__METHOD__, $inp); 
  
      if(!empty($inp) && is_string($inp)) { 
          return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp); 
      } 
  
      return $inp; 
  }
} 

if (!function_exists("in_array_r")) {
  function in_array_r($needle, $haystack, $strict = true) {
      foreach ($haystack as $item) {
          if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
              return true;
          }
      }
  
      return false;
  }
}

if (!function_exists("wd_substr_at_word")) {
  function wd_substr_at_word($text, $length) {
      if (strlen($text) <= $length) return $text;
      $blogCharset = get_bloginfo('charset');
      $charset = $blogCharset !== '' ? $blogCharset : 'UTF-8';
      $s = mb_substr($text, 0, $length, $charset);
      return mb_substr($s, 0, strrpos($s, ' '), $charset);
  }
}

if (!function_exists("wpdreams_ismobile")) {
  function wpdreams_ismobile() {
    $is_mobile = '0';    
    if(preg_match('/(android|iphone|ipad|up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
        $is_mobile=1;  
    if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']))))
        $is_mobile=1;  
    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
    $mobile_agents = array('w3c ','acs-','alav','alca','amoi','andr','audi','avan','benq','bird','blac','blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno','ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-','maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-','newt','noki','oper','palm','pana','pant','phil','play','port','prox','qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar','sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-','tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp','wapr','webc','winw','winw','xda','xda-');
    
    if(in_array($mobile_ua,$mobile_agents))
        $is_mobile=1;
    
    if (isset($_SERVER['ALL_HTTP'])) {
        if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini')>0) 
            $is_mobile=1;
    }    
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows')>0) 
        $is_mobile=0;
    return $is_mobile;
  }
}
if (!function_exists("current_page_url")) {  
  function current_page_url() {
  	$pageURL = 'http';
  	if( isset($_SERVER["HTTPS"]) ) {
  		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
  	}
  	$pageURL .= "://";
  	if ($_SERVER["SERVER_PORT"] != "80") {
  		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
  	} else {
  		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
  	}
  	return $pageURL;
  }  
} 
if (!function_exists("wpdreams_hex2rgb")) {  
  function wpdreams_hex2rgb($color)
  {
      if (strlen($color)>7) return $color;
      if (strlen($color)<3) return "0, 0, 0";
      if ($color[0] == '#')
          $color = substr($color, 1);
      if (strlen($color) == 6)
          list($r, $g, $b) = array($color[0].$color[1],
                                   $color[2].$color[3],
                                   $color[4].$color[5]);
      elseif (strlen($color) == 3)
          list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
      else
          return false;
      $r = hexdec($r); $g = hexdec($g); $b = hexdec($b); 
      return $r.", ".$g.", ".$b;
  }  
}

if (!function_exists("wpdreams_rgb2hex")) {
    function wpdreams_rgb2hex($color)
    {
        if (strlen($color)>7) {
          preg_match("/.*?\((\d+), (\d+), (\d+).*?/", $color, $c);
          if (is_array($c) && count($c)>3) {
             $color = "#".sprintf("%02X", $c[1]);
             $color .= sprintf("%02X", $c[2]);
             $color .= sprintf("%02X", $c[3]);
          }
        }
        return $color;
    }
} 

if (!function_exists("get_content_w")) {  
  function get_content_w($id)
  {
      $my_postid = $id;
      $content_post = get_post($my_postid);
      $content = $content_post->post_content;
      $content = apply_filters('the_content', $content);
      $content = str_replace(']]>', ']]&gt;', $content);
      return $content;
  }  
}

if (!function_exists("wpdreams_utf8safeencode")) {  
  function wpdreams_utf8safeencode($s, $delimiter)
  {
    $convmap= array(0x0100, 0xFFFF, 0, 0xFFFF);
    return $delimiter."_".base64_encode(mb_encode_numericentity($s, $convmap, 'UTF-8'));
  }  
}

if (!function_exists("wpdreams_utf8safedecode")) {  
  function wpdreams_utf8safedecode($s, $delimiter)
  {
    if (strpos($s, $delimiter)!=0) return $s;
    $convmap= array(0x0100, 0xFFFF, 0, 0xFFFF);
    $_s = explode($delimiter."_", $s);
    return base64_decode(mb_decode_numericentity($s[1], $convmap, 'UTF-8'));
  }  
}

if (!function_exists("postval_or_getoption")) {  
  function postval_or_getoption($option)
  {
    if (isset($_POST) && isset($_POST[$option]))
      return $_POST[$option];
    return get_option($option);
  }  
}

if (!function_exists("setval_or_getoption")) {  
  function setval_or_getoption($options, $key)
  {
    if (isset($options) && isset($options[$key]))
      return $options[$key];
    $def_options = get_option('asl_defaults');
    if (isset($def_options[$key]))
      return $def_options[$key];
    else
      return "";
  }  
}

if (!function_exists("wpdreams_get_image_from_content")) {
    function wpdreams_get_image_from_content($content, $number = 0) {
      if ($content=="") return false;
      $dom = new domDocument;
      @$dom->loadHTML($content);
      $dom->preserveWhiteSpace = false;
      @$images = $dom->getElementsByTagName('img');
      if ($images->length>0) {
         if ($images->length > $number) {
           $im = $images->item($number)->getAttribute('src');
         } else {
           $number = 0;
           $im = $images->item(0)->getAttribute('src');
         }
         return $im;
      } else {
         return false;
      }
    }
}

if (!function_exists("wpdreams_on_backend_page")) {  
  function wpdreams_on_backend_page($pages)
  {
    if (isset($_GET) && isset($_GET['page'])) {
        return in_array($_GET['page'] ,$pages);
    }
    return false;
  }  
}


/* Extra Functions */
if (!function_exists("isEmpty")) {
  function isEmpty($v) {
  	if (trim($v) != "")
  		return false;
  	else
  		return true;
  }
}

if (!function_exists("in_array_r")) {
  function in_array_r($needle, $haystack, $strict = true) {
      foreach ($haystack as $item) {
          if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
              return true;
          }
      }
  
      return false;
  }
}

if (!function_exists("wpdreams_on_backend_page")) {
    /**
     * @param $pages
     * @return bool
     */
    function wpdreams_on_backend_page($pages)
    {
        if (isset($_GET) && isset($_GET['page'])) {
            return in_array($_GET['page'] ,$pages);
        }
        return false;
    }
}

if (!function_exists("wpdreams_on_backend_post_editor")) {
    /**
     * @return bool
     */
    function wpdreams_on_backend_post_editor() {
        $current_url = current_page_url();
        return (strpos($current_url, 'post-new.php')!==false ||
            strpos($current_url, 'post.php')!==false);
    }
}

if (!function_exists("wpdreams_get_blog_list")) {
  function wpdreams_get_blog_list( $start = 0, $num = 10, $deprecated = '' ) {
  
  	global $wpdb;
    if (!isset($wpdb->blogs)) return array();
  	$blogs = $wpdb->get_results( $wpdb->prepare("SELECT blog_id, domain, path FROM $wpdb->blogs WHERE site_id = %d AND public = '1' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0' ORDER BY registered DESC", $wpdb->siteid), ARRAY_A );
  
  	foreach ( (array) $blogs as $details ) {
  		$blog_list[ $details['blog_id'] ] = $details;
  		$blog_list[ $details['blog_id'] ]['postcount'] = $wpdb->get_var( "SELECT COUNT(ID) FROM " . $wpdb->get_blog_prefix( $details['blog_id'] ). "posts WHERE post_status='publish' AND post_type='post'" );
  	}
  	unset( $blogs );
  	$blogs = $blog_list;
  
  	if ( false == is_array( $blogs ) )
  		return array();
  
  	if ( $num == 'all' )
  		return array_slice( $blogs, $start, count( $blogs ) );
  	else
  		return array_slice( $blogs, $start, $num );
  }
}

?>
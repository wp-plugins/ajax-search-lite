<?php

if (!function_exists("w_isset_def")) {
    function w_isset_def(&$v, $d)
    {
        if (isset($v)) return $v;
        return $d;
    }
}

if (!function_exists("wpdreams_setval_or_getoption")) {  
  function wpdreams_setval_or_getoption($options, $key, $def_key)
  {
    if (isset($options) && isset($options[$key]))
      return $options[$key];
    $def_options = get_option($def_key);
    return $def_options[$key];
  }  
}

if (!function_exists("wpdreams_get_selected")) {
    function wpdreams_get_selected($option, $key) {
        return isset($option['selected-'.$key])?$option['selected-'.$key]:array();
    }
}

if (!function_exists("wpdreams_keyword_count_sort")) { 
  function wpdreams_keyword_count_sort($first, $sec) {
  	return $sec[1] - $first[1];
  } 
}

if (!function_exists("wpdreams_get_stylesheet")) {
    function wpdreams_get_stylesheet($dir, $id, $style) {
        ob_start();
        include($dir."style.css.php");
        $out = ob_get_contents();
        ob_end_clean();
        if (isset($style['custom_css_special']) && isset($style['custom_css_selector'])
        && $style['custom_css_special'] != "") {
            $out.= " ".stripcslashes(str_replace('[instance]',
                str_replace('THEID', $id, $style['custom_css_selector']),
                $style['custom_css_special']));
        }
        return $out;
    }
}

if (!function_exists("wpdreams_update_stylesheet")) {
    function wpdreams_update_stylesheet($dir, $id, $style) {
        $out = wpdreams_get_stylesheet($dir, $id, $style);
        if (isset($style['css_compress']) && $style['css_compress'] == true)
            $out = wpdreams_css_compress($out);
        return @file_put_contents($dir."style".$id.".css", $out, FILE_TEXT);
    }
}

if (!function_exists("wpdreams_parse_params")) {
    function wpdreams_parse_params($params) {
        foreach ($params as $k=>$v) {
            $_tmp = explode('classname-', $k);
            if ($_tmp!=null && count($_tmp)>1) {
                ob_start();
                $c = new $v('0', '0', $params[$_tmp[1]]);
                $out = ob_get_clean();
                $params['selected-'.$_tmp[1]] = $c->getSelected();
            }
            $_tmp = null;
            $_tmp = explode('wpdfont-', $k);
            if ($_tmp!=null && count($_tmp)>1) {
                ob_start();
                $c = new $v('0', '0', $params[$_tmp[1]]);
                $out = ob_get_clean();
                $params['import-'.$_tmp[1]] = $c->getImport();
            }
        }
        return $params;
    }
}

if (!function_exists("wpdreams_admin_hex2rgb")) {  
  function wpdreams_admin_hex2rgb($color)
  {
      if (strlen($color)>7) return $color;
      if (strlen($color)<3) return "rgba(0, 0, 0, 1)";
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
      return "rgba(".$r.", ".$g.", ".$b.", 1)";
  }  
}
if (!function_exists("wpdreams_four_to_string")) {
    function wpdreams_four_to_string($data) {
        // 1.Top 2.Bottom 3.Right 4.Left
        preg_match("/\|\|(.*?)\|\|(.*?)\|\|(.*?)\|\|(.*?)\|\|/", $data, $matches);
        // 1.Top 3.Right 2.Bottom 4.Left
        return $matches[1]." ".$matches[3]." ".$matches[2]." ".$matches[4];
    }
}


if (!function_exists("wpdreams_box_shadow_css")) {  
  function wpdreams_box_shadow_css($css) {
    $css = str_replace("\n", "", $css);
    preg_match("/box-shadow:(.*?)px (.*?)px (.*?)px (.*?)px (.*?);/", $css, $matches);
    $ci = $matches[5];
    $hlength = $matches[1];
    $vlength = $matches[2];
    $blurradius = $matches[3];
    $spread = $matches[4];
    $moz_blur = ($blurradius>2)?$blurradius - 2:0;
    if ($hlength==0 && $vlength==0 && $blurradius==0 && $spread==0) {
        echo "box-shadow: none;";
    } else {
        echo "box-shadow:".$hlength."px ".$vlength."px ".$moz_blur."px ".$spread."px ".$ci.";";
        echo "-webkit-box-shadow:".$hlength."px ".$vlength."px ".$blurradius."px ".$spread."px ".$ci.";";
        echo "-ms-box-shadow:".$hlength."px ".$vlength."px ".$blurradius."px ".$spread."px ".$ci.";";
    }
  }
}

if (!function_exists("wpdreams_gradient_css")) {  
  function wpdreams_gradient_css($data, $print=true)
  {
  
		$data = str_replace("\n", "", $data);
    preg_match("/(.*?)-(.*?)-(.*?)-(.*)/", $data, $matches);
    
    if (!isset($matches[1]) || !isset($matches[2]) || !isset($matches[3])) {
      // Probably only 1 color..
      if ($print) echo "background: ".$data.";";
      return "background: ".$data.";";
    }
    
    $type = $matches[1];
    $deg = $matches[2];
		$color1 = wpdreams_admin_hex2rgb($matches[3]);
		$color2 = wpdreams_admin_hex2rgb($matches[4]);

    // Check for full transparency
    preg_match("/rgba\(.*?,.*?,.*?,[\s]*(.*?)\)/", $color1, $opacity1);
    preg_match("/rgba\(.*?,.*?,.*?,[\s]*(.*?)\)/", $color2, $opacity2);
    if (isset($opacity1[1]) && $opacity1[1] == "0" && isset($opacity2[1]) && $opacity2[1] == "0") {
        if ($print) echo "background: transparent;";
        return "background: transparent;";
    }
    
    ob_start();
    //compatibility
    /*if (strlen($color1)>7) {
      preg_match("/\((.*?)\)/", $color1, $matches);
      $colors = explode(',', $matches[1]);
      echo "background: rgb($colors[0], $colors[1], $colors[2]);";
    } else {
      echo "background: ".$color1.";";
    }   */
    //linear

    if ($type!='0' || $type!=0) {
      ?>
        background-image: linear-gradient(<?php echo $deg; ?>deg, <?php echo $color1; ?>, <?php echo $color2; ?>);
        background-image: -webkit-linear-gradient(<?php echo $deg; ?>deg, <?php echo $color1; ?>, <?php echo $color2; ?>);
        background-image: -moz-linear-gradient(<?php echo $deg; ?>deg, <?php echo $color1; ?>, <?php echo $color2; ?>);
        background-image: -o-linear-gradient(<?php echo $deg; ?>deg, <?php echo $color1; ?>, <?php echo $color2; ?>);
        background-image: -ms-linear-gradient(<?php echo $deg; ?>deg, <?php echo $color1; ?>, <?php echo $color2; ?>);
      <?php
    } else {
    //radial
      ?>
        background-image: -moz-radial-gradient(center, ellipse cover,  <?php echo $color1; ?>, <?php echo $color2; ?>);
        background-image: -webkit-gradient(radial, center center, 0px, center center, 100%, <?php echo $color1; ?>, <?php echo $color2; ?>);
        background-image: -webkit-radial-gradient(center, ellipse cover,  <?php echo $color1; ?>, <?php echo $color2; ?>);
        background-image: -o-radial-gradient(center, ellipse cover,  <?php echo $color1; ?>, <?php echo $color2; ?>);
        background-image: -ms-radial-gradient(center, ellipse cover,  <?php echo $color1; ?>, <?php echo $color2; ?>);
        background-image: radial-gradient(ellipse at center,  <?php echo $color1; ?>, <?php echo $color2; ?>);
      <?php
    }
    $out = ob_get_clean();
    if ($print) echo $out;
    return $out;
  }  
}

if (!function_exists("wpdreams_gradient_css_rgba")) {  
  function wpdreams_gradient_css_rgba($data, $print=true)
  {
  
		$data = str_replace("\n", "", $data);
    preg_match("/(.*?)-(.*?)-(.*?)-(.*)/", $data, $matches);
    
    if (!isset($matches[1]) || !isset($matches[2]) || !isset($matches[3])) {
      // Probably only 1 color..
      echo "background: ".$data.";";
      return;
    }
    
    $type = $matches[1];
    $deg = $matches[2];
		$color1 = wpdreams_admin_hex2rgb($matches[3]);
		$color2 = wpdreams_admin_hex2rgb($matches[4]);
    
    ob_start();
    //compatibility


    if ($type!='0' || $type!=0) {
      ?>linear-gradient(<?php echo $deg; ?>deg, <?php echo $color1; ?>, <?php echo $color2; ?>)<?php
    } else {
    //radial
      ?>radial-gradient(ellipse at center,  <?php echo $color1; ?>, <?php echo $color2; ?>)<?php
    }
    $out = ob_get_clean();
    if ($print) echo $out;
    return $out;
  }  
}


if (!function_exists("wpdreams_border_width")) {  
  function wpdreams_border_width($css)
  {
  		$css = str_replace("\n", "", $css);
      
      preg_match("/border:(.*?)px (.*?) (.*?);/", $css, $matches);
      
      return $matches[1];

  }  
}

if (!function_exists("wpdreams_width_from_px")) {  
  function wpdreams_width_from_px($css)
  {
  		$css = str_replace("\n", "", $css);
      
      preg_match("/(.*?)px/", $css, $matches);
      
      return $matches[1];

  }  
}

if (!function_exists("wpdreams_x2")) {  
  function wpdreams_x2($url)
  {
      $ext = pathinfo($url, PATHINFO_EXTENSION);
      return str_replace('.'.$ext, 'x2.'.$ext, $url);
  }  
}

if (!function_exists("wpdreams_in_array_r")) { 
  function wpdreams_in_array_r($needle, $haystack, $strict = false) {
      foreach ($haystack as $item) {
          if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
              return true;
          }
      }
  
      return false;
  }
}

if (!function_exists("wpdreams_css_compress")) {
    function wpdreams_css_compress ($code) {
        $code = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $code);
        $code = str_replace(array("\r\n", "\r", "\n", "\t", '    '), '', $code);
        $code = str_replace('{ ', '{', $code);
        $code = str_replace(' }', '}', $code);
        $code = str_replace('; ', ';', $code);
        return $code;
    }
}

if (!function_exists("wpdreams_get_all_taxonomies")) {
  function wpdreams_get_all_taxonomies() {
    $args = array(
      'public'   => true,
      '_builtin' => false
      
    ); 
    $output = 'names'; // or objects
    $operator = 'and'; // 'and' or 'or'
    $taxonomies = get_taxonomies( $args, $output, $operator ); 
    return $taxonomies;
  }
}

if (!function_exists("wpdreams_get_all_terms")) {  
  function wpdreams_get_all_terms() {
    $taxonomies = wpdreams_get_all_taxonomies();
    $terms = array();
    $_terms = array();
    foreach ($taxonomies as $taxonomy) {
       $_temp = get_terms($taxonomy, 'orderby=name');
       foreach ($_temp as $k=>$v)
        $terms[] = $v;
    }
    foreach ($terms as $k=>$v) {
      $_terms[$v->term_id] = $v;
    }
    return $_terms;
  }
}

if (!function_exists("wpdreams_get_all_term_ids")) {  
  function wpdreams_get_all_term_ids() {
    $taxonomies = wpdreams_get_all_taxonomies();
    $terms = array();
    foreach ($taxonomies as $taxonomy) {
       $_temp = get_terms($taxonomy, 'orderby=name');
       foreach ($_temp as $k=>$v)
        $terms[] = $v->term_id;
    }
    return $terms;
  }
}
?>
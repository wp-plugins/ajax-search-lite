<?php
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

if (!function_exists("wpdreams_box_shadow_css")) {  
  function wpdreams_box_shadow_css($css) {
    $css = str_replace("\n", "", $css);
    preg_match("/box-shadow:(.*?)px (.*?)px (.*?)px (.*?)px (.*?);/", $css, $matches);
    $ci = $matches[5];
    $hlength = $matches[1];
    $vlength = $matches[2];
    $blurradius = $matches[3];
    $spread = $matches[4];
    echo "box-shadow:".$hlength."px ".$vlength."px ".$blurradius."px ".$spread."px ".$ci.";";
    echo "-webkit-box-shadow:".$hlength."px ".$vlength."px ".($blurradius+2)."px ".$spread."px ".$ci.";";
    echo "-ms-box-shadow:".$hlength."px ".$vlength."px ".($blurradius+2)."px ".$spread."px ".$ci.";";
  }
}

if (!function_exists("wpdreams_gradient_css")) {  
  function wpdreams_gradient_css($data, $print=true)
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
    if (strlen($color1)>7) {
      preg_match("/\((.*?)\)/", $color1, $matches);
      $colors = explode(',', $matches[1]);
      echo "background: rgb($colors[0], $colors[1], $colors[2]);";
    } else {
      echo "background: ".$color1.";";
    }    
    //linear

    if ($type!='0' || $type!=0) {
      ?>
        background-image: linear-gradient(<?php echo $deg; ?>deg, <?php echo $color1; ?>, <?php echo $color2; ?>);
        -background-image: -webkit-linear-gradient(<?php echo $deg; ?>deg, <?php echo $color1; ?>, <?php echo $color2; ?>);
        -background-image: -moz-linear-gradient(<?php echo $deg; ?>deg, <?php echo $color1; ?>, <?php echo $color2; ?>);
        -background-image: -o-linear-gradient(<?php echo $deg; ?>deg, <?php echo $color1; ?>, <?php echo $color2; ?>); 
        -background-image: -ms-linear-gradient(<?php echo $deg; ?>deg, <?php echo $color1; ?>, <?php echo $color2; ?>);
      <?php
    } else {
    //radial
      ?>
        -background-image: -moz-radial-gradient(center, ellipse cover,  <?php echo $color1; ?>, <?php echo $color2; ?>); /* FF3.6+ */
        -background-image: -webkit-gradient(radial, center center, 0px, center center, 100%, <?php echo $color1; ?>, <?php echo $color2; ?>); /* Chrome,Safari4+ */
        -background-image: -webkit-radial-gradient(center, ellipse cover,  <?php echo $color1; ?>, <?php echo $color2; ?>); /* Chrome10+,Safari5.1+ */
        -background-image: -o-radial-gradient(center, ellipse cover,  <?php echo $color1; ?>, <?php echo $color2; ?>); /* Opera 12+ */
        -background-image: -ms-radial-gradient(center, ellipse cover,  <?php echo $color1; ?>, <?php echo $color2; ?>); /* IE10+ */
        background-image: radial-gradient(ellipse at center,  <?php echo $color1; ?>, <?php echo $color2; ?>); /* W3C */
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
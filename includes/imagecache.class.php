<?php
/*
* Creates a cache of the image file in the given dimensions
* as a jpeg file into the specified folder.
* <code>
*   //Parse the first image from text
*   new wpdreamsImageCache($im, $saveas, $w, $h, 1)
*   //Parse the image from url
*   new wpdreamsImageCache($im, $saveas, $w, $h)
* </code>
* 
* @author Ernest Marcinko <ernest.marcinko@wp-dreams.com>
* @version 1.0
* @link http://wp-dreams.com, http://codecanyon.net/user/anago/portfolio
* @copyright Copyright (c) 2012, Ernest Marcinko
*/
if (!class_exists('wpdreamsImageCache')) {
  class wpdreamsImageCache {
    /*
    * Constructor
    *     
    * @param string $im text containing the image or image url
    * @param string $saveas path to the cache folder WITH DS on the end!
    * @param int $w width of the result image
    * @param int $h height of the result image 
    * @param int $imagenum (optional) the number of the image found in the text to be cached, if left blank, then the $im is treated as an url and NOT as TEXT!               
    */  
      
    function __construct($im, $unique, $saveas, $w, $h, $imagenum=-1, $color="#ffffff") {
      
      $this->im = $im;
      $this->unique = $unique;
      $this->saveas = $saveas;
      $this->saveas = $saveas;
      $this->w = $w;
      $this->h = $h;
      $this->imagenum = $imagenum;
      $this->bgcolor = $color;
      
      $exists = $this->file_exists();
      
      if ($exists!==false) {
          $this->resultImageName = $exists;
      }  else {
     
        if ($imagenum>=0) {
          $this->content = $im;
          $this->imagenum = $imagenum-1;
          $this->parse_content();
        } else { 
          $this->im = $im;
        }  
        if (function_exists('get_home_path'))                           
          $this->path = get_home_path();
        else
          $this->path = NULL;
        if (function_exists('get_home_url')) 
          $this->url  = get_home_url(); 
        else
          $this->url  = NULL;
        /* Clear all possible warning, not safe, but still.. */
        ob_start();
        $this->resultImageName = $this->img_resizer($this->im, 100, $w, $h, $saveas, $color);
        ob_end_clean();
      
      }
    } 
    
    function file_exists() {
        $filename = md5($this->unique.$this->w.$this->h.$this->imagenum).".jpg";
        $saveas = $this->saveas.$filename;
        if (file_exists($saveas)) return $filename;
        return false;
    }
    
    function parse_content() {
      $this->im = "";
      if ($this->content=="") return;
      $dom = new domDocument;
      @$dom->loadHTML($this->content);
      $dom->preserveWhiteSpace = false;
      @$images = $dom->getElementsByTagName('img');
      if ($images->length>0) {
         if ($images->length>$this->imagenum) {
           $this->im = $images->item($this->imagenum)->getAttribute('src');
         } else {
           $this->imagenum = 0;
           $this->im = $images->item(0)->getAttribute('src');
         }
      }
    }
    
    function get_image() {
      return $this->resultImageName; 
    }
    
    function _ckdir($fn) {
        if (strpos($fn,"/") !== false) {
            $p=substr($fn,0,strrpos($fn,"/"));
            if (!is_dir($p)) {
                //_o("Mkdir: ".$p);
                mkdir($p,0777,true);
            }
        }
    } 
    
    function check_color($color)
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
    
    function img_resizer($src,$quality,$w,$h,$saveas, $color) {
        if (!extension_loaded('gd') || !function_exists('gd_info')) {
            return "";
        }
        $color = $this->check_color($color);
        $method = $this->can_get_file();
        if( $method==false) {
            return "";
        }     
        if ($src=="") return "";
        $filename = md5($this->unique.$w.$h.$this->imagenum).".jpg";
        $saveas .= $filename;
        if (file_exists($saveas)) return $filename;
        $r = 1;
        $_file = $this->url_get_contents($src, $method);
        if ($_file=="") return "";
        $OldImage = imagecreatefromstring($_file);
        $_bgcolor = $this->hex2rgb($color);
        $bgcolor = imagecolorallocate($OldImage,  $_bgcolor[0],$_bgcolor[1],$_bgcolor[2]);
        
        
        if ($r) {
            if ($method==1) {
              list($width, $height) =$this->fast_getimagesize($OldImage);
            } else {
              list($width,$height) =getimagesize($src);
            }
            
            if ($width<=0 || $height<=0) return "";
             
            $_ratio=array($width/$height,$w/$h);
            if ($_ratio[0] != $_ratio[1]) { 
                $_scale=min((float)($width/$w),(float)($height/$h));
                $cropX=(float)($width-($_scale*$w));
                $cropY=(float)($height-($_scale*$h));             
                $cropW=(float)($width-$cropX);
                $cropH=(float)($height-$cropY); 
                $crop=ImageCreateTrueColor($cropW,$cropH);
                imagefilledrectangle($crop, 0, 0, $cropW, $cropH, $bgcolor);
                ImageCopy($crop,$OldImage,0,0,(int)($cropX/2),(int)($cropY/2),$cropW,$cropH);
            }
           
            $NewThumb=ImageCreateTrueColor($w,$h);
            imagefilledrectangle($NewThumb, 0, 0, $w, $h, $bgcolor);
            if (isset($crop)) {
                ImageCopyResampled($NewThumb,$crop,0,0,0,0,$w,$h,$cropW,$cropH);
                ImageDestroy($crop);
            } else { 
                ImageCopyResampled($NewThumb,$OldImage,0,0,0,0,$w,$h,$width,$height);
            }
            $this->_ckdir($saveas);
            ImageJpeg($NewThumb,$saveas,$quality);
            ImageDestroy($NewThumb);
            ImageDestroy($OldImage);
        }
        return $filename;
    }
    
    function can_get_file() {
      if (function_exists('curl_init')){
        return 2;
      } else if (ini_get('allow_url_fopen')==true) {
        return 2;
      }
      return false;
    } 
    
    function url_get_contents($Url, $method) {
        if ($method==2) {
          //var_dump($this->replace_url_path($Url));
          return file_get_contents($this->replace_url_path($Url));
        } else if ($method==1) {
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $Url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $output = curl_exec($ch);
          curl_close($ch);
          return $output;
        }
    }
    
    function fast_getimagesize($im) {
      $width = imagesx($im);
      $height = imagesy($im);
      return array($width, $height);
    }
    
    function set_home_path_url($path, $url) {
      if ($path!="" && $url!="") {
        $this->path = $path;
        $this->url = $url;
      }
    }
    
    function replace_url_path($file) {
      if ($this->url!=NULL && $this->path!=NULL) {
        return str_replace($this->url, $this->path, $file);
      }
      return $file;
    }
    
    function hex2rgb($color) {
        if (strlen($color)<3) return array(255,255,255);
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
        return array($r ,$g ,$b);
    } 
  }
}
?>
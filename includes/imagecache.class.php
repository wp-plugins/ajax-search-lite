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
    function __construct($im, $saveas, $w, $h, $imagenum=-1) {
      if ($imagenum>=0) {
        $this->content = $im;
        $this->imagenum = $imagenum-1;
        $this->parse_content();
      } else {
        $this->im = $im;
      }
      $this->resultImageName = $this->img_resizer($this->im, 100, $w, $h, $saveas);
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
           $this->im = $images->item(0)->getAttribute('src');
         }
      }
      /*foreach ($images as $image) {
        echo $image->getAttribute('src');
      }
for ($i = 0; $i < $items->length; $i++) {
    echo $items->item($i)->nodeValue . "\n";
}
      $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $this->content, $matches);
      if (isset($matches) && isset($matches[1]) && isset($matches[1][$this->imagenum])) {
        $this->im = $matches [1] [$this->imagenum]; 
      } else if (isset($matches) && isset($matches[1]) && isset($matches[1][0])) {
        $this->im = $matches [1] [0]; 
      } else {
        $this->im = "";
      } */
    }
    
    function get_image() {
      return $this->resultImageName;
    }
    
    function _ckdir($fn) {
        if (strpos($fn,"/") !== false) {
            $p=substr($fn,0,strrpos($fn,"/"));
            if (!is_dir($p)) {
                _o("Mkdir: ".$p);
                mkdir($p,777,true);
            }
        }
    }    
    
    function img_resizer($src,$quality,$w,$h,$saveas) {
        if (!extension_loaded('gd') || !function_exists('gd_info')) {
            return "";
        }
        if( ini_get('allow_url_fopen')!=true ) {
            return "";
        }
        if ($src=="") return "";
        $filename = md5($src.$w.$h).".jpg";
        $saveas .= $filename;
        if (file_exists($saveas)) return $filename;
        $r = 1;
        /*$e=strtolower(substr($src,strrpos($src,".")+1,3));
        if (($e == "jpg") || ($e == "peg")) {
            $OldImage=ImageCreateFromJpeg($src) or $r=0;
        } elseif ($e == "gif") {
            $OldImage=ImageCreateFromGif($src) or $r=0;
        } elseif ($e == "bmp") {
            $OldImage=ImageCreateFromwbmp($src) or $r=0;
        } elseif ($e == "png") {
            $OldImage=ImageCreateFromPng($src) or $r=0;
        } else {
            return "";
        }*/
        $OldImage = imagecreatefromstring(file_get_contents($src));
        if ($r) {
            list($width,$height)=getimagesize($src);
            if ($width<=0 || $height<=0) return ""; 
            $_ratio=array($width/$height,$w/$h);
            if ($_ratio[0] != $_ratio[1]) { 
                $_scale=min((float)($width/$w),(float)($height/$h));
                $cropX=(float)($width-($_scale*$w));
                $cropY=(float)($height-($_scale*$h));             
                $cropW=(float)($width-$cropX);
                $cropH=(float)($height-$cropY); 
                $crop=ImageCreateTrueColor($cropW,$cropH);
                ImageCopy($crop,$OldImage,0,0,(int)($cropX/2),(int)($cropY/2),$cropW,$cropH);
            }
           
            $NewThumb=ImageCreateTrueColor($w,$h);
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
  }
}
?>
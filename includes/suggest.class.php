<?php
if (!class_exists('keywordSuggest')) {
  class keywordSuggest {
    function __construct($lang="en", $overrideUrl = '') {
      $this->lang = $lang;
      if ($overrideUrl!='') {
         $this->url = $overrideUrl;
      } else {
         $this->url = 'http://suggestqueries.google.com/complete/search?output=toolbar&oe=utf-8&client=toolbar&hl='.$this->lang.'&q=';
      }
    }
    
    
    function getKeywords($q) {
      $q = str_replace(' ', '+', $q);
      $method = $this->can_get_file();
      if ($method==false) {
        return array('Error: The fopen url wrapper is not enabled on your server!');      
      }
      $_content = $this->url_get_contents($this->url.$q, $method);
      if ($_content=="") return false;
      $_content = mb_convert_encoding($_content, "UTF-8");
      $xml = simplexml_load_string($this->url_get_contents($this->url.$q, $method));
      $json = json_encode($xml);
      $array = json_decode($json,TRUE);
      $res = array();
      if (isset($array['CompleteSuggestion'])) {
        foreach($array['CompleteSuggestion'] as $k=>$v) {
          if (isset($v['suggestion']))
            $res[] = $v['suggestion']['@attributes']['data']; 
          elseif (isset($v[0])) 
            $res[] = $v[0]['@attributes']['data']; 
        }
      }
      if (count($res)>0)
        return $res;
      else
        return false;
    }
    
    function can_get_file() {
      if (function_exists('curl_init')){
        return 1;
      } else if (ini_get('allow_url_fopen')==true) {
        return 2;
      }
      return false;
    } 
    
    function url_get_contents($Url, $method) {
        if ($method==2) {
          return file_get_contents($Url);
        } else if ($method==1) {
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $Url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $output = curl_exec($ch);
          curl_close($ch);
          return $output;
        }
    }  
  }
}
?>
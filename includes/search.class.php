<?php
if (!class_exists('wpdreams_search')) {
  class wpdreams_search {
    
    protected $params;
    protected $options;
    protected $searchData;
    protected $results;
    protected $s;
    protected $_s;
    
    function __construct($params) {
                                                          
      $this->params = $params;
      
      $options = array();
      $options = $params['options'];
      $options['set_exactonly'] = (isset($params['options']['set_exactonly'])?true:false);
      $options['set_intitle'] = (isset($params['options']['set_intitle'])?true:false);
      $options['set_incontent'] = (isset($params['options']['set_incontent'])?true:false);
      $options['set_incomments'] = (isset($params['options']['set_incomments'])?true:false);
      $options['set_inexcerpt'] = (isset($params['options']['set_inexcerpt'])?true:false);
      $options['set_inposts'] = (isset($params['options']['set_inposts'])?true:false);
      $options['set_inpages'] = (isset($params['options']['set_inpages'])?true:false);
      $options['searchinterms'] = (($params['data']['searchinterms']==1)?true:false);
      $options['set_inbpusers'] = (isset($params['options']['set_inbpusers'])?true:false);
      $options['set_inbpgroups'] = (isset($params['options']['set_inbpgroups'])?true:false);
      $options['set_inbpforums'] = (isset($params['options']['set_inbpforums'])?true:false);
      $options['maxresults'] = $params['data']['maxresults'];

      $options['do_group'] = ($params['data']['resultstype']=='vertical') ? true : false;
      
      $this->options = $options;
      $this->searchData = $params['data'];
      if (isset($this->searchData['image_options']))
       $this->imageSettings = $this->searchData['image_options'];
      
    }
    
    public function search($keyword) {
      $this->s = mb_convert_case($keyword, MB_CASE_LOWER, "UTF-8");
      $this->_s = explode(" ", $this->s);
            
      $this->do_search();
      $this->post_process();
      $this->group();
    
      return is_array($this->results)?$this->results:array();
    }
    
    protected function do_search() { 
      global $wpdb;
      
      if (isset($wpdb->base_prefix)) {
        $_prefix = $wpdb->base_prefix;
      } else {
        $_prefix = $wpdb->prefix;
      } 
    
      $options = $this->options;
      $searchData = $this->searchData;     
      $s = $this->s;
      $_s = $this->_s;
      
    } 
    
    protected function post_process() {
      
      $commentsresults = $this->results;
      $options = $this->options;
      $searchData = $this->searchData;   
      $s = $this->s;
      $_s = $this->_s;

      if (is_array($this->results) && count($this->results)>0) {
        foreach ($this->results as $k=>$v) {
           
           $r = &$this->results[$k];
           
           if (!is_object($r) || count($r)<=0) continue;
           if (!isset($r->id)) $r->id = 0;
           $r->image = isset($r->image)?$r->image:"";
           $r->title = apply_filters( 'asl_result_title_before_prostproc' , $r->title, $r->id);
           $r->content = apply_filters( 'asl_result_content_before_prostproc' , $r->content, $r->id);
           $r->image = apply_filters( 'asl_result_image_before_prostproc' ,$r->image, $r->id);
           $r->author = apply_filters( 'asl_result_author_before_prostproc' ,$r->author, $r->id);
           $r->date = apply_filters( 'asl_result_date_before_prostproc' , $r->date, $r->id);
           
        
           
           $r->title = apply_filters( 'asl_result_title_after_prostproc' , $r->title, $r->id);
           $r->content = apply_filters( 'asl_result_content_after_prostproc' ,$r->content, $r->id);
           $r->image = apply_filters( 'asl_result_image_after_prostproc' ,$r->image, $r->id);
           $r->author = apply_filters( 'asl_result_author_after_prostproc' ,$r->author, $r->id);
           $r->date = apply_filters( 'asl_result_date_after_prostproc' ,$r->date, $r->id);
           
        }   
       }        
      
    }  

    protected function group() {
      
      $commentsresults = $this->results;
      $options = $this->options;
      $searchData = $this->searchData;   
      $s = $this->s;
      $_s = $this->_s;
      
    }     
    
  }
}
?>
<?php
  add_shortcode( 'wpdreams_ajaxsearchlite', 'add_ajaxsearchlite');
  
  function searchlite_stylesheets() {
    wp_enqueue_style('wpdreams-ajaxsearchlite', plugin_dir_url(__FILE__).'../css/style.css', false);
  }     
  add_action('wp_print_styles', 'searchlite_stylesheets'); 
   
  function add_ajaxsearchlite( $atts ) {
    ob_start();
    $style = null;
    global $wpdb;
    global $wpdreams_polaroids;
    $id = 1;
    $search = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ajaxsearchlite", ARRAY_A);

    $search[0]['data'] = json_decode($search[0]['data'], true);

    $style = $search[0]['data'];
    $file = AJAXSEARCHLITE_PATH."/css/style.css";
  
    $settingsHidden = ((
      $style['showexactmatches']!=1 &&
      $style['showsearchintitle']!=1 &&
      $style['showsearchincontent']!=1 &&
      $style['showsearchinexcerpt']!=1 &&
      $style['showsearchinposts']!=1 &&
      $style['showsearchinpages']!=1 &&
      $style['showsearchinproducts']!=1 &&
      $style['showsearchinbpusers']!=1 &&
      $style['showsearchinbpgroups']!=1 &&
      $style['showsearchinbpforums']!=1 &&
      count($style['selected-showcustomtypes'])<=0
      )?true:false);
    ?>
    <div id='ajaxsearchlite'>
         <div class="probox">
              <div class='proinput'>
                <input type='text' name='phrase' value='' />
                <span class='loading'></span>
              </div>
              <div class='promagnifier'>
              </div>
              <div class='prosettings' <?php echo ($settingsHidden?"style='display:none;'":""); ?>opened=0>
              </div>
              <div class='proloading'>
              </div>                            
         </div>
         <div id='ajaxsearchlitesettings' class="searchsettings">
          <form name='options'>
             <div class="option<?php echo (($style['showexactmatches']!=1)?" hiddend":""); ?>">
              	<input type="checkbox" value="checked" id="set_exactonly<?php echo $id; ?>" name="set_exactonly" <?php echo (($style['exactonly']==1)?'checked="checked"':''); ?>/>
              	<label for="set_exactonly<?php echo $id; ?>"></label>
             </div>
             <div class="label<?php echo (($style['showexactmatches']!=1)?" hiddend":""); ?>">
                <?php echo $style['exactmatchestext']; ?>
             </div>
             <div class="option hiddend"); ?>">
              	<input type="checkbox" value="None" id="set_intitle<?php echo $id; ?>" name="set_intitle" <?php echo (($style['searchintitle']==1)?'checked="checked"':''); ?>/>
              	<label for="set_intitle<?php echo $id; ?>"></label>
             </div>
             <div class="label hiddend"); ?>">
                
             </div> 
             <div class="option hiddend"); ?>">
              	<input type="checkbox" value="None" id="set_incontent<?php echo $id; ?>" name="set_incontent" <?php echo (($style['searchincontent']==1)?'checked="checked"':''); ?>/>
              	<label for="set_incontent<?php echo $id; ?>"></label>
             </div>
             <div class="label hiddend"); ?>">
             
             </div>
             <div class="option<?php echo (($style['showsearchinposts']!=1)?" hiddend":""); ?>">
              	<input type="checkbox" value="None" id="set_inposts<?php echo $id; ?>" name="set_inposts" <?php echo (($style['searchinposts']==1)?'checked="checked"':''); ?>/>
              	<label for="set_inposts<?php echo $id; ?>"></label>
             </div>
             <div class="label<?php echo (($style['showsearchinposts']!=1)?" hiddend":""); ?>">
                <?php echo $style['searchinpoststext']; ?>
             </div>
             <div class="option<?php echo (($style['showsearchinpages']!=1)?" hiddend":""); ?>">
              	<input type="checkbox" value="None" id="set_inpages<?php echo $id; ?>" name="set_inpages" <?php echo (($style['searchinpages']==1)?'checked="checked"':''); ?>/>
              	<label for="set_inpages<?php echo $id; ?>"></label>
             </div>
             <div class="label<?php echo (($style['showsearchinpages']!=1)?" hiddend":""); ?>">
                <?php echo $style['searchinpagestext']; ?>
             </div>    
          </form> 
         </div>
    </div> 
    <div id='ajaxsearchliteres'>
         <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
         <div class="results viewport">
            <div class="resdrg overview">                                  
            </div>
         </div> 
    </div>    
    <?php
    /*if (isset($_POST['action']) && $_POST['action']=="ajaxsearchpro_preview") {
      ;
    } else if(1) { */
    ?>
      <script>
      jQuery(document).ready(function() {
         jQuery("#ajaxsearchlite").ajaxsearchpro({
          itemscount: <?php echo ((isset($style['itemscount']) && $style['itemscount']!="")?$style['itemscount']:"2"); ?>,
          imagewidth: <?php echo ((isset($style['settings-imagesettings']['width']))?$style['settings-imagesettings']['width']:"70"); ?>,
          imageheight: <?php echo ((isset($style['settings-imagesettings']['height']))?$style['settings-imagesettings']['height']:"70"); ?>,
          resultitemheight: <?php echo ((isset($style['resultitemheight']) && $style['resultitemheight']!="")?$style['resultitemheight']:"70"); ?>,
          showauthor: <?php echo ((isset($style['showauthor']) && $style['showauthor']!="")?$style['showauthor']:"1"); ?>,
          showdate: <?php echo ((isset($style['showdate']) && $style['showdate']!="")?$style['showdate']:"1"); ?>,
          showdescription: <?php echo ((isset($style['showdescription']) && $style['showdescription']!="")?$style['showdescription']:"1"); ?>,
          charcount:  <?php echo ((isset($style['charcount']) && $style['charcount']!="")?$style['charcount']:"3"); ?>,
          noresultstext: 'No results!',
          didyoumeantext: '<?php echo ((isset($style['didyoumeantext']) && $style['didyoumeantext']!="")?$style['didyoumeantext']:"3"); ?>',
          highlight: 0,
          highlightwholewords: 0,
          resultareaclickable: <?php echo ((isset($style['resultareaclickable']) && $style['resultareaclickable']!="")?$style['resultareaclickable']:0); ?>    
         });
      });       
      </script> 
    <?php   
    //} 
    $return = ob_get_clean();
    return $return;
  }  
  
?>
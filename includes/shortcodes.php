<?php
  add_shortcode( 'wpdreams_ajaxsearchlite', 'add_ajaxsearchlite');
  
  function searchlite_stylesheets() {
    wp_enqueue_style('wpdreams-ajaxsearchlite', plugin_dir_url(__FILE__).'../css/'.get_option('asl_theme_select'), false);
  }     
  add_action('wp_print_styles', 'searchlite_stylesheets'); 
   
  function add_ajaxsearchlite( $atts ) {
    ob_start();
    $style = null;
    global $wpdb;
    global $wpdreams_polaroids;
    $id = 1;
    $file = AJAXSEARCHLITE_PATH."/css/style.css";
  
    $settingsHidden = ((
      get_option('asl_showexactmatches')!=1 &&
      get_option('asl_showsearchinposts')!=1 &&
      get_option('asl_showsearchinpages')!=1
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
             <div class="option<?php echo ((get_option('asl_showexactmatches')!=1)?" hiddend":""); ?>">
              	<input type="checkbox" value="checked" id="set_exactonly<?php echo $id; ?>" name="set_exactonly" <?php echo ((get_option('asl_exactonly')==1)?'checked="checked"':''); ?>/>
              	<label for="set_exactonly<?php echo $id; ?>"></label>
             </div>
             <div class="label<?php echo ((get_option('asl_showexactmatches')!=1)?" hiddend":""); ?>">
                <?php echo  get_option('asl_exactmatchestext'); ?>
             </div>
             <div class="option hiddend"); ?>">
              	<input type="checkbox" value="None" id="set_intitle<?php echo $id; ?>" name="set_intitle" <?php echo ((get_option('asl_searchintitle')==1)?'checked="checked"':''); ?>/>
              	<label for="set_intitle<?php echo $id; ?>"></label>
             </div>
             <div class="label hiddend"); ?>">
                
             </div> 
             <div class="option hiddend"); ?>">
              	<input type="checkbox" value="None" id="set_incontent<?php echo $id; ?>" name="set_incontent" <?php echo ((get_option('asl_searchincontent')==1)?'checked="checked"':''); ?>/>
              	<label for="set_incontent<?php echo $id; ?>"></label>
             </div>
             <div class="label hiddend"); ?>">
             
             </div>
             <div class="option<?php echo ((get_option('asl_showsearchinposts')!=1)?" hiddend":""); ?>">
              	<input type="checkbox" value="None" id="set_inposts<?php echo $id; ?>" name="set_inposts" <?php echo ((get_option('asl_searchinposts')==1)?'checked="checked"':''); ?>/>
              	<label for="set_inposts<?php echo $id; ?>"></label>
             </div>
             <div class="label<?php echo ((get_option('asl_showsearchinposts')!=1)?" hiddend":""); ?>">
                <?php echo get_option('asl_searchinpoststext'); ?>
             </div>
             <div class="option<?php echo ((get_option('asl_showsearchinpages')!=1)?" hiddend":""); ?>">
              	<input type="checkbox" value="None" id="set_inpages<?php echo $id; ?>" name="set_inpages" <?php echo ((get_option('asl_searchinpages')==1)?'checked="checked"':''); ?>/>
              	<label for="set_inpages<?php echo $id; ?>"></label>
             </div>
             <div class="label<?php echo ((get_option('asl_showsearchinpages')!=1)?" hiddend":""); ?>">
                <?php echo get_option('asl_searchinpagestext'); ?>
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

      <script>
      asljQuery(document).ready(function() {
         asljQuery("#ajaxsearchlite").ajaxsearchpro({
          itemscount: <?php echo get_option('asl_itemscount'); ?>,
          imagewidth: 70,
          imageheight: 70,
          resultitemheight: 70,
          showauthor: <?php echo get_option('asl_showauthor'); ?>,
          showdate: <?php echo get_option('asl_showdate'); ?>,
          showdescription: 1,
          charcount:  <?php echo get_option('asl_charcount'); ?>,
          noresultstext: 'No results!',
          didyoumeantext: 'Did you mean?',
          highlight: 0,
          highlightwholewords: 0,
          resultareaclickable: <?php echo get_option('asl_resultareaclickable'); ?>    
         });
      });       
      </script> 
    <?php   

    $return = ob_get_clean();
    return $return;
  }  
  
?>
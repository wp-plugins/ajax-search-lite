<?php ob_start(); ?>
<fieldset>
<legend>Genearal Options</legend>
    <div class="item"><?php
    $o = new wpdreamsSelect("asl_theme", "Theme", postval_or_getoption('asl_theme'));
    ?></div> 
    <div class="item">                                             
    <?php
    $o = new wpdreamsYesNo("asl_searchinposts", "Search in posts?", postval_or_getoption('asl_searchinposts'));
    ?>
    </div>
    <div class="item">
    <?php
    $o = new wpdreamsYesNo("asl_searchinpages", "Search in pages?", postval_or_getoption('asl_searchinpages'));
    ?>
    </div>
    <div class="item">
    <?php
    $o = new wpdreamsYesNo("asl_searchintitle", "Search in title?", postval_or_getoption('asl_searchintitle'));
    ?>
    </div>
    <div class="item">
    <?php
    $o = new wpdreamsYesNo("asl_searchincontent", "Search in content?", postval_or_getoption('asl_searchincontent'));
    ?>
    </div>

    <div class="item">
    <?php
    $o = new wpdreamsYesNo("asl_exactonly", "Show exact matches only?", postval_or_getoption('asl_exactonly'));
    ?>
    </div>
    <div class="item"><?php
    $o = new wpdreamsSelect("asl_orderby", "Result ordering", postval_or_getoption('asl_orderby'));
    ?></div>  
    <div class="item"><?php
    $o = new wpdreamsTextSmall("asl_charcount", "Minimal character count to trigger search", postval_or_getoption('asl_charcount'), array( array("func"=>"ctype_digit", "op"=>"eq", "val"=>true) ));
    ?></div>
    <div class="item"><?php
    $o = new wpdreamsTextSmall("asl_maxresults", "Max. results", postval_or_getoption('asl_maxresults'), array( array("func"=>"ctype_digit", "op"=>"eq", "val"=>true) ));
    ?></div>  
    <div class="item"><?php
    $o = new wpdreamsTextSmall("asl_itemscount", "Results box viewport (in item numbers)", postval_or_getoption('asl_itemscount'), array( array("func"=>"ctype_digit", "op"=>"eq", "val"=>true) ));
    ?></div>            
</fieldset>
<fieldset>
<legend>Frontend Search Settings options</legend>
    <div class="item" style="text-align:center;"> 
      The default values of the checkboxes on the frontend are the values set above.
    </div>
    <div class="item">
    <?php
    $o = new wpdreamsYesNo("asl_showexactmatches", "Show exact matches selector?", postval_or_getoption('asl_showexactmatches'));
    $o = new wpdreamsText("asl_exactmatchestext", "Text", postval_or_getoption('asl_exactmatchestext'));
    ?></div>
    <div class="item">
    <?php 
    $o = new wpdreamsYesNo("asl_showsearchinposts", "Show search in posts selector?", postval_or_getoption('asl_showsearchinposts'));
    $o = new wpdreamsText("asl_searchinpoststext", "Text", postval_or_getoption('asl_searchinpoststext'));
    ?></div>
    <div class="item">
    <?php
    $o = new wpdreamsYesNo("asl_showsearchinpages", "Show search in pages selector?", postval_or_getoption('asl_showsearchinpages'));
    $o = new wpdreamsText("asl_searchinpagestext", "Text", postval_or_getoption('asl_searchinpagestext'));
    ?></div>         
</fieldset>
<fieldset>
<legend>Layout Options</legend>
    <div class="item">          
    <?php
    $o = new wpdreamsYesNo("asl_resultareaclickable", "Make the whole result area clickable?", postval_or_getoption('asl_resultareaclickable'));
    ?>
    </div>
    <div class="item">          
    <?php
    $o = new wpdreamsYesNo("asl_showauthor", "Show author in results?", postval_or_getoption('asl_showauthor'));
    ?>
    </div>
    <div class="item">               
    <?php
    $o = new wpdreamsYesNo("asl_showdate", "Show date in results?", postval_or_getoption('asl_showdate'));
    ?>
    </div> 
</fieldset>
<?php $_r = ob_get_clean(); ?>
<?php
  $updated = false;
  $err = ((wpdreamsType::getErrorNum()==0)?false:true);
  
  if (isset($_POST) && !$err) {
    foreach($_POST as $key=>$value) {
      if (is_string($key) && (strpos($key, 'asl_')==0)) {
        update_option($key, $value);
        $updated = true;
      }
    }
  }
?>
<div class="wpdreams-slider moveable">
  <div class="slider-info"> 
    <span>
       <label class="shortcode">Search shortcode:</label>
       <input type="text" class="shortcode" value="[wpdreams_ajaxsearchlite]" readonly="readonly" />
       <?php new wpdreamsInfo("Copy this shortcode to any page or post!"); ?>
       <label class="shortcode">Search shortcode for templates:</label>
       <input type="text" class="shortcode" value="echo do_shortcode('[wpdreams_ajaxsearchlite');" readonly="readonly" />
       <?php new wpdreamsInfo("Copy this shortcode into your template!"); ?>
    </span>
  </div>
  <hr />
  <form name="polaroid_slider_<?php echo $search['id']; ?>" action="" method="POST">
      <?php if($err): ?><div class='errorMsg'>Error in settings, check the values!</div><?php endif; ?>
      <?php if($updated): ?><div class='successMsg'>Settings succesfully updated!</div><?php endif; ?>
      <?php print $_r; ?> 
      <div class="item">
        <input name="submit_<?php echo $search['id']; ?>" type="submit" value="Save this search!" />
      </div>
  </form>
</div>
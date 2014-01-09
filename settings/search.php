<?php
  global $sliders;
  global $wpdb;
  //include "types.class.php";
  $params = array();

  /* General Options */
  $_search_default['searchinposts'] =  1;
  $_search_default['searchinpages'] =  1;
  $_search_default['searchinproducts'] =  1;
  $_search_default['searchintitle'] =  1;
  $_search_default['searchincontent'] =  1;
  $_search_default['searchinexcerpt'] =  1;
  $_search_default['searchinbpusers'] =  1;
  $_search_default['searchinbpgroups'] =  1;
  $_search_default['searchinbpforums'] =  1;
  $_search_default['searchindrafts'] =  0;
  $_search_default['searchinpending'] =  0;
  $_search_default['exactonly'] =  0;
  $_search_default['searchinterms'] =  0;
  $_search_default['keywordsuggestions'] = 1;
  $_search_default['keywordsuggestionslang'] = "en";
  $_search_default['charcount'] =  3;
  $_search_default['maxresults'] =  30;
  $_search_default['itemscount'] =  4;
  $_search_default['resultitemheight'] =  70;
  $_search_default['imagesettings'] = 'show:1;cache:1;featured:0;content:1;excerpt:2;imagenum:1;width:70;height:70;';
  $_search_default['settings-imagesettings'] = array();
  $_search_default['settings-imagesettings']['show'] = 1;
  $_search_default['settings-imagesettings']['cache'] = 1;
  $_search_default['settings-imagesettings']['width'] = 70;
  $_search_default['settings-imagesettings']['height'] = 70;
  $_search_default['settings-imagesettings']['imagenum'] = 1;
  $_search_default['settings-imagesettings']['from'] = array(
    0=>"featured",
    1=>"content",
    2=>"excerpt"
  );
  $_search_default['orderby'] = "
     Title descending|post_title DESC;
     Title ascending|post_title ASC;
     Date descending|post_date DESC;
     Date ascending|post_date ASC||
     post_date DESC
  ";

  /* Frontend search settings Options */
  $_search_default['showexactmatches'] = 1;
  $_search_default['showsearchinposts'] = 1;
  $_search_default['showsearchinpages'] = 1;
  $_search_default['showsearchintitle'] = 1;
  $_search_default['showsearchincontent'] = 1;
  $_search_default['showsearchinexcerpt'] = 1;
  $_search_default['showsearchinbpusers'] = 0;
  $_search_default['showsearchinbpgroups'] = 0;
  $_search_default['showsearchinbpforums'] = 0;
  
  $_search_default['exactmatchestext'] = "Exact matches only";
  $_search_default['searchinpoststext'] = "Search in posts";
  $_search_default['searchinpagestext'] = "Search in pages";
  $_search_default['searchintitletext'] = "Search in title";
  $_search_default['searchincontenttext'] = "Search in content";
  $_search_default['searchinexcerpttext'] = "Search in excerpt";
  $_search_default['searchinbpuserstext'] = "Search in users";
  $_search_default['searchinbpgroupstext'] = "Search in groups";
  $_search_default['searchinbpforumstext'] = "Search in forums";
                          
  
  /* Layout Options */
  $_search_default['resultareaclickable'] = 0;
  $_search_default['showauthor'] = 1;
  $_search_default['showdate'] = 1;
  $_search_default['showdescription'] = 1;
  $_search_default['descriptionlength'] = 100;
  $_search_default['noresultstext'] = "No results!";
  $_search_default['didyoumeantext'] = "Did you mean:";
  $_search_default['highlight'] = 1;
  $_search_default['highlightwholewords'] = 1;
  $_search_default['highlightcolor'] = "#d9312b";
  $_search_default['highlightbgcolor'] = "#eee";
  /* Theme options */
  $_search_default['boxbackground'] = '#c1ecf0';
  $_search_default['boxborder'] = 'border:0px none #000000;border-radius:5px 5px 5px 5px;';
  $_search_default['boxshadow'] = 'box-shadow:0px 0px 1px 1px #d2dbd9 ;';
  $_search_default['inputbackground'] = '#ffffff';
  $_search_default['inputborder'] = 'border:1px solid #ffffff;border-radius:3px 3px 3px 3px;';
  $_search_default['inputshadow'] = 'box-shadow:1px 0px 3px 0px #ccc inset;';
  $_search_default['inputfont'] = 'font-weight:normal;font-family:\'Arial\', Helvetica, sans-serif;color:#212121;font-size:12px;line-height:15px;';
  $_search_default['settingsbackground'] = '#ddd';
  $_search_default['settingsbackground'] = '#ddd';
  $_search_default['settingsdropbackground'] = '#ddd';
  $_search_default['settingsdropbackgroundfontcolor'] = '#333';
   
  $_search_default['resultsborder'] = 'border:0px none #000000;border-radius:3px 3px 3px 3px;';
  $_search_default['resultshadow'] = 'box-shadow:0px 0px 0px 0px #000000 ;'; 
  $_search_default['resultsbackground'] = '#c1ecf0';
  $_search_default['resultscontainerbackground'] = '#ebebeb';
  $_search_default['resultscontentbackground'] = '#ffffff';
  $_search_default['titlefont'] = 'font-weight:bold;font-family:\'Arial\', Helvetica, sans-serif;color:#1454a9;font-size:14px;line-height:15px;';
  $_search_default['titlehoverfont'] = 'font-weight:bold;font-family:\'Arial\', Helvetica, sans-serif;color:#1454a9;font-size:14px;line-height:15px;';
  $_search_default['authorfont'] = 'font-weight:bold;font-family:\'Arial\', Helvetica, sans-serif;color:#a1a1a1;font-size:12px;line-height:15px;';
  $_search_default['datefont'] = 'font-weight:normal;font-family:\'Arial\', Helvetica, sans-serif;color:#adadad;font-size:12px;line-height:15px;';
  $_search_default['descfont'] = 'font-weight:normal;font-family:\'Arial\', Helvetica, sans-serif;color:#4a4a4a;font-size:13px;line-height:15px;';
  $_search_default['arrowcolor'] = '#0a3f4d';
  $_search_default['overflowcolor'] = '#ffffff';  
  
  $_search_default['magnifierimage'] = "
    /ajax-search-pro/img/magnifiers/magn1.png;
    /ajax-search-pro/img/magnifiers/magn2.png;
    /ajax-search-pro/img/magnifiers/magn3.png;
    /ajax-search-pro/img/magnifiers/magn4.png;
    /ajax-search-pro/img/magnifiers/magn5.png;
    /ajax-search-pro/img/magnifiers/magn6.png;
    /ajax-search-pro/img/magnifiers/magn7.png;
    /ajax-search-pro/img/magnifiers/magn8.png||
    /ajax-search-pro/img/magnifiers/magn3.png
  ";
  $_search_default['selected-magnifierimage'] = "/ajax-search-pro/img/magnifiers/magn3.png";
  $_search_default['settingsimage'] = "
    /ajax-search-pro/img/settings/settings1.png;
    /ajax-search-pro/img/settings/settings2.png;
    /ajax-search-pro/img/settings/settings3.png;
    /ajax-search-pro/img/settings/settings4.png;
    /ajax-search-pro/img/settings/settings5.png;
    /ajax-search-pro/img/settings/settings6.png;
    /ajax-search-pro/img/settings/settings7.png;
    /ajax-search-pro/img/settings/settings8.png;
    /ajax-search-pro/img/settings/settings9.png;
    /ajax-search-pro/img/settings/settings10.png||
    /ajax-search-pro/img/settings/settings1.png
  ";
  $_search_default['selected-settingsimage'] = "/ajax-search-pro/img/settings/settings1.png";
  $_search_default['loadingimage'] = "
    /ajax-search-pro/img/loading/loading1.gif;
    /ajax-search-pro/img/loading/loading2.gif;
    /ajax-search-pro/img/loading/loading3.gif;
    /ajax-search-pro/img/loading/loading4.gif;
    /ajax-search-pro/img/loading/loading5.gif;
    /ajax-search-pro/img/loading/loading6.gif;
    /ajax-search-pro/img/loading/loading7.gif;
    /ajax-search-pro/img/loading/loading8.gif;
    /ajax-search-pro/img/loading/loading9.gif;
    /ajax-search-pro/img/loading/loading10.gif;
    /ajax-search-pro/img/loading/loading11.gif||
    /ajax-search-pro/img/loading/loading3.gif
  ";
  $_search_default['selected-loadingimage'] = "/ajax-search-pro/img/loading/loading3.gif";
  $_search_default['magnifierbackground'] = "#eeeeee";   
  $_search_default['showauthor'] = 1;
  $_search_default['showdate'] = 1;
  $_search_default['showdescription'] = 1;
  $_search_default['descriptionlength'] = 130;
  //$_themes = file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'themes.json');
  ?>

  <?php
  
  if (isset($_POST['delete'])) {
    $wpdb->query("DELETE FROM ".$wpdb->prefix."ajaxsearchlite WHERE id=".$_POST['did']);
  }
    
 
  $searchforms = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ajaxsearchlite", ARRAY_A);
  if (is_array($searchforms))
  foreach ($searchforms as $search) {
      $search['data'] = json_decode($search['data'], true);   
      
    ?>
      <div class="wpdreams-slider moveable">
        <div class="slider-info"> 
          <span><?php
             echo $search['name'];
          ?>
          </span>
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
          <fieldset>
          <legend>Genearal Options</legend>
              <div class="item">
              <?php
              if (!isset($search['data']['searchinposts'])) $search['data']['searchinposts']=1;
              $o = new wpdreamsYesNo("searchinposts_".$search['id'], "Search in posts?", $search['data']['searchinposts']);
              $params[$o->getName()] = $o->getData();
              ?>
              </div>
              <div class="item">
              <?php
              if (!isset($search['data']['searchinpages'])) $search['data']['searchinpages']=1;
              $o = new wpdreamsYesNo("searchinpages_".$search['id'], "Search in pages?", $search['data']['searchinpages']);
              $params[$o->getName()] = $o->getData();
              ?>
              </div>

              <div class="item">
              <?php
              if (!isset($search['data']['searchintitle'])) $search['data']['searchintitle']=1;
              $o = new wpdreamsYesNo("searchintitle_".$search['id'], "Search in title?", $search['data']['searchintitle']);
              $params[$o->getName()] = $o->getData();
              ?>
              </div>
              <div class="item">
              <?php
              if (!isset($search['data']['searchincontent'])) $search['data']['searchincontent']=1;
              $o = new wpdreamsYesNo("searchincontent_".$search['id'], "Search in content?", $search['data']['searchincontent']);
              $params[$o->getName()] = $o->getData();
              ?>
              </div>

              <div class="item">
              <?php
              if (!isset($search['data']['exactonly'])) $search['data']['exactonly']=0;
              $o = new wpdreamsYesNo("exactonly_".$search['id'], "Show exact matches only?", $search['data']['exactonly']);
              $params[$o->getName()] = $o->getData();
              ?>
              </div>
              <div class="item"><?php
              if (!isset($search['data']['orderby'])) $search['data']['orderby']=$_search_default['orderby'];
              $o = new wpdreamsSelect("orderby_".$search['id'], "Result ordering", (($search['data']['orderby']!="")?$search['data']['orderby']:$_search_default['orderby'] ));
              $params[$o->getName()] = $o->getData();
              $params["selected-".$o->getName()] = $o->getSelected();
              ?></div>  
              <div class="item"><?php
              if (!isset($search['data']['charcount'])) $search['data']['charcount']=1;
              $o = new wpdreamsTextSmall("charcount_".$search['id'], "Minimal character count to trigger search", $search['data']['charcount'], array( array("func"=>"ctype_digit", "op"=>"eq", "val"=>true) ));
              $params[$o->getName()] = $o->getData();
              ?></div>
              <div class="item"><?php
              if (!isset($search['data']['maxresults'])) $search['data']['maxresults']=20;
              $o = new wpdreamsTextSmall("maxresults_".$search['id'], "Max. results", $search['data']['maxresults'], array( array("func"=>"ctype_digit", "op"=>"eq", "val"=>true) ));
              $params[$o->getName()] = $o->getData();
              ?></div>  
              <div class="item"><?php
              if (!isset($search['data']['itemscount'])) $search['data']['itemscount']=4;
              $o = new wpdreamsTextSmall("itemscount_".$search['id'], "Results box viewport (in item numbers)", $search['data']['itemscount'], array( array("func"=>"ctype_digit", "op"=>"eq", "val"=>true) ));
              $params[$o->getName()] = $o->getData();
              ?></div>            
          </fieldset>
          <fieldset>
          <legend>Frontend Search Settings options</legend>
              <div class="item" style="text-align:center;"> 
                The default values of the checkboxes on the frontend are the values set above.
              </div>
              <div class="item">
              <?php
              if (!isset($search['data']['showexactmatches'])) $search['data']['showexactmatches']=1;
              $o = new wpdreamsYesNo("showexactmatches_".$search['id'], "Show exact matches selector?", $search['data']['showexactmatches']);
              $params[$o->getName()] = $o->getData();
              if ($search['data']['exactmatchestext']=="") $search['data']['exactmatchestext'] = $_search_default['exactmatchestext'];
              $o = new wpdreamsText("exactmatchestext_".$search['id'], "Text", $search['data']['exactmatchestext']);
              $params[$o->getName()] = $o->getData();
              ?></div>
              <div class="item">
              <?php 
              $o = new wpdreamsYesNo("showsearchinposts_".$search['id'], "Show search in posts selector?", $search['data']['showsearchinposts']);
              $params[$o->getName()] = $o->getData();
              if ($search['data']['searchinpoststext']=="") $search['data']['searchinpoststext'] = $_search_default['searchinpoststext'];
              $o = new wpdreamsText("searchinpoststext_".$search['id'], "Text", $search['data']['searchinpoststext']);
              $params[$o->getName()] = $o->getData();
              ?></div>
              <div class="item">
              <?php
              $o = new wpdreamsYesNo("showsearchinpages_".$search['id'], "Show search in pages selector?", $search['data']['showsearchinpages']);
              $params[$o->getName()] = $o->getData();
              if ($search['data']['searchinpagestext']=="") $search['data']['searchinpagestext'] = $_search_default['searchinpagestext'];
              $o = new wpdreamsText("searchinpagestext_".$search['id'], "Text", $search['data']['searchinpagestext']);
              $params[$o->getName()] = $o->getData();
              ?></div>         
          </fieldset>
          <fieldset>
          <legend>Layout Options</legend>
              <div class="item">          
              <?php
              if (!isset($search['data']['resultareaclickable'])) $search['data']['resultareaclickable']=1;
              $o = new wpdreamsYesNo("resultareaclickable_".$search['id'], "Make the whole result area clickable?", $search['data']['resultareaclickable']);
              $params[$o->getName()] = $o->getData();
              ?>
              </div>
              <div class="item">          
              <?php
              if (!isset($search['data']['showauthor'])) $search['data']['showauthor']=1;
              $o = new wpdreamsYesNo("showauthor_".$search['id'], "Show author in results?", $search['data']['showauthor']);
              $params[$o->getName()] = $o->getData();
              ?>
              </div>
              <div class="item">               
              <?php
              if (!isset($search['data']['showdate'])) $search['data']['showdate']=1;
              $o = new wpdreamsYesNo("showdate_".$search['id'], "Show date in results?", $search['data']['showdate']);
              $params[$o->getName()] = $o->getData();
              ?>
              </div> 
          </fieldset>
            <div class="item">
              <input name="submit_<?php echo $search['id']; ?>" type="submit" value="Save this search!" />
            </div>
        </form>
      </div>
    <?php
    if (isset($_POST['submit_'.$search['id']]) && (wpdreamsType::getErrorNum())==0) {
      /* update data */
      foreach ($params as $k=>$v) {
        $_tmp = explode("_".$search['id'], $k);
        $params[$_tmp[0]] = $v;
        unset($params[$k]);
      }
      $data = mysql_real_escape_string(json_encode($params));
    
      $wpdb->query("
        UPDATE ".$wpdb->prefix."ajaxsearchlite 
        SET data = '".$data."'
        WHERE id = ".$search['id']."
      ");
      echo "<div class='successMsg'>Search settings saved!</div>";
    }
  }
 
?>

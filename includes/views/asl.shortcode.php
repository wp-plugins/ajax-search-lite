<?php
    $id = self::$instanceCount;
    $real_id = self::$instanceCount;
?>
<div id='ajaxsearchlite<?php echo self::$instanceCount; ?>'>
<div class="probox">

    <?php do_action('asl_layout_before_magnifier', $id); ?>

    <div class='promagnifier'>
        <?php do_action('asl_layout_in_magnifier', $id); ?>
        <div class='innericon'>
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
                <path id="magnifier-2-icon" d="M460.355,421.59L353.844,315.078c20.041-27.553,31.885-61.437,31.885-98.037
                    C385.729,124.934,310.793,50,218.686,50C126.58,50,51.645,124.934,51.645,217.041c0,92.106,74.936,167.041,167.041,167.041
                    c34.912,0,67.352-10.773,94.184-29.158L419.945,462L460.355,421.59z M100.631,217.041c0-65.096,52.959-118.056,118.055-118.056
                    c65.098,0,118.057,52.959,118.057,118.056c0,65.096-52.959,118.056-118.057,118.056C153.59,335.097,100.631,282.137,100.631,217.041
                    z"/>
            </svg>
        </div>
    </div>

    <?php do_action('asl_layout_after_magnifier', $id); ?>

    <?php do_action('asl_layout_before_settings', $id); ?>

    <div class='prosettings' <?php echo($settingsHidden ? "style='display:none;'" : ""); ?>opened=0>
        <?php do_action('asl_layout_in_settings', $id); ?>
        <div class='innericon'>
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
                <polygon id="arrow-25-icon" transform = "rotate(90 256 256)" points="142.332,104.886 197.48,50 402.5,256 197.48,462 142.332,407.113 292.727,256 "/>
            </svg>
        </div>
    </div>

    <?php do_action('asl_layout_after_settings', $id); ?>

    <?php do_action('asl_layout_before_input', $id); ?>

    <div class='proinput'>
        <form action='' autocomplete="off">
            <input type='search' class='orig' name='phrase' value='' autocomplete="off"/>
            <input type='text' class='autocomplete' name='phrase' value='' autocomplete="off"/>
            <span class='loading'></span>
            <input type='submit' style='width:0; height: 0; visibility: hidden;'>
        </form>
    </div>

    <?php do_action('asl_layout_after_input', $id); ?>

    <?php do_action('asl_layout_before_loading', $id); ?>

    <div class='proloading'>

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32">
            <path opacity=".25" d="M16 0 A16 16 0 0 0 16 32 A16 16 0 0 0 16 0 M16 4 A12 12 0 0 1 16 28 A12 12 0 0 1 16 4"/>
            <path d="M16 0 A16 16 0 0 1 32 16 L28 16 A12 12 0 0 0 16 4z">
                <animateTransform attributeName="transform" type="rotate" from="0 16 16" to="360 16 16" dur="0.8s" repeatCount="indefinite" />
            </path>
        </svg>

        <?php do_action('asl_layout_in_loading', $id); ?>
    </div>

    <?php if ($style['show_close_icon']): ?>
        <div class='proclose'>
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                 y="0px"
                 width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512"
                 xml:space="preserve">
            <polygon id="x-mark-icon"
                     points="438.393,374.595 319.757,255.977 438.378,137.348 374.595,73.607 255.995,192.225 137.375,73.622 73.607,137.352 192.246,255.983 73.622,374.625 137.352,438.393 256.002,319.734 374.652,438.378 "/>
        </svg>
        </div>
    <?php endif; ?>

    <?php do_action('asl_layout_after_loading', $id); ?>

</div>
</div>

<div id='ajaxsearchlitesettings<?php echo $id; ?>' class="searchsettings">
    <form name='options'>

        <?php do_action('asl_layout_settings_before_first_item', $id); ?>
        <fieldset class="asl_sett_scroll">
            <div class="option hiddend">
                <input type='hidden' name='qtranslate_lang' id='qtranslate_lang'
                       value='<?php echo(function_exists('qtrans_getLanguage') ? qtrans_getLanguage() : '0'); ?>'/>
            </div>

	        <?php if (defined('ICL_LANGUAGE_CODE')
	                  && ICL_LANGUAGE_CODE != ''
	                  && defined('ICL_SITEPRESS_VERSION')
	        ): ?>
		        <div class="option hiddend">
			        <input type='hidden' name='wpml_lang'
			               value='<?php echo ICL_LANGUAGE_CODE; ?>'/>
		        </div>
	        <?php endif; ?>

            <div class="option<?php echo(($style['showexactmatches'] != 1) ? " hiddend" : ""); ?>">
                <input type="checkbox" value="checked" id="set_exactonly<?php echo $id; ?>"
                       name="set_exactonly" <?php echo(($style['exactonly'] == 1) ? 'checked="checked"' : ''); ?>/>
                <label for="set_exactonly<?php echo $id; ?>"></label>
            </div>
            <div class="label<?php echo(($style['showexactmatches'] != 1) ? " hiddend" : ""); ?>">
                <?php echo $style['exactmatchestext']; ?>
            </div>
            <div class="option<?php echo(($style['showsearchintitle'] != 1) ? " hiddend" : ""); ?>">
                <input type="checkbox" value="None" id="set_intitle<?php echo $id; ?>"
                       name="set_intitle" <?php echo(($style['searchintitle'] == 1) ? 'checked="checked"' : ''); ?>/>
                <label for="set_intitle<?php echo $id; ?>"></label>
            </div>
            <div class="label<?php echo(($style['showsearchintitle'] != 1) ? " hiddend" : ""); ?>">
                <?php echo $style['searchintitletext']; ?>
            </div>
            <div class="option<?php echo(($style['showsearchincontent'] != 1) ? " hiddend" : ""); ?>">
                <input type="checkbox" value="None" id="set_incontent<?php echo $id; ?>"
                       name="set_incontent" <?php echo(($style['searchincontent'] == 1) ? 'checked="checked"' : ''); ?>/>
                <label for="set_incontent<?php echo $id; ?>"></label>
            </div>
            <div class="label<?php echo(($style['showsearchincontent'] != 1) ? " hiddend" : ""); ?>">
                <?php echo $style['searchincontenttext']; ?>
            </div>

            <div class="option<?php echo(($style['showsearchinposts'] != 1) ? " hiddend" : ""); ?>">
                <input type="checkbox" value="None" id="set_inposts<?php echo $id; ?>"
                       name="set_inposts" <?php echo(($style['searchinposts'] == 1) ? 'checked="checked"' : ''); ?>/>
                <label for="set_inposts<?php echo $id; ?>"></label>
            </div>
            <div class="label<?php echo(($style['showsearchinposts'] != 1) ? " hiddend" : ""); ?>">
                <?php echo $style['searchinpoststext']; ?>
            </div>
            <div class="option<?php echo(($style['showsearchinpages'] != 1) ? " hiddend" : ""); ?>">
                <input type="checkbox" value="None" id="set_inpages<?php echo $id; ?>"
                       name="set_inpages" <?php echo(($style['searchinpages'] == 1) ? 'checked="checked"' : ''); ?>/>
                <label for="set_inpages<?php echo $id; ?>"></label>
            </div>
            <div class="label<?php echo(($style['showsearchinpages'] != 1) ? " hiddend" : ""); ?>">
                <?php echo $style['searchinpagestext']; ?>
            </div>
            <?php

            $types = get_post_types(array(
                '_builtin' => false
            ));
            $i = 1;
            if (!isset($style['selected-customtypes']) || !is_array($style['selected-customtypes']))
                $style['selected-customtypes'] = array();
            if (!isset($style['selected-showcustomtypes']) || !is_array($style['selected-showcustomtypes']))
                $style['selected-showcustomtypes'] = array();
            $flat_show_customtypes = array();

            foreach ($style['selected-showcustomtypes'] as $k => $v) {
                $selected = in_array($v[0], $style['selected-customtypes']);
                $hidden = "";
                $flat_show_customtypes[] = $v[0];
                ?>
                <div class="option<?php echo $hidden; ?>">
                    <input type="checkbox" value="<?php echo $v[0]; ?>"
                           id="<?php echo $id; ?>customset_<?php echo $id . $i; ?>"
                           name="customset[]" <?php echo(($selected) ? 'checked="checked"' : ''); ?>/>
                    <label for="<?php echo $id; ?>customset_<?php echo $id . $i; ?>"></label>
                </div>
                <div class="label<?php echo $hidden; ?>">
                    <?php echo $v[1]; ?>
                </div>
                <?php
                $i++;
            }
            ?>
        </fieldset>
        <?php
        $hidden_types = array();
        $hidden_types = array_diff($style['selected-customtypes'], $flat_show_customtypes);

        foreach ($hidden_types as $k => $v) {
            ?>
            <div class="option hiddend">
                <input type="checkbox" value="<?php echo $v; ?>"
                       id="<?php echo $id; ?>customset_<?php echo $id . $i; ?>"
                       name="customset[]" checked="checked"/>
                <label for="<?php echo $id; ?>customset_<?php echo $id . $i; ?>"></label>
            </div>
            <div class="label<?php echo $hidden; ?>">
                <?php echo $val; ?>
            </div>

            <?php
            $i++;
        }
        ?>
        <?php
        /* Category and term filters */
        if ($style['showsearchincategories']) {
        ?>

        <fieldset>
            <?php if ($style['exsearchincategoriestext'] != ""): ?>
                <legend><?php echo $style['exsearchincategoriestext']; ?></legend>
            <?php endif; ?>
            <div class='categoryfilter asl_sett_scroll'>
                <?php

                /* Categories */
                if (!isset($style['selected-exsearchincategories']) || !is_array($style['selected-exsearchincategories']))
                    $style['selected-exsearchincategories'] = array();
                if (!isset($style['selected-excludecategories']) || !is_array($style['selected-excludecategories']))
                    $style['selected-excludecategories'] = array();
                $_all_cat = get_terms('category', array('fields'=>'ids'));
                $_needed_cat = array_diff($_all_cat, $style['selected-exsearchincategories']);
                foreach ($_needed_cat as $k => $v) {
                    $selected = !in_array($v, $style['selected-excludecategories']);
                    $cat = get_category($v);
                    $val = $cat->name;
                    $hidden = (($style['showsearchincategories']) == 0 ? " hiddend" : "");
                    if ($style['showuncategorised'] == 0 && $v == 1) {
                        $hidden = ' hiddend';
                    }
                    ?>
                    <div class="option<?php echo $hidden; ?>">
                        <input type="checkbox" value="<?php echo $v; ?>"
                               id="<?php echo $id; ?>categoryset_<?php echo $v; ?>"
                               name="categoryset[]" <?php echo(($selected) ? 'checked="checked"' : ''); ?>/>
                        <label for="<?php echo $id; ?>categoryset_<?php echo $v; ?>"></label>
                    </div>
                    <div class="label<?php echo $hidden; ?>">
                        <?php echo $val; ?>
                    </div>
                <?php
                }
                ?>

            </div>
        </fieldset>
        <?php
        }
        ?>
    </form>
</div>

<div id='ajaxsearchliteres<?php echo $id; ?>' class='<?php echo $style['resultstype']; ?>'>

    <?php do_action('asl_layout_before_results', $id); ?>

    <div class="results">

        <?php do_action('asl_layout_before_first_result', $id); ?>

            <div class="resdrg">
            </div>

        <?php do_action('asl_layout_after_last_result', $id); ?>

    </div>

    <?php do_action('asl_layout_after_results', $id); ?>

    <?php if ($style['showmoreresults'] == 1): ?>
        <?php do_action('asl_layout_before_showmore', $id); ?>
    <p class='showmore'>
        <a href='<?php home_url('/'); ?>?s='><?php echo $style['showmoreresultstext']; ?></a>
    </p>
    <?php do_action('asl_layout_after_showmore', $id); ?>
    <?php endif; ?>

</div>

<?php if (self::$instanceCount<2): ?>
    <div id="asl_hidden_data">
        <svg style="position:absolute" height="0" width="0">
            <filter id="aslblur">
                <feGaussianBlur in="SourceGraphic" stdDeviation="4"/>
            </filter>
        </svg>
        <svg style="position:absolute" height="0" width="0">
            <filter id="no_aslblur"></filter>
        </svg>

    </div>
<?php endif; ?>

<?php
    $ana_options = get_option('asl_analytics');
    $scope = "asljQuery";
?>

<script>
    <?php echo $scope; ?>(document).ready(function () {
        <?php echo $scope; ?>("#ajaxsearchlite<?php echo $id; ?>").ajaxsearchlite({
            homeurl: '<?php echo home_url('/'); ?>',
            resultstype: 'vertical',
            resultsposition: 'hover',
            itemscount: <?php echo ((isset($style['itemscount']) && $style['itemscount']!="")?$style['itemscount']:"10"); ?>,
            imagewidth: <?php echo ((isset($style['settings-imagesettings']['width']))?$style['settings-imagesettings']['width']:"70"); ?>,
            imageheight: <?php echo ((isset($style['settings-imagesettings']['height']))?$style['settings-imagesettings']['height']:"70"); ?>,
            resultitemheight: '<?php echo ((isset($style['resultitemheight']) && $style['resultitemheight']!="")?$style['resultitemheight']:"70"); ?>',
            showauthor: <?php echo ((isset($style['showauthor']) && $style['showauthor']!="")?$style['showauthor']:"1"); ?>,
            showdate: <?php echo ((isset($style['showdate']) && $style['showdate']!="")?$style['showdate']:"1"); ?>,
            showdescription: <?php echo ((isset($style['showdescription']) && $style['showdescription']!="")?$style['showdescription']:"1"); ?>,
            charcount:  <?php echo ((isset($style['charcount']) && $style['charcount']!="")?$style['charcount']:"3"); ?>,
            noresultstext: '<?php echo ((isset($style['noresultstext']) && $style['noresultstext']!="")?$style['noresultstext']:"3"); ?>',
            didyoumeantext: '<?php echo ((isset($style['didyoumeantext']) && $style['didyoumeantext']!="")?$style['didyoumeantext']:"3"); ?>',
            defaultImage: '<?php echo w_isset_def($style['image_default'], "")==""?ASL_URL."img/default.jpg":$style['image_default']; ?>',
            highlight: 0,
            highlightwholewords: 0,
            scrollToResults: <?php echo w_isset_def($style['scroll_to_results'], 1); ?>,
            resultareaclickable: <?php echo ((isset($style['resultareaclickable']) && $style['resultareaclickable']!="")?$style['resultareaclickable']:0); ?>,
            defaultsearchtext: '<?php echo ((isset($style['defaultsearchtext']) && $style['defaultsearchtext']!="")?$style['defaultsearchtext']:""); ?>',
            autocomplete: 0,
            triggerontype: <?php echo ((isset($style['triggerontype']) && $style['triggerontype']!="")?$style['triggerontype']:1); ?>,
            triggeronclick: <?php echo ((isset($style['triggeronclick']) && $style['triggeronclick']!="")?$style['triggeronclick']:1); ?>,
            redirectonclick: <?php echo ((isset($style['redirectonclick']) && $style['redirectonclick']!="")?$style['redirectonclick']:0); ?>,
            settingsimagepos: '<?php echo w_isset_def($style['theme'], 'classic-blue')=='classic-blue'?'left':'right'; ?>',
            hresultanimation: 'fx-none',
            vresultanimation: 'fx-none',
            hresulthidedesc: '<?php echo ((isset($style['hhidedesc']) && $style['hhidedesc']!="")?$style['hhidedesc']:1); ?>',
            prescontainerheight: '<?php echo ((isset($style['prescontainerheight']) && $style['prescontainerheight']!="")?$style['prescontainerheight']:"400px"); ?>',
            pshowsubtitle: '<?php echo ((isset($style['pshowsubtitle']) && $style['pshowsubtitle']!="")?$style['pshowsubtitle']:0); ?>',
            pshowdesc: '<?php echo ((isset($style['pshowdesc']) && $style['pshowdesc']!="")?$style['pshowdesc']:1); ?>',
            closeOnDocClick: <?php echo w_isset_def($style['close_on_document_click'], 1); ?>,
            iifNoImage: '<?php echo w_isset_def($style['i_ifnoimage'], 'description'); ?>',
            iiRows: <?php echo w_isset_def($style['i_rows'], 2); ?>,
            iitemsWidth: <?php echo w_isset_def($style['i_item_width'], 200); ?>,
            iitemsHeight: <?php echo w_isset_def($style['i_item_height'], 200); ?>,
            iishowOverlay: <?php echo w_isset_def($style['i_overlay'], 1); ?>,
            iiblurOverlay: <?php echo w_isset_def($style['i_overlay_blur'], 1); ?>,
            iihideContent: <?php echo w_isset_def($style['i_hide_content'], 1); ?>,
            iianimation: '<?php echo w_isset_def($style['i_animation'], 1); ?>',
            analytics: <?php echo w_isset_def($ana_options['analytics'], 0); ?>,
            analyticsString: '<?php echo w_isset_def($ana_options['analytics_string'], ""); ?>'
        });
    });
</script>
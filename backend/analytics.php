<?php $ana_options = get_option('asl_analytics');  ?>

<div id="wpdreams" class='wpdreams wrap'>
    <div class="wpdreams-box">
        <?php ob_start(); ?>
        <div class="item">
            <?php $o = new wpdreamsYesNo("analytics", __("Enable search Google Analytics integration?", "ajax-search-lite"),
                wpdreams_setval_or_getoption($ana_options, 'analytics', 'asl_analytics_def')
            ); ?>
        </div>
        <div class="item">
            <?php $o = new wpdreamsText("analytics_string", __("Google analytics pageview string", "ajax-search-lite"),
                wpdreams_setval_or_getoption($ana_options, "analytics_string", 'asl_analytics_def')
            ); ?>
            <p class='infoMsg'>
                <?php _e("This is how the pageview will look like on the google analytics website. Use the {asl_term} variable to add the search term to the pageview.", "ajax-search-lite"); ?>
            </p>
        </div>
        <div class="item">
            <input type='submit' class='submit' value='Save options'/>
        </div>
        <?php $_r = ob_get_clean(); ?>

        <?php
        $updated = false;
        if (isset($_POST) && isset($_POST['asl_analytics']) && (wpdreamsType::getErrorNum()==0)) {
            print "saving!";
            $values = array(
                "analytics" => $_POST['analytics'],
                "analytics_string" => $_POST['analytics_string']
            );
            update_option('asl_analytics', $values);
            $updated = true;
        }
        ?>
        <div class='wpdreams-slider'>
            <form name='asl_analytics1' method='post'>
                <?php if($updated): ?><div class='successMsg'>Analytics options successfuly updated!</div><?php endif; ?>
                <fieldset>
                    <legend><?php _e("Analytics options", "ajax-search-lite"); ?></legend>
                    <?php print $_r; ?>
                    <input type='hidden' name='asl_analytics' value='1' />
                </fieldset>
                <fieldset>
                    <legend><?php _e("Result", "ajax-search-lite"); ?></legend>
                    <p class='infoMsg'>
                        <?php _e("After some time you should be able to see the hits on your analytics board.", "ajax-search-lite"); ?>
                    </p>
                    <img src="http://i.imgur.com/s7BXiPV.png">
                </fieldset>
            </form>
        </div>
    </div>
</div>
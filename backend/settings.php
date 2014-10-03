<?php
$params = array();
$messages = "";

$sd = get_option('asl_options');
//var_dump($_sd);
$_def = get_option('asl_defaults');
$_dk = 'asl_defaults';
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=470596109688127&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<script>
    (function ($) {
        $(document).ready(function () {
            jQuery(jQuery('.tabs a')[0]).trigger('click');
        });
    }(jQuery));
</script>

<div id="wpdreams" class='wpdreams wrap'>
    <?php if (ASL_DEBUG == 1): ?>
        <p class='infoMsg'>Debug mode is on!</p>
    <?php endif; ?>

    <div class="wpdreams-box" style='vertical-align: middle;'>
        <a class='gopro' href='http://demo.wp-dreams.com/?product=ajax_search_pro' target='_blank'>Get the pro version!</a>
        or leave a like :)
        <div style='display: inline-block;' class="fb-like" data-href="https://www.facebook.com/pages/WPDreams/383702515034741" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
        or you can follow me
        <a href="https://twitter.com/ernest_marcinko" class="twitter-follow-button" data-show-count="false">Follow @ernest_marcinko</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    </div>

    <?php ob_start(); ?>
    <div class="wpdreams-box">

            <label class="shortcode">Search shortcode:</label>
            <input type="text" class="shortcode" value="[wpdreams_ajaxsearchlite]"
                   readonly="readonly"/>
            <label class="shortcode">Search shortcode for templates:</label>
            <input type="text" class="shortcode"
                   value="&lt;?php echo do_shortcode('[wpdreams_ajaxsearchlite'); ?&gt;"
                   readonly="readonly"/>
    </div>
    <div class="wpdreams-box">

        {--messages--}

        <form action='' method='POST' name='asl_data'>
            <ul id="tabs" class='tabs'>
                <li><a tabid="1" class='current general'>General Options</a></li>
                <li><a tabid="2" class='multisite'>Image Options</a></li>
                <li><a tabid="3" class='frontend'>Frontend Options</a></li>
                <li><a tabid="4" class='layout'>Layout options</a></li>
                <li><a tabid="7" class='advanced'>Advanced</a></li>
            </ul>
            <div id="content" class='tabscontent'>
                <div tabid="1">
                    <fieldset>
                        <legend>Genearal Options</legend>

                        <?php include(ASL_PATH . "backend/tabs/instance/general_options.php"); ?>

                    </fieldset>
                </div>
                <div tabid="2">
                    <fieldset>
                        <legend>Image Options</legend>

                        <?php include(ASL_PATH . "backend/tabs/instance/image_options.php"); ?>

                    </fieldset>
                </div>
                <div tabid="3">
                    <fieldset>
                        <legend>Frontend Search Settings</legend>

                        <?php include(ASL_PATH . "backend/tabs/instance/frontend_options.php"); ?>

                    </fieldset>
                </div>
                <div tabid="4">
                    <fieldset>
                        <legend>Layout Options</legend>

                        <?php include(ASL_PATH . "backend/tabs/instance/layout_options.php"); ?>

                    </fieldset>
                </div>
                <div tabid="7">
                    <fieldset>
                        <legend>Advanced Options</legend>

                        <?php include(ASL_PATH . "backend/tabs/instance/advanced_options.php"); ?>

                    </fieldset>
                </div>
            </div>
        </form>
    </div>
    <?php $output = ob_get_clean(); ?>
    <?php
    if (isset($_POST['submit_asl'])) {

        $params = wpdreams_parse_params($_POST);

        $_asl_options = get_option('asl_options');
        $_asl_options = array_merge($_asl_options, $params);

        update_option('asl_options', $_asl_options);

        $messages .= "<div class='infoMsg'>Ajax Search Lite settings saved!</div>";
    }

    echo str_replace("{--messages--}", $messages, $output);

    ?>
</div>      
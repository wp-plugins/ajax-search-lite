<p class='infoMsg'>
    This css will be added before the plugin as inline CSS so it has a precedence
    over plugin CSS. (you can override existing rules)
</p>
<div class="item">
    <?php
    $option_name = "custom_css";
    $option_desc = "Custom CSS";
    $o = new wpdreamsTextareaBase64($option_name, $option_desc, wpdreams_setval_or_getoption($sd, $option_name, $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
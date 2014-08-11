<style>
    .wpdreamsTextSmall {
        display: inline-block;
    }
</style>
<div class="item"><?php
    $o = new wpdreamsCustomSelect("i_ifnoimage", "If no image found",  array(
        'selects'=>wpdreams_setval_or_getoption($sd, 'i_ifnoimage_def', $_dk),
        'value'=>wpdreams_setval_or_getoption($sd, 'i_ifnoimage', $_dk)
    ));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsTextSmall("i_item_width", "Result width", wpdreams_setval_or_getoption($sd, 'i_item_width', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>px
    <p class="descMsg">The search will try to stick close to this value when filling the width of the results list.</p>
</div>
<div class="item"><?php
    $o = new wpdreamsTextSmall("i_item_height", "Result height", wpdreams_setval_or_getoption($sd, 'i_item_height', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>px
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("i_res_item_content_background", "Result content background", wpdreams_setval_or_getoption($sd, 'i_res_item_content_background', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("i_overlay", "Show overlay on mouseover?", wpdreams_setval_or_getoption($sd, 'i_overlay', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("i_overlay_blur", "Blur overlay image on mouseover?", wpdreams_setval_or_getoption($sd, 'i_overlay_blur', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("i_hide_content", "Hide the content when overlay is active?", wpdreams_setval_or_getoption($sd, 'i_hide_content', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsAnimations("i_animation", "Display animation", wpdreams_setval_or_getoption($sd, 'i_animation', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsTextSmall("i_rows", "Rows count", wpdreams_setval_or_getoption($sd, 'i_rows', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
    <p class="descMsg">If the item would exceed the row limit, it gets placed to a new page.</p>
</div>
<div class="item">
    <?php
    $option_name = "i_res_container_padding";
    $option_desc = "Result container padding";
    $option_expl = "Include the unit as well, example: 10px or 1em or 90%";
    $o = new wpdreamsFour($option_name, $option_desc,
        array(
            "desc" => $option_expl,
            "value" => wpdreams_setval_or_getoption($sd, $option_name, $_dk)
        )
    );
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $option_name = "i_res_container_margin";
    $option_desc = "Result container margin";
    $option_expl = "Include the unit as well, example: 10px or 1em or 90%";
    $o = new wpdreamsFour($option_name, $option_desc,
        array(
            "desc" => $option_expl,
            "value" => wpdreams_setval_or_getoption($sd, $option_name, $_dk)
        )
    );
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("i_res_container_bg", "Result box background", wpdreams_setval_or_getoption($sd, 'i_res_container_bg', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
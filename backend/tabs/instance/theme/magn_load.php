<div class="item">
    <?php
    $o = new wpdreamsImageRadio("magnifierimage", "Magnifier image", array(
            'images'  => wpdreams_setval_or_getoption($sd, 'magnifierimage_selects', $_dk),
            'value'=> wpdreams_setval_or_getoption($sd, 'magnifierimage', $_dk)
        )
    );
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("magnifierimage_color", "Magnifier icon color", wpdreams_setval_or_getoption($sd, 'magnifierimage_color', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsUpload("magnifierimage_custom", "Custom magnifier icon", wpdreams_setval_or_getoption($sd, 'magnifierimage_custom', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsGradient("magnifierbackground", "Magnifier background gradient", wpdreams_setval_or_getoption($sd, 'magnifierbackground', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsBorder("magnifierbackgroundborder", "Magnifier-icon border", wpdreams_setval_or_getoption($sd, 'magnifierbackgroundborder', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsBoxShadow("magnifierboxshadow", "Magnifier-icon box-shadow", wpdreams_setval_or_getoption($sd, 'magnifierboxshadow', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsImageRadio("loadingimage", "Loading image", array(
            'images'  => wpdreams_setval_or_getoption($sd, 'loadingimage_selects', $_dk),
            'value'=> wpdreams_setval_or_getoption($sd, 'loadingimage', $_dk)
        )
    );
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("loadingimage_color", "Loader color", wpdreams_setval_or_getoption($sd, 'loadingimage_color', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsUpload("loadingimage_custom", "Custom magnifier icon", wpdreams_setval_or_getoption($sd, 'loadingimage_custom', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
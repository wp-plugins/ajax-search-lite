<div class="item">
    <?php
    $o = new wpdreamsCustomSelect("settingsimagepos", "Settings icon position", array(
        'selects'=>wpdreams_setval_or_getoption($sd, 'settingsimagepos_def', $_dk),
        'value'=>wpdreams_setval_or_getoption($sd, 'settingsimagepos', $_dk)
    ));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsImageRadio("settingsimage", "Settings icon", array(
            'images'  => wpdreams_setval_or_getoption($sd, 'settingsimage_selects', $_dk),
            'value'=> wpdreams_setval_or_getoption($sd, 'settingsimage', $_dk)
        )
    );
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("settingsimage_color", "Settings icon color", wpdreams_setval_or_getoption($sd, 'settingsimage_color', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsUpload("settingsimage_custom", "Custom settings icon", wpdreams_setval_or_getoption($sd, 'settingsimage_custom', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsGradient("settingsbackground", "Settings-icon background gradient", wpdreams_setval_or_getoption($sd, 'settingsbackground', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item">
    <?php
    $o = new wpdreamsBorder("settingsbackgroundborder", "Settings-icon border", wpdreams_setval_or_getoption($sd, 'settingsbackgroundborder', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsBoxShadow("settingsboxshadow", "Settings-icon box-shadow", wpdreams_setval_or_getoption($sd, 'settingsboxshadow', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsGradient("settingsdropbackground", "Settings drop-down background gradient", wpdreams_setval_or_getoption($sd, 'settingsdropbackground', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item">
    <?php
    $o = new wpdreamsBoxShadow("settingsdropboxshadow", "Settings drop-down box-shadow", wpdreams_setval_or_getoption($sd, 'settingsdropboxshadow', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsFontComplete("settingsdropfont", "Settings drop down font", wpdreams_setval_or_getoption($sd, 'settingsdropfont', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsFontComplete("exsearchincategoriestextfont", "Settings box header text font", wpdreams_setval_or_getoption($sd, 'exsearchincategoriestextfont', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("settingsdroptickcolor","Settings drop-down tick color", wpdreams_setval_or_getoption($sd, 'settingsdroptickcolor', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item"><?php
    $o = new wpdreamsGradient("settingsdroptickbggradient", "Settings drop-down tick background", wpdreams_setval_or_getoption($sd, 'settingsdroptickbggradient', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
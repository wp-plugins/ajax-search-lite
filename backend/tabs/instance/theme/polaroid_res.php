<div class="item"><?php
    $o = new wpdreamsCustomSelect("pifnoimage", "If no image found",  array(
        'selects'=>wpdreams_setval_or_getoption($sd, 'pifnoimage_def', $_dk),
        'value'=>wpdreams_setval_or_getoption($sd, 'pifnoimage', $_dk)
    ));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("pshowdesc", "Show descripton on the back of the polaroid", wpdreams_setval_or_getoption($sd, 'pshowdesc', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsNumericUnit("prescontainerheight", "Container height", array(
        'value' => wpdreams_setval_or_getoption($sd, 'prescontainerheight', $_dk),
        'units'=>array('px'=>'px')));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsNumericUnit("preswidth", "Result width", array(
        'value' => wpdreams_setval_or_getoption($sd, 'preswidth', $_dk),
        'units'=>array('px'=>'px')));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsNumericUnit("presheight", "Result height", array(
        'value' => wpdreams_setval_or_getoption($sd, 'presheight', $_dk),
        'units'=>array('px'=>'px')));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsNumericUnit("prespadding", "Result padding", array(
        'value' => wpdreams_setval_or_getoption($sd, 'prespadding', $_dk),
        'units'=>array('px'=>'px')));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("pshowsubtitle", "Show date/author", wpdreams_setval_or_getoption($sd, 'pshowsubtitle', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsFontComplete("prestitlefont", "Result title font", wpdreams_setval_or_getoption($sd, 'prestitlefont', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsFontComplete("pressubtitlefont", "Result sub-title font", wpdreams_setval_or_getoption($sd, 'pressubtitlefont', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>

<div class="item"><?php
    $o = new wpdreamsFontComplete("presdescfont", "Result description font", wpdreams_setval_or_getoption($sd, 'presdescfont', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsGradient("prescontainerbg", "Container background", wpdreams_setval_or_getoption($sd, 'prescontainerbg', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsGradient("pdotssmallcolor", "Nav dot colors", wpdreams_setval_or_getoption($sd, 'pdotssmallcolor', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsGradient("pdotscurrentcolor", "Nav active dot color", wpdreams_setval_or_getoption($sd, 'pdotscurrentcolor', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsGradient("pdotsflippedcolor", "Nav flipped dot color", wpdreams_setval_or_getoption($sd, 'pdotsflippedcolor', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
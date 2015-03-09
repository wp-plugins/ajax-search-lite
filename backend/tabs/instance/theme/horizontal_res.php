<div class="item">
    <?php
    $o = new wpdreamsYesNo("hhidedesc", "Hide description if images are available", wpdreams_setval_or_getoption($sd, 'hhidedesc', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsNumericUnit("hreswidth", "Result width", array(
        'value' => wpdreams_setval_or_getoption($sd, 'hreswidth', $_dk),
        'units'=>array('px'=>'px')));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsNumericUnit("hresheight", "Result height", array(
        'value' => wpdreams_setval_or_getoption($sd, 'hresheight', $_dk),
        'units'=>array('px'=>'px')));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsNumericUnit("hressidemargin", "Result side margin", array(
        'value' => wpdreams_setval_or_getoption($sd, 'hressidemargin', $_dk),
        'units'=>array('px'=>'px')));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsNumericUnit("hrespadding", "Result padding", array(
        'value' => wpdreams_setval_or_getoption($sd, 'hrespadding', $_dk),
        'units'=>array('px'=>'px')));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsGradient("hboxbg", "Result container background gradient", wpdreams_setval_or_getoption($sd, 'hboxbg', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsBorder("hboxborder", "Results container border", wpdreams_setval_or_getoption($sd, 'hboxborder', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsBoxShadow("hboxshadow", "Results container box shadow", wpdreams_setval_or_getoption($sd, 'hboxshadow', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsAnimations("hresultinanim", "Result item incoming animation", wpdreams_setval_or_getoption($sd, 'hresultinanim', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsGradient("hresultbg", "Result item background gradient", wpdreams_setval_or_getoption($sd, 'hresultbg', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsGradient("hresulthbg", "Result item mouse hover background gradient", wpdreams_setval_or_getoption($sd, 'hresulthbg', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsBorder("hresultborder", "Results item border", wpdreams_setval_or_getoption($sd, 'hresultborder', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsBoxShadow("hresultshadow", "Results item box shadow", wpdreams_setval_or_getoption($sd, 'hresultshadow', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsBorder("hresultimageborder", "Results image border", wpdreams_setval_or_getoption($sd, 'hresultimageborder', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsBoxShadow("hresultimageshadow", "Results image box shadow", wpdreams_setval_or_getoption($sd, 'hresultimageshadow', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("harrowcolor","Resultbar arrow color", wpdreams_setval_or_getoption($sd, 'harrowcolor', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("hoverflowcolor","Resultbar overflow color", wpdreams_setval_or_getoption($sd, 'hoverflowcolor', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
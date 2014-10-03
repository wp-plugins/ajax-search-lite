<div class="item"><?php
    $o = new wpdreamsGradient("inputbackground", "Search input field background gradient", wpdreams_setval_or_getoption($sd, 'inputbackground', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item">
    <?php
    $o = new wpdreamsBorder("inputborder", "Search input field border", wpdreams_setval_or_getoption($sd, 'inputborder', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsBoxShadow("inputshadow", "Search input field Shadow", wpdreams_setval_or_getoption($sd, 'inputshadow', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsFontComplete("inputfont", "Search input font", wpdreams_setval_or_getoption($sd, 'inputfont', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
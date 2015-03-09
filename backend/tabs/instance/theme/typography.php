<div class="item"><?php
    $o = new wpdreamsFontComplete("titlefont", "Results title link font", wpdreams_setval_or_getoption($sd, 'titlefont', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsFontComplete("titlehoverfont", "Results title hover link font", wpdreams_setval_or_getoption($sd, 'titlehoverfont', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsFontComplete("authorfont", "Author text font", wpdreams_setval_or_getoption($sd, 'authorfont', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsFontComplete("datefont", "Date text font", wpdreams_setval_or_getoption($sd, 'datefont', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsFontComplete("descfont", "Description text font", wpdreams_setval_or_getoption($sd, 'descfont', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("exsearchincategoriesboxcolor","Grouping box header background color", wpdreams_setval_or_getoption($sd, 'exsearchincategoriesboxcolor', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("groupingbordercolor","Grouping box border color", wpdreams_setval_or_getoption($sd, 'groupingbordercolor', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item"><?php
    $o = new wpdreamsFontComplete("groupbytextfont", "Grouping font color", wpdreams_setval_or_getoption($sd, 'groupbytextfont', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsFontComplete("showmorefont", "Show more font", wpdreams_setval_or_getoption($sd, 'showmorefont', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
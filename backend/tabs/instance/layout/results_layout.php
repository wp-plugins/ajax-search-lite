<div class="item">
    <?php
    $o = new wpdreamsText("defaultsearchtext", "Placeholder text", wpdreams_setval_or_getoption($sd, 'defaultsearchtext', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("showmoreresults", "Show 'More results..' text in the bottom of the search box?", wpdreams_setval_or_getoption($sd, 'showmoreresults', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsText("showmoreresultstext", "' Show more results..' text", wpdreams_setval_or_getoption($sd, 'showmoreresultstext', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("showauthor", "Show author in results?", wpdreams_setval_or_getoption($sd, 'showauthor', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("showdate", "Show date in results?", wpdreams_setval_or_getoption($sd, 'showdate', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("showdescription", "Show description in results?", wpdreams_setval_or_getoption($sd, 'showdescription', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsTextSmall("descriptionlength", "Description length", wpdreams_setval_or_getoption($sd, 'descriptionlength', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
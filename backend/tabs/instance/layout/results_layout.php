<div class="item">
    <?php
    $o = new wpdreamsText("defaultsearchtext", __("Placeholder text", "ajax-search-lite"), wpdreams_setval_or_getoption($sd, 'defaultsearchtext', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("showmoreresults", __("Show 'More results..' text in the bottom of the search box?", "ajax-search-lite"), wpdreams_setval_or_getoption($sd, 'showmoreresults', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsText("showmoreresultstext", __("' Show more results..' text", "ajax-search-lite"), wpdreams_setval_or_getoption($sd, 'showmoreresultstext', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("showauthor", __("Show author in results?", "ajax-search-lite"), wpdreams_setval_or_getoption($sd, 'showauthor', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("showdate", __("Show date in results?", "ajax-search-lite"), wpdreams_setval_or_getoption($sd, 'showdate', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("showdescription", __("Show description in results?", "ajax-search-lite"), wpdreams_setval_or_getoption($sd, 'showdescription', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsTextSmall("descriptionlength", __("Description length", "ajax-search-lite"), wpdreams_setval_or_getoption($sd, 'descriptionlength', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
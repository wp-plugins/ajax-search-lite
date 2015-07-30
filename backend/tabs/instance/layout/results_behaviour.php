<div class="item">
    <?php
    $o = new wpdreamsYesNo("scroll_to_results", __("Sroll the window to the result list?", "ajax-search-lite"), wpdreams_setval_or_getoption($sd, 'scroll_to_results', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("resultareaclickable", __("Make the whole result area clickable?", "ajax-search-lite"), wpdreams_setval_or_getoption($sd, 'resultareaclickable', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("close_on_document_click", __("Close result list on document click?", "ajax-search-lite"), wpdreams_setval_or_getoption($sd, 'close_on_document_click', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("show_close_icon", __("Show the close icon?", "ajax-search-lite"), wpdreams_setval_or_getoption($sd, 'show_close_icon', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsText("noresultstext", __("No results text", "ajax-search-lite"), wpdreams_setval_or_getoption($sd, 'noresultstext', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item"><?php
    $o = new wpdreamsText("didyoumeantext", __("Did you mean text", "ajax-search-lite"), wpdreams_setval_or_getoption($sd, 'didyoumeantext', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
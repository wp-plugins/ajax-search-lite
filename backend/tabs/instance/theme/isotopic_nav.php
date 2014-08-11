<div class="item"><?php
    $o = new wpdreamsCustomSelect("i_pagination_position", "Navigation position",  array(
        'selects'=>wpdreams_setval_or_getoption($sd, 'i_pagination_position_def', $_dk),
        'value'=>wpdreams_setval_or_getoption($sd, 'i_pagination_position', $_dk)
    ));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("i_pagination_background", "Pagination background", wpdreams_setval_or_getoption($sd, 'i_pagination_background', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsImageRadio("i_pagination_arrow", "Arrow image", array(
            'images'  => wpdreams_setval_or_getoption($sd, 'i_pagination_arrow_selects', $_dk),
            'value'=> wpdreams_setval_or_getoption($sd, 'i_pagination_arrow', $_dk)
        )
    );
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("i_pagination_arrow_background", "Arrow background color", wpdreams_setval_or_getoption($sd, 'i_pagination_arrow_background', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("i_pagination_arrow_color", "Arrow color", wpdreams_setval_or_getoption($sd, 'i_pagination_arrow_color', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("i_pagination_page_background", "Active page background color", wpdreams_setval_or_getoption($sd, 'i_pagination_page_background', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("i_pagination_font_color", "Font color", wpdreams_setval_or_getoption($sd, 'i_pagination_font_color', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
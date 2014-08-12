<div class="item">
    <?php
    $o = new wpdreamsYesNo("keywordsuggestions", "Keyword suggestions on no results?",
        wpdreams_setval_or_getoption($sd, 'keywordsuggestions', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsLanguageSelect("keywordsuggestionslang", "Keyword suggestions language",
        wpdreams_setval_or_getoption($sd, 'keywordsuggestionslang', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>

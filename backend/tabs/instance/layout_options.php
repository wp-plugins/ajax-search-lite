<ul id="subtabs"  class='tabs'>
    <li><a tabid="201" class='subtheme current'><?php _e("Results layout", "ajax-search-lite"); ?></a></li>
    <li><a tabid="202" class='subtheme'><?php _e("Results Behaviour", "ajax-search-lite"); ?></a></li>
</ul>
<div class='tabscontent'>
    <div tabid="201">
        <fieldset>
            <legend><?php _e("Results layout", "ajax-search-lite"); ?></legend>
            <?php include(ASL_PATH."backend/tabs/instance/layout/results_layout.php"); ?>
        </fieldset>
    </div>
    <div tabid="202">
        <fieldset>
            <legend><?php _e("Results Behaviour", "ajax-search-lite"); ?></legend>
            <?php include(ASL_PATH."backend/tabs/instance/layout/results_behaviour.php"); ?>
        </fieldset>
    </div>
</div>
<div class="item">
    <input type="hidden" name='asl_submit' value=1 />
    <input name="submit_asl" type="submit" value="<?php _e("Save options!", "ajax-search-lite"); ?>" />
</div>
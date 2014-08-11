<?php
if (!class_exists("wpdreamsCustomPostTypes")) {
    /**
     * Class wpdreamsCustomPostTypes
     *
     * A custom post types selector UI element with.
     *
     * @author Ernest Marcinko <ernest.marcinko@wp-dreams.com>
     * @link http://wp-dreams.com, http://codecanyon.net/user/anago/portfolio
     * @copyright Copyright (c) 2014, Ernest Marcinko
     */
    class wpdreamsCustomPostTypes extends wpdreamsType {
        function getType() {
            parent::getType();
            $this->processData();
            $this->types = get_post_types(array(
                '_builtin' => false
            ));
            echo "
      <div class='wpdreamsCustomPostTypes'>
        <fieldset>
          <legend>" . $this->label . "</legend>";
            echo '<div class="sortablecontainer"><p>Available post types</p><ul id="sortable' . self::$_instancenumber . '" class="connectedSortable">';
            if ($this->types != null && is_array($this->types)) {
                foreach ($this->types as $k => $v) {
                    if ($this->selected == null || !in_array($v, $this->selected)) {
                        echo '<li class="ui-state-default">' . $k . '</li>';
                    }
                }
            }
            echo "</ul></div>";
            echo '<div class="sortablecontainer"><p>Drag here the post types you want to use!</p><ul id="sortable_conn' . self::$_instancenumber . '" class="connectedSortable">';
            if ($this->selected != null && is_array($this->selected)) {
                foreach ($this->selected as $k => $v) {
                    echo '<li class="ui-state-default">' . $v . '</li>';
                }
            }
            echo "</ul></div>";
            echo "
         <input isparam=1 type='hidden' value='" . $this->data . "' name='" . $this->name . "'>";
            echo "
         <input type='hidden' value='wpdreamsCustomPostTypes' name='classname-" . $this->name . "'>";
            ?>
            <script type='text/javascript'>
                (function ($) {
                    $(document).ready(function () {
                        $("#sortable<?php echo self::$_instancenumber ?>, #sortable_conn<?php echo self::$_instancenumber ?>").sortable({
                            connectWith: ".connectedSortable"
                        }, {
                            update: function (event, ui) {
                                parent = $(ui.item).parent();
                                while (!parent.hasClass('wpdreamsCustomPostTypes')) {
                                    parent = $(parent).parent();
                                }
                                var items = $('ul[id*=sortable_conn] li', parent);
                                var hidden = $('input[name=<?php echo $this->name; ?>]', parent);
                                var val = "";
                                items.each(function () {
                                    val += "|" + $(this).html();
                                });
                                val = val.substring(1);
                                hidden.val(val);
                            }
                        }).disableSelection();
                    });
                }(jQuery));
            </script>
            <?php
            echo "
        </fieldset>
      </div>";
        }

        function processData() {
            $this->data = str_replace("\n", "", $this->data);
            if ($this->data != "")
                $this->selected = explode("|", $this->data);
            else
                $this->selected = null;
            //$this->css = "border-radius:".$this->topleft."px ".$this->topright."px ".$this->bottomright."px ".$this->bottomleft."px;";
        }

        final function getData() {
            return $this->data;
        }

        final function getSelected() {
            return $this->selected;
        }
    }
}
?>
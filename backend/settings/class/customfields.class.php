<?php
if (!class_exists("wpdreamsCustomFields")) {
    /**
     * Class wpdreamsCustomFields
     *
     * A custom field selector UI element.
     *
     * @author Ernest Marcinko <ernest.marcinko@wp-dreams.com>
     * @link http://wp-dreams.com, http://codecanyon.net/user/anago/portfolio
     * @copyright Copyright (c) 2014, Ernest Marcinko
     */
    class wpdreamsCustomFields extends wpdreamsType {
        function getType() {
            parent::getType();
            global $wpdb;
            $this->processData();
            $this->types = $wpdb->get_results("SELECT * FROM " . $wpdb->postmeta . " GROUP BY meta_key", ARRAY_A);
            echo "
      <div class='wpdreamsCustomFields'>
        <fieldset>
          <legend>" . $this->label . "</legend>";
            echo '<div class="sortablecontainer"><p>Available public custom fields types</p><ul id="sortable' . self::$_instancenumber . '" class="connectedSortable">';
            if ($this->types != null && is_array($this->types)) {
                foreach ($this->types as $k => $v) {
                    if ($this->selected == null || !in_array($v['meta_key'], $this->selected)) {
                        echo '<li class="ui-state-default">' . $v['meta_key'] . '</li>';
                    }
                }
            }
            echo "</ul></div>";
            echo '<div class="sortablecontainer"><p>Drag here the custom fields you want to use!</p><ul id="sortable_conn' . self::$_instancenumber . '" class="connectedSortable">';
            if ($this->selected != null && is_array($this->selected)) {
                foreach ($this->selected as $k => $v) {
                    echo '<li class="ui-state-default">' . $v . '</li>';
                }
            }
            echo "</ul></div>";
            echo "
         <input isparam=1 type='hidden' value='" . $this->data . "' name='" . $this->name . "'>";
            echo "
         <input type='hidden' value='wpdreamsCustomFields' name='classname-" . $this->name . "'>";
            ?>
            <script>
                (function ($) {
                    $(document).ready(function () {
                        $("#sortable<?php echo self::$_instancenumber ?>, #sortable_conn<?php echo self::$_instancenumber ?>").sortable({
                            connectWith: ".connectedSortable"
                        }, {
                            update: function (event, ui) {
                                parent = $(ui.item).parent();
                                while (!parent.hasClass('wpdreamsCustomFields')) {
                                    parent = $(parent).parent();
                                }
                                var items = $('ul[id*=sortable_conn] li', parent);
                                var hidden = $('input[name=<?php echo $this->name; ?>]', parent);
                                console.log(items, hidden);
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
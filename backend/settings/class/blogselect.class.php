<?php
if (!class_exists("wpdreamsBlogselect")) {
    /**
     * Class wpdreamsBlogselect
     *
     * Creates a blog selection drag and drop UI element.
     *
     * @author Ernest Marcinko <ernest.marcinko@wp-dreams.com>
     * @link http://wp-dreams.com, http://codecanyon.net/user/anago/portfolio
     * @copyright Copyright (c) 2012, Ernest Marcinko
     */
    class wpdreamsBlogselect extends wpdreamsType {
        function getType() {
            parent::getType();
            global $wpdb;
            $this->processData();
            $this->types = wpdreams_get_blog_list(0, 'all');
            echo "
      <div class='wpdreamsBlogselect'>
        <fieldset>
          <legend>" . $this->label . "</legend>";
            echo '<div class="sortablecontainer"><p>Available blogs</p><ul id="sortable' . self::$_instancenumber . '" class="connectedSortable">';
            if ($this->types != null && is_array($this->types)) {
                foreach ($this->types as $k => $v) {
                    if ($this->selected == null || !in_array($v['blog_id'], $this->selected)) {
                        $_temp = get_blog_details($v['blog_id']);
                        echo '<li class="ui-state-default" bid="' . $v['blog_id'] . '">' . $_temp->blogname . '</li>';
                    }
                }
            }
            echo "</ul></div>";
            echo '<div class="sortablecontainer"><p>Drag here the blogs you want to use!</p><ul id="sortable_conn' . self::$_instancenumber . '" class="connectedSortable">';
            if ($this->selected != null && is_array($this->selected)) {
                foreach ($this->selected as $k => $v) {
                    $echo = "";
                    foreach ($this->types as $_type) {
                        if ($_type['blog_id'] == $v) {
                            $_temp = get_blog_details($v);
                            $echo = $_temp->blogname;
                            break;
                        }
                    }
                    echo '<li class="ui-state-default" bid="' . $v . '">' . $echo . '</li>';
                }
            }
            echo "</ul></div>";
            echo "
         <input isparam=1 type='hidden' value='" . $this->data . "' name='" . $this->name . "'>";
            echo "
         <input type='hidden' value='wpdreamsBlogselect' name='classname-" . $this->name . "'>";
            ?>
            <script>
                (function ($) {
                    $(document).ready(function () {
                        $("#sortable<?php echo self::$_instancenumber ?>, #sortable_conn<?php echo self::$_instancenumber ?>").sortable({
                            connectWith: ".connectedSortable"
                        }, {
                            update: function (event, ui) {
                                parent = $(ui.item).parent();
                                while (!parent.hasClass('wpdreamsBlogselect')) {
                                    parent = $(parent).parent();
                                }
                                var items = $('ul[id*=sortable_conn] li', parent);
                                var hidden = $('input[name=<?php echo $this->name; ?>]', parent);
                                var val = "";
                                items.each(function () {
                                    val += "|" + $(this).attr('bid');
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
<?php
if (!class_exists("wpdreamsCustomPostTypesEditable")) {
    /**
     * Class wpdreamsCustomPostTypesEditable
     *
     * A custom post types selector UI element with editable titles.
     *
     * @author Ernest Marcinko <ernest.marcinko@wp-dreams.com>
     * @link http://wp-dreams.com, http://codecanyon.net/user/anago/portfolio
     * @copyright Copyright (c) 2014, Ernest Marcinko
     */
    class wpdreamsCustomPostTypesEditable extends wpdreamsType {
        function getType() {
            parent::getType();
            $this->processData();
            $this->types = get_post_types(array(
                '_builtin' => false
            ));
            echo "
      <div class='wpdreamsCustomPostTypesEditable'>
        <fieldset>
          <legend>" . $this->label . "</legend>";
            echo '<div class="sortablecontainer"><p>Available post types</p><ul id="sortable' . self::$_instancenumber . '" class="connectedSortable">';
            if ($this->types != null && is_array($this->types)) {
                foreach ($this->types as $k => $v) {
                    if ($this->selected == null || !in_array_r($v, $this->selected)) {
                        echo '<li class="ui-state-default ui-left" style="background: #ddd;">
              <label>' . $k . '</label>
              <input type="text" value="' . $k . '"/>
              </li>';
                    }
                }
            }
            echo "</ul></div>";
            echo '<div class="sortablecontainer"><p>Drag here the post types you want to use!</p><ul id="sortable_conn' . self::$_instancenumber . '" class="connectedSortable">';
            if ($this->selected != null && is_array($this->selected)) {
                foreach ($this->selected as $k => $v) {
                    echo '<li class="ui-state-default ui-left" style="background: #ddd;">
            <label>' . $v[0] . '</label>
            <input type="text" value="' . $v[1] . '"/>
            </li>';
                }
            }
            echo "</ul></div>";
            echo "
         <input isparam=1 type='hidden' value='" . $this->data . "' name='" . $this->name . "'>";
            echo "
         <input type='hidden' value='wpdreamsCustomPostTypesEditable' name='classname-" . $this->name . "'>";
            ?>
            <script>
                (function ($) {
                    $(document).ready(function () {
                        $("#sortable_conn<?php echo self::$_instancenumber ?> li input").keyup(function () {
                            parent = $(this).parent();
                            while (!parent.hasClass('wpdreamsCustomPostTypesEditable')) {
                                parent = $(parent).parent();
                            }
                            var items = $('ul[id*=sortable_conn] li', parent);
                            var hidden = $('input[name=<?php echo $this->name; ?>]', parent);
                            var val = "";
                            items.each(function () {
                                val += "|" + $('label', this).html() + ";" + $('input', this).val();
                            });
                            val = val.substring(1);
                            hidden.val(val);
                        });
                        $("#sortable<?php echo self::$_instancenumber ?>, #sortable_conn<?php echo self::$_instancenumber ?>").sortable({
                            connectWith: ".connectedSortable"
                        }, {
                            update: function (event, ui) {
                                $("#sortable_conn<?php echo self::$_instancenumber ?> li input").keyup(function () {
                                    parent = $(this).parent();
                                    while (!parent.hasClass('wpdreamsCustomPostTypesEditable')) {
                                        parent = $(parent).parent();
                                    }
                                    var items = $('ul[id*=sortable_conn] li', parent);
                                    var hidden = $('input[name=<?php echo $this->name; ?>]', parent);
                                    var val = "";
                                    console.log(val);
                                    items.each(function () {
                                        val += "|" + $('label', this).html() + ";" + $('input', this).val();
                                    });
                                    val = val.substring(1);
                                    hidden.val(val);
                                });
                                if ($("#sortable_conn<?php echo self::$_instancenumber ?> li input").length != 0) {
                                    $("#sortable_conn<?php echo self::$_instancenumber ?> li input").keyup();
                                } else {
                                    $("#sortable_conn<?php echo self::$_instancenumber ?>").each(function () {
                                        parent = $(this).parent();
                                        while (!parent.hasClass('wpdreamsCustomPostTypesEditable')) {
                                            parent = $(parent).parent();
                                        }
                                        var hidden = $('input[name=<?php echo $this->name; ?>]', parent);
                                        hidden.val("");
                                    });
                                }
                            }
                        });
                    });

                }(jQuery));
            </script>
            <?php
            echo "
        </fieldset>
      </div>";
        }

        function processData() {
            $this->data = stripslashes(str_replace("\n", "", $this->data));
            if ($this->data != "") {
                $this->_t = explode("|", $this->data);
                foreach ($this->_t as $k => $v) {
                    $this->selected[] = explode(';', $v);
                }
            } else {
                $this->selected = null;
            }
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
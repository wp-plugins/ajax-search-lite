<?php
if (!class_exists("wpdreamsCustomTaxonomyTerm")) {
    /**
     * Class wpdreamsCustomTaxonomyTerm
     *
     * A taxonomy-term drag and drop UI element.
     *
     * @author Ernest Marcinko <ernest.marcinko@wp-dreams.com>
     * @link http://wp-dreams.com, http://codecanyon.net/user/anago/portfolio
     * @copyright Copyright (c) 2014, Ernest Marcinko
     */
    class wpdreamsCustomTaxonomyTerm extends wpdreamsType {
        function getType() {
            parent::getType();
            $this->processData();
            $this->types = $this->getAllTerms();
            echo "
      <div class='wpdreamsCustomTaxonomyTerm'>
        <fieldset>                               
          <div style='margin:15px 30px;text-align: left;'>
          <label>Select the taxonomy: </label>
          <select name='" . $this->name . "_taxonomies' id='" . $this->name . "_taxonomies'> ";
            foreach ($this->types as $taxonomy => $v) {
                $tax = get_taxonomy($taxonomy);
                $custom_post_type = "";
                if ($tax->object_type != null && $tax->object_type[0] != null)
                    $custom_post_type = $tax->object_type[0] . " - ";
                echo "<option  value='" . $taxonomy . "' taxonomy='" . $taxonomy . "'>" . $custom_post_type . $tax->labels->name . "</option>";
            }
            echo "</select>
          </div>
          <legend>" . $this->label . "</legend>";
            echo '<div class="sortablecontainer"><p>Available terms for the selected taxonomy</p><ul id="sortable' . self::$_instancenumber . '" class="connectedSortable">';
            if ($this->types != null && is_array($this->types)) {
                foreach ($this->types as $kk => $vv) {
                    foreach ($vv as $k => $term) {
                        if ($this->selected == null || !wpdreams_in_array_r($term->term_id, $this->selected)) {
                            echo '<li class="ui-state-default" term_id="' . $term->term_id . '" taxonomy="' . $term->taxonomy . '">' . $term->name . '</li>';
                        }
                    }
                }
            }
            echo "</ul></div>";
            echo '<div class="sortablecontainer"><p>Drag here the terms you want to <b>' . $this->otype . '</b>!</p><ul id="sortable_conn' . self::$_instancenumber . '" class="connectedSortable">';
            if ($this->selected != null && is_array($this->selected)) {
                foreach ($this->selected as $k => $v) {
                    $term = get_term($v[0], $v[1]);
                    echo '<li class="ui-state-default" term_id="' . $term->term_id . '" taxonomy="' . $term->taxonomy . '">' . $term->name . '</li>';
                }
            }
            echo "</ul></div>";
            echo "
         <input isparam=1 type='hidden' value='" . $this->data["value"] . "' name='" . $this->name . "'>
         <input type='hidden' value='wpdreamsCustomTaxonomyTerm' name='classname-" . $this->name . "'>";
            ?>
            <script type='text/javascript'>
                (function ($) {
                    $(document).ready(function () {
                        $("#sortable<?php echo self::$_instancenumber ?>, #sortable_conn<?php echo self::$_instancenumber ?>").sortable({
                            connectWith: ".connectedSortable"
                        }, {
                            update: function (event, ui) {
                                parent = $(ui.item).parent();
                                while (!parent.hasClass('wpdreamsCustomTaxonomyTerm')) {
                                    parent = $(parent).parent();
                                }
                                var items = $('ul[id*=sortable_conn] li', parent);
                                var hidden = $('input[name=<?php echo $this->name; ?>]', parent);
                                var val = "";
                                items.each(function () {
                                    val += "|" + $(this).attr('term_id') + "-" + $(this).attr('taxonomy');
                                });
                                val = val.substring(1);
                                hidden.val(val);
                            }
                        }).disableSelection();
                        $("#<?php echo $this->name; ?>_taxonomies").change(function () {
                            var taxonomy = $(this).val();
                            $("li", "#sortable<?php echo self::$_instancenumber ?>").css('display', 'none');
                            $("li[taxonomy=" + taxonomy + "]", "#sortable<?php echo self::$_instancenumber ?>").css('display', 'block');
                        });
                        $("#<?php echo $this->name; ?>_taxonomies").change();
                    });
                }(jQuery));
            </script>
            <?php
            echo "
        </fieldset>
      </div>";
        }

        function getAllTaxonomies() {
            $args = array(
                'public' => true,
                '_builtin' => false

            );
            $output = 'names'; // or objects
            $operator = 'and'; // 'and' or 'or'
            $taxonomies = get_taxonomies($args, $output, $operator);
            return $taxonomies;
        }

        function getAllTerms() {
            $taxonomies = $this->getAllTaxonomies();
            $terms = array();
            foreach ($taxonomies as $taxonomy) {
                $terms[$taxonomy] = get_terms($taxonomy, 'orderby=name');
            }
            return $terms;
        }

        function processData() {
            if (isset($this->data['type']) && isset($this->data['value'])) {
              $this->otype = $this->data['type'];
              $this->v = str_replace("\n", "", $this->data["value"]);
            } else {
              $this->otype = "include";
              $this->v = str_replace("\n", "", $this->data);
            }

            $this->selected = array();
            $this->_selected = array();
            if ($this->v != "") {
                $_sel = explode("|", $this->v);
                foreach ($_sel as $k => $v)
                    $this->selected[] = explode("-", $v);
                foreach ($this->selected as $kk => $vv)
                    $this->_selected[$vv[1]][] = $vv[0];
            } else {
                $this->selected = null;
                $this->_selected = null;
            }

        }

        final function getData() {
            return $this->data;
        }

        final function getSelected() {
            return $this->_selected;
        }
    }
}
?>
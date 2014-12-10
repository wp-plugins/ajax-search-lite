<?php
/**
 * Class wpdreamsText
 *
 * A simple text input field.
 *
 * @author Ernest Marcinko <ernest.marcinko@wp-dreams.com>
 * @link http://wp-dreams.com, http://codecanyon.net/user/anago/portfolio
 * @copyright Copyright (c) 2014, Ernest Marcinko
 */
if (!class_exists("wpdreamsText")) {
    class wpdreamsText extends wpdreamsType {
        function getType() {
            parent::getType();
            echo "<div class='wpdreamsText'>";
            if ($this->label != "")
                echo "<label for='wpdreamstext_" . self::$_instancenumber . "'>" . $this->label . "</label>";
            echo "<input isparam=1 type='text' id='wpdreamstext_" . self::$_instancenumber . "' name='" . $this->name . "' value='" . $this->data . "' />";
            echo "
        <div class='triggerer'></div>
      </div>";
        }
    }
}
?>
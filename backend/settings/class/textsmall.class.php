<?php
if (!class_exists("wpdreamsTextSmall")) {
    /**
     * Class wpdreamsTextSmall
     *
     * A 5 characters wide text input field.
     *
     * @author Ernest Marcinko <ernest.marcinko@wp-dreams.com>
     * @link http://wp-dreams.com, http://codecanyon.net/user/anago/portfolio
     * @copyright Copyright (c) 2014, Ernest Marcinko
     */
    class wpdreamsTextSmall extends wpdreamsType {
        function getType() {
            parent::getType();
            echo "<div class='wpdreamsTextSmall'>";
            if ($this->label != "")
                echo "<label for='wpdreamstextsmall_" . self::$_instancenumber . "'>" . $this->label . "</label>";
            echo "<input isparam=1 class='small' type='text' id='wpdreamstextsmall_" . self::$_instancenumber . "' name='" . $this->name . "' value='" . $this->data . "' />";
            echo "
        <div class='triggerer'></div>
      </div>";
        }
    }
}
?>
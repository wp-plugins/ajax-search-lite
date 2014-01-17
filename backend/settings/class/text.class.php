<?php
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
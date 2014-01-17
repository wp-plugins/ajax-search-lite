<?php
if (!class_exists("wpdreamsHidden")) {
  class wpdreamsHidden extends wpdreamsType {
  	function getType() {
  		echo "<input type='hidden' id='wpdreamshidden_" . self::$_instancenumber . "' name='" . $this->name . "' value='" . $this->data . "' />";
  	}
  }
}
?>
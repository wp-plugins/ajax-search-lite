<?php
if (!class_exists("wpdreamsTextarea")) {
  class wpdreamsTextarea extends wpdreamsType {
  	function getType() {
  		parent::getType();
  		echo "<label style='vertical-align: top;' for='wpdreamstextarea_" . self::$_instancenumber . "'>" . $this->label . "</label>";
  		echo "<textarea id='wpdreamstextarea_" . self::$_instancenumber . "' name='" . $this->name . "'>" . stripcslashes($this->data) . "</textarea>";
  	}
  } 
}
?>
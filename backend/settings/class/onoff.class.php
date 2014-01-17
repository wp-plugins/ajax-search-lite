<?php
if (!class_exists("wpdreamsOnOff")) {
  class wpdreamsOnOff extends wpdreamsType {
	function getType() {
  		parent::getType();
      echo "<div class='wpdreamsOnOff". (($this->data == 1) ? " active" : "") ."'>";
  		echo "<label for='wpdreamstext_" . self::$_instancenumber . "'>" . $this->label . "</label>";
  		//echo "<a class='wpdreamsyesno" . (($this->data == 1) ? " yes" : " no") . "' id='wpdreamsyesno_" . self::$_instancenumber . "' name='" . $this->name . "_yesno'>" . (($this->data == 1) ? "YES" : "NO") . "</a>";
  		echo "<input isparam=1 type='hidden' value='" . $this->data . "' name='" . $this->name . "'>";
  	  echo "<div class='wpdreamsOnOffInner'></div>";
      echo "<div class='triggerer'></div>";  
      echo "</div>";
  	} 
  }
}
?>
<?php
if (!class_exists("wpdreamsInfo")) {
  class wpdreamsInfo extends wpdreamsType {
  	function __construct($data) {
  		$this->data = $data;
  		$this->getType();
  	}
  	function getType() {
  		echo "<img style='display:none;' class='infoimage' src='" . plugins_url('../types/icons/info.png', __FILE__) . "' title='" . $this->data . "' />";
  	}
  }
}
?>
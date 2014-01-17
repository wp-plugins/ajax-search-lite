<?php
if (!class_exists("wpdreamsThemeChooser")) {
  class wpdreamsThemeChooser extends wpdreamsType {
  	function getType() {
      parent::getType();
      echo "
      <div class='wpdreamsThemeChooser'>
       <fieldset style='background:#eee'>
       <label style='color:#333' for='wpdreamsThemeChooser_'" . self::$_instancenumber . "'>" . $this->label . "</label>";
      $decodedData = json_decode($this->data);
      echo "<select id='wpdreamsThemeChooser_" . self::$_instancenumber . "'>
          <option value=''>Select</option>";
      foreach ($decodedData as $name=>$theme) {
        echo "<option value='".$name."'>".$name."</option>";
      }
      echo "</select>";
      foreach ($decodedData as $name=>$theme) {
         echo "<div name='".$name."' style='display:none;'>";
         foreach ($theme as $pname=>$param) {
           echo "<p paramname='".$pname."'>".$param."</p>";
         }
         echo "</div>";
      }
      echo "
      <span></span></fieldset>
      </div>";
  	}
  }
}
?>
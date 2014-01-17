<?php
if (!class_exists("wpdreamsType")) {
  class wpdreamsType {
  	protected static $_instancenumber = 0;             
  	protected static $_errors = 0;
  	protected static $_globalerrormsg = "Only integer values are accepted!";
    protected $data;
  	function __construct($name, $label, $data, $constraints = null, $errormsg = "") {
  		$this->name        = $name;
  		$this->label       = $label;
  		$this->constraints = $constraints;
  		$this->errormsg    = $errormsg;
      $this->defaultData = $data; // Perserving constructor default data after posting
  		$this->data        = $data;
      $this->args        = $args;
  		$this->isError     = false;
  		self::$_instancenumber++;
  		$this->getType();
  	}
  	function getData() {
  		return $this->data;
  	}
  	final function getName() {
  		return $this->name;
  	}
  	final function getError() {
  		return $this->isError;
  	}
  	final function getErrorMsg() {
  		return $this->errormsg;
  	}
  	final function setError($error, $errormsg = "") {
  		if ($errormsg != "")
  			$this->errormsg = $errormsg;
  		if ($error) {
  			self::$_errors++;
  			$this->isError = true;
  		}
  	}
  	protected final function checkData() {
  		$this->newData = $_POST[$this->name];
  		if (is_array($this->constraints)) {
  			foreach ($this->constraints as $key => $val) {
  				if ($this->constraints[$key]['op'] == "eq") {
  					if ($val['func']($this->newData) == $this->constraints[$key]['val']) {
  						;
  					} else {
  						$this->setError(true);
  						return false;
  					}
  				} else if ($this->constraints[$key]['op'] == "ge") {
  					if ($val['func']($this->newData) >= $this->constraints[$key]['val']) {
  						;
  					} else {
  						$this->setError(true);
  						return false;
  					}
  				} else {
  					if ($val['func']($this->newData) < $this->constraints[$key]['val']) {
  						;
  					} else {
  						$this->setError(true);
  						return false;
  					}
  				}
  			}
  		}
      
  		return true;
  	}
  	protected function getType() {
  		if (isset($_POST[$this->name])) {
  			if (!$this->checkData() || $this->getError()) {
  				/*errormessage*/
  				echo "<div class='errorMsg'>" . (($this->errormsg != "") ? $this->errormsg : self::$_globalerrormsg) . "</div>";
  			} else {
          if (is_array($this->data) && isset($this->data['value'])) {
            $this->data['value'] = $_POST[$this->name];
          } else {
      		  $this->data = $_POST[$this->name];
          }
  			}
  		}
  	}
  	static function getErrorNum() {
  		return self::$_errors;
  	}
  }
}
?>
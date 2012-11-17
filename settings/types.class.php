<?php
if (!class_exists("wpdreamsType")) {
  class wpdreamsType {
  	protected static $_instancenumber = 0;
  	protected static $_errors = 0;
  	protected static $_globalerrormsg = "Only integer values are accepted!";
  	function __construct($name, $label, $data, $constraints = null, $errormsg = "") {
  		$this->name        = $name;
  		$this->label       = $label;
  		$this->constraints = $constraints;
  		$this->errormsg    = $errormsg;
  		$this->data        = $data;
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
  		$this->data = $this->newData;
  		return true;
  	}
  	protected function getType() {
  		if (isset($_POST[$this->name])) {
  			if (!$this->checkData() || $this->getError()) {
  				/*errormessage*/
  				echo "<div class='errorMsg'>" . (($this->errormsg != "") ? $this->errormsg : self::$_globalerrormsg) . "</div>";
  			} else {
  				$this->data = $_POST[$this->name];
  			}
  		}
  	}
  	static function getErrorNum() {
  		return self::$_errors;
  	}
  }
}

if (!class_exists("wpdreamsHidden")) {
  class wpdreamsHidden extends wpdreamsType {
  	function getType() {
  		echo "<input type='hidden' id='wpdreamshidden_" . self::$_instancenumber . "' name='" . $this->name . "' value='" . $this->data . "' />";
  	}
  }
}

if (!class_exists("wpdreamsInfo")) {
  class wpdreamsInfo extends wpdreamsType {
  	function __construct($data) {
  		$this->data = $data;
  		$this->getType();
  	}
  	function getType() {
  		echo "<img class='infoimage' src='" . plugins_url('/types/icons/info.png', __FILE__) . "' title='" . $this->data . "' />";
  	}
  }
}

if (!class_exists("wpdreamsText")) {
  class wpdreamsText extends wpdreamsType {
  	function getType() {
  		parent::getType();
      echo "<div class='wpdreamsText'>";
  		if ($this->label != "")
  			echo "<label for='wpdreamstext_" . self::$_instancenumber . "'>" . $this->label . "</label>";
  		echo "<input type='text' id='wpdreamstext_" . self::$_instancenumber . "' name='" . $this->name . "' value='" . $this->data . "' />";
      echo "
        <div class='triggerer'></div>
      </div>";
  	}
  }
}

if (!class_exists("wpdreamsTextSmall")) {
  class wpdreamsTextSmall extends wpdreamsType {
  	function getType() {
  		parent::getType();
      echo "<div class='wpdreamsTextSmall'>";
  		if ($this->label != "")
  			echo "<label for='wpdreamstextsmall_" . self::$_instancenumber . "'>" . $this->label . "</label>";
  		echo "<input class='small' type='text' id='wpdreamstextsmall_" . self::$_instancenumber . "' name='" . $this->name . "' value='" . $this->data . "' />";
      echo "
        <div class='triggerer'></div>
      </div>";
  	}
  }
}

if (!class_exists("wpdreamsTextarea")) {
  class wpdreamsTextarea extends wpdreamsType {
  	function getType() {
  		parent::getType();
  		echo "<label style='vertical-align: top;' for='wpdreamstextarea_" . self::$_instancenumber . "'>" . $this->label . "</label>";
  		echo "<textarea id='wpdreamstextarea_" . self::$_instancenumber . "' name='" . $this->name . "'>" . stripcslashes($this->data) . "</textarea>";
  	}
  } 
}

if (!class_exists("wpdreamsUpload")) {
  class wpdreamsUpload extends wpdreamsType {
  	function getType() {
  		parent::getType();
  		echo "<div>";
  		if ($this->data != "") {
  			echo "<img class='preview' rel='#overlay_" . self::$_instancenumber . "' src=" . $this->data . " />";
  		} else {
  			echo "<img class='preview' style='display:none;'  rel='#overlay_" . self::$_instancenumber . "' />";
  		}
  		echo "<label for='wpdreamsUpload_" . self::$_instancenumber . "'>" . $this->label . "</label>";
  		echo "<input type='text' class='wpdreamsUpload' id='wpdreamsUpload_" . self::$_instancenumber . "' name='" . $this->name . "' value='" . $this->data . "' />";
  		echo "<input class='wpdreamsUpload_button'type='button' value='Upload Image' />";
  		echo "<br />Enter an URL or upload an image!";
  		echo "<div class='overlay' id='overlay_" . self::$_instancenumber . "'><img src=" . $this->data . " /></div>";
  		echo "</div>";
  	}
  }
}

if (!class_exists("wpdreamsLabelPosition")) {
  class wpdreamsLabelPosition extends wpdreamsType {
  	function __construct($name, $label, $width, $height, $data) {
  		$this->constraints = null;
  		$this->name        = $name;
  		$this->label       = $label;
  		$this->data        = $data;
  		$this->width       = $width;
  		$this->height      = $height;
  		$this->ratio       = 400 / $this->width;
  		$this->cheight     = $this->ratio * $this->height;
  		self::$_instancenumber++;
  		$this->direction = "";
  		$this->duration  = "";
  		$this->getType();
  	}
  	function getType() {
  		parent::getType();
  		$this->processData();
  		$inst = self::$_instancenumber;
  		echo "
        <div class='labeldrag' id='labeldrag_" . $inst . "' style='height:" . ($this->cheight + 90) . "px;'>
           <div class='inner' style='overflow:auto;width:400px;height:" . $this->cheight . "px;'>
              <script>
                jQuery(document).ready(function() { 
                  var drag = jQuery('#" . $this->name . "_" . $inst . "').draggable({ containment: 'parent', refreshPositions: true, appendTo: 'body' });
                  jQuery('#" . $this->name . "_" . $inst . "').bind( 'dragstop', function(event, ui) {
                      var pos = drag.position();
                      var ratio = " . $this->ratio . ";
                      var hidden = jQuery('#labelposition_hidden_" . $inst . "');
                      var duration = jQuery('input[name=\"induration_" . $this->name . "\"]')[0];
                      var direction= jQuery('input[name=\"indirection_" . $this->name . "\"]').prev();
                      jQuery(hidden).val('duration:'+jQuery(duration).val()+';direction:'+jQuery(direction).val()+';position:'+((pos.top+5)/ratio)+'||'+((pos.left+5)/ratio)+';');
                  });
                  jQuery('#labeldrag_" . $inst . " input').keyup(function(){
                     jQuery('#" . $this->name . "_" . $inst . "').trigger('dragstop');
                  });
                  jQuery('#labeldrag_" . $inst . " select').change(function(){
                     jQuery('#" . $this->name . "_" . $inst . "').trigger('dragstop');
                  });                 
                });
              </script>
              <div class='dragme' style='top:" . (($this->top * $this->ratio) - 5) . "px;left:" . (($this->left * $this->ratio) - 5) . "px;' id='" . $this->name . "_" . $inst . "'>
              </div>
           </div>
      ";
  		echo "<div style='margin-top:" . ($this->cheight + 10) . "px;'>";
  		new wpdreamsSelect("indirection_" . $this->name, "Animation direction", $this->_direction);
  		new wpdreamsText("induration_" . $this->name, "Animation duration (ms)", $this->duration);
  		echo "</div>";
  		echo "
        </div>
        <div style='clear:both'></div>
        <input type='hidden' id='labelposition_hidden_" . $inst . "' name='" . $this->name . "' value='" . $this->data . "' />
      ";
  		echo "
      
      ";
  	}
  	function processData() {
  		// string: 'duration:123;direction:bottom-left;position:123||321;'
  		$this->data = str_replace("\n", "", $this->data);
  		preg_match("/duration:(.*?);/", $this->data, $matches);
  		$this->duration = $matches[1];
  		if ($this->duration == "")
  			$this->duration = 500;
  		preg_match("/direction:(.*?);/", $this->data, $matches);
  		$this->direction = $matches[1];
  		if ($this->direction == "")
  			$this->direction = "top-left";
  		$this->_direction = "
        Top|top;
        Bottom|bottom;
        Left|left;
        Right|right;
        Bottom-Left|bottom-left;
        Bottom-Right|bottom-right;
        Top-Left|top-left;
        Top-Right|top-right;
        Random|random|| 
      " . $this->direction;
  		preg_match("/position:(.*?);/", $this->data, $matches);
  		$this->position = $matches[1];
  		$_temp          = explode("||", $this->position);
  		$this->top      = $_temp[0];
  		$this->left     = $_temp[1];
  	}
  }
}

if (!class_exists("wpdreamsImageParser")) {
  class wpdreamsImageParser extends wpdreamsType {
  	function __construct($name, $label, $uid, $callback) {
  		$this->name     = $name;
  		$this->uid      = $uid;
  		$this->label    = $label;
  		$this->callback = $callback;
  		$this->isError  = false;
  		self::$_instancenumber++;
  		$this->getType();
  	}
  	function getType() {
  		echo "<form name='" . $this->name . "' class='wpdreams-ajaxinput' style='height:40px;margin-left: -535px;'>";
  		//echo "<label for='wpdreamsAjaxInput_".self::$_instancenumber."'>".$this->label."</label>";
  		echo "<input type='hidden' name='callback' value='" . $this->callback . "' />";
  		echo "<input type='hidden' name='uid' value='" . $this->uid . "' />";
  		echo "<input type='text' id='wpdreamsAjaxInput_" . self::$_instancenumber . "' name='url' value='Enter the feed url here...' />";
  		echo "
      <select style='width: 70px;' name='itemsnum'>
           <option value='1'>1</option>
           <option value='2'>2</option>
           <option value='3'>3</option>
           <option value='4'>4</option>
           <option value='5'>5</option>
           <option value='6'>6</option>
           <option value='7'>7</option>
           <option value='8'>8</option>
           <option value='9'>9</option>
           <option value='10'>10</option>
      </select>";
  		echo "<select  style='width: 130px;' name='itemsnum'>";
  		echo "
              <option value='flickr'>Source</option>
              <option value='flickr'>Flickr.com</option>
              <option value='500px'>500px.com</option>
      ";
  		echo "</select>";
  		echo "<input type='button' class='default' value='Generate!'/>";
  		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $this->label . "<img opened='0' style='cursor:pointer;vertical-align:middle;height:20px;' src='" . plugins_url('/types/icons/arrow-right.png', __FILE__) . "' />";
  		echo "</form>";
  	}
  }
}

if (!class_exists("wpdreamsUploadReset")) {
  class wpdreamsUploadReset extends wpdreamsType {
  	function __construct($name, $label, $data, $default_data, $constraints = null, $errormsg = "") {
  		$this->name         = $name;
  		$this->label        = $label;
  		$this->constraints  = $constraints;
  		$this->errormsg     = $errormsg;
  		$this->data         = $data;
  		$this->default_data = $default_data;
  		$this->isError      = false;
  		self::$_instancenumber++;
  		$this->getType();
  	}
  	function getType() {
  		parent::getType();
  		echo "<div>";
  		if ($this->data != "") {
  			echo "<img class='preview' rel='#overlay_" . self::$_instancenumber . "' src=" . $this->data . " />";
  		} else {
  			echo "<img class='preview' style='display:none;' rel='#overlay_" . self::$_instancenumber . "' />";
  		}
  		echo "<label for='wpdreamsUploadReset_" . self::$_instancenumber . "'>" . $this->label . "</label>";
  		echo "<input type='text' class='wpdreamsUpload' id='wpdreamsUploadReset_" . self::$_instancenumber . "' name='" . $this->name . "' value='" . $this->data . "' />";
  		echo "<input class='wpdreamsUpload_button' type='button' value='Upload Image' />";
  		echo "<input type='button' class='default' name='default' value='Default' />";
  		echo "<input type='hidden' value='" . $this->default_data . "' />";
  		echo "<br />Enter an URL or upload an image!";
  		echo "<div class='overlay' id='overlay_" . self::$_instancenumber . "'><img src='" . $this->data . "'' /></div>";
  		echo "</div>";
  	}
  }
}

if (!class_exists("wpdreamsSelect")) {
  class wpdreamsSelect extends wpdreamsType {
  	function getType() {
  		parent::getType();
  		$this->processData();
      echo "<div class='wpdreamsSelect'>";
  		echo "<label for='wpdreamsselect_" . self::$_instancenumber . "'>" . $this->label . "</label>";
  		echo "<select class='wpdreamsselect' id='wpdreamsselect_" . self::$_instancenumber . "' name='" . $this->name . "_select'>";
  		foreach ($this->selects as $sel) {
  			preg_match('/(?<option>.*?)\\|(?<value>.*)/', $sel, $matches);
  			$matches['value']  = trim($matches['value']);
  			$matches['option'] = trim($matches['option']);
  			if ($matches['value'] == $this->selected)
  				echo "<option value='" . $matches['value'] . "' selected='selected'>" . $matches['option'] . "</option>";
  			else
  				echo "<option value='" . $matches['value'] . "'>" . $matches['option'] . "</option>";
  		}
  		echo "</select>";
  		echo "<input type='hidden' value='" . $this->data . "' name='" . $this->name . "'>";
      echo "<div class='triggerer'></div>
      </div>";
  	}
  	function processData() {
  		//$this->data = str_replace("\n","",$this->data); 
  		$_temp          = explode("||", $this->data);
  		$this->selects  = explode(";", $_temp[0]);
  		$this->selected = trim($_temp[1]);
  	}
  	final function getData() {
  		return $this->data;
  	}
  	final function getSelected() {
  		return $this->selected;
  	}
  }
}

if (!class_exists("wpdreamsLanguageSelect")) {
  class wpdreamsLanguageSelect extends wpdreamsType {

  	function getType() {
  		parent::getType();
   $this->languages = array(
        'ab' => 'Abkhazian',
        'aa' => 'Afar',
        'af' => 'Afrikaans',
        'ak' => 'Akan',
        'sq' => 'Albanian',
        'am' => 'Amharic',
        'ar' => 'Arabic',
        'an' => 'Aragonese',
        'hy' => 'Armenian',
        'as' => 'Assamese',
        'av' => 'Avaric',
        'ae' => 'Avestan',
        'ay' => 'Aymara',
        'az' => 'Azerbaijani',
        'bm' => 'Bambara',
        'ba' => 'Bashkir',
        'eu' => 'Basque',
        'be' => 'Belarusian',
        'bn' => 'Bengali',
        'bh' => 'Bihari',
        'bi' => 'Bislama',
        'nb' => 'Bokmal',
        'bs' => 'Bosnian',
        'br' => 'Breton',
        'bg' => 'Bulgarian',
        'my' => 'Burmese',
        'ca' => 'Catalan',
        'km' => 'Central Khmer',
        'ch' => 'Chamorro',
        'ce' => 'Chechen',
        'ny' => 'Chewa',
        'zh' => 'Chinese',
        'cu' => 'Church Slavic',
        'cv' => 'Chuvash',
        'kw' => 'Cornish',
        'co' => 'Corsican',
        'cr' => 'Cree',
        'hr' => 'Croatian',
        'cs' => 'Czech',
        'da' => 'Danish',
        'dv' => 'Dhivehi',
        'nl' => 'Dutch',
        'dz' => 'Dzongkha',
        'en' => 'English',
        'eo' => 'Esperanto',
        'et' => 'Estonian',
        'ee' => 'Ewe',
        'fo' => 'Faroese',
        'fj' => 'Fijian',
        'fi' => 'Finnish',
        'fr' => 'French',
        'ff' => 'Fulah',
        'gd' => 'Gaelic',
        'gl' => 'Galician',
        'lg' => 'Ganda',
        'ka' => 'Georgian',
        'de' => 'German',
        'ki' => 'Gikuyu',
        'el' => 'Greek',
        'kl' => 'Greenlandic',
        'gn' => 'Guarani',
        'gu' => 'Gujarati',
        'ht' => 'Haitian',
        'ha' => 'Hausa',
        'he' => 'Hebrew',
        'hz' => 'Herero',
        'hi' => 'Hindi',
        'ho' => 'Hiri Motu',
        'hu' => 'Hungarian',
        'is' => 'Icelandic',
        'io' => 'Ido',
        'ig' => 'Igbo',
        'id' => 'Indonesian',
        'ia' => 'Interlingua',
        'iu' => 'Inuktitut',
        'ik' => 'Inupiaq',
        'ga' => 'Irish',
        'it' => 'Italian',
        'ja' => 'Japanese',
        'jv' => 'Javanese',
        'kn' => 'Kannada',
        'kr' => 'Kanuri',
        'ks' => 'Kashmiri',
        'kk' => 'Kazakh',
        'rw' => 'Kinyarwanda',
        'kv' => 'Komi',
        'kg' => 'Kongo',
        'ko' => 'Korean',
        'ku' => 'Kurdish',
        'kj' => 'Kwanyama',
        'ky' => 'Kyrgyz',
        'lo' => 'Lao',
        'la' => 'Latin',
        'lv' => 'Latvian',
        'lb' => 'Letzeburgesch',
        'li' => 'Limburgan',
        'ln' => 'Lingala',
        'lt' => 'Lithuanian',
        'lu' => 'Luba-Katanga',
        'mk' => 'Macedonian',
        'mg' => 'Malagasy',
        'ms' => 'Malay',
        'ml' => 'Malayalam',
        'mt' => 'Maltese',
        'gv' => 'Manx',
        'mi' => 'Maori',
        'mr' => 'Marathi',
        'mh' => 'Marshallese',
        'ro' => 'Moldavian',
        'mn' => 'Mongolian',
        'na' => 'Nauru',
        'nv' => 'Navajo',
        'ng' => 'Ndonga',
        'ne' => 'Nepali',
        'nd' => 'North Ndebele',
        'se' => 'Northern Sami',
        'no' => 'Norwegian',
        'nn' => 'Norwegian Nynorsk',
        'ie' => 'Occidental',
        'oc' => 'Occitan',
        'oj' => 'Ojibwa',
        'or' => 'Oriya',
        'om' => 'Oromo',
        'os' => 'Ossetian',
        'pi' => 'Pali',
        'fa' => 'Persian',
        'pl' => 'Polish',
        'pt' => 'Portuguese',
        'pa' => 'Punjabi',
        'ps' => 'Pushto',
        'qu' => 'Quechua',
        'ro' => 'Romanian',
        'rm' => 'Romansh',
        'rn' => 'Rundi',
        'ru' => 'Russian',
        'sm' => 'Samoan',
        'sg' => 'Sango',
        'sa' => 'Sanskrit',
        'sc' => 'Sardinian',
        'sr' => 'Serbian',
        'sn' => 'Shona',
        'ii' => 'Sichuan Yi',
        'sd' => 'Sindhi',
        'si' => 'Sinhalese',
        'sk' => 'Slovak',
        'sl' => 'Slovenian',
        'so' => 'Somali',
        'st' => 'Southern Sotho',
        'nr' => 'South Ndebele',
        'es' => 'Spanish',
        'su' => 'Sundanese',
        'sw' => 'Swahili',
        'ss' => 'Swati',
        'sv' => 'Swedish',
        'tl' => 'Tagalog',
        'ty' => 'Tahitian',
        'tg' => 'Tajik',
        'ta' => 'Tamil',
        'tt' => 'Tatar',
        'te' => 'Telugu',
        'th' => 'Thai',
        'bo' => 'Tibetan',
        'ti' => 'Tigrinya',
        'to' => 'Tonga',
        'ts' => 'Tsonga',
        'tn' => 'Tswana',
        'tr' => 'Turkish',
        'tk' => 'Turkmen',
        'tw' => 'Twi',
        'uk' => 'Ukrainian',
        'ur' => 'Urdu',
        'ug' => 'Uyghur',
        'uz' => 'Uzbek',
        've' => 'Venda',
        'vi' => 'Vietnamese',
        'vo' => 'VolapA1k',
        'wa' => 'Walloon',
        'cy' => 'Welsh',
        'fy' => 'Western Frisian',
        'wo' => 'Wolof',
        'xh' => 'Xhosa',
        'yi' => 'Yiddish',
        'yo' => 'Yoruba',
        'za' => 'Zhuang',
        'zu' => 'Zulu'
    ); 
      echo "<div class='wpdreamsLanguageSelect'>";
  		echo "<label for='wpdreamslanguageselect_" . self::$_instancenumber . "'>" . $this->label . "</label>";
  		echo "<select class='wpdreamsselect' id='wpdreamsselect_" . self::$_instancenumber . "' name='" . $this->name . "_select'>";
  		foreach ($this->languages as $k=>$v) {
  			if ($k == $this->data)
  				echo "<option value='" . $k . "' selected='selected'>" . $v . "</option>";
  			else
  				echo "<option value='" . $k . "'>" . $v . "</option>";
  		}
  		echo "</select>";
  		echo "<input type='hidden' value='" . $this->data . "' name='" . $this->name . "'>";
      echo "<div class='triggerer'></div>
      </div>";
  	}
  	final function getData() {
  		return $this->data;
  	}
  }
}




if (!class_exists("wpdreamsFont")) {
  class wpdreamsFont extends wpdreamsType {
  	function getType() {
  		parent::getType();
  		wp_register_script('wpdreams-fonts', plugin_dir_url(__FILE__) . '/types/fonts.js', array(
  			'jquery',
  			'media-upload',
  			'thickbox'
  		));
  		wp_enqueue_script('wpdreams-fonts');
      $this->data = str_replace('\\', "", stripcslashes($this->data));
  		preg_match("/family:(.*?);/", $this->data, $_fonts);
  		$this->font = $_fonts[1];
  		preg_match("/weight:(.*?);/", $this->data, $_weight);
  		$this->weight = $_weight[1];
  		preg_match("/color:(.*?);/", $this->data, $_color);
  		$this->color = $_color[1];
  		preg_match("/size:(.*?);/", $this->data, $_size);
  		$this->size    = $_size[1];
  		preg_match("/height:(.*?);/", $this->data, $_lineheight);
  		$this->lineheight    = $_lineheight[1];
  		$applied_style = "font-family:" . ($this->font) . ";font-weight:" . $this->weight . ";line-height:".$this->lineheight.";color:" . $this->color;
  		echo $this->getScript();
  		echo "<div class='wpdreamsFont'>
        <fieldset>
        <legend>" . $this->label . "</legend>
      ";
      echo "<label for='wpdreamsfont_" . self::$_instancenumber . "' style=\"" . $applied_style . "\">Test Text :)</label>";
  		echo "<select class='wpdreamsfont' id='wpdreamsfont_" . self::$_instancenumber . "' name='" . self::$_instancenumber . "_select'>";
  		$options = '
        <option disabled>-------Classic Webfonts-------</option>
        <option value="\'Arial\', Helvetica, sans-serif" style="font-family:Arial, Helvetica, sans-serif">Arial, Helvetica, sans-serif</option>
        <option value="\'Arial Black\', Gadget, sans-serif" style="font-family:\'Arial Black\', Gadget, sans-serif">"Arial Black", Gadget, sans-serif</option>
        <option value="\'Comic Sans MS\', cursive" style="font-family:\'Comic Sans MS\', cursive">"Comic Sans MS", cursive</option>
        <option value="\'Courier New\', Courier, monospace" style="font-family:\'Courier New\', Courier, monospace">"Courier New", Courier, monospace</option>
        <option value="\'Georgia\', serif" style="font-family:Georgia, serif">Georgia, serif</option>
        <option value="\'Impact\', Charcoal, sans-serif" style="font-family:Impact, Charcoal, sans-serif">Impact, Charcoal, sans-serif</option>
        <option value="\'Lucida Console\', Monaco, monospace" style="font-family:\'Lucida Console\', Monaco, monospace">"Lucida Console", Monaco, monospace</option>
        <option value="\'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif" style="font-family:\'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif">"Lucida Sans Unicode", "Lucida Grande", sans-serif</option>
        <option value="\'Palatino Linotype\', \'Book Antiqua\', Palatino, serif" style="font-family:\'Palatino Linotype\', \'Book Antiqua\', Palatino, serif">"Palatino Linotype", "Book Antiqua", Palatino, serif</option>
        <option value="\'Tahoma\', Geneva, sans-serif" style="font-family:Tahoma, Geneva, sans-serif">Tahoma, Geneva, sans-serif</option>
        <option value="\'Times New Roman\', Times, serif" style="font-family:\'Times New Roman\', Times, serif">"Times New Roman", Times, serif</option>
        <option value="\'Trebuchet MS\', Helvetica, sans-serif" style="font-family:\'Trebuchet MS\', Helvetica, sans-serif">"Trebuchet MS", Helvetica, sans-serif</option>
        <option value="\'Verdana\', Geneva, sans-serif" style="font-family:Verdana, Geneva, sans-serif">Verdana, Geneva, sans-serif</option>
        <option value="\'Symbol\'" style="font-family:Symbol">Symbol</option>
        <option value="\'Webdings\'" style="font-family:Webdings">Webdings</option>
        <option value="\'Wingdings\', \'Zapf Dingbats\'" style="font-family:Wingdings, \'Zapf Dingbats\'">Wingdings, "Zapf Dingbats"</option>
        <option value="\'MS Sans Serif\', Geneva, sans-serif" style="font-family:\'MS Sans Serif\', Geneva, sans-serif">"MS Sans Serif", Geneva, sans-serif</option>
        <option value="\'MS Serif\', \'New York\', serif" style="font-family:\'MS Serif\', \'New York\', serif">"MS Serif", "New York", serif</option>
        <option disabled>-------Google Webfonts-------</option>
        <option  value="Allan" style="font-family: Allan,Allan;"> Allan</option>
        <option  value="Allerta" style="font-family: Allerta,Allerta;"> Allerta</option>
        <option  value="Allerta Stencil" style="font-family: Allerta Stencil,Allerta Stencil;"> Allerta Stencil</option>
        <option  value="Anonymous Pro" style="font-family: Anonymous Pro,Anonymous Pro;"> Anonymous Pro</option>
        <option  value="Arimo" style="font-family: Arimo,Arimo;"> Arimo</option>
        <option  value="Arvo" style="font-family: Arvo,Arvo;"> Arvo</option>
        <option  value="Bentham" style="font-family: Bentham,Bentham;"> Bentham</option>
        <option  value="Buda" style="font-family: Buda,Buda;"> Buda</option>
        <option  value="Cabin" style="font-family: Cabin,Cabin;"> Cabin</option>
        <option  value="Calligraffitti" style="font-family: Calligraffitti,Calligraffitti;"> Calligraffitti</option>
        <option  value="Cantarell" style="font-family: Cantarell,Cantarell;"> Cantarell</option>
        <option  value="Cardo" style="font-family: Cardo,Cardo;"> Cardo</option>
        <option  value="Cherry Cream Soda" style="font-family: Cherry Cream Soda,Cherry Cream Soda;"> Cherry Cream Soda</option>
        <option  value="Chewy" style="font-family: Chewy,Chewy;"> Chewy</option>
        <option  value="Coda" style="font-family: Coda,Coda;"> Coda</option>
        <option  value="Coming Soon" style="font-family: Coming Soon,Coming Soon;"> Coming Soon</option>
        <option  value="Copse" style="font-family: Copse,Copse;"> Copse</option>
        <option  value="Corben" style="font-family: Corben,Corben;"> Corben</option>
        <option  value="Cousine" style="font-family: Cousine,Cousine;"> Cousine</option>
        <option  value="Covered By Your Grace" style="font-family: Covered By Your Grace,Covered By Your Grace;"> Covered By Your Grace</option>
        <option  value="Crafty Girls" style="font-family: Crafty Girls,Crafty Girls;"> Crafty Girls</option>
        <option  value="Crimson Text" style="font-family: Crimson Text,Crimson Text;"> Crimson Text</option>
        <option  value="Crushed" style="font-family: Crushed,Crushed;"> Crushed</option>
        <option  value="Cuprum" style="font-family: Cuprum,Cuprum;"> Cuprum</option>
        <option  value="Droid Sans" style="font-family: Droid Sans,Droid Sans;"> Droid Sans</option>
        <option  value="Droid Sans Mono" style="font-family: Droid Sans Mono,Droid Sans Mono;"> Droid Sans Mono</option>
        <option  value="Droid Serif" style="font-family: Droid Serif,Droid Serif;"> Droid Serif</option>
        <option  value="Fontdiner Swanky" style="font-family: Fontdiner Swanky,Fontdiner Swanky;"> Fontdiner Swanky</option>
        <option  value="GFS Didot" style="font-family: GFS Didot,GFS Didot;"> GFS Didot</option>
        <option  value="GFS Neohellenic" style="font-family: GFS Neohellenic,GFS Neohellenic;"> GFS Neohellenic</option>
        <option  value="Geo" style="font-family: Geo,Geo;"> Geo</option>
        <option  value="Gruppo" style="font-family: Gruppo,Gruppo;"> Gruppo</option>
        <option  value="Hanuman" style="font-family: Hanuman,Hanuman;"> Hanuman</option>
        <option  value="Homemade Apple" style="font-family: Homemade Apple,Homemade Apple;"> Homemade Apple</option>
        <option  value="IM Fell DW Pica" style="font-family: IM Fell DW Pica,IM Fell DW Pica;"> IM Fell DW Pica</option>
        <option  value="IM Fell DW Pica SC" style="font-family: IM Fell DW Pica SC,IM Fell DW Pica SC;"> IM Fell DW Pica SC</option>
        <option  value="IM Fell Double Pica" style="font-family: IM Fell Double Pica,IM Fell Double Pica;"> IM Fell Double Pica</option>
        <option  value="IM Fell Double Pica SC" style="font-family: IM Fell Double Pica SC,IM Fell Double Pica SC;"> IM Fell Double Pica SC</option>
        <option  value="IM Fell English" style="font-family: IM Fell English,IM Fell English;"> IM Fell English</option>
        <option  value="IM Fell English SC" style="font-family: IM Fell English SC,IM Fell English SC;"> IM Fell English SC</option>
        <option  value="IM Fell French Canon" style="font-family: IM Fell French Canon,IM Fell French Canon;"> IM Fell French Canon</option>
        <option  value="IM Fell French Canon SC" style="font-family: IM Fell French Canon SC,IM Fell French Canon SC;"> IM Fell French Canon SC</option>
        <option  value="IM Fell Great Primer" style="font-family: IM Fell Great Primer,IM Fell Great Primer;"> IM Fell Great Primer</option>
        <option  value="IM Fell Great Primer SC" style="font-family: IM Fell Great Primer SC,IM Fell Great Primer SC;"> IM Fell Great Primer SC</option>
        <option  value="Inconsolata" style="font-family: Inconsolata,Inconsolata;"> Inconsolata</option>
        <option  value="Irish Growler" style="font-family: Irish Growler,Irish Growler;"> Irish Growler</option>
        <option  value="Josefin Sans" style="font-family: Josefin Sans,Josefin Sans;"> Josefin Sans</option>
        <option  value="Josefin Slab" style="font-family: Josefin Slab,Josefin Slab;"> Josefin Slab</option>
        <option  value="Just Another Hand" style="font-family: Just Another Hand,Just Another Hand;"> Just Another Hand</option>
        <option  value="Just Me Again Down Here" style="font-family: Just Me Again Down Here,Just Me Again Down Here;"> Just Me Again Down Here</option>
        <option  value="Kenia" style="font-family: Kenia,Kenia;"> Kenia</option>
        <option  value="Kranky" style="font-family: Kranky,Kranky;"> Kranky</option>
        <option  value="Kristi" style="font-family: Kristi,Kristi;"> Kristi</option>
        <option  value="Lato" style="font-family: Lato,Lato;"> Lato</option>
        <option  value="Lekton" style="font-family: Lekton,Lekton;"> Lekton</option>
        <option  value="Lobster" style="font-family: Lobster,Lobster;"> Lobster</option>
        <option  value="Luckiest Guy" style="font-family: Luckiest Guy,Luckiest Guy;"> Luckiest Guy</option>
        <option  value="Merriweather" style="font-family: Merriweather,Merriweather;"> Merriweather</option>
        <option  value="Molengo" style="font-family: Molengo,Molengo;"> Molengo</option>
        <option  value="Mountains of Christmas" style="font-family: Mountains of Christmas,Mountains of Christmas;"> Mountains of Christmas</option>
        <option  value="Neucha" style="font-family: Neucha,Neucha;"> Neucha</option>
        <option  value="Neuton" style="font-family: Neuton,Neuton;"> Neuton</option>
        <option  value="Nobile" style="font-family: Nobile,Nobile;"> Nobile</option>
        <option  value="OFL Sorts Mill Goudy TT" style="font-family: OFL Sorts Mill Goudy TT,OFL Sorts Mill Goudy TT;"> OFL Sorts Mill Goudy TT</option>
        <option  value="Old Standard TT" style="font-family: Old Standard TT,Old Standard TT;"> Old Standard TT</option>
        <option  value="Orbitron" style="font-family: Orbitron,Orbitron;"> Orbitron</option>
        <option  value="PT Sans" style="font-family: PT Sans,PT Sans;"> PT Sans</option>
        <option  value="PT Sans Caption" style="font-family: PT Sans Caption,PT Sans Caption;"> PT Sans Caption</option>
        <option  value="PT Sans Narrow" style="font-family: PT Sans Narrow,PT Sans Narrow;"> PT Sans Narrow</option>
        <option  value="Permanent Marker" style="font-family: Permanent Marker,Permanent Marker;"> Permanent Marker</option>
        <option  value="Philosopher" style="font-family: Philosopher,Philosopher;"> Philosopher</option>
        <option  value="Puritan" style="font-family: Puritan,Puritan;"> Puritan</option>
        <option  value="Raleway" style="font-family: Raleway,Raleway;"> Raleway</option>
        <option  value="Reenie Beanie" style="font-family: Reenie Beanie,Reenie Beanie;"> Reenie Beanie</option>
        <option  value="Rock Salt" style="font-family: Rock Salt,Rock Salt;"> Rock Salt</option>
        <option  value="Schoolbell" style="font-family: Schoolbell,Schoolbell;"> Schoolbell</option>
        <option  value="Slackey" style="font-family: Slackey,Slackey;"> Slackey</option>
        <option  value="Sniglet" style="font-family: Sniglet,Sniglet;"> Sniglet</option>
        <option  value="Sunshiney" style="font-family: Sunshiney,Sunshiney;"> Sunshiney</option>
        <option  value="Syncopate" style="font-family: Syncopate,Syncopate;"> Syncopate</option>
        <option  value="Tangerine" style="font-family: Tangerine,Tangerine;"> Tangerine</option>
        <option  value="Tinos" style="font-family: Tinos,Tinos;"> Tinos</option>
        <option  value="Ubuntu" style="font-family: Ubuntu,Ubuntu;"> Ubuntu</option>
        <option  value="UnifrakturCook" style="font-family: UnifrakturCook,UnifrakturCook;"> UnifrakturCook</option>
        <option  value="UnifrakturMaguntia" style="font-family: UnifrakturMaguntia,UnifrakturMaguntia;"> UnifrakturMaguntia</option>
        <option  value="Unkempt" style="font-family: Unkempt,Unkempt;"> Unkempt</option>
        <option  value="Vibur" style="font-family: Vibur,Vibur;"> Vibur</option>
        <option  value="Vollkorn" style="font-family: Vollkorn,Vollkorn;"> Vollkorn</option>
        <option  value="Walter Turncoat" style="font-family: Walter Turncoat,Walter Turncoat;"> Walter Turncoat</option>
        <option  value="Yanone Kaffeesatz" style="font-family: Yanone Kaffeesatz,Yanone Kaffeesatz;"> Yanone Kaffeesatz</option> 
      ';
  		$options = explode("<option", $options);
  		unset($options[0]);
  		foreach ($options as $option) {
  			if (strpos(stripslashes($option), '"' . stripslashes($this->font) . '"') !== false) {
  				echo "<option selected='selected' " . $option;
  			} else {
  				echo "<option " . $option;
  			}
  		}
  		if ($this->weight == "")
  			$this->weight = "normal";
  		echo "</select><br><br>";
  		echo "<input type='hidden' value=\"" . $this->data . "\" name='" . $this->name . "'>";
  		echo "<input class='wpdreans-fontweight' name='" .self::$_instancenumber . "_font-weight' type='radio' value='normal' " . (($this->weight == 'normal') ? 'checked' : '') . ">Normal</input>";
  		echo "<input class='wpdreans-fontweight' name='" .self::$_instancenumber . "_font-weight' type='radio' value='bold' " . (($this->weight == 'bold') ? 'checked' : '') . ">Bold</input><br><br>";
  		new wpdreamsColorPickerDummy( self::$_instancenumber . "_color", "", (isset($this->color) ? $this->color : "#000000"));
  		echo "<br />" . $this->label . " size (ex.:10em, 10px or 110%): ";
  		echo "<input type='text' class='wpdreams-fontsize' style='width:70px;' name='" . self::$_instancenumber . "_size' value='" . $this->size . "' />";
      echo " Line height: <input type='text' class='wpdreams-lineheight' style='width:70px;' name='" . self::$_instancenumber . "_lineheight' value='" . $this->lineheight . "' />";
  		new wpdreamsInfo("You can enter the font size in pixels, ems or in percents. For example: 10px or 1.3em or 120%");
  		echo "
        <div class='triggerer'></div>
      </fieldset>
      </div>";
  	}
  	final function getData() {
  		return $this->data;
  	}
  	final function getScript() {
  		if (strpos($this->font, "'"))
  			return;
  		$font = str_replace(" ", "+", trim($this->font));
  		ob_start();
  ?>
    <style>
      @import url(http://fonts.googleapis.com/css?family=<?php echo $font; ?>:300|<?php echo $font; ?>:400|<?php echo $font; ?>:700);
    </style>
    <?php
  		$out = ob_get_contents();
  		ob_end_clean();
  		return $out;
  	}
  	final function getImport() {
  		if (strpos($this->font, "'"))
  			return;
  		$font = str_replace(" ", "+", trim($this->font));
  		ob_start();
  ?>
      @import url(http://fonts.googleapis.com/css?family=<?php echo $font; ?>:300|<?php echo $font; ?>:400|<?php echo $font; ?>:700);
    <?php
  		$out = ob_get_contents();
  		ob_end_clean();
  		return $out;
  	}
  }
}

if (!class_exists("wpdreamsOnOff")) {
  class wpdreamsOnOff extends wpdreamsType {
  	function getType() {
  		parent::getType();
      echo "<div class='wpdreamsOnOff'>";
  		echo "<label for='wpdreamstext_" . self::$_instancenumber . "'>" . $this->label . "</label>";
  		echo "<a class='wpdreamsonoff" . (($this->data == 1) ? " on" : " off") . "' id='wpdreamsonoff_" . self::$_instancenumber . "' name='" . $this->name . "_onoff'>" . (($this->data == 1) ? "ON" : "OFF") . "</a>";
  		echo "<input type='hidden' value='" . $this->data . "' name='" . $this->name . "'>";
  	  echo "<div class='triggerer'></div>
      </div>";
    }
  }
}


if (!class_exists("wpdreamsYesNo")) {
  class wpdreamsYesNo extends wpdreamsType {
  	function getType() {
  		parent::getType();
      echo "<div class='wpdreamsYesNo'>";
  		echo "<label for='wpdreamstext_" . self::$_instancenumber . "'>" . $this->label . "</label>";
  		echo "<a class='wpdreamsyesno" . (($this->data == 1) ? " yes" : " no") . "' id='wpdreamsyesno_" . self::$_instancenumber . "' name='" . $this->name . "_yesno'>" . (($this->data == 1) ? "YES" : "NO") . "</a>";
  		echo "<input type='hidden' value='" . $this->data . "' name='" . $this->name . "'>";
  	  echo "<div class='triggerer'></div>
      </div>";
  	}
  }
}

if (!class_exists("wpdreamsImageRadio")) {
  class wpdreamsImageRadio extends wpdreamsType {
  	function getType() {
  		parent::getType();
      $this->processData();
      echo "<div class='wpdreamsImageRadio'>";
  		echo "<span class='radioimage'>" . $this->label . "</span>";
      
      foreach ($this->selects as $radio) {
        $radio = trim($radio);
        echo "
          <img src='".plugins_url().$radio."' class='radioimage".(($radio==trim($this->selected))?' selected':'')."'/>
        ";
      }
  		echo "<input type='hidden' value='" . $this->data . "' name='" . $this->name . "'>";
      echo "<div class='triggerer'></div>
      </div>";
  	}
  	function processData() {
  		//$this->data = str_replace("\n","",$this->data); 
  		$_temp          = explode("||", $this->data);
  		$this->selects  = explode(";", $_temp[0]);
  		$this->selected = trim($_temp[1]);
  	}
  	final function getData() {
  		return $this->data;
  	}
  	final function getSelected() {
  		return $this->selected;
  	}
  }
}


if (!class_exists("wpdreamsBoxShadow")) {
  class wpdreamsBoxShadow extends wpdreamsType {
  	function getType() {
  		parent::getType();
      $this->processData();
  		echo "
      <div class='wpdreamsBoxShadow'>
        <fieldset>
          <legend>" . $this->label . "</legend>";
      echo "
         <label>Inset</label><select class='smaller' name='_xx_inset_xx_'>
             <option value='' ".(($this->inset=='')?'selected="selected"':'').">None</option>
             <option value='inset' ".(($this->inset=='inset')?'selected="selected"':'').">Inset</option>
         </select><br><br>
         <label>Vertical offset</label><input type='text' class='twodigit' name='_xx_hlength_xx_' value='".$this->hlength."' />px
         <label>Horizontal offset</label><input type='text' class='twodigit' name='_xx_vlength_xx_' value='".$this->vlength."' />px
         <label>Blur radius</label><input type='text' class='twodigit' name='_xx_blurradius_xx_' value='".$this->blurradius."' />px
         <label>Spread</label><input type='text' class='twodigit' name='_xx_spread_xx_' value='".$this->spread."' />px<br><br>
      ";
      new wpdreamsColorPickerDummy("_xx_color_xx_", "Shadow color", (isset($this->color) ? $this->color : "#000000"));
  		echo "
         <input type='hidden' value='" . $this->data . "' name='" . $this->name . "'>
         <div class='triggerer'></div>
        </fieldset>
      </div>";
  	}
  	function processData() {
  		$this->data = str_replace("\n", "", $this->data);
      preg_match("/box-shadow:(.*?)px (.*?)px (.*?)px (.*?)px (.*?) (.*?);/", $this->data, $matches);
  		$this->inset = $matches[6];
  		$this->hlength = $matches[1];
  		$this->vlength = $matches[2];
  		$this->blurradius = $matches[3];
  		$this->spread = $matches[4];
  		$this->color = $matches[5];
  	}
  	final function getData() {
  		return $this->data;
  	}
  	final function getCss() {
  		return $this->css;
  	}
  }
}


 if (!class_exists("wpdreamsBorder")) {
  class wpdreamsBorder extends wpdreamsType {
  	function getType() {
  		parent::getType();
      $this->processData();
  		echo "
      <div class='wpdreamsBorder'>
        <fieldset>
          <legend>" . $this->label . "</legend>";
      echo "
         <label>Border Style</label><select class='smaller' name='_xx_style_xx_'>
            <option value='none' ".(($this->style=='none')?'selected="selected"':'').">None</option>
            <option value='hidden' ".(($this->style=='hidden')?'selected="selected"':'').">Hidden</option>
            <option value='dotted' ".(($this->style=='dotted')?'selected="selected"':'').">Dotted</option>
            <option value='dashed' ".(($this->style=='dashed')?'selected="selected"':'').">Dashed</option>
            <option value='solid' ".(($this->style=='solid')?'selected="selected"':'').">Solid</option>
            <option value='double' ".(($this->style=='double')?'selected="selected"':'').">Double</option>
            <option value='groove' ".(($this->style=='groove')?'selected="selected"':'').">Groove</option>
            <option value='groove' ".(($this->style=='groove')?'selected="selected"':'').">Ridge</option>
            <option value='inset' ".(($this->style=='inset')?'selected="selected"':'').">Inset</option>
            <option value='outset' ".(($this->style=='outset')?'selected="selected"':'').">Outset</option>
         </select><br><br>
         <label>Border Width</label><input type='text' class='twodigit' name='_xx_width_xx_' value='".$this->width."' />px
         <br><br>";
         new wpdreamsColorPickerDummy("_xx_color_xx_", "Border color", (isset($this->color) ? $this->color : "#000000")); 
         echo "<span style='margin-right:550px;color:#222;'>Border Radius Options:</span><br><br>
         <label>Top-Left</label><input type='text' class='twodigit' name='_xx_topleft_xx_' value='".$this->topleft."' />px
         <label>Top-Right</label><input type='text' class='twodigit' name='_xx_topright_xx_' value='".$this->topright."' />px
         <label>Bottom-Right</label><input type='text' class='twodigit' name='_xx_bottomright_xx_' value='".$this->bottomright."' />px
         <label>Bottom-Left</label><input type='text' class='twodigit' name='_xx_bottomleft_xx_' value='".$this->bottomleft."' />px
      ";
      
  		echo "
         <input type='hidden' value='" . $this->data . "' name='" . $this->name . "'>
         <div class='triggerer'></div>
        </fieldset>
      </div>";
  	}
  	function processData() {
  		$this->data = str_replace("\n", "", $this->data);
      
      preg_match("/border-radius:(.*?)px(.*?)px(.*?)px(.*?)px;/", $this->data, $matches);
  		$this->topleft = $matches[1];
  		$this->topright = $matches[2];
  		$this->bottomright = $matches[3];
  		$this->bottomleft = $matches[4]; 
      
      preg_match("/border:(.*?)px (.*?) (.*?);/", $this->data, $matches);
      $this->width = $matches[1];
      $this->style = $matches[2];
      $this->color = $matches[3];     

  	}
  	final function getData() {
  		return $this->data;
  	}
  	final function getCss() {
  		return $this->css;
  	}
  }
}


if (!class_exists("wpdreamsBorderRadius")) {
  class wpdreamsBorderRadius extends wpdreamsType {
  	function getType() {
  		parent::getType();
      $this->processData();
  		echo "
      <div class='wpdreamsBorderRadius'>
        <fieldset>
          <legend>" . $this->label . "</legend>";
      echo "
         <label>Top Left</label><input type='text' class='twodigit' name='topleft' value='".$this->topleft."' />px
         <label>Top Right</label><input type='text' class='twodigit' name='topright' value='".$this->topright."' />px
         <label>Bottom Right</label><input type='text' class='twodigit' name='bottomright' value='".$this->bottomright."' />px
         <label>Bottom Left</label><input type='text' class='twodigit' name='bottomleft' value='".$this->bottomleft."' />px<br><br>
      ";
  		echo "
         <input type='hidden' value='" . $this->data . "' name='" . $this->name . "'>
         <div class='triggerer'></div>
        </fieldset>
      </div>";
  	}
  	function processData() {
  		$this->data = str_replace("\n", "", $this->data);
      preg_match("/border-radius:(.*?)px(.*?)px(.*?)px(.*?)px;/", $this->data, $matches);
  		$this->topleft = $matches[1];
  		$this->topright = $matches[2];
  		$this->bottomright = $matches[3];
  		$this->bottomleft = $matches[4];
      //$this->css = "border-radius:".$this->topleft."px ".$this->topright."px ".$this->bottomright."px ".$this->bottomleft."px;"; 
  	}
  	final function getData() {
  		return $this->data;
  	}
  	/*final function getCss() {
  		return $this->css;
  	}*/
  }
}

if (!class_exists("wpdreamsCustomPostTypes")) {
  class wpdreamsCustomPostTypes extends wpdreamsType {
  	function getType() {
  		parent::getType();
      $this->processData();
      $this->types = get_post_types(array(
        '_builtin'=>false
      ));
  		echo "
      <div class='wpdreamsCustomPostTypes'>
        <fieldset>
          <legend>" . $this->label . "</legend>";
      echo '<div class="sortablecontainer">Available post types<ul id="sortable'.self::$_instancenumber.'" class="connectedSortable">';
      if ($this->types!=null && is_array($this->types)) {
        foreach($this->types as $k=>$v) {
          if ($this->selected==null || !in_array($v, $this->selected)) {
            echo '<li class="ui-state-default">'.$k.'</li>';
          }
        }
      }
      echo "</ul></div>";
      echo '<div class="sortablecontainer">Drag here the post types you want to use!<ul id="sortable_conn'.self::$_instancenumber.'" class="connectedSortable">';
      if ($this->selected!=null && is_array($this->selected)) {
        foreach($this->selected as $k=>$v) {
          echo '<li class="ui-state-default">'.$v.'</li>';
        }
      }
      echo "</ul></div>";
  		echo "
         <input type='hidden' value='" . $this->data . "' name='" . $this->name . "'>";
      ?>
         <script>
          (function($) {
            $(document).ready(function() { 
              $( "#sortable<?php echo self::$_instancenumber ?>, #sortable_conn<?php echo self::$_instancenumber ?>" ).sortable({
                  connectWith: ".connectedSortable"
              }, {
                update: function(event, ui) {
                  parent = $(ui.item).parent();
                  while(!parent.hasClass('wpdreamsCustomPostTypes')) {
                    parent=$(parent).parent();
                  }
                  var items = $('ul[id*=sortable_conn] li',parent);
                  var hidden = $('input[type=hidden]', parent);
                  console.log(items, hidden);
                  var val = "";
                  items.each(function(){
                     val+= "|"+$(this).html();
                  });
                  val = val.substring(1);
                  hidden.val(val);
                }
              }).disableSelection();
            });
          }(jQuery));
         </script>
      <?php
      echo "
        </fieldset>
      </div>";
  	}
  	function processData() {
  		$this->data = str_replace("\n", "", $this->data);
      if ($this->data!="")
        $this->selected = explode("|", $this->data);
      else
        $this->selected = null;
      //$this->css = "border-radius:".$this->topleft."px ".$this->topright."px ".$this->bottomright."px ".$this->bottomleft."px;"; 
  	}
  	final function getData() {
  		return $this->data;
  	}
  	final function getSelected() {
  		return $this->selected;
  	}
  }
}

if (!class_exists("wpdreamsCustomPostTypesEditable")) {
  class wpdreamsCustomPostTypesEditable extends wpdreamsType {
  	function getType() {
  		parent::getType();
      $this->processData();
      $this->types = get_post_types(array(
        '_builtin'=>false
      ));
  		echo "
      <div class='wpdreamsCustomPostTypesEditable'>
        <fieldset>
          <legend>" . $this->label . "</legend>";
      echo '<div class="sortablecontainer">Available post types<ul id="sortable'.self::$_instancenumber.'" class="connectedSortable">';
      if ($this->types!=null && is_array($this->types)) {
        foreach($this->types as $k=>$v) {
          if ($this->selected==null || !in_array_r($v, $this->selected)) {
            echo '<li class="ui-state-default" style="background: #ddd;">
              <span>'.$k.'</span><br>
              <input type="text" value="'.$k.'"/>
              </li>';
          }
        }
      }
      echo "</ul></div>";
      echo '<div class="sortablecontainer">Drag here the post types you want to use!<ul id="sortable_conn'.self::$_instancenumber.'" class="connectedSortable">';
      if ($this->selected!=null && is_array($this->selected)) {
        foreach($this->selected as $k=>$v) {
          echo '<li class="ui-state-default" style="background: #ddd;">
            <span>'.$v[0].'</span><br>
            <input type="text" value="'.$v[1].'"/>
            </li>';
        }
      }
      echo "</ul></div>";
  		echo "
         <input type='hidden' value='" . $this->data . "' name='" . $this->name . "'>";
      ?>
         <script>
          (function($) {
            $(document).ready(function() { 
              $("#sortable_conn<?php echo self::$_instancenumber ?> li input" ).keyup(function() {
                    parent = $(this).parent();
                    while(!parent.hasClass('wpdreamsCustomPostTypesEditable')) {
                      parent=$(parent).parent();
                    }
                    var items = $('ul[id*=sortable_conn] li',parent);
                    var hidden = $('input[type=hidden]', parent);
                    var val = "";
                    console.log(hidden, items);
                    items.each(function(){
                       val+= "|"+$('span', this).html()+";"+$('input', this).val();
                    });
                    val = val.substring(1);
                    hidden.val(val);           
              });
              $( "#sortable<?php echo self::$_instancenumber ?>, #sortable_conn<?php echo self::$_instancenumber ?>" ).sortable({
                  connectWith: ".connectedSortable"
              }, {
                update: function(event, ui) {
                  $("#sortable_conn<?php echo self::$_instancenumber ?> li input" ).keyup(function() {
                        parent = $(this).parent();
                        while(!parent.hasClass('wpdreamsCustomPostTypesEditable')) {
                          parent=$(parent).parent();
                        }
                        var items = $('ul[id*=sortable_conn] li',parent);
                        var hidden = $('input[type=hidden]', parent);
                        var val = "";
                        console.log(hidden, items);
                        items.each(function(){
                           val+= "|"+$('span', this).html()+";"+$('input', this).val();
                        });
                        val = val.substring(1);
                        hidden.val(val);           
                  });
                  $("#sortable_conn<?php echo self::$_instancenumber ?> li input" ).keyup();
                }
              });
            });

          }(jQuery));
         </script>
      <?php
      echo "
        </fieldset>
      </div>";
  	}
  	function processData() {
  		$this->data = str_replace("\n", "", $this->data);
      if ($this->data!="") {
        $this->_t = explode("|", $this->data);
        foreach($this->_t as $k=>$v) {
          $this->selected[] = explode(';', $v);
        }
      } else {
        $this->selected = null;
      }
  	}
  	final function getData() {
  		return $this->data;
  	}
  	final function getSelected() {
  		return $this->selected;
  	}
  }
}

if (!class_exists("wpdreamsImageSettings")) {
  class wpdreamsImageSettings extends wpdreamsType {
  	function getType() {
  		parent::getType();
      $this->processData();
  		echo "
      <div class='wpdreamsImageSettings'>
        <fieldset>
          <legend>" . $this->label . "</legend>";
          new wpdreamsYesNo("show", "Show Images", $this->show);
          echo "<br><br>";
          new wpdreamsYesNo("cache", "Cache Images", $this->cache);
      echo "
         <br><br>
         <label>Use post featured image</label><select class='smaller' name='featured'>
             <option value='-1' ".(($this->featured==-1)?'selected="selected"':'').">Don't use</option>
             <option value='0' ".(($this->featured==0)?'selected="selected"':'').">High Priority</option>
             <option value='1' ".(($this->featured==1)?'selected="selected"':'').">Medium Priority</option>
             <option value='2' ".(($this->featured==2)?'selected="selected"':'').">Low Priority</option>
         </select><br><br>
         <label>Search for images in post content</label><select class='smaller' name='content'>
             <option value='-1' ".(($this->content==-1)?'selected="selected"':'').">Don't use</option>
             <option value='0' ".(($this->content==0)?'selected="selected"':'').">High Priority</option>
             <option value='1' ".(($this->content==1)?'selected="selected"':'').">Medium Priority</option>
             <option value='2' ".(($this->content==2)?'selected="selected"':'').">Low Priority</option>
         </select><br><br>
         <label>Search for images in post excerpt</label><select class='smaller' name='excerpt'>
             <option value='-1' ".(($this->excerpt==-1)?'selected="selected"':'').">Don't use</option>
             <option value='0' ".(($this->excerpt==0)?'selected="selected"':'').">High Priority</option>
             <option value='1' ".(($this->excerpt==1)?'selected="selected"':'').">Medium Priority</option>
             <option value='2' ".(($this->excerpt==2)?'selected="selected"':'').">Low Priority</option>
         </select><br><br>
         <label>Use the </label><select class='smaller' name='imagenum'>
             <option value='1' ".(($this->imagenum==1)?'selected="selected"':'').">1. found image</option>
             <option value='2' ".(($this->imagenum==2)?'selected="selected"':'').">2. found image</option>
             <option value='3' ".(($this->imagenum==3)?'selected="selected"':'').">3. found image</option>
         </select><br><br>
         <label>Image Size:</label>
         <span style='color:#888;font-size:0.9em'>Width </span><input class='threedigit' param=0 type='text' value='".$this->width."' name='width' /><span style='color:#888;font-size:0.9em;margin-right:10px;'> px</span>
         <span style='color:#888;font-size:0.9em'>Height </span><input class='threedigit' param=0 type='text' value='".$this->height."' name='height' /><span style='color:#888;font-size:0.9em;margin-right:10px;'> px</span>
      ";
  		echo "
         <input type='hidden' param=1 value='" . $this->data . "' name='" . $this->name . "'>
         <div class='triggerer'></div>
        </fieldset>
      </div>";
  	}
  	function processData() {
  		$this->data = str_replace("\n", "", $this->data);
  		preg_match("/show:(.*?);/", $this->data, $matches);
  		$this->show = $matches[1];
  		preg_match("/cache:(.*?);/", $this->data, $matches);
  		$this->cache = $matches[1];
  		preg_match("/featured:(.*?);/", $this->data, $matches);
  		$this->featured = $matches[1];
  		preg_match("/content:(.*?);/", $this->data, $matches);
  		$this->content = $matches[1];
  		preg_match("/excerpt:(.*?);/", $this->data, $matches);
  		$this->excerpt= $matches[1];
  		preg_match("/imagenum:(.*?);/", $this->data, $matches);
  		$this->imagenum = $matches[1];
  		preg_match("/width:(.*?);/", $this->data, $matches);
  		$this->width = $matches[1];
  		preg_match("/height:(.*?);/", $this->data, $matches);
  		$this->height = $matches[1];      
      $this->ret = array();
      $this->ret['show'] = $this->show;
      $this->ret['cache'] = $this->cache;
      $this->ret['width'] = $this->width;
      $this->ret['height'] = $this->height;
      $this->ret['imagenum'] = $this->imagenum;
      $this->ret['from'] = array(
        $this->featured=>"featured",
        $this->content=>"content",
        $this->excerpt=>"excerpt"
      );
  	}
  	final function getData() {
  		return $this->data;
  	}
  	final function getSettings() {
  		return $this->ret;
  	}
  }
}

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
if (!class_exists("wpdreamsColorPicker")) {
  class wpdreamsColorPicker extends wpdreamsType {
  	function getType() {
  		$this->name = $this->name . "_colorpicker";
  		parent::getType();
      echo "<div class='wpdreamsColorPicker'>";
  		if ($this->label != "")
  			echo "<label for='wpdreamscolorpicker_" . self::$_instancenumber . "'>" . $this->label . "</label>";
  		echo "<input type='text' class='color'  name='" . $this->name . "' id='wpdreamscolorpicker_" . self::$_instancenumber . "' value='" . $this->data . "' />";
  		echo "<input type='button' class='wpdreamscolorpicker button-secondary' value='Select Color'>";
  		echo "<div class='' style='z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;'></div>";
      echo "<div class='triggerer'></div>
      </div>";
  	}
  }
}

if (!class_exists("wpdreamsColorPickerDummy")) {
  class wpdreamsColorPickerDummy extends wpdreamsType {
  	function getType() {
  		$this->name = $this->name . "_colorpicker";
      echo "<div class='wpdreamsColorPicker'>";
  		if ($this->label != "")
  			echo "<label for='wpdreamscolorpicker_" . self::$_instancenumber . "'>" . $this->label . "</label>";
  		echo "<input type='text' class='color'  name='" . $this->name . "' id='wpdreamscolorpicker_" . self::$_instancenumber . "' value='" . $this->data . "' />";
  		echo "<input type='button' class='wpdreamscolorpicker button-secondary' value='Select Color'>";
  		echo "<div class='' style='z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;'></div>";
      echo "<div class='triggerer'></div>
      </div>";
  	}
  }
}

add_action('admin_print_styles', 'admin_stylesV02t');
add_action('admin_enqueue_scripts', 'admin_scriptsV02t');
add_action('wp_ajax_wpdreams-ajaxinput', "ajaxinputcallback");
if (!function_exists("ajaxinputcallback")) {
	function ajaxinputcallback() {
		$param = $_POST;
		echo call_user_func($_POST['callback'], $param);
		exit;
	}
}
function admin_scriptsV02t() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_script('farbtastic', array(
		'wpdreams-jquerytooltip'
	));
	wp_register_script('wpdreams-others', plugin_dir_url(__FILE__) . '/types/others.js', array(
		'jquery',
		'thickbox',
		'farbtastic',
		'wpdreams-notytheme'
	));
	wp_enqueue_script('wpdreams-others');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-draggable');
	wp_register_script('wpdreams-upload', plugin_dir_url(__FILE__) . '/types/upload.js', array(
		'jquery',
		'media-upload',
		'thickbox'
	));
	wp_enqueue_script('wpdreams-upload');
	wp_register_script('wpdreams-noty', plugin_dir_url(__FILE__) . '/types/js/noty/jquery.noty.js', array(
		'jquery'
	));
	wp_enqueue_script('wpdreams-noty');
	wp_register_script('wpdreams-notylayout', plugin_dir_url(__FILE__) . '/types/js/noty/layouts/top.js', array(
		'wpdreams-noty'
	));
	wp_enqueue_script('wpdreams-notylayout');
	wp_register_script('wpdreams-notytheme', plugin_dir_url(__FILE__) . '/types/js/noty/themes/default.js', array(
		'wpdreams-noty'
	));
	wp_enqueue_script('wpdreams-notytheme');
	wp_register_script('wpdreams-jquerytooltip', 'http://cdn.jquerytools.org/1.2.7/all/jquery.tools.min.js', array(
		'jquery'
	));
	wp_enqueue_script('wpdreams-jquerytooltip');
}
function admin_stylesV02t() {
	wp_enqueue_style('thickbox');
	wp_enqueue_style('farbtastic'); 
  wp_register_style('wpdreams-jqueryui', 'http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css');
  wp_enqueue_style('wpdreams-jqueryui');
	wp_register_style('wpdreams-style', plugin_dir_url(__FILE__) . '/types/style.css');
	wp_enqueue_style('wpdreams-style');
}
/* Extra Functions */
if (!function_exists("isEmpty")) {
  function isEmpty($v) {
  	if (trim($v) != "")
  		return false;
  	else
  		return true;
  }
}

if (!function_exists("in_array_r")) {
  function in_array_r($needle, $haystack, $strict = true) {
      foreach ($haystack as $item) {
          if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
              return true;
          }
      }
  
      return false;
  }
}
?>
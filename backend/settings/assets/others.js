(function( $ ){
function wpdreamsOthers (args)  {
  var _self = this;  
  this.constructor = function() {
    _self.init = true; 

    $( ".sortable" ).sortable({ 
      items: 'div.wpdreams-slider.moveable', 
      dropOnEmpty: false,
      delay: 200, 
      stop: function(event, ui) { 
        var nodes = $(".sortable div.wpdreams-slider.moveable");
        var nodesArr = Array();
        for(var j=0,i=nodes.length;i>=0;j++,i--) {
          nodesArr[j] = $(nodes[i]).attr("slideid");
        }
      	var data = {
      	  action: 'reorder_slides',
      		nodes: nodesArr,
      		ordering: i
      	};
        $(nodes).fadeTo(400, 0.4); 
      	jQuery.post(ajaxurl, data, function(response) {
            $(nodes).fadeTo(400, 1);   		
      	});
      }
    }); 
    _self.init = false;
  },


  $('.wpdreamsThemeChooser select').bind('change', function(){
      var c = confirm('Do you really want to load this template?');
      if (!c) return;
     var parent = $(this);
     while(parent.is('form')!=true) {
       parent = parent.parent();
     }
     var themeDiv = $('div[name="'+$(this).val()+'"]');
     var items = $('p', themeDiv);
     items.each(function(){
        param = $('input[name="'+$(this).attr('paramname')+'"]', parent);
        if (param.length==0)
          param = $('select[name="'+$(this).attr('paramname')+'"]', parent);
     if (param.length==0)
         param = $('textarea[name="'+$(this).attr('paramname')+'"]', parent);
        param.val($(this).html());
        $('>.triggerer', param.parent()).trigger('click');
     });   
  });



  /*
    Image Settings
    Msg: The name of the separate params determinates the value outputted in the hidden field.
  */
  $('.wpdreamsImageSettings input, .wpdreamsImageSettings select').change(function() {
    parent = $(this).parent();
    while (parent.hasClass('item')!=true) {
      parent = parent.parent();
    }
    var elements = $('input[param!=1], select', parent);
    var hidden = $('input[param=1]' ,parent);
    var ret = "";
    elements.each(function() { 
       ret+=$(this).attr("name")+":"+ $(this).val() + ";";
    });
    hidden.val(ret);
  });
  $('.wpdreamsImageSettings>fieldset>.triggerer').bind("click", function(){
    var elements = $('input[param!=1], select', parent);
    var hidden = $('input[param=1]' ,parent);
    elements.each(function() {
      var name = $(this).attr("name");
      var regex = new RegExp(".*" + name + ":(.*?);.*"); 
      val = hidden.val().replace(/(\r\n|\n|\r)/gm,"").match(regex);
      $(this).val(val[1]);
      if ($(this).next().hasClass('triggerer')) $(this).next().click();    
    });
  });  
  //Image Settings End
 
 
  /*
    wpdreamsNumericUnit
    Msg: 
  */
  $('.wpdreamsNumericUnit select, .wpdreamsNumericUnit input[name=numeric]').change(function() {
     var value = "";
     var parent = $(this).parent();
     while (parent.hasClass('wpdreamsNumericUnit')!=true) {
       parent = $(parent).parent();
     }
     var value = $('input[name=numeric]', parent).val() + $('select', parent).val();
     $('input[type=hidden]', parent).val(value);
  });
  
  $('.wpdreamsNumericUnit .triggerer').bind('click', function(){
     var value = "";
     var parent = $(this).parent();
     while (parent.hasClass('wpdreamsNumericUnit')!=true) {
       parent = $(parent).parent();
     }
     var hiddenval = $('input[type=hidden]', parent).val();
     var value = hiddenval.match(/([0-9]+)(.*)/)
     $('input[name=numeric]', parent).val(value[1]);
     $('select', parent).val(value[2]);
  });
  //Select end 
  
  /*
    Select
    Msg: 
  */
  $('.wpdreamsSelect .wpdreamsselect').change(function() {
     _self.hidden = $(this).next();
     var selhidden = $(this).next().next();
     var val = $(_self.hidden).val().match(/(.*[\S\s]*?)\|\|(.*)/);
     var options = val[1];
     var selected = val[2];
     $(_self.hidden).val(options+"||"+$(this).val());
     selhidden.val($(this).val());
  });
  
  $('.wpdreamsSelect .triggerer').bind('click', function(){
     var parent = $(this).parent();
     var select = $('select', parent);
     var hidden = select.next();
     var selhidden = hidden.next();
     var val = $(hidden).val().replace(/(\r\n|\n|\r)/gm,"").match(/(.*[\S\s]*?)\|\|(.*)/);
     var selected = $.trim(val[2]);
     select.val(selected);
     selhidden.val(selected);
  });
  //Select end

    /*
     textareaIsparam
     Msg:
     */
    $('.wpdreamsTextareaIsParam .triggerer').bind('click', function(){
        $('textarea', $(this).parent()).change();
    });
  
  /*
    wpdreamsanimationselect
    Msg: 
  */
  $('.wpdreamsAnimations .wpdreamsanimationselect').change(function() {
     var parent = $(this).parent();
     $('span', parent).removeClass();
     $('span', parent).addClass($(this).val());
  });
  
  $('.wpdreamsAnimations .triggerer').bind('click', function(){
     var parent = $(this).parent();
     var select = $('select', parent);
     return;
  });
  //wpdreamsanimationselect end
  
  
  /*
    LanguageSelect
    Msg: 
  */
  $('.wpdreamsLanguageSelect .wpdreamsselect').change(function() {
     _self.hidden = $(this).next();
     $(_self.hidden).val($(this).val());
  });

  //LanguageSelect end


  /*
    Onoff
    Msg: 
  */  
  $('.wpdreamsOnOff .wpdreamsOnOffInner').on('click', function() {
     var hidden = $(this).prev();
     var val = $(hidden).val();
     if (val==1) {
      val = 0;
      $(this).parent().removeClass("active");
     } else {
      val = 1;
      $(this).parent().addClass("active");
     }
     $(hidden).val(val);
     $(hidden).change();
  });
  $('.wpdreamsOnOff .triggerer').on('click', function() {
     var hidden = $('input[type=hidden]', $(this).parent());
     var div =  $(this).parent();
     var val = $(hidden).val();
     if (val==0) {
      div.removeClass("active");
     } else {
      div.addClass("active");
     }
  });
  /*Onoff End*/
  
  /*
    YesNo
    Msg: 
  */   
  $('.wpdreamsYesNo .wpdreamsYesNoInner').on('click', function() {
     var hidden = $(this).prev();
     var val = $(hidden).val();
     if (val==1) {
      val = 0;
      $(this).parent().removeClass("active");
     } else {
      val = 1;
      $(this).parent().addClass("active");
     }
     $(hidden).val(val);
     $(hidden).change();
  });
  $('.wpdreamsYesNo .triggerer').on('click', function() {
     var hidden = $('input[type=hidden]', $(this).parent());
     var div =  $(this).parent();
     var val = $(hidden).val();
     if (val==0) {
      div.removeClass("active");
     } else {
      div.addClass("active");
     }
     $(hidden).change();
  });
  /*YesNo End*/
  
  
  /*this.colorPickerInit = function(event) {
      colorPicker = $(this).next().next('div');
      input = this;
      $(colorPicker).farbtastic(input);
  }; */

  $('.successMsg').each(function() {
     $(this).delay(4000).fadeOut();
  }); 
  $('img.delete').click(function() {
     var del = confirm("Do yo really want to delete this item?");
     if (del) {
      $(this).next().submit();
     }
  });
  
  /*
   RadioImage
   Msg:
  */
  $('.wpdreamsImageRadio img.radioimage').click(function() {
     var $parent = $(this).parent();
     var $hidden = $("input[class=realvalue]", $parent);
     $('img.selected', $parent).removeClass('selected');
     $(this).addClass('selected');  
     var vals = $(this).attr('src').split('/plugins/');
     $hidden.val(vals[1]);
     $hidden.change();
  });
  $('.wpdreamsImageRadio .triggerer').bind('click', function(){
     var $parent = $(this).parent();
     var $hidden = $("input[class=realvalue]", $parent);
     $('img.selected', $parent).removeClass('selected');
     $('img[src*="'+$hidden.val()+'"]', $parent).addClass('selected');
     $hidden.change();
  });
  /*RadioImage End*/


  /*
    TextShadow
    Msg: Its a bit more complicated but working fine :)
  */
  $('.wpdreamsTextShadow input[type=text]').change(function() {
     var value = "";
     var parent = $(this).parent();
     while (parent.hasClass('wpdreamsTextShadow')!=true) {
       parent = $(parent).parent();
     }
     var hlength = $.trim($('input[name*="_xx_hlength_xx_"]', parent).val())+"px ";
     var vlength = $.trim($('input[name*="_xx_vlength_xx_"]', parent).val())+"px ";
     var blurradius = $.trim($('input[name*="_xx_blurradius_xx_"]', parent).val())+"px ";
     var color = $.trim($('input[name*="_xx_color_xx_"]', parent).val())+" ";
     var boxshadow = "text-shadow:"+hlength+vlength+blurradius+color;    
     $('input[type=hidden]', parent).val(boxshadow);
     $('input[type=hidden]', parent).change();
  });
  $('.wpdreamsTextShadow>fieldset>.triggerer').bind('click', function(){
     var parent = $(this).parent();
     var hidden = $("input[type=hidden]", parent);
     var boxshadow = hidden.val().replace(/(\r\n|\n|\r)/gm,"").match(/box-shadow:(.*?)px (.*?)px (.*?)px (.*?);/);

     $('input[name*="_xx_hlength_xx_"]', parent).val(boxshadow[1])+"px ";
     $('input[name*="_xx_vlength_xx_"]', parent).val(boxshadow[2])+"px ";
     $('input[name*="_xx_blurradius_xx_"]', parent).val(boxshadow[3])+"px ";
     $('input[name*="_xx_color_xx_"]', parent).val(boxshadow[4])+" ";
     $('input[name*="_xx_color_xx_"]', parent).keyup();
    /*var name = $(this).attr('name').match(/.*_xx_(.*)_xx_/)[1]
    var regex = new RegExp(".*" + name + ":(.*?);.*"); 
    val = hidden.val().replace(/(\r\n|\n|\r)/gm,"").match(regex);
    $(this).val(val[1]);  */
    //$('input[name*="_xx_color_xx_"]', parent).trigger("keyup"); 

  });
  /*BoxShadow end*/   
  
  /*
    BoxShadow
    Msg: Its a bit more complicated but working fine :)
  */
  $('.wpdreamsBoxShadow input[type=text], .wpdreamsBoxShadow select').change(function() {
     var value = "";
     var parent = $(this).parent();
     while (parent.hasClass('wpdreamsBoxShadow')!=true) {
       parent = $(parent).parent();
     }
     var hlength = $.trim($('input[name*="_xx_hlength_xx_"]', parent).val())+"px ";
     var vlength = $.trim($('input[name*="_xx_vlength_xx_"]', parent).val())+"px ";
     var blurradius = $.trim($('input[name*="_xx_blurradius_xx_"]', parent).val())+"px ";
     var spread = $.trim($('input[name*="_xx_spread_xx_"]', parent).val())+"px ";
     var color = $.trim($('input[name*="_xx_color_xx_"]', parent).val())+" ";
     var inset = $.trim($('select[name*="_xx_inset_xx_"]', parent).val())+";";
     var boxshadow = "box-shadow:"+hlength+vlength+blurradius+spread+color+inset;
     
     $('input[type=hidden]', parent).val(boxshadow);
     $('input[type=hidden]', parent).change();
  });
  $('.wpdreamsBoxShadow>fieldset>.triggerer').bind('click', function(){
     var parent = $(this).parent();
     var hidden = $("input[type=hidden]", parent);
     var boxshadow = hidden.val().replace(/(\r\n|\n|\r)/gm,"").match(/box-shadow:(.*?)px (.*?)px (.*?)px (.*?)px (.*?)\) (.*?);/);
     var plus = ")";
     if (boxshadow==null) {
         boxshadow = hidden.val().replace(/(\r\n|\n|\r)/gm,"").match(/box-shadow:(.*?)px (.*?)px (.*?)px (.*?)px (.*?) (.*?);/);
         plus = '';
     }
     $('input[name*="_xx_hlength_xx_"]', parent).val(boxshadow[1]);
     $('input[name*="_xx_vlength_xx_"]', parent).val(boxshadow[2]);
     $('input[name*="_xx_blurradius_xx_"]', parent).val(boxshadow[3]);
     $('input[name*="_xx_spread_xx_"]', parent).val(boxshadow[4]);
     $('input[name*="_xx_color_xx_"]', parent).val(boxshadow[5]+plus);
     $('select[name*="_xx_inset_xx_"]', parent).val(boxshadow[6]);
     $('input[name*="_xx_color_xx_"]', parent).spectrum('set', boxshadow[5]+plus);
    

  });
  /*BoxShadow end*/ 
  
  
  /*
    Border
    Msg: Its a bit more complicated but working fine :)
  */
  $('.wpdreamsBorder input[type=text], .wpdreamsBorder select').bind("change", function() {
     var value = "";
     var parent = $(this).parent();
     while (parent.hasClass('wpdreamsBorder')!=true) {
       parent = $(parent).parent();
     }
     var width = $('input[name*="_xx_width_xx_"]', parent).val()+"px ";
     var style = $('select[name*="_xx_style_xx_"]', parent).val()+" ";
     var color = $('input[name*="_xx_color_xx_"]', parent).val()+";";
     var border = "border:"+width+style+color;
     
     var topleft =  $.trim($('input[name*="_xx_topleft_xx_"]', parent).val())+"px ";
     var topright =  $.trim($('input[name*="_xx_topright_xx_"]', parent).val())+"px ";
     var bottomright =  $.trim($('input[name*="_xx_bottomright_xx_"]', parent).val())+"px ";
     var bottomleft =  $.trim($('input[name*="_xx_bottomleft_xx_"]', parent).val())+"px;";
     var borderradius = "border-radius:"+topleft+topright+bottomright+bottomleft;
     
     var value = border + borderradius;
     
     $('input[type=hidden]', parent).val(value);
     $('input[type=hidden]', parent).change();
  });
  $('.wpdreamsBorder>fieldset>.triggerer').bind('click', function(){
     var parent = $(this).parent();
     var hidden = $("input[type=hidden]", parent);
     var border = hidden.val().replace(/(\r\n|\n|\r)/gm,"").match(/border:(.*?)px (.*?) (.*?);/);
     $('input[name*="_xx_width_xx_"]', parent).val(border[1])+"px ";
     $('select[name*="_xx_style_xx_"]', parent).val(border[2])+" ";
     $('input[name*="_xx_color_xx_"]', parent).val(border[3])+";";

     var borderradius = hidden.val().replace(/(\r\n|\n|\r)/gm,"").match(/border-radius:(.*?)px(.*?)px(.*?)px(.*?)px;/);
     $('input[name*="_xx_topleft_xx_"]', parent).val(borderradius[1])+"px ";
     $('input[name*="_xx_topright_xx_"]', parent).val(borderradius[2])+"px ";
     $('input[name*="_xx_bottomright_xx_"]', parent).val(borderradius[3])+"px ";
     $('input[name*="_xx_bottomleft_xx_"]', parent).val(borderradius[4])+"px;";
     $('input[name*="_xx_color_xx_"]', parent).spectrum('set', border[3]);
    
    /*var name = $(this).attr('name').match(/.*_xx_(.*)_xx_/)[1]
    var regex = new RegExp(".*" + name + ":(.*?);.*"); 
    val = hidden.val().replace(/(\r\n|\n|\r)/gm,"").match(regex);
    $(this).val(val[1]);  */
    //$('input[name*="_xx_color_xx_"]', parent).trigger("keyup"); 

  });
  /*Border end*/ 
  
  
  /*
    BorderRadius
    Msg: Its a bit more complicated but working fine :)
  */
  $('.wpdreamsBorderRadius input[type=text]').change(function() {
     var value = "";
     $('input[type=text]', $(this).parent()).each(function(){
        value += " " + $(this).val()+"px";
     });
     $('input[type=hidden]', $(this).parent()).val("border-radius:"+value+";");
     $('input[type=hidden]',  $(this).parent()).change();
  });
  $('.wpdreamsBorderRadius>fieldset>.triggerer').bind('click', function(){
     var hidden = $("input[type=hidden]", $(this).parent());
     var values = hidden.val().match(/(.*?)px(.*?)px(.*?)px(.*?)px;/);
     var i = 1;
     $('input[type=text]', $(this).parent()).each(function(){
        if ($(this).attr('name')!=null) {
          $(this).val(values[i]);
          i++;
        }
     });
  });
  /*BorderRadius end*/   
  
  /*
    wpdreamsFour
    Msg: Its a bit more complicated but working fine :)
  */
  $('.wpdreamsFour input[type=text]').change(function() {
     var value = "";
     $('input[type=text]', $(this).parent()).each(function(){
        value += $(this).val()+"||";
     });
     $('input[isparam=1]', $(this).parent()).val("||" + value);
     $('input[isparam=1]',  $(this).parent()).change();
  });
  $('.wpdreamsFour>fieldset>.triggerer').bind('click', function(){
     var hidden = $("input[isparam=1]", $(this).parent());
     var values = hidden.val().match(/\|\|(.*?)\|\|(.*?)\|\|(.*?)\|\|(.*?)\|\|/);
     var i = 1;
     $('input[type=text]', $(this).parent()).each(function(){
        if ($(this).attr('name')!=null) {
          $(this).val(values[i]);
          i++;
        }
     });
     hidden.change();
  });
  /*BorderRadius end*/ 
  
  $('img.ordering').click(function() {
    $(this).next().submit();
  });
  
  /*
    Colorpicker Start
    Msg: 
  */

  $(".wpdreamsColorPicker .color").spectrum({
    showInput: true,
    showAlpha: true,
    showPalette: true,
    showSelectionPalette: true
  });
  $('.wpdreamsColorPicker .triggerer').bind('click', function(){
    function hex2rgb(hex, opacity) {
      var rgb = hex.replace('#', '').match(/(.{2})/g);
       
      var i = 3;
      while (i--) {
      rgb[i] = parseInt(rgb[i], 16);
      }
       
      if (typeof opacity == 'undefined') {
      return 'rgb(' + rgb.join(', ') + ')';
      }
       
      return 'rgba(' + rgb.join(', ') + ', ' + opacity + ')';
    }
    var parent = $(this).parent();
    var input = $('input.color', parent);
    var val = input.val();
    if (val.length<=7) val = hex2rgb(val, 1); 
    input.spectrum("set", val);
  });  
  //Colorpicker End
  
  /* Gradient */
  $(".wpdreamsGradient .color, .wpdreamsGradient .grad_type, .wpdreamsGradient .dslider").change(function() {
    var $parent = $(this);
    while(!$parent.hasClass('wpdreamsGradient')) {
       $parent = $parent.parent();
    }
    var $hidden = $('input.gradient', $parent);
    var $colors = $('input.color', $parent);
    var $type = $('select.grad_type', $parent);
    var $dslider = $('div.dslider', $parent);
    var $grad_ex = $('div.grad_ex', $parent);
    var $dbg = $('div.dbg', $parent);
    var $dtxt = $('div.dtxt', $parent);
    
    $dbg.css({
        "-webkit-transform": "rotate("+ $dslider.slider('value') +"deg)",
        "-moz-transform": "rotate("+ $dslider.slider('value') +"deg)",
        "transform": "rotate("+ $dslider.slider('value') +"deg)"
    });
    $dtxt.html($dslider.slider('value'));

    grad($grad_ex, $($colors[0]).val(), $($colors[1]).val(),$type.val(), $dslider.slider('value'));
    
    $hidden.val(
      $type.val() + '-' +
      $dslider.slider('value') + '-' +
      $($colors[0]).val() + '-' +
      $($colors[1]).val()
    );
    $hidden.change();
  }); 
  
  $(".wpdreamsGradient>.triggerer").click(function() {
    var $parent = $(this).parent();
    var $hidden = $('input.gradient', $parent);
    var $colors = $('input.color', $parent);
    var $dslider = $('div.dslider', $parent);
    var $type = $('select.grad_type', $parent);
    var colors = $hidden.val().match(/(.*?)-(.*?)-(.*?)-(.*)/);
    
    if (colors==null || colors[1]==null) {
      //Fallback to older 1 color
      $type.val(0);
      $dslider.slider('value', 0);
      $($colors[0]).spectrum('set', $hidden.val());
      $($colors[1]).spectrum('set', $hidden.val());       
    } else {
      $type.val(colors[1]);
      $dslider.slider('value', colors[2]);
      $($colors[0]).val(colors[3]);
      $($colors[1]).val(colors[4]);
  
      $($colors[0]).spectrum('set', colors[3]);
      $($colors[1]).spectrum('set', colors[4]);    
    }
    

  }); 
  
  
  function grad(el, c1, c2, t, d) {
    if (t!=0) {
      $(el).css('background-image','-webkit-linear-gradient('+d+'deg, '+c1+', '+c2+')')
        .css('background-image','-moz-linear-gradient('+d+'deg,  '+c1+',  '+c2+')')
        .css('background-image','-ms-linear-gradient('+d+'deg,  '+c1+',  '+c2+')')
        .css('background-image','linear-gradient('+d+'deg,  '+c1+',  '+c2+')')
        .css('background-image','-o-linear-gradient('+d+'deg,  '+c1+',  '+c2+')'); 
    } else {
      $(el).css('background-image','-webkit-radial-gradient(center, ellipse cover, '+c1+', '+c2+')')
        .css('background-image','-moz-radial-gradient(center, ellipse cover, '+c1+',  '+c2+')')
        .css('background-image','-ms-radial-gradient(center, ellipse cover, '+c1+',  '+c2+')')
        .css('background-image','radial-gradient(ellipse at center, '+c1+',  '+c2+')')
        .css('background-image','-o-radial-gradient(center, ellipse cover, '+c1+',  '+c2+')'); 
    }
  }
  // !Gradient

  /*
    Up-Down arrow
  */
  $('.wpdreams-updown .wpdreams-uparrow').click(function(){
      var prev = $(this).parent().prev();
      while(!prev.is('input')) {
        prev = prev.prev();
      }
      prev.val(parseFloat($(prev).val())+1);
      prev.change();
  });
  $('.wpdreams-updown .wpdreams-downarrow').click(function(){
      var prev = $(this).parent().prev();
      while(!prev.is('input')) {
        prev = prev.prev();
      }
      prev.val(parseFloat($(prev).val())-1);
      prev.change();
  });
  //Up-Down arrow end


  $('form.wpdreams-ajaxinput').each(function(){
      var _tmpmargin = $(this).css("marginLeft");
      $("img", this).click(function() {
        var src = $(this).attr('src');
        var img = src.match(/(.*)\/.*$/)[1];
        if ($(this).attr('opened')=="0") {
          $(this).attr('opened', '1');
          $(this).attr('src', img+'/arrow-left.png');
          ($(this).parent()).animate({marginLeft:0});
        } else {
          $(this).attr('opened', '0');
          $(this).attr('src', img+'/arrow-right.png');
          ($(this).parent()).animate({marginLeft:_tmpmargin});
        }
      });      
      $("input[name=url]", this).click(function() {
        if ($(this).val()=="Enter the feed url here...")
           $(this).val("");
      });
      $("input[name=url]", this).blur(function() {
        if ($(this).val()=="")
           $(this).val("Enter the feed url here...");
      });
      $("input[type=button]", this).bind("click",function(e){
        e.preventDefault();
      	var data = {
      	  action: 'wpdreams-ajaxinput',
      	  url: $("input[name=url]", $(this).parent()).val(),
      	  uid: $("input[name=uid]", $(this).parent()).val(),
      	  callback: $("input[name=callback]", $(this).parent()).val(),
      	  itemsnum: $("select[name=itemsnum]", $(this).parent()).val()
      	};
      	var _tmpnode = $("input[type=button]", $(this).parent());
      	var _tmpval = $("input[type=button]", $(this).parent()).val();
      	_tmpnode.val("Wait..");
      	_tmpnode.css("opacity", 0.8);
      	_tmpnode.attr("disabled", "disabled");
      	jQuery.post(
          ajaxurl, 
          data, 
          function(response) {
            if (response.status==0) {
              noty({
                text: response.msg,
                type: 'error',
                timeout: '2000'
              });
            } else {
              noty({
                text: response.msg,
                type: 'success',
                timeout: '2000'
              });
            }
      	   _tmpnode.css("opacity", 1);
      	   _tmpnode.removeAttr("disabled");
           _tmpnode.val(_tmpval);		
      	}, 'json');
      });
  });
  this.constructor();
}(jQuery);
$(document).ready(function() { 
  var x = new wpdreamsOthers();
});
(function( $ ){
  $.fn.disable = function() {
      return this.each(function() {
          if ($('.hider', this)[0]==null) {
            $(this).css('position', 'relative');
            var w = $(this).width();
            var h = $(this).height();
            this.$innerDiv = $(this)
                .append($('<div></div>')
                    .css({
                      position: 'absolute',
                      opacity: 0.7,
                      top: 0,
                      left: 0,
                      background: "#FFFFFF",
                      width: w,
                      height: h
                    })
                    .addClass('hider')
                )
            ;
          } else {
            $('.hider', this).css({
              display: 'block'
            });
          }
      });
  }
  $.fn.enable = function() {
      return this.each(function() {
          if ($('.hider', this)[0]!=null) {
            $('.hider', this).css({
              display: "none"
            });
          }
      });
  }
})( jQuery );
}(jQuery));
(function( $ ){
function wpdreamsOthers (args)  {
  var _self = this;  
  this.constructor = function() {
    _self.init = true; 
    $('.wpdreamscolorpicker').prev('input').bind("change", this.colorPickerInit);
    $('.wpdreamscolorpicker').prev('input').trigger("change");
    $('.wpdreams-slider.moveable .settings').trigger("click");
    $("#wpdreams img[title].infoimage").tooltip({
        effect: 'slide', 
        delay: 500,
        events: {
          def:  'click, mouseout',
          img: 'click, blur',
          checkbox: 'mouseover click, mouseout',
          date: 'click, blur'
        }
    });
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
     var parent = $(this);
     while(parent.is('form')!=true) {
       parent = parent.parent();
     }
     var themeDiv = $('div[name="'+$(this).val()+'"]');
     var items = $('p', themeDiv);
     items.each(function(){
        param = $('input[name^="'+$(this).attr('paramname')+'_"]', parent);
        param.val($(this).html());
        $('.triggerer', param.parent()).trigger('click');
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
    Select
    Msg: 
  */
  $('.wpdreamsSelect .wpdreamsselect').change(function() {
     _self.hidden = $(this).next();
     var val = $(_self.hidden).val().match(/(.*[\S\s]*?)\|\|(.*)/);
     var options = val[1];
     var selected = val[2];
     $(_self.hidden).val(options+"||"+$(this).val());
  });
  
  $('.wpdreamsSelect .triggerer').bind('click', function(){
     var parent = $(this).parent();
     var select = $('select', parent);
     var hidden = $('input[type=hidden]', parent);
     var val = $(hidden).val().replace(/(\r\n|\n|\r)/gm,"").match(/(.*[\S\s]*?)\|\|(.*)/);
     var selected = $.trim(val[2]);
     select.val(selected);
  });
  //Select end
  
  
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
  $('.wpdreamsOnOff .wpdreamsonoff').click(function() {
     var hidden = $(this).next();
     var val = $(hidden).val();
     if (val==1) {
      val = 0;
      $(this).removeClass("on"); 
      $(this).addClass("off");
      $(this).html("OFF");
     } else {
      val = 1;
      $(this).removeClass("off"); 
      $(this).addClass("on");
      $(this).html("ON");
     }
     $(hidden).val(val).change();
  });
  $('.wpdreamsOnOff .triggerer').click(function() {
     var hidden = $('input[type=hidden]', $(this).parent());
     var a =  $('a', $(this).parent());
     var val = $(hidden).val();
     if (val==0) {
      a.removeClass("on").addClass("off").html("OFF");
     } else {
      a.removeClass("off").addClass("on").html("ON");
     }
  });
  /*Onoff End*/
  
  /*
    YesNo
    Msg: 
  */   
  $('.wpdreamsYesNo .wpdreamsyesno').click(function() {
     var hidden = $(this).next();
     var val = $(hidden).val();
     if (val==1) {
      val = 0;
      $(this).removeClass("yes"); 
      $(this).addClass("no");
      $(this).html("NO");
     } else {
      val = 1;
      $(this).removeClass("no"); 
      $(this).addClass("yes");
      $(this).html("YES");
     }
     $(hidden).val(val);
     $(hidden).change();
  });
  $('.wpdreamsYesNo .triggerer').click(function() {
     var hidden = $('input[type=hidden]', $(this).parent());
     var a =  $('a', $(this).parent());
     var val = $(hidden).val();
     if (val==0) {
      a.removeClass("yes").addClass("no").html("NO");
     } else {
      a.removeClass("no").addClass("yes").html("YES");
     }
  });
  /*YesNo End*/
  
  
  this.colorPickerInit = function(event) {
      colorPicker = $(this).next().next('div');
      input = this;
      $(colorPicker).farbtastic(input);
  };
  $('.wpdreams-slider.moveable .settings').click(function(){
     var moveable = this.parentNode.parentNode;
     if ($('.errorMsg', moveable).length) return;
     if (_self.sliderHeight==null) {
       _self.sliderHeight = $(moveable).height();
     }  
     if ($(moveable).height()<27) {
      if (_self.init) {
        $(moveable).css({
          height: _self.sliderHeight
        });      
      } else {
        $(moveable).animate({
          height: _self.sliderHeight
        }, 500, function() {
        });  
      }
     } else {
      if (_self.init) {
        $(moveable).css({
          height: "26px"
        });      
      } else {
        $(moveable).animate({
          height: "26px"
        }, 500, function() {
        });  
      }
     }
  });
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
  $('img.radioimage').click(function() {
     $("img.radioimage", $(this).parent()).removeClass("selected");
     $(this).addClass("selected");
     var val = $("input[type=hidden]", $(this).parent()).val().match(/(.*[\S\s]*?)\|\|(.*)/);
     var options = val[1];
     var selected = val[2];
     var pre = "/ajax-search-pro/img/" //magnifiers/magn5.png
     var nval = $(this).attr('src').match(/.*?ajax-search-pro\/img\/(.*)/)[1];
     nval = pre+nval;
     $("input[type=hidden]", $(this).parent()).val(options+"||"+nval);       
  });
  $('.wpdreamsImageRadio .triggerer').bind('click', function(){
     var val = $("input[type=hidden]", $(this).parent()).val().replace(/(\r\n|\n|\r)/gm,"").match(/(.*[\S\s]*?)\|\|(.*)/);
     var selected = $.trim(val[2]);
     $("img", $(this).parent()).each(function(){
        $(this).removeClass("selected");
        var re = new RegExp(selected);
        if ($.trim($(this).attr('src')).match(re)!=null) {
           $(this).addClass("selected");
        }
     });
  });
  /*RadioImage End*/
  
  
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
  });
  $('.wpdreamsBoxShadow>fieldset>.triggerer').bind('click', function(){
     var parent = $(this).parent();
     var hidden = $("input[type=hidden]", parent);
     var boxshadow = hidden.val().replace(/(\r\n|\n|\r)/gm,"").match(/box-shadow:(.*?)px (.*?)px (.*?)px (.*?)px (.*?) (.*?);/);

     $('input[name*="_xx_hlength_xx_"]', parent).val(boxshadow[1])+"px ";
     $('input[name*="_xx_vlength_xx_"]', parent).val(boxshadow[2])+"px ";
     $('input[name*="_xx_blurradius_xx_"]', parent).val(boxshadow[3])+"px ";
     $('input[name*="_xx_spread_xx_"]', parent).val(boxshadow[4])+"px ";
     $('input[name*="_xx_color_xx_"]', parent).val(boxshadow[5])+" ";
     $('select[name*="_xx_inset_xx_"]', parent).val(boxshadow[6])+";";
     $('input[name*="_xx_color_xx_"]', parent).keyup();
    /*var name = $(this).attr('name').match(/.*_xx_(.*)_xx_/)[1]
    var regex = new RegExp(".*" + name + ":(.*?);.*"); 
    val = hidden.val().replace(/(\r\n|\n|\r)/gm,"").match(regex);
    $(this).val(val[1]);  */
    //$('input[name*="_xx_color_xx_"]', parent).trigger("keyup"); 

  });
  /*BoxShadow end*/ 
  
  
  /*
    Border
    Msg: Its a bit more complicated but working fine :)
  */
  $('.wpdreamsBorder input[type=text], .wpdreamsBorder select').bind("change", function() {
     var value = "";
     /*$('input[type=text]', $(this).parent()).each(function(){
        if ($(this).attr('name').match(/.*_xx_(.*)_xx_/)!=null) {
          var name = $(this).attr('name').match(/.*_xx_(.*)_xx_/)[1];
          value += name+ ":" + $(this).val()+";";
        }  
     });
     $('select', $(this).parent()).each(function(){
        if ($(this).attr('name').match(/.*_xx_(.*)_xx_/)!=null) {
          var name = $(this).attr('name').match(/.*_xx_(.*)_xx_/)[1];
          value += name+ ":" + $(this).val()+";";
        }
     });*/
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
     $('input[name*="_xx_color_xx_"]', parent).keyup();
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
  });
  $('.wpdreamsBorderRadius>fieldset>.triggerer').bind('click', function(){
     var hidden = $("input[type=hidden]", $(this).parent());
     var values = hidden.val().match(/border-radius:(.*?)px(.*?)px(.*?)px(.*?)px;/);
     var i = 1;
     $('input[type=text]', $(this).parent()).each(function(){
        if ($(this).attr('name')!=null) {
          $(this).val(values[i]);
          i++;
        }
     });
  });
  /*BorderRadius end*/    
  
  $('img.ordering').click(function() {
    $(this).next().submit();
  });
  
  /*
    Colorpicker Start
    Msg: Keyup event triggers the color change!
  */
  $('.wpdreamsColorPicker .wpdreamscolorpicker').click( function(e) {
      colorPicker = $(this).next('div');
      input = $(this).prev('input');
      $(colorPicker).farbtastic(input);
      colorPicker.show();
      var inputPos = input.position();
      colorPicker.css("left",inputPos.left);
      e.preventDefault();
      $(document).mousedown( function() {
          $(colorPicker).hide();
          $(input).val($(input).val());
          $(input).trigger('change');
          $(input).trigger('keyup');
      });
  });
  $('.wpdreamsColorPicker .triggerer').bind('click', function(){
     var parent = $(this).parent();
     var input = $('input[type=text]', parent);
     input.trigger("keyup");
  });  
  //Colorpicker End


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
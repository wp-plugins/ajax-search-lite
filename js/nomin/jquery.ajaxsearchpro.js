(function( $ ){  
  var methods = {
     init : function( options ) {      
       var $this =  $.extend({}, this, methods); 
       $this.searching = false;
       $this.o = $.extend({}, options);
       $this.n = new Object();
       $this.n.container = $(this);
       $this.n.probox = $('.probox', this);
       $this.n.proinput = $('.proinput', this);
       $this.n.text = $('.proinput input', this);
       $this.n.loading = $('.proinput .loading', this);
       $this.n.proloading = $('.proloading', this);
       $this.n.promagnifier = $('.promagnifier', this);
       $this.n.prosettings = $('.prosettings', this);
       $this.n.searchsettings = $('.searchsettings', this);
       $this.n.resultsDiv = $(this).next();
       $this.n.items = $('.item', $this.n.resultsDiv);
       $this.n.results =  $('.results', $this.n.resultsDiv);
       $this.n.resdrg =  $('.resdrg', $this.n.resultsDiv);
       $this.n.drag = $('.resdrg', $this.n.resultsDiv);
       $this.n.scrollbar = $(".scrollbar", $this.n.resultsDiv);
       
       //$this.cleanUp();
           
       $this.n.resultsDiv.appendTo("body");
       $this.n.searchsettings.appendTo("body");
       
       if ( $.browser.msie && $.browser.version<9 ) {
          $this.n.searchsettings.addClass("ie78");
       }

       $this.n.resultsDiv.css({
        opacity: 0
       });
       $(document).bind("click", function(){
          $this.hideResults();
          $this.hideSettings();
       });
       $(this).bind("click", function(e){
          e.stopImmediatePropagation();
       });
       $this.n.resultsDiv.bind("click", function(e){
          e.stopImmediatePropagation();
       });
       $this.n.searchsettings.bind("click", function(e){
          e.stopImmediatePropagation();
       });
       /*$this.scroll = $this.n.results.mCustomScrollbar({
          scrollButtons:{ 
            enable:true, 
            scrollType:"pixels", 
            scrollSpeed:parseInt($this.o.resultitemheight), 
            scrollAmount:parseInt($this.o.resultitemheight)
          },
          callbacks:{
            onScroll:function(){
                if (is_touch_device()) return;
                var top = parseInt($('.mCSB_container', $this.n.results).position().top);
                scr = ((((top%($this.o.resultitemheight+3))-top)==0 && (Math.abs(top)%($this.o.resultitemheight+3))<($this.o.resultitemheight/2+3))?'first':(-(Math.abs(top)%($this.o.resultitemheight+3))-top ));
                if ((Math.abs(top)%($this.o.resultitemheight+3))>($this.o.resultitemheight/2)) {
                  if (scr!='first') scr+=($this.o.resultitemheight+3);
                  $(".mCSB_container", $this.n.resultsDiv).animate({
                    top: -scr
                  });
                } else { 
                  $(".mCSB_container", $this.n.resultsDiv).animate({
                    top: -scr
                  }); 
                }
            }
          }
       }); */
       
       $this.n.prosettings.click(function(){
          if ($this.n.prosettings.attr('opened')==0) {
            $this.showSettings();
          } else {
            $this.hideSettings();          
          }
       });
           
       var t;
       $(window).bind("resize", function(){
           $this.resize();
       });
       $(window).bind("scroll", function() {
           $this.scrolling(false);
       });
       $(window).trigger('resize');
       $(window).trigger('scroll');
       $this.n.promagnifier.click(function(){
         clearTimeout(t);
         t = setTimeout (function() {
          $this.search();
          t = null;
         }, 700);
       });
       $this.n.text.keyup(function(){
         $this.n.promagnifier.trigger('click'); 
       });

       return $this;
     },
     destroy : function( ) {
       return this.each(function(){
         var $this =  $.extend({}, this, methods);
         $(window).unbind($this);
       })
     },
     searchfor: function(phrase) {
        $(".proinput input",this).val(phrase).trigger("keyup");
     },
     search : function() {
        var $this =  $.extend({}, this, methods);
        if ($this.searching && 0) return;
        if ($this.n.text.val().length<$this.o.charcount) return;
        $this.searching = true;
        $this.n.proloading.css({
           visibility: "visible"
        });
        $this.hideSettings();
        $this.hideResults();
        var data = {
      	  action: 'ajaxsearchlite_search',
          s: $this.n.text.val(),
          options: $('form' ,$this.n.searchsettings).serialize()  
      	};
      	jQuery.post(ajaxsearchpro.ajaxurl, data, function(response) {
          $this.n.resdrg.html("");
          if (response.nores!=null && response.keywords!=null) {
            var str = $this.o.noresultstext+" "+$this.o.didyoumeantext+"<br>";
            for(var i=0;i<response.keywords.length;i++) {
              str = str + "<span class='keyword'>"+response.keywords[i]+"</span>";
            }
            $this.n.resdrg.append("<div class='nores'>"+str+"</div>");
            $(".keyword", $this.n.resdrg).bind('click', function(){
               $this.n.text.val($(this).html());
               $this.n.promagnifier.trigger('click');
            });
          } else if (response.length>0) {
            for(var i=0;i<response.length;i++) {
                var imageDiv = "";
                var desc = "";
                var authorSpan = "";
                var dateSpan = "";
                if (response[i].image!=null && response[i].image!="") {
                  imageDiv = "\
                       <div class='image' style='width:"+$this.o.imagewidth+"px;height:"+$this.o.imageheight+"px;'>\
                        <img src='"+response[i].image+"'> \
                        </div>";
                }
                if ($this.o.showauthor==1) {
                  authorSpan = "<span class='author'>"+response[i].author+"</span>"; 
                }
                if ($this.o.showdate==1) {
                  dateSpan = "<span class='date'>"+response[i].date+"</span>";
                }
                if ($this.o.showdescription==1) {
                  desc = response[i].content;
                }                
                var id = 'item_'+i;
                var clickable = ""
                if ($this.o.resultareaclickable==1) {
                  clickable = "<span class='overlap'></span>";
                }
                var result = "\
                     <div class='item' id='"+id+"' style='height:"+$this.o.resultitemheight+"px;'> \
                      "+imageDiv+" \
                      <div class='content' style='height:"+$this.o.resultitemheight+"px;'> \
                        <h3><a href='"+response[i].link+"'>"+response[i].title+clickable+"</a></h3>   \
                                <div class='etc'>"+authorSpan+" \
                                "+dateSpan+"</div> \
                        <p class='desc'>"+desc+"</p>        \
                      </div>     \
                      <div class='clear'></div>   \
                     </div>";
                result = $(result);
                $this.n.resdrg.append(result);
                
            }
          } else {
            $this.n.resdrg.append("<div class='nores'>"+$this.o.noresultstext+"</div>");
          }
          $this.n.items = $('.item', $this.n.resultsDiv);
          $this.showResults();
          $this.n.proloading.css({
             visibility: "hidden"
          });  
      	}, "json"); 
     },
     showResults : function( ) {
        var $this =  $.extend({}, this, methods); 
        $this.scrolling(true);
        $this.n.resdrg.css({
          "position":"relative"
        });
        if ($this.n.items.length<=$this.o.itemscount) {
           $this.n.scrollbar.css({
              "display":"none"
           });
        } else {
           $this.n.scrollbar.css({
              "display":"inline"
           }); 
        }
        var top = $this.n.resultsDiv.position().top;
        $this.n.resultsDiv.css({
           "top": top-100,
           opacity: 0,
           visibility: "visible"
        }).animate({
           "top": top,
           opacity: 1
        });
        if ($this.n.items.length>0) {
          var count = (($this.n.items.length<$this.o.itemscount)?$this.n.items.length:$this.o.itemscount);
          $this.n.results.css({
            height: (count * $this.n.items.outerHeight(true)+3)
          });
          if ($this.o.highlight==1) {
            var wholew = (($this.o.highlightwholewords==1)?true:false);
            $this.n.resultsDiv.highlight($this.n.text.val().split(" "), { element: 'span', className: 'highlighted', wordsOnly: wholew });
          }
         
        } 
        $this.resize(); 
        if ($this.n.items.length==0) {
          var h = ($('.nores', $this.n.results).outerHeight(true)>($this.o.resultitemheight)?($this.o.resultitemheight):$('.nores', $this.n.results).outerHeight(true));
          $this.n.results.css({
            height: 11110
          }); 
          $this.n.results.css({
            height: $('.nores', $this.n.results).outerHeight(true)
          }); 
        }
        $this.scrolling(true);
        $this.searching = false;
          $this.n.resdrg.css({
            "position":"absolute"
          });
          $this.scroll = $this.n.resultsDiv.tinyscrollbar({ axis: 'y'});  
     },
     hideResults : function( ) {
        var $this =  $.extend({}, this, methods);
        $this.n.resultsDiv
        .animate({
           opacity: 0
        },{
          complete: function() {
            $(this).css({
              visibility: "hidden"
            });
          }
        });
     },
     showSettings : function( ) {
       var $this =  $.extend({}, this, methods);
       $this.scrolling(true);
       $this.n.searchsettings.css({
        opacity: 0,
        visibility: "visible",
        top: "-=50px"
       });
       $this.n.searchsettings.animate({
        opacity: 1,
        top: "+=50px"
       });
       $this.n.prosettings.attr('opened', 1);       
     },   
     hideSettings : function( ) {
       var $this =  $.extend({}, this, methods);
       $this.n.searchsettings.animate({
        opacity: 0
       }, {
        complete: function() {
          $(this).css({
            visibility: "hidden"
          });
        }
       });
       $this.n.prosettings.attr('opened', 0);
     },
     cleanUp: function( ) {
       var $this =  $.extend({}, this, methods);
       $('body>#ajaxsearchlitesettings').remove();
       $('body>#ajaxsearchliteres').remove();
     },  
     resize : function( ) {
       var $this =  $.extend({}, this, methods);
       $this.n.proinput.css({
          width: ($this.n.probox.width()-8-($this.n.proinput.outerWidth()-$this.n.proinput.width())-$this.n.proloading.outerWidth(true)-$this.n.prosettings.outerWidth(true)-$this.n.promagnifier.outerWidth(true)-10)
       });
       if ($this.n.prosettings.attr('opened')!=0) {
         $this.n.searchsettings.css({
           display: "block",
           top: $this.n.prosettings.offset().top+$this.n.prosettings.height()-2,
           left: $this.n.prosettings.offset().left+$this.n.prosettings.width()-$this.n.searchsettings.width() 
         });
       }
       if ($this.n.resultsDiv.css('visibility')!='hidden') {
         $this.n.resultsDiv.css({
            width: $this.n.container.width()-($this.n.resultsDiv.outerWidth(true)-$this.n.resultsDiv.width()),
            top: $this.n.container.offset().top+$this.n.container.outerHeight(true)+10,
            left: $this.n.container.offset().left
         }); 
         
         $('.content', $this.n.items).each(function(){
            var imageWidth = (($(this).prev().css('display')=="none")?0:$(this).prev().outerWidth(true));
            $(this).css({
             width: ($(this.parentNode).width()-$(this).prev().outerWidth(true)-$(this).outerWidth() + $(this).width())
            }); 
         });
        }   
     },
     scrolling: function(ignoreVisibility) {
       var $this =  $.extend({}, this, methods);
       if (ignoreVisibility==true || $this.n.searchsettings.css('visibility')=='visible') {
         $this.n.searchsettings.css({
           display: "block",
           top: $this.n.prosettings.offset().top+$this.n.prosettings.height()-2,
           left: $this.n.prosettings.offset().left+$this.n.prosettings.width()-$this.n.searchsettings.width() 
         });
       }
       if (ignoreVisibility==true || $this.n.resultsDiv.css('visibility')=='visible') {
         $this.n.resultsDiv.css({
            width: $this.n.container.width()-($this.n.resultsDiv.outerWidth(true)-$this.n.resultsDiv.width()),
            top: $this.n.container.offset().top+$this.n.container.outerHeight(true)+10,
            left: $this.n.container.offset().left
         }); 
         $('.content', $this.n.items).each(function(){
            var imageWidth = (($(this).prev().css('display')=="none")?0:$(this).prev().outerWidth(true));
            $(this).css({
             width: ($(this.parentNode).width()-$(this).prev().outerWidth(true)-$(this).outerWidth() + $(this).width())
            }); 
         });
       }
     }
  };

  $.fn.ajaxsearchpro = function( method ) {
    if ( methods[method] ) {
      return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } else if ( typeof method === 'object' || ! method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error( 'Method ' +  method + ' does not exist on jQuery.ajaxsearchpro' );
    }    
  
  };
	function is_touch_device(){
		return !!("ontouchstart" in window) ? 1 : 0;
	}
})( jQuery );

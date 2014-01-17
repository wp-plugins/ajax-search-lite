function loadFonts(family) {
  var fonts = new Array(
    'Allan:400,700',
    'Allerta:400,700',
    'Allerta+Stencil:400,700',
    'Anonymous+Pro:400,700',
    'Arimo:400,700',
    'Arvo:400,700',
    'Bentham:400,700',
    'Buda:400,700',
    'Cabin:400,700',
    'Calligraffitti:400,700',
    'Cantarell:400,700',
    'Cardo:400,700',
    'Cherry+Cream+Soda:400,700',
    'Chewy:400,700',
    'Coda:400,700',
    'Coming+Soon:400,700',
    'Copse:400,700',
    'Corben:400,700',
    'Cousine:400,700',
    'Covered+By+Your+Grace:400,700',
    'Crafty+Girls:400,700',
    'Crimson+Text:400,700',
    'Crushed:400,700',
    'Cuprum:400,700',
    'Droid+Sans:400,700',
    'Droid+Sans+Mono:400,700',
    'Droid+Serif:400,700',
    'Fontdiner+Swanky:400,700',
    'GFS+Didot:400,700',
    'GFS+Neohellenic:400,700',
    'Geo:400,700',
    'Gruppo:400,700',
    'Hanuman:400,700',
    'Homemade+Apple:400,700',
    'IM+Fell+DW+Pica:400,700',
    'IM+Fell+DW+Pica+SC:400,700',
    'IM+Fell+Double+Pica:400,700',
    'IM+Fell+Double+Pica+SC:400,700',
    'IM+Fell+English:400,700',
    'IM+Fell+English+SC:400,700',
    'IM+Fell+French+Canon:400,700',
    'IM+Fell+French+Canon+SC:400,700',
    'IM+Fell+Great+Primer:400,700',
    'IM+Fell+Great+Primer+SC:400,700',
    'Inconsolata:400,700',
    'Irish+Growler:400,700',
    'Josefin+Sans:400,700',
    'Josefin+Slab:400,700',
    'Just+Another+Hand:400,700',
    'Just+Me+Again+Down+Here:400,700',
    'Kenia:400,700',
    'Kranky:400,700',
    'Kristi:400,700',
    'Lato:400,700',
    'Lekton:400,700',
    'Lobster:400,700',
    'Luckiest+Guy:400,700',
    'Merriweather:400,700',
    'Molengo:400,700',
    'Mountains+of+Christmas:400,700',
    'Neucha:400,700',
    'Neuton:400,700',
    'Nobile:400,700',
    'OFL+Sorts+Mill+Goudy+TT:400,700',
    'Old+Standard+TT:400,700',
    'Orbitron:400,700',
    'PT+Sans:400,700',
    'PT+Sans+Caption:400,700',
    'PT+Sans+Narrow:400,700',
    'Permanent+Marker:400,700',
    'Philosopher:400,700',
    'Puritan:400,700',
    'Raleway:400,700',
    'Reenie+Beanie:400,700',
    'Rock+Salt:400,700',
    'Schoolbell:400,700',
    'Slackey:400,700',
    'Sniglet:400,700',
    'Sunshiney:400,700',
    'Syncopate:400,700',
    'Tangerine:400,700',
    'Tinos:400,700',
    'Ubuntu:400,700',
    'UnifrakturCook:400,700',
    'UnifrakturMaguntia:400,700',
    'Unkempt:400,700',
    'Vibur:400,700',
    'Vollkorn:400,700',
    'Walter+Turncoat:400,700',
    'Yanone+Kaffeesatz:400,700'
  );
  WebFontConfig = {
    google: { families: [family+":400,700"] }
  };
  (function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })();
}
(function($) {
$(document).ready(function() { 
  $(".wpdreamsfont").change(function() {    
     var weightNode = $('.wpdreams-fontweight:checked', this.parentNode)[0];
     $(weightNode).trigger('change');
     return; 
  });
  $(".color").change(function() {    
     var weightNode = $('.wpdreams-fontweight:checked', this.parentNode.parentNode)[0];
     $(weightNode).trigger('change');
     return;
  });
  $(".wpdreams-fontsize").change(function() {    
     var weightNode = $('.wpdreams-fontweight:checked', this.parentNode)[0];
     $(weightNode).trigger('change');
     return;
  });
  $(".wpdreams-lineheight").change(function() {
     var weightNode = $('.wpdreams-fontweight:checked', this.parentNode)[0];
     $(weightNode).trigger('change');
  });
  $('.wpdreams-fontweight').change(function() {
     var weight = "font-weight:"+jQuery(this).val()+";";
     var familyNode = $('.wpdreamsfont', this.parentNode)[0];
     var colorNode = $('.color', this.parentNode)[0];
     var sizeNode = $('.wpdreams-fontsize', this.parentNode)[0];
     var lhNode = $('.wpdreams-lineheight', this.parentNode)[0];
     
     var family = "font-family:"+jQuery(familyNode).val()+";";
     var color = "color:"+$(colorNode).val()+";";
     var size = "font-size:"+$(sizeNode).val()+";";
     var lh =  "line-height:"+$(lhNode).val()+";"; 
      
     loadFonts(jQuery(familyNode).val());   
     $("label", this.parentNode).css("font-family", $(familyNode).val());
     $("label", this.parentNode).css("font-weight", $(this).val());
     $("label", this.parentNode).css("color", $(colorNode).val());
     $("input[type=hidden]", this.parentNode).val("font-weight:"+$(this).val()+";"+family+color+size+lh);   
  });
  
  
  $(".wpdreamsFont>fieldset>.triggerer").click(function() {
      var parent = $(this).parent();
    
      var hidden = $('input[type=hidden]', parent);
      var val = hidden.val().replace(/(\r\n|\n|\r)/gm,"");
      var familyNode = $('.wpdreamsfont', parent)[0];
      var colorNode = $('.color', parent)[0];
      var sizeNode = $('.wpdreams-fontsize', parent)[0];
      var lhNode = $('.wpdreams-lineheight', this.parentNode)[0];
      
      $(familyNode).val(val.match(/family:(.*?);/)[1]);
      $(sizeNode).val(val.match(/size:(.*?);/)[1]); 
      $(colorNode).val(val.match(/color:(.*?);/)[1]);
      $(colorNode).spectrum('set', val.match(/color:(.*?);/)[1]);
      $(lhNode).val(val.match(/height:(.*?);/)[1]);   
  });
});  
}(jQuery));
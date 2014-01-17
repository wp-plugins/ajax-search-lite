(function($){
  $(document).ready(function() {
    $('.tabs a').click(function(e){
       e.preventDefault();
       var tid = $(this).attr('tabid');
       var tabsContent = $(this).parent().parent().next();
       tabsContent.children().each(function(){
          $(this).hide();
          if ($(this).attr('tabid')==tid) {
            $(this).fadeIn();
          }
       });
       $('a', $(this).parent().parent()).removeClass('current');
       $(this).addClass('current');
    });
    
  });
})(jQuery)
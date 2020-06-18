// sidenav open/close event handler
(function($){
  $(function(){

    $('.sidenav').sidenav();
  });
})(jQuery);

// error message close event handler
$('#message-close').click(function(){
  $( "#message-box" ).fadeOut( "slow", function() {
  });
});

// dropdown event handler
$('.dropdown-trigger').dropdown({
    coverTrigger: false,
    constrainWidth: false
    }
  );
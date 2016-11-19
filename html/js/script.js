$(function(){
 $(".has-sub-menu").click(function(){
        $(this).children(".sub-menu").toggle();
    });
 $('input#organisateur').attr('checked', true) 
 $("#organisateurform").show();
 $("#participantform").hide();
  $("input[name='choix']").on('change',function(){
  		$('#participantform').toggle()
  		$("#organisateurform").toggle();
    });

   $("a.resp-menu").click(function(){
        $(".resp-nav").toggle();
    });
});
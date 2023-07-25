$(document).ready(function(){
  $('.alternar a').click(function(){
    $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
  });
       });
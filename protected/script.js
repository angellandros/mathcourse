$(document).ready(function(){
  $("#main-motto").click(function(){
	$("#main-motto-pic").fadeOut(1000,function(){
	  $("#main-integrate-pic").fadeIn(1000);
	  $("#main-integrate-text").slideDown(1000);
	});
  });
});

document.getElementById("main-motto-pic").style.cursor="help";
var verticalScroll, backgroundPosition;

function frameSize(){
	$("#poll").height($("#poll").contents().find("html").height());
	$("#poll").css("overflow","hidden");
}

$(document).ready(function(){
	
	
	$(window).scroll(function(){
		verticalScroll = $(this).scrollTop();
		backgroundPosition = verticalScroll/1.5;
		$("body").css("background-position","right -"+String(backgroundPosition)+"px");
	});
	
});
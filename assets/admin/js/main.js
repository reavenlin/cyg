
$(function(){
	$("#side_switch").click(function(){
		$(".left").hide();
		$("#mainFrame").contents().find(".right_body").css('margin-left',10);
		$(this).hide();
		$("#side_switchl").show();
	});
	$("#side_switchl").click(function(){
		$(".left").show();
		$("#mainFrame").contents().find(".right_body").css('margin-left',200);
		$(this).hide();
		$("#side_switch").show();
	});
	$("ul.side>li>a").click(function(){
		$("ul.side>li>a").removeClass("selected");
		$(this).addClass("selected");
	});
});

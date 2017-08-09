$(document).ready(function(){
	$('select').material_select();
	/*For 0.00*/
	/*$('input.p002').blur(function(){
		if($(this).val() == "" || $(this).val() == "."){
			$(this).val("0.00")
		}
		var num = parseFloat($(this).val());
		var cleanNum = num.toFixed(2);
		$(this).val(cleanNum);
		
	});*/
	$('input.np0,input.p00').blur(function(){
		if($(this).val() == ""){
			$(this).val("0")
		}
		/*var num = parseFloat($(this).val());
		var cleanNum = num.toFixed(2);
		$(this).val(cleanNum);*/
		
	});
	
	$("input.np0,input.p00").on("keypress", function(evt) {
		var keycode = evt.charCode || evt.keyCode;
		if (keycode == 46) {
			return false;
		}
	});
	
	$(".nave").sideNav();
	 

});


$(window).on("load resize", function(){
	var winHeight = $(window).outerHeight();
	var headerHeight = $("#header").outerHeight();
	var footerHeight = $("#footer").outerHeight();	
	var dchHeight = $(".de-header").outerHeight();
	var fcfHeight = $(".field-container-footer").outerHeight();	
	var hfHeight = headerHeight + footerHeight;
	var contHeight = winHeight - hfHeight - dchHeight - fcfHeight - 5;
	$(".field-container").height(contHeight);

	$(".field-container").mCustomScrollbar({
        axis:"y"
    });

});

$("input").keypress(function (e) {
    if (e.which == 13 || e.keyCode == 13) {
        return false;
    }else{
    	return true;
    }
});




var inputReadOnly = 'input[readonly=readonly]';
$(inputReadOnly).hover(
function() {
	$(this).css({"background":"#fe6c6c"})	    
},
function() {
	$(this).css({"background":"transparent"})		  
});
$(inputReadOnly).on('focus',function () {
	$(this).css({"background":"#fe6c6c"})
});
$(inputReadOnly).on('blur',function () {
	$(this).css({"background":"transparent"})
});


(function($){
var totalCount = 4;
function ChangeIt()
{
var num = Math.ceil( Math.random() * totalCount );
$('body.log-body').css({"background-image":"url(images/log-bg"+num+".jpg)" });
}
ChangeIt();
})(jQuery);

function equalHeightImage(group) {
	tallest = 0;
	group.each(function() {
		thisHeight = $(this).height();
		if(thisHeight > tallest) {
			tallest = thisHeight;
		}
	});
	group.height(tallest);
}
$(document).ready(function() {
	equalHeightImage($(".landing-ico-box figure"));
});	
$(window).bind('load resize ', function() {
	equalHeightImage(group);	
})

equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
 $(container).each(function() {

   $el = $(this);
   $($el).height('auto')
   topPostion = $el.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}
$(window).on('load resize ', function() {
	equalheight('.landing-ico-box');	
})

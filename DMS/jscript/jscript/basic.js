/* JCarousel Settings */
$(document).ready(function() { 
    $("#portfolio .portfolio-show").jCarouselLite({
        btnNext: ".next",
        btnPrev: ".prev",
        visible:1,
        scroll:1,
        circular: true,
        speed:300
    });
});

/* Rollover function */
/*if (!$.browser.msie) {*/

	$(function() {
		$("img.rollover").hover(
			function () {
	 				this.src = this.src.replace("_off","_on");
				},
			function () {
	 				this.src = this.src.replace("_on","_off");
			}
		);
	});
/*}*/
/* Fade In / Out Function */
$(function() {
	$('#portfolio #content li div.movable').hover(
		function (){
			$(this).find("img").fadeOut("slow");	
			$(this).find("dl").fadeIn("slow");	
		}, 
		function (){			
			$(this).find("dl").fadeOut("slow");
			$(this).find("img").fadeIn("slow");
		}
	);
});

$(function() {
	$('#portfolio #content li div.construction').hover(
	function () {		
		var fade = $(this);
		fade.find(".image img").fadeOut("slow");
		fade.find(".image .overlay").fadeIn("slow");
	}, 
	function () {
		var fade = $(this);
		fade.find(".image .overlay").fadeOut("slow", function() {
			fade.find(".image img").fadeIn("slow");		
		});		
	});	
});

/* Form handling functions */

function clear_text(elm) {
	if (elm.value == elm.defaultValue) elm.style.color = '#000';
	if (elm.value == elm.defaultValue) elm.value='';	
}

function remake_text(elm) {
	elm.value = elm.value || elm.defaultValue; 
	if (elm.value == elm.defaultValue) elm.style.color = '#999';
}

/* Image Preloader */

jQuery.preloadImages = function() {
  for(var i = 0; i<arguments.length; i++) {
  	jQuery("<img>").attr("src", arguments[i]);
  }
}

$.preloadImages("/javascripts/itc_cond_m.swf", "/images/caps_pic.jpg", "/images/production_pic.jpg", "/images/read_pic.jpg", "/images/syn_pic.jpg", "/images/walter_pic.jpg", "/images/right_arrow_off.gif", "/images/left_arrow_off.gif", "/images/right_arrow_on.gif", "/images/left_arrow_on.gif", "/images/our_advantage.gif", "/images/what_we_can_do_for_you.gif");
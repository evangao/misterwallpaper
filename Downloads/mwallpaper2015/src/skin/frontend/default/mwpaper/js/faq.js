
jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery(".mw-collapse-content").css("display","none");
	jQuery(".mw-collapse-control").css("cursor","pointer");
	//jQuery('.mw-collapse-control').bind('click', function(this) {
	//jQuery(this).next(".mw-collapse-content").toggle();

	jQuery(".mw-collapse-control").click(function() {
    	jQuery(this).next(".mw-collapse-content").slideToggle("slow");
		
	});


	//});
});

function movetop(){
jQuery("html, body").animate({ scrollTop: 0 }, "slow");
  return false;


} 


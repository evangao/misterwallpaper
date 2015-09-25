var $j = jQuery.noConflict();

$j(document).ready(function(){
        //Examples of how to assign the Colorbox event to elements
       
        $j(".group4").colorbox({rel:'group4', slideshow:true,maxWidth:"90%",maxHeight:"90%",fixed:true,innerWidth:"90%",innerHeight:"90%",slideshowSpeed:5000});
        //$j('.group4').first().trigger('click');
});

function playSlideshow()
{

    $j('.group4').first().trigger('click');
    
}
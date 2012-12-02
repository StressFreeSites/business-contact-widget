jQuery('document').ready(function($) {
    $('#bcw-tabs').tabs();
    // jQuery('.greyscale').grayscale();
    
    // fade in the grayscaled images to avoid visual jump        
    $('.greyscale').hide().fadeIn(10);  
});

jQuery(window).load(function($) {
    jQuery('.greyscale').greyScale({
        // call the plugin with non-defult fadeTime (default: 400ms)
        fadeTime: 100,
        reverse: false
    }); 
});
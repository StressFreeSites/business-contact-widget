jQuery('document').ready(function($) {
    var openTab = $('#bcw_openTab').val();
    var active = openTab - 1;
    
    $('#bcw-tabs').tabs({
                    active: active
                });
    // jQuery('.greyscale').grayscale();
    
    // fade in the grayscaled images to avoid visual jump        
    $('.greyscale').hide().fadeIn(5);
    
});

jQuery(window).load(function($) {
    jQuery('.greyscale').greyScale({
        // call the plugin with non-defult fadeTime (default: 400ms)
        fadeTime: 50,
        reverse: false
    }); 
});
jQuery('document').ready(function($) {
    var openTab = $('.business-contact .bcw-tabs_openTab').val();
    var active = openTab - 1;
    
    $('.business-contact .bcw-tabs').tabs({
                    active: active
                });

    $('.business-contact .bcw-tabs .ui-tabs-nav li').hover(
        function () {
            $('img.grey', this).hide('slow');
          },
          function () {
            $('img.grey', this).show('slow');
          }
    );
    
    // only show business contact when all loaded
    $('.business-contact .preloader').css('display', 'none');
    $('.business-contact .bcw-tabs').css('display', 'block');  
});
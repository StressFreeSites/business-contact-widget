jQuery('document').ready(function($) {
    var openTab = $('#bcw_openTab').val();
    var active = openTab - 1;
    
    $('#bcw-tabs').tabs({
                    active: active
                });

    $('#bcw-tabs .ui-tabs-nav li').hover(
        function () {
            $('img.grey', this).hide('slow');
          },
          function () {
            $('img.grey', this).show('slow');
          }
      );
   
    });
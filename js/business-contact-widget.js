/*  Copyright 2014 StressFree Sites  (info@stressfreesites.co.uk : alex@stressfreesites.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 3, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

jQuery('document').ready(function($) {
    var openTab = $('.business-contact .bcw-open-tab').val();
    var active = openTab - 1;
    
    // Fix to make tabs combatible with Wordpress customizer mode
    var makeTabs = function(selector, active) {
        $( selector )
            .find( "ul a" ).each( function() {
                var href = $( this ).attr( "href" ),
                    newHref = window.location.protocol + '//' + window.location.hostname +
                        window.location.pathname + window.location.search + href;

                if ( href.indexOf( "#" ) == 0 ) {
                    $( this ).attr( "href", newHref );
                }
            })
        $( selector ).tabs({
            active: active
        });
    };

    makeTabs('.business-contact .bcw-tabs', active);

//    $('.business-contact .bcw-tabs').tabs({
//            active: active
//    });

    // Fade out all icons apart from the active one 
    $('.business-contact .bcw-tabs .ui-tabs-nav li').not('.ui-state-active').find('img.colour').animate({
       opacity: 0
    }, 'slow' );

    // Make the icon display the coloured icon on hover
    $('.business-contact .bcw-tabs .ui-tabs-nav li').hover(
        function () {
            showColour($(this), 'slow');
        },
        function () {
            hideColour($(this), 'slow');
        });
    
    // Make the previous icon grey
    $('.business-contact .bcw-tabs .ui-tabs-nav').mouseup(function () {
            setTimeout(function(){
                hideColour($('.business-contact .bcw-tabs .ui-tabs-nav li'), 'fast');
            }, 100);
        });  
    
    // Reload Google map on map tab mouse press down
    $('.business-contact .bcw-tabs .ui-tabs-nav .tab-map').mousedown(function() { 
        //Check if its clicked once or else will reload iframe on every click
        if(!$('.business-contact .bcw-tabs #bcw-map').find('iframe').hasClass('hovered')){
            
            $('.business-contact .bcw-tabs #bcw-map').find('iframe').attr('src', function (i, val) { return val; });
            
            // add any class to say its clicked
            $('.business-contact .bcw-tabs #bcw-map').find('iframe').addClass('hovered'); 
        }
    });
    
    // Only show business contact when all loaded 
    $('.business-contact .preloader').hide('fast');
    $('.business-contact .bcw-tabs').show('fast');  
});

jQuery(window).load(function() {
    var tabDirection = jQuery('.business-contact .bcw-tab-direction').val();
    
    // Once loaded, dynamically change the width
    if(tabDirection === 'Vertical'){
        jQuery('.business-contact .bcw-tabs').addClass('ui-tabs-vertical ui-helper-clearfix');
        jQuery('.business-contact .bcw-tabs li').removeClass('ui-corner-top').addClass('ui-corner-left');

        // Dynamically setting the width of the content panels to fit the space
        var width = jQuery('.business-contact .bcw-tabs').width() - jQuery('.business-contact .bcw-tabs .ui-tabs-nav li').width() - 14;
        jQuery('.business-contact .bcw-tabs .ui-tabs-panel').width(width);
    }
});

function showColour(selector, animation) {
    selector.find('img.colour').animate({
        opacity: 1
    }, 'slow', function() {
        selector.parent('a.ui-tabs-anchor').find('img.grey').animate({opacity: 0}, animation);
    });    
}

function hideColour(selector, animation) {
    selector.not('.ui-state-active').find('img.colour').stop();
    selector.not('.ui-state-active').find('img.grey').stop();
    selector.not('.ui-state-active').find('img.grey').css('opacity','1');
    selector.not('.ui-state-active').find('img.colour').animate({
        opacity: 0
    }, animation);    
}
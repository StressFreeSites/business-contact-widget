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
    $('#accordion').accordion({
            active: false,
            collapsible: true,
            heightStyle: "content"
    });
    
    var height = 0,
        footerBoxes = $('#bcw-footer .box');
    
    $.each(footerBoxes, function (index, footerBox) {
        if($(footerBox).height() > height) {
            height = $(footerBox).height();
        };
    });
    $('#bcw-footer .box').height(height);
});
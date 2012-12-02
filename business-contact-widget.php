<?php
/*
Plugin Name: Business Contact Widget
Plugin URI: http://stressfreesites.co.uk/plugins/business-contact-widget
Description: This plugin creates a widget which easily displays, without becoming cluttered, all the business contact details of a company/organisation.
Version: 1.0
Author: StressFree Sites
Author URI: http://stressfreesites.co.uk
License: GPL2
*/

/*  Copyright 2012 StressFree Sites  (info@stressfreesites.co.uk : alex@stressfreesites.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Localisation of text */
function bcw_init() {
  load_plugin_textdomain( 'bcw-language', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action('plugins_loaded', 'bcw_init');

function bcw_enqueue_scripts() {       
    /* Load custom scripts */
    wp_enqueue_script('greyscale', plugins_url('business-contact-widget/js/greyscale.js'), array('jquery'),'1.0',true);
    wp_enqueue_script('jquery-business-contact-widget-load', plugins_url('business-contact-widget/js/business-contact-widget-jquery-load.js'), array('jquery','jquery-ui-core','jquery-ui-tabs','greyscale'),'1.0',true); 
}    
add_action('wp_enqueue_scripts', 'bcw_enqueue_scripts');

function bcw_enqueue_styles() { 
    /* Load custom styling */
    wp_enqueue_style('jquery-ui-style', plugins_url('business-contact-widget/css/jquery-ui.css')); 
    wp_enqueue_style('business-contact-widget-style', plugins_url('business-contact-widget/css/business-contact-widget-style.css'), array('jquery-ui-style')); 
} 
add_action('wp_print_styles', 'bcw_enqueue_styles');

class Business_Contact_Widget extends WP_Widget {
    function Business_Contact_Widget() {
            /* Widget settings. */
            $widget_ops = array('classname' => 'contact', 'description' => 'A widget which clearly displays business contact details for sidebar.');

            /* Widget control settings. */
            $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'business-contact-widget');

            /* Create the widget. */
            $this->WP_Widget('business-contact-widget', 'Business Contact Widget', $widget_ops, $control_ops);
    }
    
    /* Displays widget on website */
    function widget($args, $instance) {
            extract($args);

            /* User-selected settings. */
            $title = apply_filters('widget_title', $instance['title']);
            $telephone = $instance['telephone'];
            $fax = $instance['fax'];
            $mobileName = $instance['mobileName'];
            $mobileNo = $instance['mobileNo'];
            $mobileName2 = $instance['mobileName2'];
            $mobileNo2 = $instance['mobileNo2'];
            $mobileName3 = $instance['mobileName3'];
            $mobileNo3 = $instance['mobileNo3'];
            $otherTelephoneName = $instance['otherTelephoneName'];
            $otherTelephoneNo = $instance['otherTelephoneNo'];
            $email = $instance['email'];
            $personalEmailName = $instance['personalEmailName'];
            $personalEmail = $instance['personalEmail'];
            $personalEmailName2 = $instance['personalEmailName2'];
            $personalEmail2 = $instance['personalEmail2'];
            $personalEmailName3 = $instance['personalEmailName3'];
            $personalEmail3 = $instance['personalEmail3'];
            $otherEmailName = $instance['otherEmailName'];
            $otherEmail = $instance['otherEmail'];            
            $address = $instance['address'];
            $showMap = isset($instance['showMap']) ? $instance['showMap'] : false;
            $map = $instance['map'];
            $openingTimes = $instance['openingTimes'];
            $contact = $instance['contact'];
            $createdBy = isset($instance['createdBy']) ? $instance['createdBy'] : false;

            /* Before widget (defined by themes). */
            echo $before_widget .'<div class="business-contact">';

            /* Title of widget (before and after defined by themes). */
            if ($title)
                    echo $before_title . $title . $after_title;
            
            /* Tab headers */
            echo ('<div id="bcw-tabs"><ul>');
            
            if ($telephone || $fax || $mobileNo || $mobileNo2 || $mobileNo3 || $otherTelephoneNo)
                    echo ('<li><a href="#bcw-telephone"><img src="' . plugins_url('business-contact-widget/images/telephone.png') . '" class="greyscale"/></a></li>');

            if ($email || $personalEmail || $personalEmail2 || $personalEmail3 || $otherEmail)
                    echo ('<li><a href="#bcw-email"><img src="' . plugins_url('business-contact-widget/images/email.png') . '" class="greyscale"/></a></li>');
            
            if ($address || $showMap)
                    echo ('<li><a href="#bcw-address"><img src="' . plugins_url('business-contact-widget/images/address.png') . '" class="greyscale"/></a></li>');
            
            if ($openingTimes)
                    echo ('<li><a href="#bcw-clock"><img src="' . plugins_url('business-contact-widget/images/clock.png') . '" class="greyscale"/></a></li>');
            
            if ($contact)
                    echo ('<li class="contact-tab"><a href="' . $contact . '" target="_blank">' . __('Contact', 'bcw-language') . ':</a></li>');

            echo ('</ul>');
            
            /* Tab body content */    
            if ($telephone || $fax || $mobileNo || $mobileNo2 || $mobileNo3 || $otherTelephoneNo){
                    echo ('<div id="bcw-telephone">');
                    
                    if ($telephone)
                        echo ('<p><strong>' . __('Telephone', 'bcw-language') . ':</strong> ' . $telephone . '</p>');
                    
                    if ($fax)
                        echo ('<p><strong>' . __('Fax', 'bcw-language') . ':</strong> ' . $fax . '</p>');
                    
                    if ($mobileNo)
                        echo ('<p><strong>' . $mobileName . '\'s ' . __('Mobile', 'bcw-language') . ':</strong> ' . $mobileNo . '</p>');

                    if ($mobileNo2)
                        echo ('<p><strong>' . $mobileName2 . '\'s ' . __('Mobile', 'bcw-language') . ':</strong> ' . $mobileNo2 . '</p>');
                    
                    if ($mobileNo3)
                        echo ('<p><strong>' . $mobileName3 . '\'s ' . __('Mobile', 'bcw-language') . ':</strong> ' . $mobileNo3 . '</p>');
                    
                    if ($otherTelephoneNo)
                        echo ('<p><strong>' . $otherTelephoneName . ':</strong> ' . $otherTelephoneNo . '</p>');
                    
                    echo ('</div>');
            }
            
            if ($email || $personalEmail || $personalEmail2 || $personalEmail3 || $otherEmail){
                echo ('<div id="bcw-email">');
                
                if ($email)
                        echo ('<p><strong>' . __('Email', 'bcw-language') . ':</strong> <a href="mailto:'.$email.'">' . $email . '</a></p>');
 
                if ($personalEmail)
                        echo ('<p><strong>' . $personalEmailName . '\'s ' . __('Email', 'bcw-language') . ':</strong> <a href="mailto:' . $personalEmail . '">' . $personalEmail . '</a></p>');

                if ($personalEmail2)
                        echo ('<p><strong>' . $personalEmailName2 . '\'s ' . __('Email', 'bcw-language') . ':</strong> <a href="mailto:' . $personalEmail2 . '">' . $personalEmail2 . '</a></p>');
 

                if ($personalEmail3)
                        echo ('<p><strong>' . $personalEmailName3 . '\'s ' . __('Email', 'bcw-language') . ':</strong> <a href="mailto:' . $personalEmail3 . '">' . $personalEmail3 . '</a></p>');
 

                if ($otherEmail)
                        echo ('<p><strong>' . $otherEmailName . __('Email', 'bcw-language') . ':</strong> <a href="mailto:'.$otherEmail.'">' . $otherEmail . '</a></p>');
 
                echo ('</div>');
            }
            
            if ($address || $showMap){
                    echo ('<div id="bcw-address">');
                    
                    if ($address)
                            echo ('<p><strong>' . __('Address', 'bcw-language') . ':</strong><br/>' . $address . '</a></p>');

                    /* Show map */
                    if ($showMap)
                            echo ('<p><strong>' . __('Map', 'bcw-language') . ':</strong><br/>' . $map . '</p>');

                    echo ('</div>');
            }
            
            if ($openingTimes)
                    echo ('<div id="bcw-clock"><p><strong>' . __('Opening Times', 'bcw-language') . ':</strong><br/> ' . $openingTimes . '</a></p></div>');
  
            echo ('</div>');
            
            /* Copyright */
            if ($createdBy){
                    echo ('<div class="small"><p>' . __('Plugin created by', 'bcw-language') . '<a href="http://stressfreesites.co.uk/plugins/business-contact-widget" target="_blank">StressFree Sites</a></p></div>');
            }    
            
            /* After widget (defined by themes). */
            echo '</div>'.$after_widget;
    }

    /* Updating the Wordpress backend */
    function update($new_instance, $old_instance) {
            $instance = $old_instance;

            /* Strip tags (if needed) and update the widget settings. */
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['telephone'] = strip_tags($new_instance['telephone']);
            $instance['fax'] = strip_tags($new_instance['fax']);
            $instance['mobileName'] = strip_tags($new_instance['mobileName']);
            $instance['mobileNo'] = strip_tags($new_instance['mobileNo']);
            $instance['mobileName2'] = strip_tags($new_instance['mobileName2']);
            $instance['mobileNo2'] = strip_tags($new_instance['mobileNo2']);
            $instance['mobileName3'] = strip_tags($new_instance['mobileName3']);
            $instance['mobileNo3'] = strip_tags($new_instance['mobileNo3']);
            $instance['otherTelephoneName'] = strip_tags($new_instance['otherTelephoneName']);
            $instance['otherTelephoneNo'] = strip_tags($new_instance['otherTelephoneNo']);
            $instance['email'] = strip_tags($new_instance['email']);
            $instance['personalEmailName'] = strip_tags($new_instance['personalEmailName']);
            $instance['personalEmail'] = strip_tags($new_instance['personalEmail']);
            $instance['personalEmailName2'] = strip_tags($new_instance['personalEmailName2']);            
            $instance['personalEmail2'] = strip_tags($new_instance['personalEmail2']);
            $instance['personalEmailName3'] = strip_tags($new_instance['personalEmailName3']);            
            $instance['personalEmail3'] = strip_tags($new_instance['personalEmail3']); 
            $instance['otherEmailName'] = strip_tags($new_instance['otherEmailName']);
            $instance['otherEmail'] = strip_tags($new_instance['otherEmail']);
            $instance['address'] = nl2br(strip_tags($new_instance['address']));
            $instance['showMap'] = $new_instance['showMap'];
            $instance['map'] = $new_instance['map'];
            $instance['openingTimes'] = nl2br(strip_tags($new_instance['openingTimes']));
            $instance['contact'] = strip_tags($new_instance['contact']);
            $instance['createdBy'] = $new_instance['createdBy'];        
            return $instance;
    }
    
    /* Form for the Wordpress backend */
    function form($instance) {
            /* Set up some default widget settings. */
            $defaults = array('title' => 'Contact', 
                              'telephone' => '', 'fax' => '', 'mobileName' => '', 'mobileNo' => '', 'mobileName2' => '', 'mobileNo2' => '', 'mobileName3' => '', 'mobileNo3' => '', 'otherTelephoneName' => '', 'otherTelephoneNo' => '', 
                              'email' => '', 'personalEmailName' => '', 'personalEmail' => '', 'personalEmailName2' => '', 'personalEmail2' => '', 'personalEmailName3' => '', 'personalEmail3' => '', 'otherEmailName' => '', 'otherEmail' => '',
                              'address' => '', 'showMap' => 'on', 'map' => '<iframe width="220" height="220" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.uk/maps?client=safari&amp;oe=UTF-8&amp;q=London&amp;ie=UTF8&amp;hq=&amp;hnear=London,+United+Kingdom&amp;gl=uk&amp;t=m&amp;z=11&amp;ll=51.507335,-0.127683&amp;output=embed"></iframe>', 
                              'openingTimes' => '', 
                              'contact' => '', 'createdBy' => 'off');
            $instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
                <p>
			<label for="<?php echo $this->get_field_id('telephone'); ?>"><?php _e('Telephone', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('telephone'); ?>" name="<?php echo $this->get_field_name('telephone'); ?>" value="<?php echo $instance['telephone']; ?>" style="width:100%;" />
		</p>
                <p>
			<label for="/<?php echo $this->get_field_id('fax'); ?>"><?php _e('Fax', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('fax'); ?>" name="<?php echo $this->get_field_name('fax'); ?>" value="<?php echo $instance['fax']; ?>" style="width:100%;" />
		</p>
                <p>
			<label for="<?php echo $this->get_field_id('mobileName'); ?>"><?php _e('Mobile Person\'s Name', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('mobileName'); ?>" name="<?php echo $this->get_field_name('mobileName'); ?>" value="<?php echo $instance['mobileName']; ?>" style="width:100%;" />
			<label for="<?php echo $this->get_field_id('mobileNo'); ?>"><?php _e('Their Mobile Number', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('mobileNo'); ?>" name="<?php echo $this->get_field_name('mobileNo'); ?>" value="<?php echo $instance['mobileNo']; ?>" style="width:100%;" />

                </p>
                <p>
			<label for="<?php echo $this->get_field_id('mobileName2'); ?>"><?php _e('2nd Mobile Person\'s Name', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('mobileName2'); ?>" name="<?php echo $this->get_field_name('mobileName2'); ?>" value="<?php echo $instance['mobileName2']; ?>" style="width:100%;" />
			<label for="<?php echo $this->get_field_id('mobileNo2'); ?>"><?php _e('Their Mobile Number', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('mobileNo2'); ?>" name="<?php echo $this->get_field_name('mobileNo2'); ?>" value="<?php echo $instance['mobileNo2']; ?>" style="width:100%;" />

                </p>
                <p>
			<label for="<?php echo $this->get_field_id('mobileName3'); ?>"><?php _e('3rd Mobile Person\'s Name', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('mobileName3'); ?>" name="<?php echo $this->get_field_name('mobileName3'); ?>" value="<?php echo $instance['mobileName3']; ?>" style="width:100%;" />
			<label for="<?php echo $this->get_field_id('mobileNo3'); ?>"><?php _e('Their Mobile Number', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('mobileNo3'); ?>" name="<?php echo $this->get_field_name('mobileNo3'); ?>" value="<?php echo $instance['mobileNo3']; ?>" style="width:100%;" />

                </p>
                <p>
			<label for="<?php echo $this->get_field_id('otherTelelphoneName'); ?>"><?php _e('Other Telephone Name', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('otherTelephoneName'); ?>" name="<?php echo $this->get_field_name('otherTelephoneName'); ?>" value="<?php echo $instance['otherTelephoneName']; ?>" style="width:100%;" />
			<label for="<?php echo $this->get_field_id('otherTelephoneNo'); ?>"><?php _e('Other Telephone Number', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('otherTelephoneNo'); ?>" name="<?php echo $this->get_field_name('otherTelephoneNo'); ?>" value="<?php echo $instance['otherTelephoneNo']; ?>" style="width:100%;" />

                </p>
                <p>
			<label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" value="<?php echo $instance['email']; ?>" style="width:100%;" />
		</p>
                <p>
			<label for="<?php echo $this->get_field_id('personalEmailName'); ?>"><?php _e('Personal Email Name', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('personalEmailName'); ?>" name="<?php echo $this->get_field_name('personalEmailName'); ?>" value="<?php echo $instance['personalEmailName']; ?>" style="width:100%;" />
			<label for="<?php echo $this->get_field_id('personalEmail'); ?>"><?php _e('Personal Email Address', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('personalEmail'); ?>" name="<?php echo $this->get_field_name('personalEmail'); ?>" value="<?php echo $instance['personalEmail']; ?>" style="width:100%;" />
                </p>
                <p>
			<label for="<?php echo $this->get_field_id('personalEmailName2'); ?>"><?php _e('2nd Personal Email Name', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('personalEmailName2'); ?>" name="<?php echo $this->get_field_name('personalEmailName2'); ?>" value="<?php echo $instance['personalEmailName2']; ?>" style="width:100%;" />
			<label for="<?php echo $this->get_field_id('personalEmail2'); ?>"><?php _e('2nd Personal Email Address', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('personalEmail2'); ?>" name="<?php echo $this->get_field_name('personalEmail2'); ?>" value="<?php echo $instance['personalEmail2']; ?>" style="width:100%;" />
                </p>
                <p>
			<label for="<?php echo $this->get_field_id('personalEmailName3'); ?>"><?php _e('3rd Personal Email Name', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('personalEmailName3'); ?>" name="<?php echo $this->get_field_name('personalEmailName3'); ?>" value="<?php echo $instance['personalEmailName3']; ?>" style="width:100%;" />
			<label for="<?php echo $this->get_field_id('personalEmail3'); ?>"><?php _e('3rd Personal Email Address', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('personalEmail3'); ?>" name="<?php echo $this->get_field_name('personalEmail3'); ?>" value="<?php echo $instance['personalEmail3']; ?>" style="width:100%;" />
                </p>
                <p>
			<label for="<?php echo $this->get_field_id('otherEmailName'); ?>"><?php _e('Other Email Name', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('otherEmailName'); ?>" name="<?php echo $this->get_field_name('otherEmailName'); ?>" value="<?php echo $instance['otherEmailName']; ?>" style="width:100%;" />
			<label for="<?php echo $this->get_field_id('otherEmail'); ?>"><?php _e('Other Email Address', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('otherEmail'); ?>" name="<?php echo $this->get_field_name('otherEmail'); ?>" value="<?php echo $instance['otherEmail']; ?>" style="width:100%;" />
                </p>                 
                <p>
			<label for="<?php echo $this->get_field_id('address'); ?>"><?php _e('Address', 'bcw-language'); ?>:</label>
			<textarea id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" style="width:100%;"><?php echo $instance['address']; ?></textarea>	
		</p>
                <p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('showMap'); ?>" name="<?php echo $this->get_field_name('showMap'); ?>" <?php checked($instance['showMap'], 'on'); ?>/>
			<label for="<?php echo $this->get_field_id('showMap'); ?>"><?php _e('Display map of address?', 'bcw-language'); ?></label>
		</p>
                <p>
			<label for="<?php echo $this->get_field_id('map'); ?>"><?php _e('Google Maps (iframe code)', 'bcw-language'); ?>:</label>
			<textarea id="<?php echo $this->get_field_id('map'); ?>" name="<?php echo $this->get_field_name('map'); ?>" style="width:100%;"><?php echo $instance['map']; ?></textarea>	
		</p>
                <p>
			<label for="<?php echo $this->get_field_id('openingTimes'); ?>"><?php _e('Opening Times', 'bcw-language'); ?>:</label>
			<textarea id="<?php echo $this->get_field_id('openingTimes'); ?>" name="<?php echo $this->get_field_name('openingTimes'); ?>" style="width:100%;"><?php echo $instance['openingTimes']; ?></textarea>	
		</p>
		<!--<p>
			<label for="<?php echo $this->get_field_id('contact'); ?>"><?php _e('Contact Page(include http://)', 'bcw-language'); ?>:</label>
			<input id="<?php echo $this->get_field_id('contact'); ?>" name="<?php echo $this->get_field_name('contact'); ?>" value="<?php echo $instance['contact']; ?>" style="width:100%;" />
		</p>-->                 
                <p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('createdBy'); ?>" name="<?php echo $this->get_field_name('createdBy'); ?>" <?php checked($instance['createdBy'], 'on'); ?> />
			<label for="<?php echo $this->get_field_id('createdBy'); ?>"><?php _e('Display created by? Please only remove this after making a ', 'bcw-language'); ?><a href="http://stressfreesites.co.uk/plugins/business-contact-widget" target="_blank"><?php _e('donation.', 'bcw-language'); ?></a><?php _e('so we can continue making plugins like these.', 'bcw-language'); ?></label>
		</p>
                <?php
    }
    
}
add_action( 'widgets_init', create_function('', 'return register_widget("Business_Contact_Widget");'));
?>
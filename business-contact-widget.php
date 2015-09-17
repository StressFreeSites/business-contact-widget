<?php
/*
Plugin Name: Business Contact Widget
Plugin URI: http://stressfreesites.co.uk/plugins/business-contact-widget
Description: This plugin creates a widget which easily displays, without becoming cluttered, all the business contact details of a company/organisation.
Version: 2.7.0
Author: StressFree Sites
Author URI: http://stressfreesites.co.uk
Text Domain: bcw
License: GPL2
*/

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

/* Load admin settings page */
if ( is_admin() ) {
    require_once('business-contact-widget-admin.php');
}

/* Localisation of text */
function bcw_init() {
    load_plugin_textdomain( 'bcw', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action('plugins_loaded', 'bcw_init');

function bcw_enqueue_scripts() {       
    /* Select which scripts to load */
    $settings = get_option('bcw_settings','');
    if($settings['loadScripts']['jQuery'] === 'true'){
        if($settings['loadScripts']['jQuery-ui-core'] === 'true'){
            if($settings['loadScripts']['jQuery-ui-tabs'] === 'true'){
                wp_enqueue_script('jquery-business-contact-widget', plugins_url('business-contact-widget/js/business-contact-widget.min.js'), array('jquery', 'jquery-ui-core', 'jquery-ui-tabs'), '1.0', true);
            }
            else{
                wp_enqueue_script('jquery-business-contact-widget', plugins_url('business-contact-widget/js/business-contact-widget.min.js'), array('jquery', 'jquery-ui-core'), '1.0', true); 
            }
        }
        else{
            if($settings['loadScripts']['jQuery-ui-tabs'] === 'true'){
                wp_enqueue_script('jquery-business-contact-widget', plugins_url('business-contact-widget/js/business-contact-widget.min.js'), array('jquery', 'jquery-ui-tabs'), '1.0', true);     
            }
            else{
                wp_enqueue_script('jquery-business-contact-widget', plugins_url('business-contact-widget/js/business-contact-widget.min.js'), array('jquery'), '1.0', true);
            }
        }
    }
    else{
        if($settings['loadScripts']['jQuery-ui-core'] === 'true'){
            if($settings['loadScripts']['jQuery-ui-tabs'] === 'true'){
                wp_enqueue_script('jquery-business-contact-widget', plugins_url('business-contact-widget/js/business-contact-widget.min.js'), array('jquery-ui-core', 'jquery-ui-tabs'), '1.0', true);
            }
            else{
                wp_enqueue_script('jquery-business-contact-widget', plugins_url('business-contact-widget/js/business-contact-widget.min.js'), array('jquery-ui-core'), '1.0', true);
            }
        }
        else{
            if($settings['loadScripts']['jQuery-ui-tabs'] === 'true'){
                wp_enqueue_script('jquery-business-contact-widget', plugins_url('business-contact-widget/js/business-contact-widget.min.js'), array('jquery-ui-tabs'), '1.0', true);
            }
            else{
                wp_enqueue_script('jquery-business-contact-widget', plugins_url('business-contact-widget/js/business-contact-widget.min.js'), array(), '1.0', true);
            }           
        }     
    } 
}    
add_action('wp_enqueue_scripts', 'bcw_enqueue_scripts');

function bcw_enqueue_styles() {   
    $settings = get_option('bcw_settings','');
    if($settings['loadJqueryUI'] === 'true'){   
        switch($settings['style']){
            case 'Grey':
                wp_enqueue_style('business-contact-widget-jquery-ui-style', plugins_url('business-contact-widget/css/jquery-ui-grey.min.css')); 
                break;
            case 'Black':
                wp_enqueue_style('business-contact-widget-jquery-ui-style', plugins_url('business-contact-widget/css/jquery-ui-black.min.css'));
                break;
            case 'Blue':
                wp_enqueue_style('business-contact-widget-jquery-ui-style', plugins_url('business-contact-widget/css/jquery-ui-blue.min.css'));
                break;
            case 'Red':
                wp_enqueue_style('business-contact-widget-jquery-ui-style', plugins_url('business-contact-widget/css/jquery-ui-red.min.css'));
                break;
            case 'Green':
                wp_enqueue_style('business-contact-widget-jquery-ui-style', plugins_url('business-contact-widget/css/jquery-ui-green.min.css'));
                break;
            case 'Skeleton':
                wp_enqueue_style('business-contact-widget-jquery-ui-style', plugins_url('business-contact-widget/css/jquery-ui-skeleton.min.css'));
                wp_enqueue_style('business-contact-widget-skeleton-style', plugins_url('business-contact-widget/css/business-contact-widget-skeleton.min.css'));
                break;
            default:
                wp_enqueue_style('business-contact-widget-jquery-ui-style', plugins_url('business-contact-widget/css/jquery-ui-skeleton.min.css'));
                wp_enqueue_style('business-contact-widget-skeleton-style', plugins_url('business-contact-widget/css/business-contact-widget-skeleton.min.css'));
                break;
        }
        wp_enqueue_style('business-contact-widget-style', plugins_url('business-contact-widget/css/business-contact-widget.min.css'), array('business-contact-widget-jquery-ui-style')); 
    }
    else{
        wp_enqueue_style('business-contact-widget-style', plugins_url('business-contact-widget/css/business-contact-widget.min.css'), array());
    }
    
     
} 
add_action('wp_print_styles', 'bcw_enqueue_styles');

// Activation code to update plugins
function bcw_activate() {
    // Get old widget information, and save in new formate in database

    // Retrieve old widget informaiton  
    $widget = get_option('widget_business-contact-widget','');

    // Retrieve new settings information(if any)
    $settings = get_option('bcw_settings');
    
    if($widget != '' && isset($widget[1])){
        bcw_settings_init();
        
        $settings['telephone'] = $widget[1]['telephone'];
        $settings['fax'] = $widget[1]['fax'];
        $settings['mobileName'] = $widget[1]['mobileName'];
        $settings['mobileNo'] = $widget[1]['mobileNo'];
        $settings['mobileName2'] = $widget[1]['mobileName2'];
        $settings['mobileNo2'] = $widget[1]['mobileNo2'];
        $settings['mobileName3'] = $widget[1]['mobileName3'];
        $settings['mobileNo3'] = $widget[1]['mobileNo3'];
        $settings['otherTelephoneName'] = $widget[1]['otherTelephoneName'];
        $settings['otherTelephoneNo'] = $widget[1]['otherTelephoneNo'];
        $settings['email'] = $widget[1]['email'];
        $settings['personalEmailName'] = $widget[1]['personalEmailName'];
        $settings['personalEmail'] = $widget[1]['personalEmail'];
        $settings['personalEmailName2'] = $widget[1]['personalEmailName2'];
        $settings['personalEmail2'] = $widget[1]['personalEmail2'];
        $settings['personalEmailName3'] = $widget[1]['personalEmailName3'];
        $settings['personalEmail3'] = $widget[1]['personalEmail3'];
        $settings['otherEmailName'] = $widget[1]['otherEmailName'];
        $settings['otherEmail'] = $widget[1]['otherEmail'];
        $settings['mainAddressName'] = $widget[1]['mainAddressName'];
        $settings['mainAddress'] = $widget[1]['mainAddress'];
        $settings['secondaryAddressName'] = $widget[1]['secondaryAddressName'];
        $settings['secondaryAddress'] = $widget[1]['secondaryAddress'];
        $settings['tertiaryAddressName'] = $widget[1]['tertiaryAddressName'];
        $settings['tertiaryAddress'] = $widget[1]['tertiaryAddress'];
        $settings['quaternaryAddressName'] = $widget[1]['quaternaryAddressName'];
        $settings['quaternaryAddress'] = $widget[1]['quaternaryAddress'];
        $settings['message'] = $widget[1]['message'];
        $settings['map'] = $widget[1]['map'];
        $settings['openingTimes'] = $widget[1]['openingTimes'];

        $settings['icons'] = $widget[1]['icons'];
        $settings['createdBy'] = $widget[1]['createdBy'];
        
        // Delete old settings
        delete_option('widget_business-contact-widget');
        delete_option('bcw_load_jquery_ui');
        delete_option('bcw_load_scripts');
        delete_option('bcw_style');
        delete_option('bcw_theme_settings');
    }
    // Save settings in new format
    update_option('bcw_settings', $settings);   
}
register_activation_hook( __FILE__, 'bcw_activate' );

/* Message box */
function bcw_plugin_admin_notice() {
	global $current_user ;
        $user_id = $current_user->ID;
        /* Check that the user hasn't already clicked to ignore the message */
	if ( ! get_user_meta($user_id, 'bcw_plugin_ignore_notice') ) {
            echo '<div class="updated"><p>'; 
            printf(__('<p>Thank you for downloading Business Contact Widget, we hope you enjoy using the plugin.</p><p>If you like this plugin, you maybe interested in the <a href="http://socialprofilesandcontactdetailswordpressplugin.com/" target="_blank">premium version</a> to enable more features.</p><p>Otherwise, maybe try some of our other <a href="http://stressfreesites.co.uk/development/?utm_source=frontend&utm_medium=plugin&utm_campaign=wordpress" target="_blank">free plugins</a>.</p><a href="%1$s">Hide This Notice</a>'), '?bcw_plugin_nag_ignore=0');
            echo "</p></div>";
	}
}
add_action('admin_notices', 'bcw_plugin_admin_notice');

function bcw_plugin_nag_ignore() {
	global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset($_GET['bcw_plugin_nag_ignore']) && '0' == $_GET['bcw_plugin_nag_ignore'] ) {
             add_user_meta($user_id, 'bcw_plugin_ignore_notice', 'true', true);
	}
}
add_action('admin_init', 'bcw_plugin_nag_ignore');

class Business_Contact_Widget extends WP_Widget {
    function Business_Contact_Widget() {
            /* Widget settings. */
            $widget_ops = array('classname' => 'contact', 'description' => 'A widget which clearly displays business contact details for sidebar.');

            /* Widget control settings. */
            $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'business-contact-widget');

            /* Create the widget. */
            $this->__construct('business-contact-widget', 'Business Contact Widget', $widget_ops, $control_ops);
    }
    
    /* Displays widget on website */
    function widget($args, $instance) {
            extract($args);
            
            /* User-selected settings. */
            $title = apply_filters('widget_title', $instance['title']);
            
            $settings = get_option('bcw_settings');

            $telephone = $settings['telephone'];
            $fax = $settings['fax'];
            $mobileName = $settings['mobileName'];
            $mobileNo = $settings['mobileNo'];
            $mobileName2 = $settings['mobileName2'];
            $mobileNo2 = $settings['mobileNo2'];
            $mobileName3 = $settings['mobileName3'];
            $mobileNo3 = $settings['mobileNo3'];
            $otherTelephoneName = $settings['otherTelephoneName'];
            $otherTelephoneNo = $settings['otherTelephoneNo'];
            $email = $settings['email'];
            $personalEmailName = $settings['personalEmailName'];
            $personalEmail = $settings['personalEmail'];
            $personalEmailName2 = $settings['personalEmailName2'];
            $personalEmail2 = $settings['personalEmail2'];
            $personalEmailName3 = $settings['personalEmailName3'];
            $personalEmail3 = $settings['personalEmail3'];
            $otherEmailName = $settings['otherEmailName'];
            $otherEmail = $settings['otherEmail'];            
            $mainAddressName = $settings['mainAddressName'];
            $mainAddress = $settings['mainAddress'];
            $secondaryAddressName = $settings['secondaryAddressName'];
            $secondaryAddress = $settings['secondaryAddress'];
            $tertiaryAddressName = $settings['tertiaryAddressName'];
            $tertiaryAddress = $settings['tertiaryAddress'];
            $quaternaryAddressName = $settings['quaternaryAddressName'];
            $quaternaryAddress = $settings['quaternaryAddress'];
            $message = $settings['message'];
            $map = $settings['map'];
            $openingTimes = $settings['openingTimes'];
            
            $icons = $settings['icons'];
            $iconSize = strtolower($settings['iconSize']);
            $tabDirection = $settings['tabDirection']; 
            $createdBy = $settings['createdBy'];
            
            $showTelephone = isset($instance['showTelephone']) ? $instance['showTelephone'] : false;
            $showEmail = isset($instance['showEmail']) ? $instance['showEmail'] : false;
            $showAddress = isset($instance['showAddress']) ? $instance['showAddress'] : false;
            $showMessage = isset($instance['showMessage']) ? $instance['showMessage'] : false;
            $showMap = isset($instance['showMap']) ? $instance['showMap'] : false;
            $showOpening = isset($instance['showOpening']) ? $instance['showOpening'] : false;
                
            $openTab = $instance['openTab']; 

            /* Before widget (defined by themes). */
            echo $before_widget .'<div class="business-contact">';
            
            /* Title of widget (before and after defined by themes). */
            if ($title)
                    echo $before_title . $title . $after_title;

            /* Tab headers and hidden inputs */
            echo ('<input type="hidden" class="bcw-open-tab" value="' . $openTab . '" /><input type="hidden" class="bcw-tab-direction" value="' . $tabDirection . '" /><div class="preloader"></div><div class="bcw-tabs"><ul>');
            
            if ($showTelephone && ($telephone || $fax || $mobileNo || $mobileNo2 || $mobileNo3 || $otherTelephoneNo)){
                if($icons == 'Modern'){
                    echo ('<li class="' . $iconSize . '"><a href="#bcw-telephone"><img src="' . plugins_url('business-contact-widget/images/modern_telephone_grey.png') . '" class="grey"/><img src="' . plugins_url('business-contact-widget/images/modern_telephone.png') . '" class="colour"/></a></li>');                    
                }
                else{
                    echo ('<li class="' . $iconSize . '"><a href="#bcw-telephone"><img src="' . plugins_url('business-contact-widget/images/telephone_grey.png') . '" class="grey"/><img src="' . plugins_url('business-contact-widget/images/telephone.png') . '" class="colour"/></a></li>');                    
                }
            }

            if ($showEmail && ($email || $personalEmail || $personalEmail2 || $personalEmail3 || $otherEmail)){
                if($icons == 'Modern'){
                     echo ('<li class="' . $iconSize . '"><a href="#bcw-email"><img src="' . plugins_url('business-contact-widget/images/modern_email_grey.png') . '" class="grey"/><img src="' . plugins_url('business-contact-widget/images/modern_email.png') . '" class="colour" /></a></li>');                   
                }
                else{
                    echo ('<li class="' . $iconSize . '"><a href="#bcw-email"><img src="' . plugins_url('business-contact-widget/images/email_grey.png') . '" class="grey"/><img src="' . plugins_url('business-contact-widget/images/email.png') . '" class="colour" /></a></li>');                    
                }
            }
            
            if ($showAddress && ($mainAddress || $secondaryAddress || $tertiaryAddress || $quaternaryAddress)){
                if($icons == 'Modern'){
                    echo ('<li class="' . $iconSize . '"><a href="#bcw-address"><img src="' . plugins_url('business-contact-widget/images/modern_address_grey.png') . '" class="grey"/><img src="' . plugins_url('business-contact-widget/images/modern_address.png') . '" class="colour" /></a></li>');                    
                }
                else{
                    echo ('<li class="' . $iconSize . '"><a href="#bcw-address"><img src="' . plugins_url('business-contact-widget/images/address_grey.png') . '" class="grey"/><img src="' . plugins_url('business-contact-widget/images/address.png') . '" class="colour" /></a></li>');                    
                }
            }

            if ($showMessage && $message){
                if($icons == 'Modern'){
                    echo ('<li class="' . $iconSize . '"><a href="#bcw-message"><img src="' . plugins_url('business-contact-widget/images/modern_write_grey.png') . '" class="grey"/><img src="' . plugins_url('business-contact-widget/images/modern_write.png') . '" class="colour" /></a></li>');                                
                }
                else{
                    echo ('<li class="' . $iconSize . '"><a href="#bcw-message"><img src="' . plugins_url('business-contact-widget/images/write_grey.png') . '" class="grey"/><img src="' . plugins_url('business-contact-widget/images/write.png') . '" class="colour" /></a></li>');                                
                }
            }
            
            if ($showMap && $map){
                if($icons == 'Modern'){
                    echo ('<li class="' . $iconSize . ' tab-map"><a href="#bcw-map"><img src="' . plugins_url('business-contact-widget/images/modern_map_grey.png') . '" class="grey" /><img src="' . plugins_url('business-contact-widget/images/modern_map.png') . '" class="colour" /></a></li>');                    
                }
                else{
                    echo ('<li class="' . $iconSize . ' tab-map"><a href="#bcw-map"><img src="' . plugins_url('business-contact-widget/images/map_grey.png') . '" class="grey" /><img src="' . plugins_url('business-contact-widget/images/map.png') . '" class="colour" /></a></li>');                    
                }
            }
            
            if ($showOpening && $openingTimes){
                if($icons == 'Modern'){
                    echo ('<li class="' . $iconSize . '"><a href="#bcw-clock"><img src="' . plugins_url('business-contact-widget/images/modern_clock_grey.png') . '" class="grey" /><img src="' . plugins_url('business-contact-widget/images/modern_clock.png') . '" class="colour" /></a></li>');                    
                }
                else{
                    echo ('<li class="' . $iconSize . '"><a href="#bcw-clock"><img src="' . plugins_url('business-contact-widget/images/clock_grey.png') . '" class="grey" /><img src="' . plugins_url('business-contact-widget/images/clock.png') . '" class="colour" /></a></li>');                     
                }
            }
           
            echo ('</ul>');
            
            /* Tab body content */    
            if ($showTelephone && ($telephone || $fax || $mobileNo || $mobileNo2 || $mobileNo3 || $otherTelephoneNo)){
                    echo ('<div id="bcw-telephone">');
                    
                    if ($telephone)
                        echo ('<h4>' . __('Telephone', 'bcw') . '</h4><p><a href="tel:' . preg_replace('/\s+/', '', $telephone) . '">' . $telephone . '</a></p>');
                    
                    if ($fax)
                        echo ('<h4>' . __('Fax', 'bcw') . '</h4><p>' . $fax . '</p>');
                    
                    if ($mobileNo)
                        echo ('<h4>' . $mobileName . '\'s ' . __('Mobile', 'bcw') . '</h4><p><a href="tel:' . preg_replace('/\s+/', '', $mobileNo) . '">' . $mobileNo . '</a></p>');

                    if ($mobileNo2)
                        echo ('<h4>' . $mobileName2 . '\'s ' . __('Mobile', 'bcw') . '</h4><p><a href="tel:' . preg_replace('/\s+/', '', $mobileNo2) . '">' . $mobileNo2 . '</a></p>');
                    
                    if ($mobileNo3)
                        echo ('<h4>' . $mobileName3 . '\'s ' . __('Mobile', 'bcw') . '</h4><p><a href="tel:' . preg_replace('/\s+/', '', $mobileNo3) . '">' . $mobileNo3 . '</a></p>');
                    
                    if ($otherTelephoneNo)
                        echo ('<h4>' . $otherTelephoneName . '</h4><p><a href="tel:' . preg_replace('/\s+/', '', $otherTelephoneNo) . '">' . $otherTelephoneNo . '<a/></p>');
                    
                    echo ('</div>');
            }
            
            if ($showEmail && ($email || $personalEmail || $personalEmail2 || $personalEmail3 || $otherEmail)){
                echo ('<div id="bcw-email">');
                
                if ($email)
                        echo ('<h4>' . __('Email', 'bcw') . '</h4><p><a href="mailto:'.$email.'">' . $email . '</a></p>');
 
                if ($personalEmail)
                        echo ('<h4>' . $personalEmailName . '\'s ' . __(' Email', 'bcw') . '</h4><p><a href="mailto:' . $personalEmail . '">' . $personalEmail . '</a></p>');

                if ($personalEmail2)
                        echo ('<h4>' . $personalEmailName2 . '\'s ' . __(' Email', 'bcw') . '</h4><p><a href="mailto:' . $personalEmail2 . '">' . $personalEmail2 . '</a></p>');
 

                if ($personalEmail3)
                        echo ('<h4>' . $personalEmailName3 . '\'s ' . __(' Email', 'bcw') . '</h4><p><a href="mailto:' . $personalEmail3 . '">' . $personalEmail3 . '</a></p>');
 

                if ($otherEmail)
                        echo ('<h4>' . $otherEmailName . __(' Email', 'bcw') . '</h4><p><a href="mailto:'.$otherEmail.'">' . $otherEmail . '</a></p>');
 
                echo ('</div>');
            }
            
            if ($showAddress && ($mainAddress || $secondaryAddress || $tertiaryAddress || $quaternaryAddress)){
                echo ('<div id="bcw-address">');
                echo ('<h4>' . $mainAddressName . '</h4><p>' . nl2br($mainAddress) . '</p>');
                echo ('<h4>' . $secondaryAddressName . '</h4><p>' . nl2br($secondaryAddress) . '</p>');
                echo ('<h4>' . $tertiaryAddressName . '</h4><p>' . nl2br($tertiaryAddress) . '</p>');
                echo ('<h4>' . $quaternaryAddressName . '</h4><p>' . nl2br($quaternaryAddress) . '</p>');
                echo ('</div>');
            }
            
            /* Show message */
            if ($showMessage && $message){
                    echo ('<div id="bcw-message"><p>' . do_shortcode(stripslashes($message)) . '</p></div>');
            } 
            
            /* Show map */
            if ($showMap && $map){
                    echo ('<div id="bcw-map">' . stripslashes($map) . '</div>');
            }
            
            if ($showOpening && $openingTimes){
                    echo ('<div id="bcw-clock"><h4>' . __('Opening Times', 'bcw') . '</h4><p> ' . nl2br($openingTimes) . '</p></div>');
            }
            
            echo ('</div>');
            
            /* Copyright */
            if ($createdBy === 'true'){
                    echo ('<div class="small"><p>' . __('Plugin created by ', 'bcw') . '<a href="http://stressfreesites.co.uk/business-contact-widget/?utm_source=frontend&utm_medium=plugin&utm_campaign=wordpress" target="_blank">StressFree Sites</a></p></div>');
            }    
            
            /* After widget (defined by themes). */
            echo '</div><!-- .business-contact -->'.$after_widget;
    }

    /* Updating the Wordpress backend */
    function update($new_instance, $old_instance) {
            $instance = $old_instance;

            /* Strip tags (if needed) and update the widget settings. */
            $instance['title'] = strip_tags($new_instance['title']);           
            
            $instance['showTelephone'] = $new_instance['showTelephone'];
            $instance['showEmail'] = $new_instance['showEmail'];
            $instance['showAddress'] = $new_instance['showAddress'];
            $instance['showMessage'] = $new_instance['showMessage'];
            $instance['showMap'] = $new_instance['showMap'];
            $instance['showOpening'] = $new_instance['showOpening'];
            
            $instance['openTab'] = $new_instance['openTab'];      
            return $instance;
    }
    
    /* Form for the Wordpress backend */
    function form($instance) {
            /* Set up some default widget settings. */
            $defaults = array('title' => 'Contact',                               
                              'showTelephone' => 'true', 'showEmail' => 'true', 'showAddress' => 'true', 'showMessage' => 'true', 'showMap' => 'true', 'showOpening' => 'true', 
                              'openTab' => '1');
            $instance = wp_parse_args((array) $instance, $defaults); ?>
                <h3><?php _e('General Options', 'bcw'); ?></h3>
                <p>
                    <?php _e('Please add all the contact details through the "', 'bcw'); ?><a href="options-general.php?page=business-contact-widget"><?php _e('Business Contact Widget', 'bcw'); ?></a><?php _e('" settings page.', 'bcw'); ?>
                </p>               
                <p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'bcw'); ?></label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
                        <span class="description"><?php _e('The title of the widget, leave blank for no title.', 'smbw'); ?></span>
		</p>
                <p>
                        <label for="<?php echo $this->get_field_id('openTab'); ?>"><?php _e('Load page open on tab','bcw'); ?></label>
                        <select id="<?php echo $this->get_field_id('openTab'); ?>" name="<?php echo $this->get_field_name('openTab'); ?>"> 
                            <option <?php if($instance['openTab'] == 1) echo ('SELECTED');?>>1</option>
                            <option <?php if($instance['openTab'] == 2) echo ('SELECTED');?>>2</option>
                            <option <?php if($instance['openTab'] == 3) echo ('SELECTED');?>>3</option>
                            <option <?php if($instance['openTab'] == 4) echo ('SELECTED');?>>4</option>
                            <option <?php if($instance['openTab'] == 5) echo ('SELECTED');?>>5</option>
                            <option <?php if($instance['openTab'] == 6) echo ('SELECTED');?>>6</option>
                        </select>                      
                </p>
                <p class="description">
                    <?php _e('Opens on tab number - 1 for first tab, 2 for second tab etc.', 'bcw'); ?>
                </p>
                <h3><?php _e('Section Display Options', 'bcw'); ?></h3>
                <p>
                    <?php _e('Select which contact details tabs you would like to be displayed on this widget.', 'bcw'); ?>
                </p>
                <p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('showTelephone'); ?>" name="<?php echo $this->get_field_name('showTelephone'); ?>" value="true" <?php checked($instance['showTelephone'], 'true'); ?>/>
			<label for="<?php echo $this->get_field_id('showTelephone'); ?>"><?php _e('Display telephone numbers', 'bcw'); ?></label>
		</p>
                <p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('showEmail'); ?>" name="<?php echo $this->get_field_name('showEmail'); ?>" value="true" <?php checked($instance['showEmail'], 'true'); ?>/>
			<label for="<?php echo $this->get_field_id('showEmail'); ?>"><?php _e('Display email addresses', 'bcw'); ?></label>
		</p>
                <p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('showAddress'); ?>" name="<?php echo $this->get_field_name('showAddress'); ?>" value="true" <?php checked($instance['showAddress'], 'true'); ?>/>
			<label for="<?php echo $this->get_field_id('showAddress'); ?>"><?php _e('Display address', 'bcw'); ?></label>
		</p> 
                 <p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('showMessage'); ?>" name="<?php echo $this->get_field_name('showMessage'); ?>" value="true" <?php checked($instance['showMessage'], 'true'); ?>/>
			<label for="<?php echo $this->get_field_id('showMessage'); ?>"><?php _e('Display message form', 'bcw'); ?></label>
		</p>                
                <p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('showMap'); ?>" name="<?php echo $this->get_field_name('showMap'); ?>" value="true" <?php checked($instance['showMap'], 'true'); ?>/>
			<label for="<?php echo $this->get_field_id('showMap'); ?>"><?php _e('Display map', 'bcw'); ?></label>
		</p> 
                <p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('showOpening'); ?>" name="<?php echo $this->get_field_name('showOpening'); ?>" value="true" <?php checked($instance['showOpening'], 'true'); ?>/>
			<label for="<?php echo $this->get_field_id('showOpening'); ?>"><?php _e('Display opening times', 'bcw'); ?></label>
		</p>
                <p class="description">
                   <?php _e('NOTE: tabs will not be displayed if there is no information saved in them!', 'bcw'); ?>
                </p>
                <?php
    }
    
}
add_action( 'widgets_init', create_function('', 'return register_widget("Business_Contact_Widget");'));
?>
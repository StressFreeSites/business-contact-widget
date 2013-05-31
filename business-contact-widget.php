<?php
/*
Plugin Name: Business Contact Widget
Plugin URI: http://stressfreesites.co.uk/plugins/business-contact-widget
Description: This plugin creates a widget which easily displays, without becoming cluttered, all the business contact details of a company/organisation.
Version: 2.3
Author: StressFree Sites
Author URI: http://stressfreesites.co.uk
License: GPL2
*/

/*  Copyright 2012 StressFree Sites  (info@stressfreesites.co.uk : alex@stressfreesites.co.uk)

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

/* Localisation of text */
function bcw_init() {
  load_plugin_textdomain( 'bcw-language', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action('plugins_loaded', 'bcw_init');

function bcw_enqueue_scripts() {       
    /* Load custom scripts */
    //wp_enqueue_script('greyScale', plugins_url('business-contact-widget/js/greyScale.min.js'), array('jquery'),'1.0',true);
    
        /* Select which scripts to load */
    $loadScripts = get_option('bcw_load_scripts', array('jQuery' => 1, 
                                                     'jQuery-ui-core' => 1,
                                                     'jQuery-ui-tabs' => 1));

    if(isset($loadScripts['jQuery'])){
        if(isset($loadScripts['jQuery-ui-core'])){
            if(isset($loadScripts['jQuery-ui-tabs'])){
                wp_enqueue_script('jquery-business-contact-widget-load', plugins_url('business-contact-widget/js/business-contact-widget-jquery-load.js'), array('jquery', 'jquery-ui-core', 'jquery-ui-tabs'), '1.0', true);
            }
            else{
                wp_enqueue_script('jquery-business-contact-widget-load', plugins_url('business-contact-widget/js/business-contact-widget-jquery-load.js'), array('jquery', 'jquery-ui-core'), '1.0', true); 
            }
        }
        else{
            if(isset($loadScripts['jQuery-ui-tabs'])){
                wp_enqueue_script('jquery-business-contact-widget-load', plugins_url('business-contact-widget/js/business-contact-widget-jquery-load.js'), array('jquery', 'jquery-ui-tabs'), '1.0', true);     
            }
            else{
                wp_enqueue_script('jquery-business-contact-widget-load', plugins_url('business-contact-widget/js/business-contact-widget-jquery-load.js'), array('jquery'), '1.0', true);
            }
        }
    }
    else{
        if(isset($loadScripts['jQuery-ui-core'])){
            if(isset($loadScripts['jQuery-ui-tabs'])){
                wp_enqueue_script('jquery-business-contact-widget-load', plugins_url('business-contact-widget/js/business-contact-widget-jquery-load.js'), array('jquery-ui-core', 'jquery-ui-tabs'), '1.0', true);
            }
            else{
                wp_enqueue_script('jquery-business-contact-widget-load', plugins_url('business-contact-widget/js/business-contact-widget-jquery-load.js'), array('jquery-ui-core'), '1.0', true);
            }
        }
        else{
            if(isset($loadScripts['jQuery-ui-tabs'])){
                wp_enqueue_script('jquery-business-contact-widget-load', plugins_url('business-contact-widget/js/business-contact-widget-jquery-load.js'), array('jquery-ui-tabs'), '1.0', true);
            }
            else{
                wp_enqueue_script('jquery-business-contact-widget-load', plugins_url('business-contact-widget/js/business-contact-widget-jquery-load.js'), array(), '1.0', true);
            }           
        }     
    } 
}    
add_action('wp_enqueue_scripts', 'bcw_enqueue_scripts');

function bcw_enqueue_styles() { 
    /* Load custom styling */
    
    /* Load the selected custom style */
    $loadJqueryUI = get_option('bcw_load_jquery_ui','true');
    if($loadJqueryUI){
        $style = get_option('bcw_style','Grey');
        switch($style){
            case 'Grey':
                wp_enqueue_style('business-contact-widget-jquery-ui-style', plugins_url('business-contact-widget/css/jquery-ui.css')); 
                break;
            case 'Black':
                wp_enqueue_style('business-contact-widget-jquery-ui-style', plugins_url('business-contact-widget/css/jquery-ui-black.css'));
                break;
            case 'Blue':
                wp_enqueue_style('business-contact-widget-jquery-ui-style', plugins_url('business-contact-widget/css/jquery-ui-blue.css'));
                break;
            default:
                wp_enqueue_style('business-contact-widget-jquery-ui-style', plugins_url('business-contact-widget/css/jquery-ui.css')); 
                break;
        }
        wp_enqueue_style('business-contact-widget-style', plugins_url('business-contact-widget/css/business-contact-widget-style.css'), array('business-contact-widget-jquery-ui-style')); 
    }
    else{
        wp_enqueue_style('business-contact-widget-style', plugins_url('business-contact-widget/css/business-contact-widget-style.css'), array());
    }
    
     
} 
add_action('wp_print_styles', 'bcw_enqueue_styles');

/* Admin page functionality */
function bcw_admin(){
    include ('business-contact-widget-admin.php');
}
function bcw_admin_init(){   
    wp_register_style('business-contact-widget-style-admin', plugins_url('business-contact-widget/css/business-contact-widget-style-admin.css'));
}
add_action('admin_init', 'bcw_admin_init');

function bcw_admin_actions(){
   /* Register our plugin page */
   $page = add_options_page('Business Contact Widget','Business Contact Widget', 'manage_options', 'businesscontactwidget', 'bcw_admin');

   /* Using registered $page handle to hook stylesheet loading */
   add_action('admin_print_styles-' . $page, 'bcw_admin_styles');
    
}
add_action('admin_menu','bcw_admin_actions');
   
function bcw_admin_styles() {
   wp_enqueue_style('business-contact-widget-style-admin');
}

/* Message box */
function bcw_theme_admin_notice() {
	global $current_user ;
        $user_id = $current_user->ID;
        /* Check that the user hasn't already clicked to ignore the message */
	if ( ! get_user_meta($user_id, 'bcw_theme_ignore_notice') ) {
            echo '<div class="updated"><p>'; 
            printf(__('<p>Thank you for downloading Business Contact Widget. We hope you enjoy using the plugin, maybe some of our <a href="http://stressfreesites.co.uk/development" target="_blank">other plugins</a> would be of interest to you.</p><p>We have just launched a new Wordpress theme which might be of interest - <a href="http://greatestwordpresstheme.com" target="_blank">take a look</a>.</p><a href="%1$s">Hide This Notice</a>'), '?bcw_theme_nag_ignore=0');
            echo "</p></div>";
	}
}
add_action('admin_notices', 'bcw_theme_admin_notice');

function bcw_theme_nag_ignore() {
	global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset($_GET['bcw_theme_nag_ignore']) && '0' == $_GET['bcw_theme_nag_ignore'] ) {
             add_user_meta($user_id, 'bcw_theme_ignore_notice', 'true', true);
	}
}
add_action('admin_init', 'bcw_theme_nag_ignore');

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
            
            $widget = get_option('widget_business-contact-widget','');

            $telephone = $widget[2]['telephone'];
            $fax = $widget[2]['fax'];
            $mobileName = $widget[2]['mobileName'];
            $mobileNo = $widget[2]['mobileNo'];
            $mobileName2 = $widget[2]['mobileName2'];
            $mobileNo2 = $widget[2]['mobileNo2'];
            $mobileName3 = $widget[2]['mobileName3'];
            $mobileNo3 = $widget[2]['mobileNo3'];
            $otherTelephoneName = $widget[2]['otherTelephoneName'];
            $otherTelephoneNo = $widget[2]['otherTelephoneNo'];
            $email = $widget[2]['email'];
            $personalEmailName = $widget[2]['personalEmailName'];
            $personalEmail = $widget[2]['personalEmail'];
            $personalEmailName2 = $widget[2]['personalEmailName2'];
            $personalEmail2 = $widget[2]['personalEmail2'];
            $personalEmailName3 = $widget[2]['personalEmailName3'];
            $personalEmail3 = $widget[2]['personalEmail3'];
            $otherEmailName = $widget[2]['otherEmailName'];
            $otherEmail = $widget[2]['otherEmail'];            
            $mainAddressName = $widget[2]['mainAddressName'];
            $mainAddress = $widget[2]['mainAddress'];
            $secondaryAddressName = $widget[2]['secondaryAddressName'];
            $secondaryAddress = $widget[2]['secondaryAddress'];
            $message = $widget[2]['message'];
            $map = $widget[2]['map'];
            $openingTimes = $widget[2]['openingTimes'];
            
            $showTelephone = isset($instance['showTelephone']) ? $instance['showTelephone'] : false;
            $showEmail = isset($instance['showEmail']) ? $instance['showEmail'] : false;
            $showAddress = isset($instance['showAddress']) ? $instance['showAddress'] : false;
            $showMessage = isset($instance['showMessage']) ? $instance['showMessage'] : false;
            $showMap = isset($instance['showMap']) ? $instance['showMap'] : false;
            $showOpening = isset($instance['showOpening']) ? $instance['showOpening'] : false;
            
            $openTab = $instance['openTab'];
            
            $createdBy = isset($instance['createdBy']) ? $instance['createdBy'] : false;

            /* Before widget (defined by themes). */
            echo $before_widget .'<div class="business-contact">';
            
            /* Title of widget (before and after defined by themes). */
            if ($title)
                    echo $before_title . $title . $after_title;

            /* Tab headers and hidden inputs */
            echo ('<input type="hidden" id="bcw_openTab" value="' . $openTab . '" /><div id="bcw-tabs"><ul>');
            
            if ($showTelephone && ($telephone || $fax || $mobileNo || $mobileNo2 || $mobileNo3 || $otherTelephoneNo))
                    echo ('<li><a href="#bcw-telephone"><img src="' . plugins_url('business-contact-widget/images/telephone.png') . '" class="colour"/><img src="' . plugins_url('business-contact-widget/images/telephone_grey.png') . '" class="grey"/></a></li>');

            if ($showEmail && ($email || $personalEmail || $personalEmail2 || $personalEmail3 || $otherEmail))
                    echo ('<li><a href="#bcw-email"><img src="' . plugins_url('business-contact-widget/images/email.png') . '" class="colour" /><img src="' . plugins_url('business-contact-widget/images/email_grey.png') . '" class="grey"/></a></li>');
            
            if ($showAddress && ($mainAddress || $secondaryAddress))
                    echo ('<li><a href="#bcw-address"><img src="' . plugins_url('business-contact-widget/images/address.png') . '" class="colour" /><img src="' . plugins_url('business-contact-widget/images/address_grey.png') . '" class="grey"/></a></li>');

            if ($showMessage && $message)
                    echo ('<li><a href="#bcw-message"><img src="' . plugins_url('business-contact-widget/images/write.png') . '" class="colour" /><img src="' . plugins_url('business-contact-widget/images/write_grey.png') . '" class="grey"/></a></li>');            
            
            if ($showMap && $map)
                    echo ('<li><a href="#bcw-map"><img src="' . plugins_url('business-contact-widget/images/map.png') . '" class="colour" /><img src="' . plugins_url('business-contact-widget/images/map_grey.png') . '" class="grey"/></a></li>');
            
            if ($showOpening && $openingTimes)
                    echo ('<li><a href="#bcw-clock"><img src="' . plugins_url('business-contact-widget/images/clock.png') . '" class="colour" /><img src="' . plugins_url('business-contact-widget/images/clock_grey.png') . '" class="grey"/></a></li>');
            
            echo ('</ul>');
            
            /* Tab body content */    
            if ($showTelephone && ($telephone || $fax || $mobileNo || $mobileNo2 || $mobileNo3 || $otherTelephoneNo)){
                    echo ('<div id="bcw-telephone">');
                    
                    if ($telephone)
                        echo ('<h4>' . __('Telephone', 'bcw-language') . '</h4><p>' . $telephone . '</p>');
                    
                    if ($fax)
                        echo ('<h4>' . __('Fax', 'bcw-language') . '</h4><p>' . $fax . '</p>');
                    
                    if ($mobileNo)
                        echo ('<h4>' . $mobileName . '\'s ' . __('Mobile', 'bcw-language') . '</h4><p>' . $mobileNo . '</p>');

                    if ($mobileNo2)
                        echo ('<h4>' . $mobileName2 . '\'s ' . __('Mobile', 'bcw-language') . '</h4><p>' . $mobileNo2 . '</p>');
                    
                    if ($mobileNo3)
                        echo ('<h4>' . $mobileName3 . '\'s ' . __('Mobile', 'bcw-language') . '</h4><p>' . $mobileNo3 . '</p>');
                    
                    if ($otherTelephoneNo)
                        echo ('<h4>' . $otherTelephoneName . '</h4><p>' . $otherTelephoneNo . '</p>');
                    
                    echo ('</div>');
            }
            
            if ($showEmail && ($email || $personalEmail || $personalEmail2 || $personalEmail3 || $otherEmail)){
                echo ('<div id="bcw-email">');
                
                if ($email)
                        echo ('<h4>' . __('Email', 'bcw-language') . '</h4><p><a href="mailto:'.$email.'">' . $email . '</a></p>');
 
                if ($personalEmail)
                        echo ('<h4>' . $personalEmailName . '\'s ' . __(' Email', 'bcw-language') . '</h4><p><a href="mailto:' . $personalEmail . '">' . $personalEmail . '</a></p>');

                if ($personalEmail2)
                        echo ('<h4>' . $personalEmailName2 . '\'s ' . __(' Email', 'bcw-language') . '</h4><p><a href="mailto:' . $personalEmail2 . '">' . $personalEmail2 . '</a></p>');
 

                if ($personalEmail3)
                        echo ('<h4>' . $personalEmailName3 . '\'s ' . __(' Email', 'bcw-language') . '</h4><p><a href="mailto:' . $personalEmail3 . '">' . $personalEmail3 . '</a></p>');
 

                if ($otherEmail)
                        echo ('<h4>' . $otherEmailName . __(' Email', 'bcw-language') . '</h4><p><a href="mailto:'.$otherEmail.'">' . $otherEmail . '</a></p>');
 
                echo ('</div>');
            }
            
            if ($showAddress && ($mainAddress || $secondaryAddress)){
                    echo ('<div id="bcw-address"><h4>' . $mainAddressName . '</h4><p>' . nl2br($mainAddress) . '</p><h4>' . $secondaryAddressName . '</h4><p>' . nl2br($secondaryAddress) . '</p></div>');
            }
            
            /* Show message */
            if ($showMessage && $message){
                    echo ('<div id="bcw-message"><h4>' . __('Message', 'bcw-language') . '</h4><p>' . do_shortcode(stripslashes($message)) . '</p></div>');
            } 
            
            /* Show map */
            if ($showMap && $map){
                    echo ('<div id="bcw-map"><p><h4>' . __('Map', 'bcw-language') . '</h4><br />' . stripslashes($map) . '</div>');
            }
            
            if ($showOpening && $openingTimes){
                    echo ('<div id="bcw-clock"><h4>' . __('Opening Times', 'bcw-language') . '</h4><p> ' . nl2br($openingTimes) . '</p></div>');
            }
            
            echo ('</div>');
            
            /* Copyright */
            if ($createdBy){
                    echo ('<div class="small"><p>' . __('Plugin created by ', 'bcw-language') . '<a href="http://stressfreesites.co.uk/plugins/business-contact-widget" target="_blank">StressFree Sites</a></p></div>');
            }    
            
            /* After widget (defined by themes). */
            echo '</div>'.$after_widget;
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
            
            $instance['createdBy'] = $new_instance['createdBy'];        
            return $instance;
    }
    
    /* Form for the Wordpress backend */
    function form($instance) {
            /* Set up some default widget settings. */
            $defaults = array('title' => 'Contact',                               
                              'showTelephone' => 'on', 'showEmail' => 'on', 'showAddress' => 'on', 'showMessage' => 'on', 'showMap' => 'on', 'showOpening' => 'on', 
                              'showTab' => '1', 'createdBy' => 'off');
            $instance = wp_parse_args((array) $instance, $defaults); ?>
                <p>
                    Please add all the contact details through the "<a href="options-general.php?page=businesscontactwidget">Business Contact Widget</a>" settings page.
                </p>
                <p>
                    Select which contact details tabs you would like to bee displayed on this widget. NOTE: tabs will not be displayed if there is no information in them.
                </p>
                <p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'bcw-language'); ?></label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
                <p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('showTelephone'); ?>" name="<?php echo $this->get_field_name('showTelephone'); ?>" <?php checked($instance['showTelephone'], 'on'); ?>/>
			<label for="<?php echo $this->get_field_id('showTelephone'); ?>"><?php _e('Display telephone numbers?', 'bcw-language'); ?></label>
		</p>
                <p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('showEmail'); ?>" name="<?php echo $this->get_field_name('showEmail'); ?>" <?php checked($instance['showEmail'], 'on'); ?>/>
			<label for="<?php echo $this->get_field_id('showEmail'); ?>"><?php _e('Display email addresses?', 'bcw-language'); ?></label>
		</p>
                <p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('showAddress'); ?>" name="<?php echo $this->get_field_name('showAddress'); ?>" <?php checked($instance['showAddress'], 'on'); ?>/>
			<label for="<?php echo $this->get_field_id('showAddress'); ?>"><?php _e('Display address?', 'bcw-language'); ?></label>
		</p> 
                 <p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('showMessage'); ?>" name="<?php echo $this->get_field_name('showMessage'); ?>" <?php checked($instance['showMessage'], 'on'); ?>/>
			<label for="<?php echo $this->get_field_id('showMessage'); ?>"><?php _e('Display message form?', 'bcw-language'); ?></label>
		</p>                
                <p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('showMap'); ?>" name="<?php echo $this->get_field_name('showMap'); ?>" <?php checked($instance['showMap'], 'on'); ?>/>
			<label for="<?php echo $this->get_field_id('showMap'); ?>"><?php _e('Display map?', 'bcw-language'); ?></label>
		</p> 
                <p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('showOpening'); ?>" name="<?php echo $this->get_field_name('showOpening'); ?>" <?php checked($instance['showOpening'], 'on'); ?>/>
			<label for="<?php echo $this->get_field_id('showOpening'); ?>"><?php _e('Display opening times?', 'bcw-language'); ?></label>
		</p>
                <p>
                        <label for="<?php echo $this->get_field_id('openTab'); ?>"><?php _e('Load page open on tab','bcw-language'); ?></label>
                        <select id="<?php echo $this->get_field_id('openTab'); ?>" name="<?php echo $this->get_field_name('openTab'); ?>"> 
                            <option <?php if($instance['openTab'] == 1) echo ('SELECTED');?>>1</option>
                            <option <?php if($instance['openTab'] == 2) echo ('SELECTED');?>>2</option>
                            <option <?php if($instance['openTab'] == 3) echo ('SELECTED');?>>3</option>
                            <option <?php if($instance['openTab'] == 4) echo ('SELECTED');?>>4</option>
                            <option <?php if($instance['openTab'] == 5) echo ('SELECTED');?>>5</option>
                        </select>                      
                </p>
                <p>
                    <?php _e('Opens on tab number - 1 for first tab, 2 for second tab etc.', 'bcw-language'); ?>
                </p>
                <p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('createdBy'); ?>" name="<?php echo $this->get_field_name('createdBy'); ?>" <?php checked($instance['createdBy'], 'on'); ?> />
			<label for="<?php echo $this->get_field_id('createdBy'); ?>"><?php _e('Display created by? Please only remove this after making a ', 'bcw-language'); ?><a href="http://stressfreesites.co.uk/plugins/business-contact-widget" target="_blank"><?php _e('donation.', 'bcw-language'); ?></a><?php _e('so we can continue making plugins like these.', 'bcw-language'); ?></label>
		</p>
                <?php
    }
    
}
add_action( 'widgets_init', create_function('', 'return register_widget("Business_Contact_Widget");'));
?>
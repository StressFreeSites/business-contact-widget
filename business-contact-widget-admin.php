<?php
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

define('BCW_DEFAULT_TAB', 'contact-settings');

function bcw_settings_styles() {
   wp_enqueue_style('business-contact-widget-admin', plugins_url('business-contact-widget/css/business-contact-widget-admin.min.css'));
   
   // Load Jquery UI
   wp_enqueue_style('business-contact-widget-admin-jquery-ui', plugins_url('business-contact-widget/css/jquery-ui-admin.min.css'));   
}
function bcw_settings_scripts() {
   wp_enqueue_script('jquery');
   wp_enqueue_script('jquery-ui-core');
   wp_enqueue_script('jquery-ui-accordion');
   wp_enqueue_script('business-contact-widget-admin', plugins_url('business-contact-widget/js/business-contact-widget-admin.min.js'), array('jquery', 'jquery-ui-core', 'jquery-ui-accordion'), '1.0', true);
}
function bcw_settings_page_init() {   
    // Register our plugin page
    $settings_page = add_options_page('Business Contact Widget','Business Contact Widget', 'manage_options', 'business-contact-widget', 'bcw_display_settings_page');

    // Add in check to see if the page is being saved
    add_action('load-' . $settings_page, 'bcw_update_settings');

    // Using registered $page handle to hook stylesheet loading 
    add_action('admin_print_styles-' . $settings_page, 'bcw_settings_styles');     
    
    // Using registered $page handle to hook stylesheet loading 
    add_action('admin_print_scripts-' . $settings_page, 'bcw_settings_scripts');     
}
add_action('admin_menu', 'bcw_settings_page_init');

function bcw_settings_init() {
    $settings = get_option('bcw_settings');
    if ( empty( $settings ) ) {
            $settings = array('telephone' => '', 'fax' => '', 'mobileName' => '', 'mobileNo' => '', 'mobileName2' => '', 'mobileNo2' => '', 'mobileName3' => '', 'mobileNo3' => '', 'otherTelephoneName' => '', 'otherTelephoneNo' => '', 
                          'email' => '', 'personalEmailName' => '', 'personalEmail' => '', 'personalEmailName2' => '', 'personalEmail2' => '', 'personalEmailName3' => '', 'personalEmail3' => '', 'otherEmailName' => '', 'otherEmail' => '',
                          'mainAddressName' => '', 'mainAddress' => '', 'secondaryAddressName' => '', 'secondaryAddress' => '', 'tertiaryAddressName' => '', 'tertiaryAddress' => '', 'quaternaryAddressName' => '', 'quaternaryAddress' => '', 
                          'message' => '',
                          'map' => '<iframe width="220" height="220" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.uk/maps?client=safari&amp;oe=UTF-8&amp;q=London&amp;ie=UTF8&amp;hq=&amp;hnear=London,+United+Kingdom&amp;gl=uk&amp;t=m&amp;z=11&amp;ll=51.507335,-0.127683&amp;output=embed"></iframe>', 
                          'openingTimes' => '',
                          'style' => 'Skeleton',
                          'icons' => 'Standard',
                          'iconSize' => 'Large',
                          'tabDirection' => 'Horizontal',
                          'createdBy' => 'true',
                          'loadJqueryUI' => 'true',
                          'loadScripts' => array('jQuery' => 'true',  'jQuery-ui-core' => 'true', 'jQuery-ui-tabs' => 'true')
                            );
            add_option('bcw_settings', $settings, '', 'yes');
    }	
}
add_action('init', 'bcw_settings_init');

function bcw_update_settings() {
    if(isset($_POST['Submit'])) {
        check_admin_referer('bcw-settings-page');
        bcw_save_settings();
        
        // Create redirect URL
        $url_parameters = isset($_GET['tab'])? 'updated=true&tab='.$_GET['tab'] : 'updated=true';
        wp_redirect(admin_url('options-general.php?page=business-contact-widget&'.$url_parameters));
        
        exit;
    }
}

function bcw_save_settings() {
    global $pagenow;
    $settings = get_option('bcw_settings');

    if($pagenow == 'options-general.php' && $_GET['page'] == 'business-contact-widget') { 
        if (isset ($_GET['tab'])){
            $tab = $_GET['tab']; 
        }
        else {
            $tab = BCW_DEFAULT_TAB; 
        }
        switch($tab) { 
            case 'contact-settings':
                $settings['telephone'] = sanitize_text_field($_POST['bcw_telephone']);
                $settings['fax'] = sanitize_text_field($_POST['bcw_fax']);
                $settings['mobileName'] = sanitize_text_field($_POST['bcw_mobileName']);
                $settings['mobileNo'] = sanitize_text_field($_POST['bcw_mobileNo']);
                $settings['mobileName2'] = sanitize_text_field($_POST['bcw_mobileName2']);
                $settings['mobileNo2'] = sanitize_text_field($_POST['bcw_mobileNo2']);
                $settings['mobileName3'] = sanitize_text_field($_POST['bcw_mobileName3']);
                $settings['mobileNo3'] = sanitize_text_field($_POST['bcw_mobileNo3']);
                $settings['otherTelephoneName'] = sanitize_text_field($_POST['bcw_otherTelephoneName']);
                $settings['otherTelephoneNo'] = sanitize_text_field($_POST['bcw_otherTelephoneNo']);
                $settings['email'] = sanitize_text_field($_POST['bcw_email']);
                $settings['personalEmailName'] = sanitize_text_field($_POST['bcw_personalEmailName']);
                $settings['personalEmail'] = sanitize_text_field($_POST['bcw_personalEmail']);
                $settings['personalEmailName2'] = sanitize_text_field($_POST['bcw_personalEmailName2']);
                $settings['personalEmail2'] = sanitize_text_field($_POST['bcw_personalEmail2']);
                $settings['personalEmailName3'] = sanitize_text_field($_POST['bcw_personalEmailName3']);
                $settings['personalEmail3'] = sanitize_text_field($_POST['bcw_personalEmail3']);
                $settings['otherEmailName'] = sanitize_text_field($_POST['bcw_otherEmailName']);
                $settings['otherEmail'] = sanitize_text_field($_POST['bcw_otherEmail']);  
                $settings['mainAddressName'] = sanitize_text_field($_POST['bcw_mainAddressName']);
                $settings['mainAddress'] = $_POST['bcw_mainAddress'];
                $settings['secondaryAddressName'] = sanitize_text_field($_POST['bcw_secondaryAddressName']);
                $settings['secondaryAddress'] = $_POST['bcw_secondaryAddress'];
                $settings['tertiaryAddressName'] = sanitize_text_field($_POST['bcw_tertiaryAddressName']);
                $settings['tertiaryAddress'] = $_POST['bcw_tertiaryAddress'];
                $settings['quaternaryAddressName'] = sanitize_text_field($_POST['bcw_quaternaryAddressName']);
                $settings['quaternaryAddress'] = $_POST['bcw_quaternaryAddress'];
                $settings['message'] = $_POST['bcw_message'];
                $settings['map'] = $_POST['bcw_map'];
                $settings['openingTimes'] = $_POST['bcw_openingTimes'];
                break; 
            case 'style-settings': 
                $settings['style'] = $_POST['bcw_style'];
                $settings['icons'] = $_POST['bcw_icons'];
                $settings['iconSize'] = $_POST['bcw_iconSize'];
                $settings['tabDirection'] = $_POST['bcw_tabDirection'];
                if(isset($_POST['bcw_createdBy'])) {
                    $settings['createdBy'] = $_POST['bcw_createdBy'];   
                }
                else {
                    $settings['createdBy'] = 'false';
                }
                break;
            case 'system-settings' : 
                if(isset($_POST['bcw_loadJqueryUI'])) {
                    $settings['loadJqueryUI'] = $_POST['bcw_loadJqueryUI'];
                }
                else {
                    $settings['loadJqueryUI'] = 'false';
                }
                if(isset($_POST['bcw_loadScripts']['jQuery'])) {
                    $settings['loadScripts']['jQuery'] = $_POST['bcw_loadScripts']['jQuery'];  
                }
                else {
                    $settings['loadScripts']['jQuery'] = 'false';
                }
                if(isset($_POST['bcw_loadScripts']['jQuery-ui-core'])) {
                    $settings['loadScripts']['jQuery-ui-core'] = $_POST['bcw_loadScripts']['jQuery-ui-core'];  
                }
                else {
                    $settings['loadScripts']['jQuery-ui-core'] = 'false';
                }
                if(isset($_POST['bcw_loadScripts']['jQuery-ui-tabs'])) {
                    $settings['loadScripts']['jQuery-ui-tabs'] = $_POST['bcw_loadScripts']['jQuery-ui-tabs'];  
                }
                else {
                    $settings['loadScripts']['jQuery-ui-tabs'] = 'false';
                }
                break;
        }
    }

    if(!current_user_can('unfiltered_html')) {
        if($settings['telephone']) {
            $settings['telephone'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['telephone'])));
        }
        if($settings['fax']) {
            $settings['fax'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['fax'])));
        }
        if($settings['mobileName']) {
            $settings['mobileName'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['mobileName'])));
        }
        if($settings['mobileNo']) {
            $settings['mobileNo'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['mobileNo'])));
        }
        if($settings['mobileName2']) {
            $settings['mobileName2'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['mobileName2'])));
        }
        if($settings['mobileNo2']) {
            $settings['mobileNo2'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['mobileNo2'])));
        }
        if($settings['mobileName3']) {
            $settings['mobileName3'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['mobileName3'])));
        }
        if($settings['mobileNo3']) {
            $settings['mobileNo3'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['mobileNo3'])));
        }
        if($settings['otherTelephoneName']) {
            $settings['otherTelephoneName'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['otherTelephoneName'])));
        }
        if($settings['otherTelephoneNo']) {
            $settings['otherTelephoneNo'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['otherTelephoneNo'])));
        }
        if($settings['email']) {
            $settings['email'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['email'])));
        }
        if($settings['personalEmailName']) {
            $settings['personalEmailName'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['personalEmailName'])));
        }
        if($settings['personalEmail']) {
            $settings['personalEmail'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['personalEmail'])));
        }
        if($settings['personalEmailName2']) {
            $settings['personalEmailName2'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['personalEmailName2'])));
        }
        if($settings['personalEmail2']) {
            $settings['personalEmail2'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['personalEmail2'])));
        }
        if($settings['personalEmailName3']) {
            $settings['personalEmailName3'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['personalEmailName3'])));
        }
        if($settings['personalEmail3']) {
            $settings['personalEmail3'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['personalEmail3'])));
        } 
        if($settings['otherEmailName']) {
            $settings['otherEmailName'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['otherEmailName'])));
        }
        if($settings['otherEmail']) {
            $settings['otherEmail'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['otherEmail'])));
        }   
        if($settings['mainAddressName']) {
            $settings['mainAddressName'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['mainAddressName'])));
        }
        if($settings['mainAddress']) {
            $settings['mainAddress'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['mainAddress'])));
        } 
        if($settings['secondaryAddressName']) {
            $settings['secondaryAddressName'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['secondaryAddressName'])));
        }
        if($settings['secondaryAddress']) {
            $settings['secondaryAddress'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['secondaryAddress'])));
        } 
        if($settings['tertiaryAddressName']) {
            $settings['tertiaryAddressName'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['tertiaryAddressName'])));
        }
        if($settings['tertiaryAddress']) {
            $settings['tertiaryAddress'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['tertiaryAddress'])));
        } 
        if($settings['quaternaryAddressName']) {
            $settings['quaternaryAddressName'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['quaternaryAddressName'])));
        }
        if($settings['quaternaryAddress']) {
            $settings['quaternaryAddress'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['quaternaryAddress'])));
        } 
        if($settings['message']) {
            $settings['message'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['message'])));
        } 
        if($settings['openingTimes']) {
            $settings['openingTimes'] = stripslashes(esc_textarea(wp_filter_post_kses($settings['openingTimes'])));
        } 
    }

    update_option('bcw_settings', $settings);
}

function bcw_display_settings_tabs($current) { 
    $tabs = array('contact-settings' => 'Contact Settings',
                  'style-settings' => 'Style Settings',
                  'system-settings' => 'System Settings',
                  'troubleshooting' => 'Troubleshooting'); 

    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo '<a class="nav-tab' . $class . '" href="?page=business-contact-widget&tab=' . $tab . '">' . $name . '</a>';   
    }
    echo '</h2>';
}

function bcw_display_settings_page() {
    global $pagenow;
    $settings = get_option('bcw_settings');

    ?>
    <div class="wrap">
        <div id="bcw-header">
            <div class="box">
                <?php _e('Plugin created by', 'bcw'); ?><br/><a href="http://stressfreesites.co.uk/?utm_source=backend&utm_medium=plugin&utm_campaign=wordpress" target="_blank"><img src="<?php echo(plugins_url('business-contact-widget/images/stressfreesites.png')); ?>" /></a>
            </div><!-- box -->
            <div id="icon-options-general" class="icon32"><br /></div>
            <h2>
                <?php _e('Business Contact Widget', 'bcw') ?>
            </h2>
            <div class="links">
                <a href="http://stressfreesites.co.uk/development/?utm_source=backend&utm_medium=plugin&utm_campaign=wordpress" target="_blank"><img src="<?php echo(plugins_url('business-contact-widget/images/home_small.jpg')); ?>" /></a>
                <a href="http://facebook.com/stressfreesites" target="_blank"><img src="<?php echo(plugins_url('business-contact-widget/images/facebook_small.jpg')); ?>" /></a>
                <a href="http://twitter.com/stressfreesites" target="_blank"><img src="<?php echo(plugins_url('business-contact-widget/images/twitter_small.jpg')); ?>" /></a>
                <a href="http://stressfreesites.co.uk/forums" target="_blank"><img src="<?php echo(plugins_url('business-contact-widget/images/support_small.jpg')); ?>" /></a>
            </div><!-- links -->  
        </div><!-- bcw-header -->
        <div id="bcw-content">
            <?php

            if (!isset($_GET['tab'])){
                 $_GET['tab'] = BCW_DEFAULT_TAB;
            }
            bcw_display_settings_tabs($_GET['tab']);

            ?>
            <div id="poststuff">
                <form method="post" action="<?php admin_url('options-general.php?page=business-contact-widget'); ?>">
                        <?php
                        wp_nonce_field('bcw-settings-page'); 

                        if ($pagenow == 'options-general.php' && $_GET['page'] == 'business-contact-widget'){ 

                                $tab = $_GET['tab']; 

                                echo '<table class="form-table">';
                                switch($tab) {
                                        case 'contact-settings':
                                            echo '<h2 class="bcw-admin-title">' . __('Contact Settings', 'bcw') . '</h2>';
                                            ?>
                                            <div id="accordion">
                                                <h3 class="bcw-admin-title"><img src="<?php echo(plugins_url('/business-contact-widget/images/telephone.png')); ?>" class="icon" alt="Telephone"/><?php _e('Telephone Settings', 'bcw'); ?></h3>
                                                <div>
                                                    <label for="bcw_telephone"><?php _e('Telephone','bcw'); ?></label><input id="bcw_telephone" name="bcw_telephone" value="<?php echo $settings['telephone']; ?>" />
                                                    <div class="clear"></div>
                                                    <label for="bcw_fax"><?php _e('Fax','bcw'); ?></label><input id="bcw_fax" name="bcw_fax" value="<?php echo $settings['fax']; ?>" /><br />
                                                    <div class="clear"></div>
                                                    <h3>Mobile Number</h3>
                                                    <label for="bcw_mobileName"><?php _e('Name','bcw'); ?></label><input id="bcw_mobileName" name="bcw_mobileName" value="<?php echo $settings['mobileName']; ?>" /><br />		
                                                    <div class="clear"></div>
                                                    <label for="bcw_mobileNo"><?php _e('Number','bcw'); ?></label><input id="bcw_mobileNo" name="bcw_mobileNo" value="<?php echo $settings['mobileNo']; ?>" /><br />		
                                                    <div class="clear"></div>
                                                    <h3>2nd Mobile Number</h3>
                                                    <label for="bcw_mobileName2"><?php _e('Name','bcw'); ?></label><input id="bcw_mobileName2" name="bcw_mobileName2" value="<?php echo $settings['mobileName2']; ?>" /><br />		
                                                    <div class="clear"></div>
                                                    <label for="bcw_mobileNo2"><?php _e('Number','bcw'); ?></label><input id="bcw_mobileNo2" name="bcw_mobileNo2" value="<?php echo $settings['mobileNo2']; ?>" /><br />		
                                                    <div class="clear"></div>
                                                    <h3>3rd Mobile Number</h3>
                                                    <label for="bcw_mobileName3"><?php _e('Name','bcw'); ?></label><input id="bcw_mobileName3" name="bcw_mobileName3" value="<?php echo $settings['mobileName3']; ?>" /><br />		
                                                    <div class="clear"></div>
                                                    <label for="bcw_mobileNo3"><?php _e('Number','bcw'); ?></label><input id="bcw_mobileNo3" name="bcw_mobileNo3" value="<?php echo $settings['mobileNo3']; ?>" /><br />		
                                                    <div class="clear"></div>
                                                    <h3>Other Number</h3>
                                                    <label for="bcw_otherTelephoneName"><?php _e('Name','bcw'); ?></label><input id="bcw_otherTelephoneName" name="bcw_otherTelephoneName" value="<?php echo $settings['otherTelephoneName']; ?>" /><br />		
                                                    <div class="clear"></div>
                                                    <label for="bcw_otherTelephoneNo"><?php _e('Number','bcw'); ?></label><input id="bcw_otherTelephoneNo" name="bcw_otherTelephoneNo" value="<?php echo $settings['otherTelephoneNo']; ?>" /><br /> 
                                                </div>
                                                <h3 class="bcw-admin-title"><img src="<?php echo(plugins_url('/business-contact-widget/images/email.png')); ?>" class="icon" alt="Email"/><?php _e('Email Settings', 'bcw'); ?></h3>
                                                <div>
                                                    <label for="bcw_email"><?php _e('Email','bcw'); ?></label><input id="bcw_email" name="bcw_email" value="<?php echo $settings['email']; ?>" />		
                                                    <div class="clear"></div>
                                                    <h3>Personal Email</h3>
                                                    <label for="bcw_personalEmailName"><?php _e('Name','bcw'); ?></label><input id="bcw_personalEmailName" name="bcw_personalEmailName" value="<?php echo $settings['personalEmailName']; ?>" />		
                                                    <div class="clear"></div>                                       
                                                    <label for="bcw_personalEmail"><?php _e('Email Address','bcw'); ?></label><input id="bcw_personalEmail" name="bcw_personalEmail" value="<?php echo $settings['personalEmail']; ?>" />		
                                                    <div class="clear"></div>
                                                    <h3>2nd Personal Email</h3>
                                                    <label for="bcw_personalEmailName2"><?php _e('Name','bcw'); ?></label><input id="bcw_personalEmailName2" name="bcw_personalEmailName2" value="<?php echo $settings['personalEmailName2']; ?>" />		
                                                    <div class="clear"></div>
                                                    <label for="bcw_personalEmail2"><?php _e('Email Address','bcw'); ?></label><input id="bcw_personalEmail2" name="bcw_personalEmail2" value="<?php echo $settings['personalEmail2']; ?>" />		
                                                    <div class="clear"></div>
                                                    <h3>3rd Personal Email</h3>
                                                    <label for="bcw_personalEmailName3"><?php _e('Name','bcw'); ?></label><input id="bcw_personalEmailName3" name="bcw_personalEmailName3" value="<?php echo $settings['personalEmailName3']; ?>" />		
                                                    <div class="clear"></div>
                                                    <label for="bcw_personalEmail3"><?php _e('Email Address','bcw'); ?></label><input id="bcw_personalEmail3" name="bcw_personalEmail3" value="<?php echo $settings['personalEmail3']; ?>" />		
                                                    <div class="clear"></div>
                                                    <h3>Other Email</h3>
                                                    <label for="bcw_otherEmailName"><?php _e('Name','bcw'); ?></label><input id="bcw_otherEmailName" name="bcw_otherEmailName" value="<?php echo $settings['otherEmailName']; ?>" />		
                                                    <div class="clear"></div>
                                                    <label for="bcw_otherEmail"><?php _e('Email Address','bcw'); ?></label><input id="bcw_otherEmail" name="bcw_otherEmail" value="<?php echo $settings['otherEmail']; ?>" />
                                                </div>
                                                <h3 class="bcw-admin-title"><img src="<?php echo(plugins_url('/business-contact-widget/images/address.png')); ?>" class="icon" alt="Address" /><?php _e('Address Settings', 'bcw'); ?></h3>
                                                <div>
                                                    <h3>Primary Address</h3>
                                                    <label for="bcw_mainAddressName"><?php _e('Name','bcw'); ?></label><input id="bcw_mainAddressName" name="bcw_mainAddressName" value="<?php echo $settings['mainAddressName']; ?>" />		
                                                    <div class="clear"></div>
                                                    <label for="bcw_mainAddress"><?php _e('Address','bcw'); ?></label><textarea id="bcw_mainAddress" name="bcw_mainAddress"><?php echo $settings['mainAddress']; ?></textarea>	
                                                    <div class="clear"></div>
                                                    <h3>Secondary Address</h3>
                                                    <label for="bcw_secondaryAddressName"><?php _e('Address Name','bcw'); ?></label><input id="bcw_secondaryAddressName" name="bcw_secondaryAddressName" value="<?php echo $settings['secondaryAddressName']; ?>" />		
                                                    <div class="clear"></div>
                                                    <label for="bcw_secondaryAddress"><?php _e('Address','bcw'); ?></label><textarea id="bcw_secondaryAddress" name="bcw_secondaryAddress"><?php echo $settings['secondaryAddress']; ?></textarea>
                                                    <div class="clear"></div>
                                                    <h3>Tertiary Address</h3>
                                                    <label for="bcw_tertiaryAddressName"><?php _e('Address Name','bcw'); ?></label><input id="bcw_tertiaryAddressName" name="bcw_tertiaryAddressName" value="<?php echo $settings['tertiaryAddressName']; ?>" />		
                                                    <div class="clear"></div>
                                                    <label for="bcw_tertiaryAddress"><?php _e('Address','bcw'); ?></label><textarea id="bcw_tertiaryAddress" name="bcw_tertiaryAddress"><?php echo $settings['tertiaryAddress']; ?></textarea>
                                                    <div class="clear"></div>
                                                    <h3>Quaternary Address</h3>
                                                    <label for="bcw_quaternaryAddressName"><?php _e('Address Name','bcw'); ?></label><input id="bcw_quaternaryAddressName" name="bcw_quaternaryAddressName" value="<?php echo $settings['quaternaryAddressName']; ?>" />		
                                                    <div class="clear"></div>
                                                    <label for="bcw_quaternaryAddress"><?php _e('Address','bcw'); ?></label><textarea id="bcw_quaternaryAddress" name="bcw_quaternaryAddress"><?php echo $settings['quaternaryAddress']; ?></textarea>
                                                </div>
                                                <h3 class="bcw-admin-title"><img src="<?php echo(plugins_url('/business-contact-widget/images/write.png')); ?>" class="icon" alt="Write" /><?php _e('Message Settings', 'bcw'); ?></h3>
                                                <div>
                                                    <label for="bcw_message"><?php _e('Message Now','bcw'); ?></label><input id="bcw_message" name="bcw_message" value="<?php echo esc_html(stripslashes($settings['message'])); ?>" />
                                                    <div class="clear"></div>
                                                    <p class="description"><?php _e('Enter the shortcode for a contact form to allow instant messages.', 'bcw'); ?></p>
                                                </div>
                                                <h3 class="bcw-admin-title"><img src="<?php echo(plugins_url('/business-contact-widget/images/map.png')); ?>" class="icon" alt="Map"/><?php _e('Location Settings', 'bcw'); ?></h3>
                                                <div>
                                                    <label for="bcw_map"><?php _e('Map','bcw'); ?></label><textarea id="bcw_map" name="bcw_map"><?php echo esc_html(stripslashes($settings['map'])); ?></textarea>
                                                    <div class="clear"></div>
                                                    <p class="description"><?php _e('Insert the iframe code generated from online tools like Google maps', 'bcw'); ?></p>
                                                </div>
                                                <h3 class="bcw-admin-title"><img src="<?php echo(plugins_url('/business-contact-widget/images/clock.png')); ?>" class="icon" alt="Openings" /><?php _e('Opening Times Settings', 'bcw'); ?></h3>
                                                <div>
                                                    <label for="bcw_openingTimes"><?php _e('Opening Times','bcw'); ?></label><textarea id="bcw_openingTimes" name="bcw_openingTimes"><?php echo $settings['openingTimes']; ?></textarea>
                                                </div>
                                            </div><!-- accordion -->
                                            <?php
                                            break; 
                                        case 'style-settings': 
                                            echo '<h2 class="bcw-admin-title">' . __('Style Settings', 'bcw') . '</h2>'; 
                                            ?>
                                            <tbody>
                                                <tr valign="top">
                                                  <th scope="row">
                                                    <label for="bcw_style"><?php _e('Widget Style','bcw'); ?></label>
                                                  </th>
                                                  <td>
                                                    <select name="bcw_style"> 
                                                        <option <?php if($settings['style'] == 'Grey') echo ('SELECTED');?>>Grey</option>
                                                        <option <?php if($settings['style'] == 'Black') echo ('SELECTED');?>>Black</option>
                                                        <option <?php if($settings['style'] == 'Blue') echo ('SELECTED');?>>Blue</option>
                                                        <option <?php if($settings['style'] == 'Red') echo ('SELECTED');?>>Red</option>
                                                        <option <?php if($settings['style'] == 'Green') echo ('SELECTED');?>>Green</option>
                                                        <option <?php if($settings['style'] == 'Skeleton') echo ('SELECTED');?>>Skeleton</option>
                                                     </select><p class="description"><?php _e('Change the widget style to match your website - Skeleton will display minimal styling.', 'bcw'); ?></p>
                                                   </td>               
                                                </tr>
                                                <tr valign="top">
                                                    <th scope="row">
                                                        <label for="bcw_icons"><?php _e('Icon Set','bcw'); ?></label>
                                                    </th>
                                                    <td>
                                                        <select name="bcw_icons"> 
                                                            <option <?php if($settings['icons'] == 'Standard') echo ('SELECTED');?>>Standard</option>
                                                            <option <?php if($settings['icons'] == 'Modern') echo ('SELECTED');?>>Modern</option>
                                                        </select><p class="description"><?php _e('Change which icon set to use.', 'bcw'); ?></p> 
                                                    </td>
                                                </tr>
                                                <tr valign="top">
                                                    <th scope="row">
                                                        <label for="bcw_iconSize"><?php _e('Icon Size','bcw'); ?></label>
                                                    </th>
                                                    <td>
                                                        <select name="bcw_iconSize"> 
                                                            <option <?php if($settings['iconSize'] == 'Large') echo ('SELECTED');?>>Large</option>
                                                            <option <?php if($settings['iconSize'] == 'Medium') echo ('SELECTED');?>>Medium</option>
                                                            <option <?php if($settings['iconSize'] == 'Small') echo ('SELECTED');?>>Small</option>
                                                        </select><p class="description"><?php _e('Change the size of the icons on your website.', 'bcw'); ?></p> 
                                                    </td>
                                                </tr>
                                                <tr valign="top">
                                                    <th scope="row">
                                                        <label for="bcw_tabDirection"><?php _e('Tab Direction','bcw'); ?></label>
                                                    </th>
                                                    <td>
                                                        <select name="bcw_tabDirection"> 
                                                            <option <?php if($settings['tabDirection'] == 'Horizontal') echo ('SELECTED');?>>Horizontal</option>
                                                            <option <?php if($settings['tabDirection'] == 'Vertical') echo ('SELECTED');?>>Vertical</option>
                                                        </select><p class="description"><?php _e('Change the size of the icons on your website.', 'bcw'); ?></p> 
                                                    </td>
                                                </tr>
                                                <tr valign="top">
                                                    <th scope="row">
                                                        <?php _e('Display Created By','bcw'); ?>
                                                    </th>
                                                    <td>
                                                        <input class="checkbox" type="checkbox" id="bcw_createdBy" name="bcw_createdBy" value="true" <?php checked($settings['createdBy'], 'true'); ?> />
                                                        <label for="bcw_createdBy"><?php _e('Please only remove this after making a ', 'bcw'); ?><a href="http://stressfreesites.co.uk/plugins/business-contact-widget/?utm_source=backend&utm_medium=plugin&utm_campaign=wordpress" target="_blank"><?php _e('donation', 'bcw'); ?></a>, <?php _e('so we can continue making plugins like these.', 'bcw'); ?></label>
                                                    </td>
                                                </tr>
                                            </tbody>    
                                            <?php
                                            break;
                                        case 'system-settings': 
                                            echo '<h2 class="bcw-admin-title">' . __('System Settings', 'bcw') . '</h2>'; 
                                            ?>
                                            <tbody>
                                               <tr valign="top">
                                                  <th scope="row">
                                                      <?php _e('Load jQuery UI styling', 'bcw'); ?>
                                                  </th>
                                                  <td>
                                                      <input class="checkbox" type="checkbox" id="bcw_loadJqueryUi" name="bcw_loadJqueryUI" <?php checked($settings['loadJqueryUI'], 'true'); ?> value="true" />
                                                      <label for="bcw_loadJqueryUI"><?php _e('If another plugin or your theme already has jQuery UI loaded (incorrectly) then untick this to stop the plugin\'s styling overriding and interferaring. NOTE: this will make many of the styling option redundant.', 'bcw'); ?></label><br />           
                                                  </td>               
                                               </tr>
                                               <tr valign="top">
                                                  <th scope="row">
                                                      <?php _e('Load jQuery and jQuery UI scripts', 'bcw'); ?>
                                                  </th>
                                                  <td>                  
                                                      <input type="checkbox" name="bcw_loadScripts[jQuery]" value="true" <?php checked($settings['loadScripts']['jQuery'], 'true'); ?> />
                                                      <label for="bcw_loadScripts[jQuery]">jQuery</label><br/>
                                                      <input type="checkbox" name="bcw_loadScripts[jQuery-ui-core]" value="true" <?php checked($settings['loadScripts']['jQuery-ui-core'], 'true'); ?> />
                                                      <label for="bcw_loadScripts[jQuery-ui-core]">jQuery-UI-Core</label><br/>
                                                      <input type="checkbox" name="bcw_loadScripts[jQuery-ui-tabs]" value="true" <?php checked($settings['loadScripts']['jQuery-ui-tabs'], 'true'); ?> />
                                                      <label for="bcw_loadScripts[jQuery-ui-tabs]">jQuery-UI-Tabs</label><br/>
                                                      <p class="description"><?php _e('If another plugin or your theme already has jQuery, jQuery UI or jQuery UI Tabs loaded (incorrectly) then untick the corresponding script to stop the plugin\'s loading it twice causing it not to work.', 'bcw'); ?></p>           
                                                  </td>               
                                               </tr>
                                            </tbody>
                                            <?php
                                            break;
                                        case 'troubleshooting': 
                                            echo '<h2 class="bcw-admin-title">' . __('Troubleshooting', 'bcw') . '</h2>';
                                            echo '<p><span>' . __('If the widget does not display correctly', 'bcw-languaage') . '</span><p>';
                                            echo '<p class="description">' . __('If this happen it means that you have a theme or plugin which loads jQuery or jQuery UI incorrectly. To resolve this untick the options jQuery, jQuery UI and jQuery UI Tabs. See if that makes the widget display correctly. If it doesn\'t try ticking jQuery UI Tabs, then checking, then ticking jQuery UI and so on.' , 'bcw') . '</p>';           
                                            echo '<hr />';
                                            echo '<p><span>' . __('If the widget interferes with the styling of other areas of your website', 'bcw') . '</span><p>';
                                            echo '<p class="description">' . __('If this happens you do not need the default styling of the widet. To resolve this untick the styling option load jQuery UI styling.' , 'bcw') .'</p>';   
                                            break;
                                }
                                echo '</table>';
                        }
                        if($tab != 'troubleshooting'){
                            ?>
                            <input type="submit" name="Submit"  class="button-primary" value="Update Settings" />
                            <?php
                        }
                        ?>
                </form>
                <hr />
            </div><!-- poststuff -->
        </div><!-- bcw-content -->
        <div id="bcw-footer">
            <div class="box">
                <h3>Help us develop the plugin further</h3>
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="6HK26SVJPG2BG">
                    <input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
                </form>
            </div><!-- box -->
            <div class="box">
                <h3>Like this plugin and want more features?</h3> 
                <div class="left-side">
                    <a href="http://socialprofilesandcontactdetailswordpressplugin.com/" target="_blank"><img src="<?php echo(plugins_url('business-contact-widget/images/spacd.jpg')); ?>" /></a>
                </div>
                <div class="right-side">
                    <p>You maybe interested in our premium plugin <br /><a href="http://socialprofilesandcontactdetailswordpressplugin.com/" target="_blank">Social Profiles and Contact Details</a>.</p>
                </div>
            </div><!-- box -->                
            <div class="box">
                <h3>Contribute to this plugin using GitHub</h3>
                <div class="left-side">
                    <a href="https://github.com/StressFreeSites/business-contact-widget" target="_blank"><img src="<?php echo(plugins_url('business-contact-widget/images/github.png')); ?>" /></a>
                </div>
                <div class="right-side">
                    <p><strong>Create new features</strong>, fork this project on <a href="https://github.com/StressFreeSites/business-contact-widget" target="_blank">GitHub</a>.</p>
                    <p><strong>Report a bug</strong>, create an issue on <a href="https://github.com/StressFreeSites/business-contact-widget/issues" target="_blank">GitHub</a>.</p>
                </div>
            </div><!-- box -->
            <div class="box">
                <h3>Let others know about this plugin</h3>
                <a href="https://twitter.com/share" class="twitter-share-button" data-via="StressFreeSites" data-size="large" data-count="none" data-hashtags="wordpress">Tweet</a><br/>
                <div class="fb-share-button" data-href="http://stressfreesites.co.uk/business-contact-widget/" data-width="75" data-type="button"></div>            
                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                  var js, fjs = d.getElementsByTagName(s)[0];
                  if (d.getElementById(id)) return;
                  js = d.createElement(s); js.id = id;
                  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
                  fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));</script>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
            </div><!-- box -->  
        </div><!-- bcw-footer -->
    </div><!-- wrap -->
<?php
}
?>
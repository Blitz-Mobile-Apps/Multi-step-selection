<?php 
/**
 * Plugin Name: Multi Step form Selection
 * Description: ...
 * Plugin URI: #
 * Author: Asad Ali
 * Author URI: #
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: Caixia
 * Domain Path: 
 */

/*
    Copyright (C) Year  Author  Email

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

if ( ! defined( 'ABSPATH' ) ) exit; 

// Add menu Page
require 'includes/multi_menu.php';
// ajax plugin
require 'includes/multi_ajax.php';
// main classs 
require 'includes/main_class.php';
// shortcode 
require 'shortcode/main_shortcode.php';
// config
require 'includes/config.php';


$plugin = plugin_basename(__FILE__);
define('MAINPATH', $dir = plugin_dir_path( __FILE__ ));
define('MAINURL', plugin_dir_url($plugin));



// Check for required minimum version of WordPress and PHP.
if (!function_exists('woo_simple_auction_required')) {
    function woo_simple_auction_required() {
        global $wp_version;
        $wpver = '4.7';     // min WordPress version
        $phpver = '5.6';    // min PHP version

        if ( version_compare( $wp_version, $wpver, '<' ) )
                $flag = 'WordPress';
        elseif ( version_compare( PHP_VERSION, $phpver, '<' ) )
                $flag = 'PHP';
        else
                return;

        if ( 'PHP' === $flag ) {
            $version = $phpver;
        } else {
            $version = $wpver;
        }
        deactivate_plugins( basename( __FILE__ ) );
        wp_die('<p>The <strong>Multi Step form Selection</strong> plugin requires '.$flag.'  version '.$version.' or greater.','Plugin Activation Error',  array( 'response'=>200, 'back_link'=>TRUE ) );
    }
}
register_activation_hook( __FILE__, 'woo_simple_auction_required' );

/**
* multi step main class
*/
class  Multistep{
    function __construct(){
    }

    public function install() {
        global $wpdb;

        $table1 = $wpdb->prefix.'dynamic_form';
        $table2 = $wpdb->prefix.'dynamic_form_inquiries';
        $table3 = $wpdb->prefix.'dynamic_type';

        $sql = "
        CREATE TABLE $table1 (
        `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        `title` varchar(255) DEFAULT NULL,
        `discription` varchar(1000) DEFAULT NULL,
        `benefits` varchar(1000) DEFAULT NULL,
        `img` varchar(500) DEFAULT NULL,
        `type` varchar(500) DEFAULT NULL,
        `data` longtext,
        `price` varchar(20) DEFAULT NULL,
        PRIMARY KEY (`id`)
        );
        CREATE TABLE $table2 (
        `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        `name_blend` varchar(250) DEFAULT NULL,
        `pers_msg` varchar(1000) DEFAULT NULL,
        `amount` varchar(20) DEFAULT NULL,
        `ingredients` longtext,
        `delivery_date` text NOT NULL,
        `billingdata` longtext,
        `transaction_id` varchar(200) DEFAULT NULL,
        `correlationid` varchar(200) DEFAULT NULL,
        `status` enum('new order','pending','delivered','closed') DEFAULT NULL,
        PRIMARY KEY (`id`)
        );
        CREATE TABLE $table3 (
        `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(500) DEFAULT NULL,
        `order` varchar(20) DEFAULT NULL,
        PRIMARY KEY (`id`)
        );
    ";
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);

    // Create Page with shortcode
    $user_id =  get_current_user_id();
    $register_page_availability = get_page_title_for_slug('Multi-step-form');
    if($register_page_availability == false){
        $register_post = array(
            'post_title'    => wp_strip_all_tags( 'Multi step form' ),
            'post_name'     => 'Multi-step-form',
            'post_content'  => '[multistep-form-selection]',
            'post_status'   => 'publish',
            'post_author'   => $user_id,
            'post_type'     => 'page',
        );
        wp_insert_post( $register_post );
    }





   }


}


// checking page is available or not
function get_page_title_for_slug($page_slug) {
    $page = get_page_by_path( $page_slug , OBJECT ); 
    if ( isset($page) ) {
        return true;
    }
    else
    {
        return false;
    }
}


// Instantiate plugin class and add it to the set of globals.
$mainobj = new Multistep();
register_activation_hook(__FILE__, array($mainobj, 'install'));


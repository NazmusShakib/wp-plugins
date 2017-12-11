<?php
/**
 * Plugin Name: Customer Entry Form
 * Plugin URI: https://nazmusshakib.github.io/
 * Description: Form shortcode: [customer-entry-form]
 * Version: 1.0.0
 * Author: Nazmus Shakib
 * Author URI: https://nazmusshakib.github.io/
 * Network: Optional. Whether the plugin can only be activated network wide. Example: true
 * License: A short license name. Example: GPL2
 */

//don't call the file directly
if (!defined('ABSPATH')) exit; //ABS = absolute

register_activation_hook(__FILE__, 'cloudly_customer_data_entry_table');

function cloudly_customer_data_entry_table()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'customer_data';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
      id int(11) NOT NULL AUTO_INCREMENT,
      customer_name varchar(150) DEFAULT NULL,
      customer_email varchar(150) DEFAULT NULL,
      customer_phone varchar(150) DEFAULT NULL,
      designation varchar(150) DEFAULT NULL,
      company varchar(150) DEFAULT NULL,
      interest varchar(150) DEFAULT NULL,
      business_type varchar(150) DEFAULT NULL,
      website varchar(150) DEFAULT NULL,
      contact_person varchar(150) DEFAULT NULL,
      UNIQUE KEY id (id)
    )$charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); //required this scripting line
    dbDelta($sql);
}

//## End of Table creation...

define('ROOTDIRE', plugin_dir_path(__FILE__)); // returns the root directory path of particular plugin
require_once(ROOTDIRE . 'customer-list-table.php');
require_once(ROOTDIRE . 'customer/customer-form.php');
require_once(ROOTDIRE . 'customer/AjaxController.php');
require_once(ROOTDIRE . 'single-customer.php');

add_action('admin_menu', 'cloudly_customer_menu4_Admin');

function cloudly_customer_menu4_Admin()
{
    add_menu_page('Customer Info', // Page title
        'Customer List', // Menu title
        'manage_options', // Capabilities 'edit_pages'
        'customer-listing', // Menu slug
        'cloudly_customers_list', // Function
        'dashicons-clipboard', //Icon
        49 // Position
    );

    // This submenu is HIDDEN, however, we need to add it anyways
    add_submenu_page(null, //parent slug
        'Customer', //page title
        'View', //menu title
        'manage_options', //capability
        'single-customer', //menu slug
        'single_customer'); //function
}


add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('jquery');
    wp_register_style('bootstrap_style', plugins_url('/assets/bootstrap/css/bootstrap.css', __FILE__), false, '1.0.0', 'all');
    wp_enqueue_script('ajaxProcess', plugins_url('/customer/js/ajax-process.js', __FILE__), array('jquery'), '', true);

    wp_localize_script('ajaxProcess', 'myVar', array(
          'ajax_url' => admin_url('admin-ajax.php'),
      ));
});


// use the registered jquery and style above
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('bootstrap_style');
});


    function ns_contact_form_csv_pull() {

       global $wpdb;

       $table = 'customer_data';// table name
       $file = 'customer-information'; // csv file name


      $results = $wpdb->get_results("SHOW COLUMNS FROM $wpdb->prefix$table", ARRAY_A );
       if(count($results) > 0) {
          foreach($results as $result) {
            $csv_output .= ucwords($result['Field']. ", ");
        }
         $csv_output .="\n";
      }

       $results = $wpdb->get_results("SELECT * FROM $wpdb->prefix$table", ARRAY_A );

       if(count($results) > 0) {
          foreach($results as $result) {
          $result = array_values($result);
          $result = implode(", ", $result);
          $csv_output .=  $result."\n";
        }
      }

      $filename = $file."_".date("Y-m-d_H-i",time());
      header("Content-type: application/vnd.ms-excel");
      header("Content-disposition: csv" . date("Y-m-d") . ".csv");
      header( "Content-disposition: filename=".$filename.".csv");
      print $csv_output;
      exit;

    }
   add_action('wp_ajax_csv_pull','ns_contact_form_csv_pull');
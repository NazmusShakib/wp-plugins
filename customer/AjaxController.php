<?php
add_action('wp_ajax_nopriv_load_data', 'load_data'); // not really needed
add_action('wp_ajax_load_data', 'load_data');

function load_data()
{
    global $wpdb;
    if ($_POST["customer_name"] != "") {

        $table = $wpdb->prefix . "customer_data";
        $customer_name = strip_tags($_POST["customer_name"], "");
        $customer_email = strip_tags($_POST["customer_email"], "");
        $customer_phone = strip_tags($_POST["customer_phone"], "");
        $company = strip_tags($_POST["company"], "");
        $designation = strip_tags($_POST["designation"], "");
        $interest = strip_tags($_POST["interest"], "");
        $business_type = strip_tags($_POST["business_type"], "");
        $website = strip_tags($_POST["website"], "");
        $contact_person = strip_tags($_POST["contact_person"], "");
        $wpdb->insert(
            $table,
            array(
                'customer_name' => $customer_name,
                'customer_email' => $customer_email,
                'customer_phone' => $customer_phone,
                'company' => $company,
                'designation' => $designation,
                'interest' => $interest,
                'business_type' => $business_type,
                'website' => $website,
                'contact_person' => $contact_person,
            )
        );
        $status = true;
    } // if the form is submitted but the name is empty
    else
        $status = false;
    // outputs everything
    echo $status;
    wp_die();
}
?>
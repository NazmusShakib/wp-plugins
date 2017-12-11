<?php

function single_customer()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "customer_data";
    $client = $wpdb->get_row($wpdb->prepare("SELECT * from $table_name where id=%s", $_REQUEST['id']));
    ?>

    <style type="text/css">
        th {
            width: 200px;
        }
    </style>

    <div class="wrap">
        <h2>Customer Information</h2>
        <a href="<?php echo admin_url('admin.php?page=customer-listing') ?>">&laquo; Back to list</a>

        <table class='wp-list-table widefat fixed' border="1" style="margin-top: 20px;">
            <tbody>
            <tr>
                <th>Name:</th>
                <td><?php echo $client->customer_name; ?></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td><?php echo $client->customer_email; ?></td>
            </tr>
            <tr>
                <th>Phone:</th>
                <td><?php echo $client->customer_phone; ?></td>
            </tr>
            <tr>
                <th>Company:</th>
                <td><?php echo $client->company; ?></td>
            </tr>
            <tr>
                <th>Designation:</th>
                <td><?php echo $client->designation; ?></td>
            </tr>
            <tr>
                <th>Interest:</th>
                <td><?php echo $client->interest; ?></td>
            </tr>
            <tr>
                <th>Business type:</th>
                <td><?php echo $client->business_type; ?></td>
            </tr>
            <tr>
                <th>Website:</th>
                <td><?php echo $client->website; ?></td>
            </tr>
            <tr>
                <th>Contact person:</th>
                <td><?php echo $client->contact_person; ?></td>
            </tr>
            </tbody>
        </table>

    </div>

<?php }
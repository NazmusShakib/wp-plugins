<?php
// adds a shortcode you can use: [customer-entry-form]
add_shortcode('customer-entry-form', 'customer_entry_form');

function customer_entry_form()
{
    ?>
    <form method="POST" action="#" id="customer-inquiry">

        <div class="form-group">
            <label for="customer-name"><?php _e('Name (required)', 'cloudly-text-domain') ?></label>
            <input type="text" name="customer_name" class="form-control" id="customer-name"
                   placeholder="<?php _e('Your name', 'cloudly-text-domain') ?>">
        </div>

        <div class="form-group">
            <label for="customer-email"><?php _e('Email', 'cloudly-text-domain') ?></label>
            <input type="email" name="customer_email" class="form-control" id="customer-email"
                   placeholder="<?php _e('Your email', 'cloudly-text-domain') ?>">
        </div>

        <div class="form-group">
            <label for="customer-phone"><?php _e('Phone number', 'cloudly-text-domain') ?></label>
            <input type="text" name="customer_phone" class="form-control" id="customer-phone"
                   placeholder="<?php _e('Phone number', 'cloudly-text-domain') ?>">
        </div>

        <div class="form-group">
            <label for="company"><?php _e('Company', 'cloudly-text-domain') ?></label>
            <input type="text" name="company" class="form-control" id="company"
                   placeholder="<?php _e('Company', 'cloudly-text-domain') ?>">
        </div>

        <div class="form-group">
            <label for="designation"><?php _e('Designation', 'cloudly-text-domain') ?></label>
            <input type="text" name="designation" class="form-control" id="designation"
                   placeholder="<?php _e('Designation', 'cloudly-text-domain') ?>">
        </div>

        <div class="form-group">
            <label for="interest"><?php _e('Interest', 'cloudly-text-domain') ?></label>
            <input type="text" name="interest" class="form-control" id="interest"
                   placeholder="<?php _e('Interest', 'cloudly-text-domain') ?>">
        </div>

        <div class="form-group">
            <label for="business-type"><?php _e('Business Type', 'cloudly-text-domain') ?></label>
            <input type="text" name="business_type" class="form-control" id="business-type"
                   placeholder="<?php _e('Business Type', 'cloudly-text-domain') ?>">
        </div>

        <div class="form-group">
            <label for="website"><?php _e('Website', 'cloudly-text-domain') ?></label>
            <input type="text" name="website" class="form-control" id="website"
                   placeholder="<?php _e('website', 'cloudly-text-domain') ?>">
        </div>

        <div class="form-group">
            <label for="contact-person"><?php _e('Contact Person', 'cloudly-text-domain') ?></label>
            <select name="contact_person" id="contact-person" class="form-control">
                <option value="Eshak">Eshak</option>
                <option value="Ranis">Ranis</option>
                <option value="Sifat">Sifat</option>
                <option value="Ishmam">Ishmam</option>
                <option value="Somir">Somir</option>
                <option value="Ovi">Ovi</option>
                <option value="Fima">Fima</option>
                <option value="Bokul">Bokul</option>
                <option value="Others">Others</option>
            </select>
        </div>

        <input type="hidden" name="action" value="load_data"/>

        <input type="submit" name="submit_form" class="btn btn-large btn-block btn-primary"
               value="<?php _e('SUBMIT', 'cloudly-text-domain') ?>">

    </form>

    <div class="clearfix"></div>
    <br>
    <div id="feedback"></div>

    <?php
}
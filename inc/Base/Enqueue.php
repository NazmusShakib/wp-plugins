<?php

namespace Inc\Base;

class Enqueue extends BaseController
{
    public function register()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    }

    public function enqueue()
    {
        // Enqueue all our scripts
        //wp_enqueue_script('jquery');
        wp_enqueue_style('bootstrapCSS', $this->plugin_url . 'assets/bootstrap/css/bootstrap.css');
        wp_enqueue_script('bootstrapJS', $this->plugin_url . 'assets/bootstrap/js/bootstrap.js');
    }


}
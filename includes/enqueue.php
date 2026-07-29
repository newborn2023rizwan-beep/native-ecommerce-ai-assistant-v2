<?php

if (!defined('ABSPATH')) {
    exit;
}


add_action(
    'admin_enqueue_scripts',
    'nea_enqueue_admin_assets'
);


function nea_enqueue_admin_assets($hook)
{

    // Only load on product edit pages
    if (
        $hook !== 'post.php' &&
        $hook !== 'post-new.php'
    ) {
        return;
    }


    wp_enqueue_script(
        'nea-product-editor-js',
        plugin_dir_url(dirname(__FILE__)) . 'assets/js/product-editor.js',
        array(),
        '2.0.0',
        true
    );
}

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
    /*
    |--------------------------------------------------------------------------
    | Only load on product edit pages
    |--------------------------------------------------------------------------
    */

    if (
        $hook !== 'post.php' &&
        $hook !== 'post-new.php'
    ) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Product Editor JavaScript
    |--------------------------------------------------------------------------
    */

    $script_path = plugin_dir_path(dirname(dirname(__FILE__)))
        . 'assets/js/product-editor.js';

    $script_url = plugin_dir_url(dirname(dirname(__FILE__)))
        . 'assets/js/product-editor.js';

    wp_enqueue_script(
        'nea-product-editor-js',
        $script_url,
        array(),
        file_exists($script_path)
            ? filemtime($script_path)
            : '2.0.0',
        true
    );
}

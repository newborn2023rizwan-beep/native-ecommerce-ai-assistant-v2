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
    | Plugin Paths
    |--------------------------------------------------------------------------
    */

    $plugin_path = plugin_dir_path(
        dirname(dirname(__FILE__))
    );

    $plugin_url = plugin_dir_url(
        dirname(dirname(__FILE__))
    );


    /*
    |--------------------------------------------------------------------------
    | JavaScript Files
    |--------------------------------------------------------------------------
    */

    $product_editor_path =
        $plugin_path . 'assets/js/product-editor.js';

    $description_generator_path =
        $plugin_path . 'assets/js/description-generator.js';

    $faq_generator_path =
        $plugin_path . 'assets/js/faq-generator.js';


    /*
    |--------------------------------------------------------------------------
    | Description Generator
    |--------------------------------------------------------------------------
    */

    wp_enqueue_script(
        'nea-description-generator-js',
        $plugin_url . 'assets/js/description-generator.js',
        array(),
        file_exists($description_generator_path)
            ? filemtime($description_generator_path)
            : '2.0.0',
        true
    );


    /*
    |--------------------------------------------------------------------------
    | FAQ Generator
    |--------------------------------------------------------------------------
    */

    wp_enqueue_script(
        'nea-faq-generator-js',
        $plugin_url . 'assets/js/faq-generator.js',
        array(),
        file_exists($faq_generator_path)
            ? filemtime($faq_generator_path)
            : '2.0.0',
        true
    );


    /*
    |--------------------------------------------------------------------------
    | Main Product Editor
    |--------------------------------------------------------------------------
    |
    | This loads last because it initializes the other modules.
    |
    */

    wp_enqueue_script(
        'nea-product-editor-js',
        $plugin_url . 'assets/js/product-editor.js',
        array(
            'nea-description-generator-js',
            'nea-faq-generator-js',
        ),
        file_exists($product_editor_path)
            ? filemtime($product_editor_path)
            : '2.0.0',
        true
    );
}

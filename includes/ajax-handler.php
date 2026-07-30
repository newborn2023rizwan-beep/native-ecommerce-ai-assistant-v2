<?php

if (!defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| Generate Product Description
|--------------------------------------------------------------------------
*/

add_action(
    'wp_ajax_nea_generate_description',
    'nea_generate_description'
);

function nea_generate_description()
{
    $product_title = isset($_POST['product_title'])
        ? sanitize_text_field($_POST['product_title'])
        : '';

    $description = nea_generate_ai_description($product_title);

    wp_send_json_success([
        'description' => $description
    ]);
}


/*
|--------------------------------------------------------------------------
| Generate Product FAQ
|--------------------------------------------------------------------------
*/

add_action(
    'wp_ajax_nea_generate_faq',
    'nea_generate_faq'
);

function nea_generate_faq()
{
    $product_title = isset($_POST['product_title'])
        ? sanitize_text_field($_POST['product_title'])
        : '';

    $faq = nea_generate_ai_faq($product_title);

    wp_send_json_success([
        'faq' => $faq
    ]);
}

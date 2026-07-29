<?php

if (!defined('ABSPATH')) {
    exit;
}


add_action(
    'wp_ajax_nea_generate_description',
    'nea_generate_description'
);


function nea_generate_description()
{
    // Get product title from AJAX
    $product_title = isset($_POST['product_title'])
        ? sanitize_text_field($_POST['product_title'])
        : '';

    // Call API Handler
    $description = nea_generate_ai_description($product_title);

    // Return response
    wp_send_json_success([
        'description' => $description
    ]);
}

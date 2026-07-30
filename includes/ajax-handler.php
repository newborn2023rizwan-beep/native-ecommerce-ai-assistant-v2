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

    $product_title = sanitize_text_field(
        $_POST['product_title'] ?? ''
    );


    $product_context = sanitize_textarea_field(
        $_POST['product_context'] ?? ''
    );


    $benefits = sanitize_textarea_field(
        $_POST['benefits'] ?? ''
    );


    $tone = sanitize_text_field(
        $_POST['tone'] ?? ''
    );


    $length = sanitize_text_field(
        $_POST['length'] ?? ''
    );


    $description = nea_generate_ai_description(
        $product_title,
        $product_context,
        $benefits,
        $tone,
        $length
    );


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

    $product_title = sanitize_text_field(
        $_POST['product_title'] ?? ''
    );


    $product_info = sanitize_textarea_field(
        $_POST['product_info'] ?? ''
    );


    $faq_mode = sanitize_text_field(
        $_POST['faq_mode'] ?? 'auto'
    );


    $custom_questions_raw = sanitize_textarea_field(
        $_POST['custom_questions'] ?? ''
    );


    $custom_questions = array_filter(
        explode("\n", $custom_questions_raw)
    );


    $faq = nea_generate_ai_faq(
        $product_title,
        $product_info,
        $faq_mode,
        $custom_questions
    );


    wp_send_json_success([
        'faq' => $faq
    ]);
}

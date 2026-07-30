<?php

if (!defined('ABSPATH')) {
    exit;
}


/**
 * Generate AI Product Description
 */
function nea_generate_ai_description(
    $product_title,
    $product_context,
    $benefits,
    $tone,
    $length
) {

    $product_title = trim($product_title);

    if (empty($product_title)) {
        return '';
    }


    /*
    |--------------------------------------------------------------------------
    | Build Prompt
    |--------------------------------------------------------------------------
    */

    $prompt = nea_build_description_prompt(
        $product_title,
        $product_context,
        $benefits,
        $tone,
        $length
    );


    /*
    |--------------------------------------------------------------------------
    | Send Request
    |--------------------------------------------------------------------------
    */

    $response = nea_openai_request($prompt);


    if (is_wp_error($response)) {

        return '<p><strong>'
            . esc_html($response->get_error_message())
            . '</strong></p>';
    }


    /*
    |--------------------------------------------------------------------------
    | Decode Response
    |--------------------------------------------------------------------------
    */

    $body = json_decode(
        wp_remote_retrieve_body($response),
        true
    );


    /*
    |--------------------------------------------------------------------------
    | Parse Response
    |--------------------------------------------------------------------------
    */

    return nea_parse_openai_response($body);
}



/**
 * Generate AI Product FAQ
 */
function nea_generate_ai_faq(
    $product_title,
    $product_info,
    $faq_mode = 'auto',
    $custom_questions = []
) {

    $product_title = trim($product_title);

    if (empty($product_title)) {
        return '';
    }


    /*
    |--------------------------------------------------------------------------
    | Build FAQ Prompt
    |--------------------------------------------------------------------------
    */

    $prompt = nea_build_faq_prompt(
        $product_title,
        $product_info,
        $faq_mode,
        $custom_questions
    );


    /*
    |--------------------------------------------------------------------------
    | Send Request
    |--------------------------------------------------------------------------
    */

    $response = nea_openai_request($prompt);


    if (is_wp_error($response)) {

        return '<p><strong>'
            . esc_html($response->get_error_message())
            . '</strong></p>';
    }


    /*
    |--------------------------------------------------------------------------
    | Decode Response
    |--------------------------------------------------------------------------
    */

    $body = json_decode(
        wp_remote_retrieve_body($response),
        true
    );


    /*
    |--------------------------------------------------------------------------
    | Parse Response
    |--------------------------------------------------------------------------
    */

    return nea_parse_openai_response($body);
}

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
            . esc_html(
                $response->get_error_message()
            )
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

    $description = nea_parse_openai_response($body);


    /*
    |--------------------------------------------------------------------------
    | Remove Duplicate Product Title
    |--------------------------------------------------------------------------
    |
    | WooCommerce already displays the product title separately.
    | Therefore the AI Description must not contain the same title
    | as its first line/heading.
    |
    */

    if (!empty($description)) {

        $clean_title = trim(
            wp_strip_all_tags(
                $product_title
            )
        );

        $clean_description = trim(
            $description
        );


        /*
        |----------------------------------------------------------------------
        | Remove HTML heading containing the exact product title
        |----------------------------------------------------------------------
        */

        $clean_description = preg_replace(
            '/^\s*<(h[1-6])[^>]*>\s*'
                . preg_quote($clean_title, '/')
                . '\s*<\/\1>\s*/iu',
            '',
            $clean_description,
            1
        );


        /*
        |----------------------------------------------------------------------
        | Remove plain-text product title from the beginning
        |----------------------------------------------------------------------
        */

        $clean_description = preg_replace(
            '/^\s*'
                . preg_quote($clean_title, '/')
                . '\s*(?:<br\s*\/?>|\r?\n|\r|:|-)?\s*/iu',
            '',
            $clean_description,
            1
        );


        /*
        |----------------------------------------------------------------------
        | Remove Markdown heading containing the exact product title
        |----------------------------------------------------------------------
        */

        $clean_description = preg_replace(
            '/^\s*#+\s*'
                . preg_quote($clean_title, '/')
                . '\s*(?:\r?\n|\r)+/iu',
            '',
            $clean_description,
            1
        );


        $description = trim(
            $clean_description
        );
    }


    return $description;
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
            . esc_html(
                $response->get_error_message()
            )
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

<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Send Request to OpenAI Responses API
 */
function nea_openai_request($prompt)
{
    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */

    $api_key = trim(
        get_option('nea_openai_api_key', '')
    );

    $model = get_option(
        'nea_openai_model',
        'gpt-5-mini'
    );

    if (empty($api_key)) {

        return new WP_Error(
            'missing_api_key',
            'OpenAI API Key is not configured.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Request
    |--------------------------------------------------------------------------
    */

    $response = wp_remote_post(

        NEA_OPENAI_API_URL,

        array(

            'headers' => array(

                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type'  => 'application/json',

            ),

            'body' => wp_json_encode(

                array(

                    'model' => $model,

                    'input' => $prompt,

                )

            ),

            'timeout' => 60,

        )

    );

    return $response;
}

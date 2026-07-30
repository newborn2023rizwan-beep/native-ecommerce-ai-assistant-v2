<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Parse OpenAI Responses API Output
 */
function nea_parse_openai_response($body)
{
    /*
    |--------------------------------------------------------------------------
    | API Error
    |--------------------------------------------------------------------------
    */

    if (isset($body['error'])) {

        return '<pre>'
            . esc_html($body['error']['message'] ?? 'Unknown API Error')
            . '</pre>';
    }

    /*
    |--------------------------------------------------------------------------
    | Parse Output
    |--------------------------------------------------------------------------
    */

    if (!empty($body['output']) && is_array($body['output'])) {

        foreach ($body['output'] as $item) {

            if (
                isset($item['type']) &&
                $item['type'] === 'message' &&
                !empty($item['content'])
            ) {

                foreach ($item['content'] as $content) {

                    if (
                        isset($content['type']) &&
                        $content['type'] === 'output_text' &&
                        !empty($content['text'])
                    ) {

                        return $content['text'];
                    }
                }
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Debug
    |--------------------------------------------------------------------------
    */

    return '<pre>'
        . esc_html(print_r($body, true))
        . '</pre>';
}

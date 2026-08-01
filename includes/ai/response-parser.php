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
    | Validate Response
    |--------------------------------------------------------------------------
    */

    if (empty($body) || !is_array($body)) {
        return '';
    }


    /*
    |--------------------------------------------------------------------------
    | API Error
    |--------------------------------------------------------------------------
    */

    if (isset($body['error'])) {

        return '<p><strong>'
            . esc_html(
                $body['error']['message']
                    ?? 'Unknown OpenAI API Error'
            )
            . '</strong></p>';
    }


    /*
    |--------------------------------------------------------------------------
    | Collect Output Text
    |--------------------------------------------------------------------------
    */

    $texts = array();


    if (
        isset($body['output']) &&
        is_array($body['output'])
    ) {

        foreach ($body['output'] as $item) {

            if (
                !is_array($item) ||
                empty($item['content']) ||
                !is_array($item['content'])
            ) {
                continue;
            }


            foreach ($item['content'] as $content) {

                if (!is_array($content)) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | Standard Responses API output_text
                |--------------------------------------------------------------------------
                */

                if (
                    isset($content['type']) &&
                    $content['type'] === 'output_text' &&
                    isset($content['text'])
                ) {

                    $text = trim(
                        (string) $content['text']
                    );

                    if ($text !== '') {
                        $texts[] = $text;
                    }

                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | Fallback Text
                |--------------------------------------------------------------------------
                */

                if (
                    isset($content['text']) &&
                    is_string($content['text'])
                ) {

                    $text = trim(
                        $content['text']
                    );

                    if ($text !== '') {
                        $texts[] = $text;
                    }
                }
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Top-Level output_text Fallback
    |--------------------------------------------------------------------------
    */

    if (
        empty($texts) &&
        isset($body['output_text']) &&
        is_string($body['output_text'])
    ) {

        $text = trim(
            $body['output_text']
        );

        if ($text !== '') {
            $texts[] = $text;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | No Text Found
    |--------------------------------------------------------------------------
    */

    if (empty($texts)) {

        /*
        |--------------------------------------------------------------------------
        | Legacy Chat Completion Fallback
        |--------------------------------------------------------------------------
        */

        if (
            isset($body['choices'][0]['message']['content']) &&
            is_string(
                $body['choices'][0]['message']['content']
            )
        ) {

            $texts[] = trim(
                $body['choices'][0]['message']['content']
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Still No Text
    |--------------------------------------------------------------------------
    */

    if (empty($texts)) {

        return '<p><strong>'
            . esc_html(
                'OpenAI returned no readable text response.'
            )
            . '</strong></p>';
    }


    /*
    |--------------------------------------------------------------------------
    | Combine Text Blocks
    |--------------------------------------------------------------------------
    */

    $text = trim(
        implode("\n\n", $texts)
    );


    /*
    |--------------------------------------------------------------------------
    | Detect FAQ Response
    |--------------------------------------------------------------------------
    |
    | If both Question: and Answer: exist, treat the response
    | as FAQ content instead of normal description content.
    |
    */

    if (
        preg_match(
            '/Question\s*:/i',
            $text
        ) &&
        preg_match(
            '/Answer\s*:/i',
            $text
        )
    ) {

        return nea_format_faq_response(
            $text
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Normal AI Content
    |--------------------------------------------------------------------------
    |
    | Description and other non-FAQ content remain unchanged.
    |
    */

    return trim($text);
}


/**
 * Format FAQ Response
 *
 * Converts:
 *
 * Question: ...
 * Answer: ...
 *
 * Question: ...
 * Answer: ...
 *
 * Into clean editable HTML blocks.
 */
function nea_format_faq_response($text)
{
    /*
    |--------------------------------------------------------------------------
    | Normalize Line Breaks
    |--------------------------------------------------------------------------
    */

    $text = str_replace(
        array("\r\n", "\r"),
        "\n",
        $text
    );


    /*
    |--------------------------------------------------------------------------
    | Normalize Question / Answer Labels
    |--------------------------------------------------------------------------
    */

    $text = preg_replace(
        '/\s*Question\s*:/i',
        "\nQuestion:",
        $text
    );

    $text = preg_replace(
        '/\s*Answer\s*:/i',
        "\nAnswer:",
        $text
    );


    $text = trim($text);


    /*
    |--------------------------------------------------------------------------
    | Extract FAQ Blocks
    |--------------------------------------------------------------------------
    */

    preg_match_all(
        '/Question\s*:\s*(.*?)\s*Answer\s*:\s*(.*?)(?=\s*Question\s*:|$)/is',
        $text,
        $matches,
        PREG_SET_ORDER
    );


    /*
    |--------------------------------------------------------------------------
    | If Parsing Fails
    |--------------------------------------------------------------------------
    */

    if (empty($matches)) {
        return nl2br(
            esc_html($text)
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Build FAQ HTML
    |--------------------------------------------------------------------------
    */

    $output = '';


    foreach ($matches as $match) {

        $question = trim(
            wp_strip_all_tags(
                $match[1]
            )
        );

        $answer = trim(
            wp_strip_all_tags(
                $match[2]
            )
        );


        if (
            $question === '' &&
            $answer === ''
        ) {
            continue;
        }


        /*
        |--------------------------------------------------------------------------
        | FAQ Block
        |--------------------------------------------------------------------------
        */

        $output .= '<div class="nea-faq-item" style="margin-bottom:20px;">';


        /*
        |--------------------------------------------------------------------------
        | Question
        |--------------------------------------------------------------------------
        */

        if ($question !== '') {

            $output .= '<p style="margin:0 0 6px 0;">'
                . '<strong>'
                . esc_html($question)
                . '</strong>'
                . '</p>';
        }


        /*
        |--------------------------------------------------------------------------
        | Answer
        |--------------------------------------------------------------------------
        */

        if ($answer !== '') {

            $output .= '<p style="margin:0;">'
                . esc_html($answer)
                . '</p>';
        }


        $output .= '</div>';
    }


    /*
    |--------------------------------------------------------------------------
    | Return Formatted FAQ
    |--------------------------------------------------------------------------
    */

    return $output;
}

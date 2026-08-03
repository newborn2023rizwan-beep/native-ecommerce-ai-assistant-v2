<?php

if (!defined('ABSPATH')) {
    exit;
}


/*
|--------------------------------------------------------------------------
| Add FAQ To WooCommerce Description Tab
|--------------------------------------------------------------------------
*/

add_filter(
    'woocommerce_product_tabs',
    'nea_add_faq_to_description_tab',
    20
);

function nea_add_faq_to_description_tab($tabs)
{
    if (!isset($tabs['description'])) {
        return $tabs;
    }

    $tabs['description']['callback'] = 'nea_render_description_with_faq';

    return $tabs;
}


/*
|--------------------------------------------------------------------------
| Render Long Description + FAQ
|--------------------------------------------------------------------------
*/

function nea_render_description_with_faq($key, $tab)
{
    /*
    |--------------------------------------------------------------------------
    | Normal WooCommerce Long Description
    |--------------------------------------------------------------------------
    */

    woocommerce_product_description_tab();


    /*
    |--------------------------------------------------------------------------
    | FAQ Immediately After Long Description
    |--------------------------------------------------------------------------
    */

    nea_render_frontend_ai_faq();
}


/*
|--------------------------------------------------------------------------
| Render AI Product FAQ
|--------------------------------------------------------------------------
*/

function nea_render_frontend_ai_faq()
{
    global $product;

    if (!$product) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Get Saved FAQ
    |--------------------------------------------------------------------------
    */

    $faq = get_post_meta(
        $product->get_id(),
        'nea_ai_faq',
        true
    );

    if (empty($faq)) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Prepare FAQ
    |--------------------------------------------------------------------------
    |
    | The FAQ is saved from:
    |
    | faqContent.innerHTML
    |
    | Therefore the saved value may contain:
    |
    | <div>Question</div>
    | <div>Answer</div>
    |
    | or:
    |
    | <p>Question</p>
    | <p>Answer</p>
    |
    | We convert the saved HTML into clean text blocks first.
    |
    */

    $faq_html = wp_unslash($faq);


    /*
    |--------------------------------------------------------------------------
    | 1. Try Explicit Question: / Answer: Format
    |--------------------------------------------------------------------------
    */

    $faq_items = array();

    preg_match_all(
        '/Question\s*:\s*(.*?)\s*Answer\s*:\s*(.*?)(?=\s*Question\s*:|$)/is',
        wp_strip_all_tags($faq_html),
        $matches,
        PREG_SET_ORDER
    );


    if (!empty($matches)) {

        foreach ($matches as $match) {

            $question = trim($match[1]);
            $answer   = trim($match[2]);

            if (
                $question === '' ||
                $answer === ''
            ) {
                continue;
            }

            $faq_items[] = array(
                'question' => $question,
                'answer'   => $answer,
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | 2. Parse HTML Block Format
    |--------------------------------------------------------------------------
    |
    | Current AI output is commonly saved as HTML through:
    |
    | faqContent.innerHTML
    |
    */

    if (empty($faq_items)) {

        /*
        |--------------------------------------------------------------------------
        | Replace Block-Level HTML Elements With New Lines
        |--------------------------------------------------------------------------
        */

        $faq_text = preg_replace(
            '/<(br\s*\/?|\/p|\/div|\/li|\/h[1-6])\s*>/i',
            "\n",
            $faq_html
        );


        /*
        |--------------------------------------------------------------------------
        | Remove Remaining HTML Tags
        |--------------------------------------------------------------------------
        */

        $faq_text = wp_strip_all_tags(
            $faq_text
        );


        /*
        |--------------------------------------------------------------------------
        | Decode HTML Entities
        |--------------------------------------------------------------------------
        */

        $faq_text = html_entity_decode(
            $faq_text,
            ENT_QUOTES,
            'UTF-8'
        );


        /*
        |--------------------------------------------------------------------------
        | Normalize Whitespace
        |--------------------------------------------------------------------------
        */

        $faq_text = str_replace(
            array(
                "\r\n",
                "\r"
            ),
            "\n",
            $faq_text
        );


        /*
        |--------------------------------------------------------------------------
        | Remove Empty Lines At Beginning / End
        |--------------------------------------------------------------------------
        */

        $faq_text = trim(
            $faq_text
        );


        /*
        |--------------------------------------------------------------------------
        | Split Into Lines
        |--------------------------------------------------------------------------
        */

        $lines = preg_split(
            "/\n+/",
            $faq_text
        );


        $clean_lines = array();


        foreach ($lines as $line) {

            $line = trim($line);

            if ($line === '') {
                continue;
            }

            $clean_lines[] = $line;
        }


        /*
        |--------------------------------------------------------------------------
        | Build Question / Answer Pairs
        |--------------------------------------------------------------------------
        |
        | Expected:
        |
        | line 0 = Question
        | line 1 = Answer
        | line 2 = Question
        | line 3 = Answer
        |
        */

        $line_count = count($clean_lines);

        for (
            $i = 0;
            $i + 1 < $line_count;
            $i += 2
        ) {

            $question = trim(
                $clean_lines[$i]
            );

            $answer = trim(
                $clean_lines[$i + 1]
            );


            if (
                $question === '' ||
                $answer === ''
            ) {
                continue;
            }


            $faq_items[] = array(
                'question' => $question,
                'answer'   => $answer,
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Safety Check
    |--------------------------------------------------------------------------
    */

    if (empty($faq_items)) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Frontend FAQ
    |--------------------------------------------------------------------------
    */

?>

    <section class="nea-ai-faq">

        <div class="nea-ai-faq-header">

            <h2 class="nea-ai-faq-title">
                Frequently Asked Questions
            </h2>

        </div>


        <div class="nea-ai-faq-list">

            <?php foreach ($faq_items as $item) : ?>

                <article class="nea-ai-faq-item">

                    <!-- QUESTION -->

                    <div class="nea-ai-faq-question">

                        <span class="nea-ai-faq-label">
                            Q
                        </span>

                        <div class="nea-ai-faq-question-text">

                            <?php
                            echo esc_html(
                                $item['question']
                            );
                            ?>

                        </div>

                    </div>


                    <!-- ANSWER -->

                    <div class="nea-ai-faq-answer">

                        <span class="nea-ai-faq-label nea-ai-faq-answer-label">
                            A
                        </span>

                        <div class="nea-ai-faq-answer-text">

                            <?php
                            echo wp_kses_post(
                                wpautop(
                                    $item['answer']
                                )
                            );
                            ?>

                        </div>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    </section>


    <style>
        /*
|--------------------------------------------------------------------------
| FAQ Container
|--------------------------------------------------------------------------
*/

        .nea-ai-faq {
            margin-top: 40px;
            padding-top: 32px;
            border-top: 1px solid #e5e7eb;
        }


        /*
|--------------------------------------------------------------------------
| FAQ Title
|--------------------------------------------------------------------------
*/

        .nea-ai-faq-title {
            margin: 0 0 24px;
            font-size: 28px;
            line-height: 1.3;
            font-weight: 600;
        }


        /*
|--------------------------------------------------------------------------
| FAQ List
|--------------------------------------------------------------------------
*/

        .nea-ai-faq-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }


        /*
|--------------------------------------------------------------------------
| FAQ Item
|--------------------------------------------------------------------------
*/

        .nea-ai-faq-item {
            padding: 20px 22px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #fff;
        }


        /*
|--------------------------------------------------------------------------
| Question
|--------------------------------------------------------------------------
*/

        .nea-ai-faq-question {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 12px;
        }


        .nea-ai-faq-question-text {
            flex: 1;
            font-size: 17px;
            line-height: 1.5;
            font-weight: 600;
        }


        /*
|--------------------------------------------------------------------------
| Answer
|--------------------------------------------------------------------------
*/

        .nea-ai-faq-answer {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }


        .nea-ai-faq-answer-text {
            flex: 1;
            font-size: 16px;
            line-height: 1.7;
            color: #555;
        }


        .nea-ai-faq-answer-text p {
            margin: 0 0 10px;
        }


        .nea-ai-faq-answer-text p:last-child {
            margin-bottom: 0;
        }


        /*
|--------------------------------------------------------------------------
| Q / A Label
|--------------------------------------------------------------------------
*/

        .nea-ai-faq-label {
            flex: 0 0 auto;
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            background: #f3f4f6;
            font-size: 13px;
            line-height: 1;
            font-weight: 700;
        }


        .nea-ai-faq-answer-label {
            background: #f9fafb;
        }


        /*
|--------------------------------------------------------------------------
| Mobile
|--------------------------------------------------------------------------
*/

        @media (max-width: 600px) {

            .nea-ai-faq {
                margin-top: 30px;
                padding-top: 24px;
            }

            .nea-ai-faq-title {
                font-size: 24px;
            }

            .nea-ai-faq-item {
                padding: 16px;
            }

            .nea-ai-faq-question-text {
                font-size: 16px;
            }

            .nea-ai-faq-answer-text {
                font-size: 15px;
            }

        }
    </style>

<?php
}

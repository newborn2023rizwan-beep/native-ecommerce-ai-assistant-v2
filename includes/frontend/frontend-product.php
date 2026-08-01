<?php

if (!defined('ABSPATH')) {
    exit;
}


/*
|--------------------------------------------------------------------------
| Add FAQ To WooCommerce Description Tab
|--------------------------------------------------------------------------
|
| FAQ is rendered directly after the normal WooCommerce
| long description.
|
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
    | Render Normal WooCommerce Long Description
    |--------------------------------------------------------------------------
    */

    woocommerce_product_description_tab();


    /*
    |--------------------------------------------------------------------------
    | Render FAQ Immediately After Long Description
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
    | Parse Question / Answer Blocks
    |--------------------------------------------------------------------------
    |
    | Expected format:
    |
    | Question: ...
    | Answer: ...
    |
    | Question: ...
    | Answer: ...
    |
    */

    preg_match_all(
        '/Question\s*:\s*(.*?)\s*Answer\s*:\s*(.*?)(?=\s*Question\s*:|$)/is',
        $faq,
        $matches,
        PREG_SET_ORDER
    );


    /*
    |--------------------------------------------------------------------------
    | Build FAQ Items
    |--------------------------------------------------------------------------
    */

    $faq_items = array();

    if (!empty($matches)) {

        foreach ($matches as $match) {

            $question = trim($match[1]);
            $answer   = trim($match[2]);

            if (
                empty($question) ||
                empty($answer)
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
    | If Parser Fails
    |--------------------------------------------------------------------------
    |
    | Do not completely hide the saved FAQ.
    |
    */

    if (empty($faq_items)) {

        echo '<section class="nea-ai-faq">';

        echo '<h2 class="nea-ai-faq-title">';
        echo 'Frequently Asked Questions';
        echo '</h2>';

        echo '<div class="nea-ai-faq-list">';

        echo wp_kses_post(
            wpautop($faq)
        );

        echo '</div>';

        echo '</section>';

        return;
    }

?>

    <style>
        .nea-ai-faq {
            margin-top: 40px;
            margin-bottom: 30px;
        }

        .nea-ai-faq-title {
            margin-bottom: 25px;
        }

        .nea-ai-faq-item {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e5e5;
        }

        .nea-ai-faq-item:last-child {
            margin-bottom: 0;
            border-bottom: 0;
        }

        .nea-ai-faq-question {
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .nea-ai-faq-answer {
            line-height: 1.7;
        }
    </style>


    <section class="nea-ai-faq">

        <h2 class="nea-ai-faq-title">
            Frequently Asked Questions
        </h2>


        <div class="nea-ai-faq-list">

            <?php foreach ($faq_items as $faq_item) : ?>

                <article class="nea-ai-faq-item">

                    <div class="nea-ai-faq-question">

                        <strong>
                            Question:
                        </strong>

                        <?php
                        echo esc_html(
                            $faq_item['question']
                        );
                        ?>

                    </div>


                    <div class="nea-ai-faq-answer">

                        <strong>
                            Answer:
                        </strong>

                        <?php
                        echo esc_html(
                            $faq_item['answer']
                        );
                        ?>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    </section>

<?php
}

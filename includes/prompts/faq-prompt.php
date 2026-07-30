<?php

if (!defined('ABSPATH')) {
    exit;
}


/**
 * Build AI FAQ Prompt
 */
function nea_build_faq_prompt(
    $product_title,
    $product_info,
    $faq_mode = 'auto',
    $custom_questions = []
) {

    $prompt = "

You are an expert ecommerce copywriter.

Generate customer-focused FAQs for this product.

Product Name:
{$product_title}


Product Information:
{$product_info}


";


    if ($faq_mode === 'custom' && !empty($custom_questions)) {

        $prompt .= "

Answer these customer questions:

";

        foreach ($custom_questions as $question) {

            $prompt .= "- " . $question . "\n";
        }
    } else {

        $prompt .= "

Generate 5 common customer questions and answers.

Focus on:

- Product benefits
- Features
- Usage
- Quality
- Customer concerns
- Buying objections

";
    }


    $prompt .= "

Return format:

Question:
Answer:

Keep answers clear, concise and ecommerce friendly.

";


    return $prompt;
}

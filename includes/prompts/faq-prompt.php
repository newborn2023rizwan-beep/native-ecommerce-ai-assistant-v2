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

    $product_title = trim($product_title);
    $product_info  = trim($product_info);

    /*
    |--------------------------------------------------------------------------
    | Base Prompt
    |--------------------------------------------------------------------------
    */

    $prompt = "

You are an expert ecommerce copywriter.

Generate clear, customer-focused FAQs for the following product.

Product Name:
{$product_title}

Product Information:
{$product_info}

";


    /*
    |--------------------------------------------------------------------------
    | Custom FAQ Mode
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    | When custom questions are provided, answer ONLY those questions.
    | Do not create additional questions.
    |
    */

    if (
        $faq_mode === 'custom' &&
        !empty($custom_questions)
    ) {

        $question_count = count($custom_questions);

        $prompt .= "

CUSTOM QUESTION MODE

The customer has provided exactly {$question_count} question(s).

You MUST answer ONLY the questions listed below.

Do NOT:
- Create additional questions.
- Rewrite the questions into different questions.
- Add extra FAQs.
- Generate five FAQs unless five questions were provided.

Answer every provided question once.

Customer Questions:

";

        foreach ($custom_questions as $question) {

            $question = trim($question);

            if ($question === '') {
                continue;
            }

            $prompt .= "- {$question}\n";
        }


        $prompt .= "

There must be exactly {$question_count} Question and Answer block(s) in your response.

";
    } else {

        /*
        |--------------------------------------------------------------------------
        | Auto FAQ Mode
        |--------------------------------------------------------------------------
        */

        $prompt .= "

AUTO FAQ MODE

Generate exactly 5 common customer questions and answers.

Focus on:

- Product benefits
- Important features
- Usage
- Compatibility
- Quality
- Customer concerns
- Buying objections

Do not generate more than 5 FAQs.

";
    }


    /*
    |--------------------------------------------------------------------------
    | Output Format
    |--------------------------------------------------------------------------
    */

    $prompt .= "

IMPORTANT OUTPUT FORMAT:

Return every FAQ as a separate Question and Answer block.

Use exactly this structure:

Question: [customer question]
Answer: [clear and concise answer]

Question: [customer question]
Answer: [clear and concise answer]

Leave one blank line between each FAQ block.

IMPORTANT RULES:

- Put Question and Answer on separate lines.
- Keep every FAQ as its own separate block.
- Do not combine multiple FAQs into one paragraph.
- Do not use numbered lists.
- Do not use bullet points.
- Do not add a title or heading before the FAQs.
- Do not add a conclusion after the FAQs.
- Do not repeat the product name unnecessarily.
- Keep answers concise and ecommerce-friendly.
- Do not invent unsupported product specifications.
- Use only information provided in the Product Information when specific product facts are required.
- If a specific detail is not provided, give a safe general answer rather than inventing a specification.

";


    return $prompt;
}

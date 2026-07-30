<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Generate AI Product Description (Mock)
 */
function nea_generate_ai_description($product_title)
{
    $product_title = trim($product_title);

    if (empty($product_title)) {
        return '';
    }

    return sprintf(
        'This is an AI-generated description for: %s',
        $product_title
    );
}


/**
 * Generate AI Product FAQ (Mock)
 */
function nea_generate_ai_faq($product_title)
{
    $product_title = trim($product_title);

    if (empty($product_title)) {
        return '';
    }

    return sprintf(
        "Q: What is %s?
A: %s is a high-quality product.

Q: Is it durable?
A: Yes, it is designed for long-term use.

Q: Does it come with a warranty?
A: Warranty information depends on the seller.",
        $product_title,
        $product_title
    );
}

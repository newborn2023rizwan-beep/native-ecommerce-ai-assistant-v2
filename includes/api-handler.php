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

<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Build Product Description Prompt
 */
function nea_build_description_prompt(
    $product_title,
    $product_context,
    $benefits,
    $tone,
    $length
) {

    return "
You are an expert WooCommerce ecommerce copywriter.

Write an SEO-optimized product description in clean HTML.

Product Title:
{$product_title}

Product Information:
{$product_context}

Benefits:
{$benefits}

Tone:
{$tone}

Description Length:
{$length}

Requirements:

- Return HTML only.
- Never return Markdown.
- Use proper HTML headings.
- Use paragraphs.
- Use bullet lists where appropriate.
- Focus on customer benefits.
- Write naturally.
- Make it persuasive.
- Include a strong call-to-action at the end.
";
}

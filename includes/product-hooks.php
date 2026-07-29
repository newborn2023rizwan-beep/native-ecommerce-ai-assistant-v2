<?php

if (!defined('ABSPATH')) {
    exit;
}


add_action(
    'woocommerce_product_options_general_product_data',
    'nea_render_ai_box'
);


function nea_render_ai_box()
{
    echo '<div class="options_group">';

    echo '<p class="form-field">';

    echo '<strong>🤖 Native eCommerce AI Assistant</strong>';

    echo '<br><br>';

    echo '<button 
        type="button" 
        class="button button-primary" 
        id="nea-generate-description">';

    echo 'Generate Description';

    echo '</button>';

    echo '</p>';

    echo '</div>';
}

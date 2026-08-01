<?php

/**
 * Plugin Name: Native eCommerce AI Assistant
 * Description: AI assistant for WooCommerce product management.
 * Version: 2.0.0
 * Author: Rizwan Ahmed
 * License: GPL v2 or later
 */

if (!defined('ABSPATH')) {
    exit;
}


/*
|--------------------------------------------------------------------------
| Plugin Constants
|--------------------------------------------------------------------------
*/

define(
    'NEA_PLUGIN_VERSION',
    '2.0.0'
);

define(
    'NEA_OPENAI_API_URL',
    'https://api.openai.com/v1/responses'
);


/*
|--------------------------------------------------------------------------
| Load Plugin Files
|--------------------------------------------------------------------------
*/


// Product Editor Hooks
require_once plugin_dir_path(__FILE__)
    . 'includes/admin/product-hooks.php';

// FAQ Box
require_once plugin_dir_path(__FILE__)
    . 'includes/admin/faq-box.php';



// Admin Assets
require_once plugin_dir_path(__FILE__)
    . 'includes/admin/enqueue.php';


// OpenAI Client
require_once plugin_dir_path(__FILE__)
    . 'includes/ai/openai.php';


// OpenAI Response Parser
require_once plugin_dir_path(__FILE__)
    . 'includes/ai/response-parser.php';


// AI Prompts
require_once plugin_dir_path(__FILE__)
    . 'includes/prompts/description-prompt.php';

require_once plugin_dir_path(__FILE__)
    . 'includes/prompts/faq-prompt.php';


// API Handler
require_once plugin_dir_path(__FILE__)
    . 'includes/ai/api-handler.php';


// AJAX Handlers
require_once plugin_dir_path(__FILE__)
    . 'includes/ajax/ajax-handler.php';


// Settings
require_once plugin_dir_path(__FILE__)
    . 'includes/admin/settings.php';


// Frontend Product Content
require_once plugin_dir_path(__FILE__)
    . 'includes/frontend/frontend-product.php';

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

define('NEA_PLUGIN_VERSION', '2.0.0');
define('NEA_OPENAI_API_URL', 'https://api.openai.com/v1/responses');

/*
|--------------------------------------------------------------------------
| Load Plugin Files
|--------------------------------------------------------------------------
*/
// Product Editor Hooks
require_once plugin_dir_path(__FILE__) . 'includes/product-hooks.php';

// Admin Assets (JS/CSS)
require_once plugin_dir_path(__FILE__) . 'includes/enqueue.php';

// OpenAI Client
require_once plugin_dir_path(__FILE__) . 'includes/ai/openai.php';

// OpenAI Response Parser
require_once plugin_dir_path(__FILE__) . 'includes/ai/response-parser.php';

// AI Prompts
require_once plugin_dir_path(__FILE__) . 'includes/prompts/description-prompt.php';

require_once plugin_dir_path(__FILE__) . 'includes/prompts/faq-prompt.php';

// API Handler
require_once plugin_dir_path(__FILE__) . 'includes/api-handler.php';

// AJAX Handlers
require_once plugin_dir_path(__FILE__) . 'includes/ajax-handler.php';

// Settings
require_once plugin_dir_path(__FILE__) . 'includes/settings.php';

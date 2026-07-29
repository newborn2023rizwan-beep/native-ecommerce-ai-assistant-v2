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
| Load Plugin Files
|--------------------------------------------------------------------------
*/

// Product Editor Hooks
require_once plugin_dir_path(__FILE__) . 'includes/product-hooks.php';

// Admin Assets (JS/CSS)
require_once plugin_dir_path(__FILE__) . 'includes/enqueue.php';

// AJAX Handlers
require_once plugin_dir_path(__FILE__) . 'includes/ajax-handler.php';

// API Handler
require_once plugin_dir_path(__FILE__) . 'includes/api-handler.php';

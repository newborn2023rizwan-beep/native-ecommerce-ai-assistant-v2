<?php

if (!defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| Admin Menu
|--------------------------------------------------------------------------
*/

add_action('admin_menu', 'nea_register_admin_menu');

function nea_register_admin_menu()
{
    add_menu_page(
        'Native AI Assistant',
        'Native AI',
        'manage_options',
        'nea-settings',
        'nea_settings_page',
        'dashicons-superhero',
        58
    );
}

/*
|--------------------------------------------------------------------------
| Register Settings
|--------------------------------------------------------------------------
*/

add_action('admin_init', 'nea_register_settings');

function nea_register_settings()
{
    /*
    |--------------------------------------------------------------------------
    | Register Options
    |--------------------------------------------------------------------------
    */

    register_setting(
        'nea_settings_group',
        'nea_openai_api_key'
    );

    register_setting(
        'nea_settings_group',
        'nea_openai_model'
    );

    /*
    |--------------------------------------------------------------------------
    | Section
    |--------------------------------------------------------------------------
    */

    add_settings_section(
        'nea_api_section',
        'OpenAI Settings',
        '__return_false',
        'nea-settings'
    );

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    */

    add_settings_field(
        'nea_openai_api_key',
        'OpenAI API Key',
        'nea_openai_api_key_callback',
        'nea-settings',
        'nea_api_section'
    );

    /*
    |--------------------------------------------------------------------------
    | Model
    |--------------------------------------------------------------------------
    */

    add_settings_field(
        'nea_openai_model',
        'OpenAI Model',
        'nea_openai_model_callback',
        'nea-settings',
        'nea_api_section'
    );
}

/*
|--------------------------------------------------------------------------
| API Key Field
|--------------------------------------------------------------------------
*/

function nea_openai_api_key_callback()
{
    $value = get_option('nea_openai_api_key', '');
?>

    <input
        type="password"
        name="nea_openai_api_key"
        value="<?php echo esc_attr($value); ?>"
        class="regular-text"
        autocomplete="off" />

<?php
}

/*
|--------------------------------------------------------------------------
| Model Field
|--------------------------------------------------------------------------
*/

function nea_openai_model_callback()
{
    $value = get_option(
        'nea_openai_model',
        'gpt-5-mini'
    );

    $models = array(

        'gpt-5-mini' => 'GPT-5 Mini',

        'gpt-5' => 'GPT-5',

        'gpt-4.1' => 'GPT-4.1',

        'gpt-4.1-mini' => 'GPT-4.1 Mini',

    );

?>

    <select
        name="nea_openai_model"
        class="regular-text">

        <?php foreach ($models as $key => $label) : ?>

            <option
                value="<?php echo esc_attr($key); ?>"
                <?php selected($value, $key); ?>>

                <?php echo esc_html($label); ?>

            </option>

        <?php endforeach; ?>

    </select>

<?php
}

/*
|--------------------------------------------------------------------------
| Settings Page
|--------------------------------------------------------------------------
*/

function nea_settings_page()
{
?>

    <div class="wrap">

        <h1>Native eCommerce AI Assistant</h1>

        <form
            method="post"
            action="options.php">

            <?php

            settings_fields('nea_settings_group');

            do_settings_sections('nea-settings');

            submit_button('Save Settings');

            ?>

        </form>

    </div>

<?php
}

<?php

if (!defined('ABSPATH')) {
    exit;
}


/*
|--------------------------------------------------------------------------
| Render AI Description Box
|--------------------------------------------------------------------------
*/

add_action(
    'woocommerce_product_options_general_product_data',
    'nea_render_ai_box'
);

function nea_render_ai_box()
{
    global $post;

    $product_id = $post ? $post->ID : 0;

    $saved_description = get_post_meta(
        $product_id,
        'nea_ai_description',
        true
    );
?>

    <div class="options_group">

        <p class="form-field">

            <strong>🤖 Native eCommerce AI Assistant</strong>

            <br><br>

            <button
                type="button"
                class="button button-primary"
                id="nea-generate-description">
                Description
            </button>

        </p>


        <!-- ========================================================= -->
        <!-- HIDDEN AI DESCRIPTION -->
        <!-- ========================================================= -->

        <input
            type="hidden"
            name="nea_ai_description"
            id="nea-ai-description"
            value="<?php echo esc_attr($saved_description); ?>">


        <!-- ========================================================= -->
        <!-- DESCRIPTION MODAL -->
        <!-- ========================================================= -->

        <div
            id="nea-description-modal"
            style="
                display:none;
                margin-top:20px;
                padding:20px;
                background:#fff;
                border:1px solid #ccd0d4;
                border-radius:6px;">

            <h2>🤖 AI Description Generator</h2>

            <table class="form-table">

                <tr>
                    <th scope="row">
                        Product Information & Features
                    </th>

                    <td>

                        <textarea
                            id="nea-product-context"
                            rows="8"
                            class="large-text"
                            placeholder="Example: Stainless steel water bottle, 750ml capacity, temperature display, leak-proof lid, double-wall insulation"></textarea>

                    </td>
                </tr>


                <tr>
                    <th scope="row">
                        Benefits
                    </th>

                    <td>

                        <textarea
                            id="nea-benefits"
                            rows="5"
                            class="large-text"
                            placeholder="Example: Keeps drinks cold for 24 hours, durable, easy to carry, ideal for travel and workouts"></textarea>

                    </td>
                </tr>


                <tr>
                    <th scope="row">
                        Tone
                    </th>

                    <td>

                        <select
                            id="nea-tone"
                            class="regular-text">

                            <option value="Professional">
                                Professional
                            </option>

                            <option value="Friendly">
                                Friendly
                            </option>

                            <option value="Premium">
                                Premium
                            </option>

                            <option value="Persuasive">
                                Persuasive
                            </option>

                        </select>

                    </td>
                </tr>


                <tr>
                    <th scope="row">
                        Description Length
                    </th>

                    <td>

                        <select
                            id="nea-length"
                            class="regular-text">

                            <option value="Short">
                                Short
                            </option>

                            <option
                                value="Medium"
                                selected>
                                Medium
                            </option>

                            <option value="Long">
                                Long
                            </option>

                        </select>

                    </td>
                </tr>

            </table>


            <!-- ===================================================== -->
            <!-- DESCRIPTION ACTIONS -->
            <!-- ===================================================== -->

            <p>

                <button
                    type="button"
                    class="button"
                    id="nea-cancel-description">
                    Cancel
                </button>

                &nbsp;

                <button
                    type="button"
                    class="button button-primary"
                    id="nea-confirm-description">
                    Generate Description
                </button>

            </p>

        </div>

    </div>

<?php
}


/*
|--------------------------------------------------------------------------
| Save AI Product Meta
|--------------------------------------------------------------------------
|
| Description UI lives in this file.
| FAQ UI lives in faq-box.php.
|
| Both values are saved during the normal WooCommerce
| product save process.
|--------------------------------------------------------------------------
*/

add_action(
    'woocommerce_process_product_meta',
    'nea_save_ai_product_meta'
);

function nea_save_ai_product_meta($product_id)
{
    /*
    |--------------------------------------------------------------------------
    | Save Description
    |--------------------------------------------------------------------------
    */

    if (isset($_POST['nea_ai_description'])) {

        $description = wp_kses_post(
            wp_unslash(
                $_POST['nea_ai_description']
            )
        );

        update_post_meta(
            $product_id,
            'nea_ai_description',
            $description
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Save FAQ
    |--------------------------------------------------------------------------
    |
    | FAQ UI is handled by faq-box.php.
    | The FAQ hidden field is submitted with the same product form.
    |
    */

    if (isset($_POST['nea_ai_faq'])) {

        $faq = wp_kses_post(
            wp_unslash(
                $_POST['nea_ai_faq']
            )
        );

        update_post_meta(
            $product_id,
            'nea_ai_faq',
            $faq
        );
    }
}

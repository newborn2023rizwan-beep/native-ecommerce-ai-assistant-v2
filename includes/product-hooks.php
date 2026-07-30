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
?>

    <div class="options_group">

        <p class="form-field">

            <strong>🤖 Native eCommerce AI Assistant</strong>

            <br><br>

            <button
                type="button"
                class="button button-primary"
                id="nea-generate-description">
                Generate Description
            </button>

            &nbsp;

            <button
                type="button"
                class="button"
                id="nea-generate-faq">
                Generate FAQ
            </button>

        </p>

        <div id="nea-faq-preview"
            style="
            display:none;
            margin:20px 0;
            padding:15px;
            background:#fff;
            border:1px solid #ccd0d4;
            border-left:4px solid #2271b1;
            white-space:pre-wrap;">
        </div>

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
                            placeholder="Example: Bluetooth 5.3, ANC, 40 Hours Battery, Type-C Charging, 1 Year Warranty"></textarea>

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
                            placeholder="Example: Crystal Clear Sound, Long Battery Life, Comfortable"></textarea>

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

                            <option value="Professional">Professional</option>

                            <option value="Friendly">Friendly</option>

                            <option value="Premium">Premium</option>

                            <option value="Persuasive">Persuasive</option>

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

                            <option value="Short">Short</option>

                            <option
                                value="Medium"
                                selected>Medium</option>

                            <option value="Long">Long</option>

                        </select>

                    </td>

                </tr>

            </table>

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

        <!-- ========================================================= -->
        <!-- FAQ MODAL -->
        <!-- ========================================================= -->

        <div
            id="nea-faq-modal"
            style="
            display:none;
            margin-top:20px;
            padding:20px;
            background:#fff;
            border:1px solid #ccd0d4;
            border-radius:6px;">

            <h2>🤖 AI FAQ Generator</h2>

            <table class="form-table">

                <tr>

                    <th scope="row">

                        Product Information

                    </th>

                    <td>

                        <textarea
                            id="nea-faq-product-info"
                            rows="8"
                            class="large-text"
                            placeholder="Example: Bluetooth 5.3, ANC, 40 Hours Battery, Type-C Charging, 1 Year Warranty"></textarea>

                    </td>

                </tr>

                <tr>

                    <th scope="row">

                        FAQ Mode

                    </th>

                    <td>

                        <label>

                            <input
                                type="radio"
                                name="nea-faq-mode"
                                value="auto"
                                checked>

                            Auto Generate (5 FAQs)

                        </label>

                        <br><br>

                        <label>

                            <input
                                type="radio"
                                name="nea-faq-mode"
                                value="custom">

                            Custom Questions

                        </label>

                    </td>

                </tr>

            </table>

            <div
                id="nea-custom-questions"
                style="display:none;">

                <table class="form-table">

                    <?php for ($i = 1; $i <= 5; $i++) : ?>

                        <tr>

                            <th>

                                Question <?php echo $i; ?>

                            </th>

                            <td>

                                <input
                                    type="text"
                                    id="nea-question-<?php echo $i; ?>"
                                    class="regular-text"
                                    style="width:100%;">

                            </td>

                        </tr>

                    <?php endfor; ?>

                </table>

            </div>

            <p>

                <button
                    type="button"
                    class="button"
                    id="nea-cancel-faq">

                    Cancel

                </button>

                &nbsp;

                <button
                    type="button"
                    class="button button-primary"
                    id="nea-confirm-faq">

                    Generate FAQ

                </button>

            </p>

        </div>

    </div>

<?php
}

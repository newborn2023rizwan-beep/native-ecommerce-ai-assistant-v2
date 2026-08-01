<?php

if (!defined('ABSPATH')) {
    exit;
}


/*
|--------------------------------------------------------------------------
| Register FAQ Meta Box
|--------------------------------------------------------------------------
*/

add_action(
    'add_meta_boxes',
    'nea_register_faq_meta_box'
);

function nea_register_faq_meta_box()
{
    add_meta_box(
        'nea-faq-box',
        '🤖 AI FAQ',
        'nea_render_faq_meta_box',
        'product',
        'normal',
        'default'
    );
}


/*
|--------------------------------------------------------------------------
| Render FAQ Meta Box
|--------------------------------------------------------------------------
*/

function nea_render_faq_meta_box($post)
{
    $saved_faq = get_post_meta(
        $post->ID,
        'nea_ai_faq',
        true
    );
?>

    <div class="nea-faq-module">

        <!-- ========================================================= -->
        <!-- FAQ TRIGGER BUTTON -->
        <!-- ========================================================= -->

        <p>

            <button
                type="button"
                class="button button-primary"
                id="nea-generate-faq">
                FAQ
            </button>

        </p>


        <!-- ========================================================= -->
        <!-- HIDDEN FAQ FIELD -->
        <!-- ========================================================= -->

        <input
            type="hidden"
            id="nea-ai-faq"
            name="nea_ai_faq"
            value="<?php echo esc_attr($saved_faq); ?>">


        <!-- ========================================================= -->
        <!-- FAQ OUTPUT -->
        <!-- ========================================================= -->

        <div
            id="nea-faq-output"
            style="
                <?php echo $saved_faq ? 'display:block;' : 'display:none;'; ?>
                margin-top:15px;
                padding:15px;
                background:#fff;
                border:1px solid #ccd0d4;
                border-radius:6px;">

            <strong>Generated FAQ</strong>

            <div
                id="nea-faq-content"
                contenteditable="true"
                style="
                    margin-top:10px;
                    padding:12px;
                    background:#f6f7f7;
                    border:1px solid #dcdcde;
                    min-height:80px;">

                <?php
                echo wp_kses_post(
                    $saved_faq
                );
                ?>

            </div>

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
                            placeholder="Example: Stainless steel water bottle, 750ml capacity, temperature display, leak-proof lid, double-wall insulation"></textarea>

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


            <!-- ===================================================== -->
            <!-- CUSTOM QUESTIONS -->
            <!-- ===================================================== -->

            <div
                id="nea-custom-questions"
                style="display:none;">

                <table class="form-table">

                    <?php for ($i = 1; $i <= 5; $i++) : ?>

                        <tr>

                            <th scope="row">
                                Question <?php echo esc_html($i); ?>
                            </th>

                            <td>

                                <input
                                    type="text"
                                    id="nea-question-<?php echo esc_attr($i); ?>"
                                    class="regular-text"
                                    style="width:100%;">

                            </td>

                        </tr>

                    <?php endfor; ?>

                </table>

            </div>


            <!-- ===================================================== -->
            <!-- MODAL ACTIONS -->
            <!-- ===================================================== -->

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

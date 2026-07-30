console.log("Native AI JS Loaded");

document.addEventListener("DOMContentLoaded", function () {
  /*
  |--------------------------------------------------------------------------
  | Description Elements
  |--------------------------------------------------------------------------
  */

  const descriptionButton = document.getElementById("nea-generate-description");

  const descriptionModal = document.getElementById("nea-description-modal");

  const cancelDescriptionButton = document.getElementById(
    "nea-cancel-description",
  );

  const confirmDescriptionButton = document.getElementById(
    "nea-confirm-description",
  );

  /*
  |--------------------------------------------------------------------------
  | FAQ Button
  |--------------------------------------------------------------------------
  */

  const faqButton = document.getElementById("nea-generate-faq");

  /*
  |--------------------------------------------------------------------------
  | Open Description Modal
  |--------------------------------------------------------------------------
  */

  if (descriptionButton) {
    descriptionButton.addEventListener("click", function () {
      descriptionModal.style.display = "block";
    });
  }

  /*
  |--------------------------------------------------------------------------
  | Close Description Modal
  |--------------------------------------------------------------------------
  */

  if (cancelDescriptionButton) {
    cancelDescriptionButton.addEventListener("click", function () {
      descriptionModal.style.display = "none";
    });
  }

  /*
  |--------------------------------------------------------------------------
  | Generate Description
  |--------------------------------------------------------------------------
  */

  if (confirmDescriptionButton) {
    confirmDescriptionButton.addEventListener("click", async function () {
      try {
        const titleField = document.getElementById("title");

        const productTitle = titleField ? titleField.value : "";

        if (!productTitle) {
          alert("Product title missing");

          return;
        }

        const productContext = document.getElementById(
          "nea-product-context",
        ).value;

        const benefits = document.getElementById("nea-benefits").value;

        const tone = document.getElementById("nea-tone").value;

        const length = document.getElementById("nea-length").value;

        confirmDescriptionButton.disabled = true;

        confirmDescriptionButton.innerText = "Generating...";

        const response = await fetch(ajaxurl, {
          method: "POST",

          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },

          body: new URLSearchParams({
            action: "nea_generate_description",

            product_title: productTitle,

            product_context: productContext,

            benefits: benefits,

            tone: tone,

            length: length,
          }),
        });

        const data = await response.json();

        if (!data.success) {
          alert("AI generation failed");

          return;
        }

        const description = data.data.description;

        const editorField = document.getElementById("content");

        if (editorField) {
          editorField.value = description;
        }

        if (typeof tinymce !== "undefined") {
          const editor = tinymce.get("content");

          if (editor) {
            editor.setContent(description);

            editor.save();
          }
        }

        descriptionModal.style.display = "none";

        alert("Description Generated Successfully");
      } catch (error) {
        console.error(error);

        alert(error.message);
      } finally {
        confirmDescriptionButton.disabled = false;

        confirmDescriptionButton.innerText = "Generate Description";
      }
    });
  }

  /*
  |--------------------------------------------------------------------------
  | FAQ Elements
  |--------------------------------------------------------------------------
  */

  const faqModal = document.getElementById("nea-faq-modal");

  const cancelFaqButton = document.getElementById("nea-cancel-faq");

  const confirmFaqButton = document.getElementById("nea-confirm-faq");

  const faqModes = document.querySelectorAll('input[name="nea-faq-mode"]');

  const customQuestions = document.getElementById("nea-custom-questions");

  /*
  |--------------------------------------------------------------------------
  | Open FAQ Modal
  |--------------------------------------------------------------------------
  */

  if (faqButton) {
    faqButton.addEventListener("click", function () {
      faqModal.style.display = "block";
    });
  }

  /*
  |--------------------------------------------------------------------------
  | Close FAQ Modal
  |--------------------------------------------------------------------------
  */

  if (cancelFaqButton) {
    cancelFaqButton.addEventListener("click", function () {
      faqModal.style.display = "none";
    });
  }

  /*
  |--------------------------------------------------------------------------
  | FAQ Mode Toggle
  |--------------------------------------------------------------------------
  */

  faqModes.forEach(function (radio) {
    radio.addEventListener("change", function () {
      if (this.value === "custom") {
        customQuestions.style.display = "block";
      } else {
        customQuestions.style.display = "none";
      }
    });
  });

  /*
  |--------------------------------------------------------------------------
  | Generate FAQ
  |--------------------------------------------------------------------------
  */

  if (confirmFaqButton) {
    confirmFaqButton.addEventListener("click", async function () {
      try {
        const titleField = document.getElementById("title");

        const productTitle = titleField ? titleField.value : "";

        if (!productTitle) {
          alert("Product title missing");

          return;
        }

        const productInfo = document.getElementById(
          "nea-faq-product-info",
        ).value;

        const faqMode = document.querySelector(
          'input[name="nea-faq-mode"]:checked',
        ).value;

        let customQuestions = "";

        if (faqMode === "custom") {
          let questions = [];

          for (let i = 1; i <= 5; i++) {
            const field = document.getElementById("nea-question-" + i);

            if (field && field.value.trim()) {
              questions.push(field.value.trim());
            }
          }

          customQuestions = questions.join("\n");
        }

        confirmFaqButton.disabled = true;

        confirmFaqButton.innerText = "Generating...";

        const response = await fetch(ajaxurl, {
          method: "POST",

          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },

          body: new URLSearchParams({
            action: "nea_generate_faq",

            product_title: productTitle,

            product_info: productInfo,

            faq_mode: faqMode,

            custom_questions: customQuestions,
          }),
        });

        const data = await response.json();

        if (!data.success) {
          alert("FAQ generation failed");

          return;
        }

        const faq = data.data.faq;

        const preview = document.getElementById("nea-faq-preview");

        if (preview) {
          preview.style.display = "block";

          preview.innerText = faq;
        }

        faqModal.style.display = "none";

        alert("FAQ Generated Successfully");
      } catch (error) {
        console.error(error);

        alert(error.message);
      } finally {
        confirmFaqButton.disabled = false;

        confirmFaqButton.innerText = "Generate FAQ";
      }
    });
  }
});

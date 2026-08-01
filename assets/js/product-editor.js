console.log("Native AI JS Loaded");

document.addEventListener("DOMContentLoaded", function () {
  /*
  |--------------------------------------------------------------------------
  | DESCRIPTION ELEMENTS
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

  const hiddenDescription = document.getElementById("nea-ai-description");

  /*
  |--------------------------------------------------------------------------
  | FAQ ELEMENTS
  |--------------------------------------------------------------------------
  */

  const faqButton = document.getElementById("nea-generate-faq");

  const faqOutput = document.getElementById("nea-faq-output");

  const faqContent = document.getElementById("nea-faq-content");

  const faqModal = document.getElementById("nea-faq-modal");

  const cancelFaqButton = document.getElementById("nea-cancel-faq");

  const confirmFaqButton = document.getElementById("nea-confirm-faq");

  const faqField = document.getElementById("nea-ai-faq");

  const faqModes = document.querySelectorAll('input[name="nea-faq-mode"]');

  const customQuestionsContainer = document.getElementById(
    "nea-custom-questions",
  );

  /*
  |--------------------------------------------------------------------------
  | DESCRIPTION MODAL
  |--------------------------------------------------------------------------
  */

  if (descriptionButton && descriptionModal) {
    descriptionButton.addEventListener("click", function () {
      descriptionModal.style.display = "block";
    });
  }

  if (cancelDescriptionButton && descriptionModal) {
    cancelDescriptionButton.addEventListener("click", function () {
      descriptionModal.style.display = "none";
    });
  }

  /*
  |--------------------------------------------------------------------------
  | GENERATE DESCRIPTION
  |--------------------------------------------------------------------------
  */

  if (confirmDescriptionButton) {
    confirmDescriptionButton.addEventListener("click", async function () {
      try {
        const titleField = document.getElementById("title");

        const productTitle = titleField ? titleField.value.trim() : "";

        if (!productTitle) {
          alert("Product title missing");
          return;
        }

        const productContextField = document.getElementById(
          "nea-product-context",
        );

        const benefitsField = document.getElementById("nea-benefits");

        const toneField = document.getElementById("nea-tone");

        const lengthField = document.getElementById("nea-length");

        const productContext = productContextField
          ? productContextField.value
          : "";

        const benefits = benefitsField ? benefitsField.value : "";

        const tone = toneField ? toneField.value : "";

        const length = lengthField ? lengthField.value : "";

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

        if (!description) {
          alert("No description generated");
          return;
        }

        /*
          |--------------------------------------------------------------------------
          | Update Hidden Description Field
          |--------------------------------------------------------------------------
          */

        if (hiddenDescription) {
          hiddenDescription.value = description;
        }

        /*
          |--------------------------------------------------------------------------
          | Update WooCommerce Description Editor
          |--------------------------------------------------------------------------
          */

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

        /*
          |--------------------------------------------------------------------------
          | Close Modal
          |--------------------------------------------------------------------------
          */

        if (descriptionModal) {
          descriptionModal.style.display = "none";
        }

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
  | FAQ MODAL
  |--------------------------------------------------------------------------
  */

  if (faqButton && faqModal) {
    faqButton.addEventListener("click", function () {
      faqModal.style.display = "block";
    });
  }

  if (cancelFaqButton && faqModal) {
    cancelFaqButton.addEventListener("click", function () {
      faqModal.style.display = "none";
    });
  }

  /*
  |--------------------------------------------------------------------------
  | FAQ MODE SWITCH
  |--------------------------------------------------------------------------
  */

  faqModes.forEach(function (radio) {
    radio.addEventListener("change", function () {
      if (!customQuestionsContainer) {
        return;
      }

      if (this.value === "custom") {
        customQuestionsContainer.style.display = "block";
      } else {
        customQuestionsContainer.style.display = "none";
      }
    });
  });

  /*
  |--------------------------------------------------------------------------
  | SYNC FAQ EDITOR → HIDDEN FIELD
  |--------------------------------------------------------------------------
  |
  | The visible FAQ content is editable.
  | Before saving the product, its HTML is copied into
  | the real hidden field named nea_ai_faq.
  |
  */

  function syncFaqField() {
    if (!faqField || !faqContent) {
      return;
    }

    faqField.value = faqContent.innerHTML;

    faqField.dispatchEvent(
      new Event("input", {
        bubbles: true,
      }),
    );

    faqField.dispatchEvent(
      new Event("change", {
        bubbles: true,
      }),
    );
  }

  /*
  |--------------------------------------------------------------------------
  | FAQ CONTENT EDITING
  |--------------------------------------------------------------------------
  */

  if (faqContent) {
    faqContent.addEventListener("input", function () {
      syncFaqField();
    });

    faqContent.addEventListener("blur", function () {
      syncFaqField();
    });
  }

  /*
  |--------------------------------------------------------------------------
  | GENERATE FAQ
  |--------------------------------------------------------------------------
  */

  if (confirmFaqButton) {
    confirmFaqButton.addEventListener("click", async function () {
      try {
        const titleField = document.getElementById("title");

        const productTitle = titleField ? titleField.value.trim() : "";

        if (!productTitle) {
          alert("Product title missing");
          return;
        }

        const productInfoField = document.getElementById(
          "nea-faq-product-info",
        );

        const productInfo = productInfoField ? productInfoField.value : "";

        const selectedMode = document.querySelector(
          'input[name="nea-faq-mode"]:checked',
        );

        const faqMode = selectedMode ? selectedMode.value : "auto";

        /*
          |--------------------------------------------------------------------------
          | Collect Custom Questions
          |--------------------------------------------------------------------------
          */

        let customQuestions = [];

        if (faqMode === "custom") {
          for (let i = 1; i <= 5; i++) {
            const questionField = document.getElementById(`nea-question-${i}`);

            const question = questionField ? questionField.value.trim() : "";

            if (question !== "") {
              customQuestions.push(question);
            }
          }

          if (customQuestions.length === 0) {
            alert("Please enter at least one custom question.");

            return;
          }
        }

        /*
          |--------------------------------------------------------------------------
          | Disable Button
          |--------------------------------------------------------------------------
          */

        confirmFaqButton.disabled = true;

        confirmFaqButton.innerText = "Generating...";

        /*
          |--------------------------------------------------------------------------
          | AJAX Request
          |--------------------------------------------------------------------------
          */

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
            custom_questions: customQuestions.join("\n"),
          }),
        });

        const data = await response.json();

        /*
          |--------------------------------------------------------------------------
          | AJAX Error
          |--------------------------------------------------------------------------
          */

        if (!data.success) {
          alert("AI generation failed");
          return;
        }

        /*
          |--------------------------------------------------------------------------
          | Get FAQ
          |--------------------------------------------------------------------------
          */

        const faq = data.data.faq;

        if (!faq) {
          alert("No FAQ generated");
          return;
        }

        /*
          |--------------------------------------------------------------------------
          | Put Generated FAQ Into Visible Editable Area
          |--------------------------------------------------------------------------
          |
          | IMPORTANT:
          | Do NOT replace faqOutput.innerHTML because that would
          | destroy the contenteditable element itself.
          |
          */

        if (faqContent) {
          faqContent.innerHTML = faq;
        }

        /*
          |--------------------------------------------------------------------------
          | Show FAQ Output
          |--------------------------------------------------------------------------
          */

        if (faqOutput) {
          faqOutput.style.display = "block";
        }

        /*
          |--------------------------------------------------------------------------
          | Sync Generated FAQ Into Hidden Field
          |--------------------------------------------------------------------------
          */

        syncFaqField();

        /*
          |--------------------------------------------------------------------------
          | Close FAQ Modal
          |--------------------------------------------------------------------------
          */

        if (faqModal) {
          faqModal.style.display = "none";
        }

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

  /*
  |--------------------------------------------------------------------------
  | SAVE BEFORE PRODUCT UPDATE
  |--------------------------------------------------------------------------
  */

  const productForm = document.getElementById("post");

  if (productForm) {
    productForm.addEventListener("submit", function () {
      /*
        |--------------------------------------------------------------------------
        | Save WooCommerce Description Editor
        |--------------------------------------------------------------------------
        */

      if (typeof tinymce !== "undefined") {
        const editor = tinymce.get("content");

        if (editor && hiddenDescription) {
          editor.save();

          hiddenDescription.value = editor.getContent();
        }
      }

      /*
        |--------------------------------------------------------------------------
        | Save Editable FAQ
        |--------------------------------------------------------------------------
        */

      syncFaqField();
    });
  }
});

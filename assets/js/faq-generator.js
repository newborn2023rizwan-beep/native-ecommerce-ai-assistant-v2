/*
|--------------------------------------------------------------------------
| Native eCommerce AI Assistant
| FAQ Generator
|--------------------------------------------------------------------------
*/

let neaFaqField = null;
let neaFaqContent = null;

/*
|--------------------------------------------------------------------------
| FAQ FIELD SYNC
|--------------------------------------------------------------------------
*/

function neaSyncFaqField() {
  if (!neaFaqField || !neaFaqContent) {
    return;
  }

  neaFaqField.value = neaFaqContent.innerHTML;

  neaFaqField.dispatchEvent(
    new Event("input", {
      bubbles: true,
    }),
  );

  neaFaqField.dispatchEvent(
    new Event("change", {
      bubbles: true,
    }),
  );
}

/*
|--------------------------------------------------------------------------
| FAQ INITIALIZATION
|--------------------------------------------------------------------------
*/

function neaInitFaqGenerator() {
  /*
  |--------------------------------------------------------------------------
  | FAQ ELEMENTS
  |--------------------------------------------------------------------------
  */

  const faqButton = document.getElementById("nea-generate-faq");

  const faqOutput = document.getElementById("nea-faq-output");

  neaFaqContent = document.getElementById("nea-faq-content");

  const faqModal = document.getElementById("nea-faq-modal");

  const cancelFaqButton = document.getElementById("nea-cancel-faq");

  const confirmFaqButton = document.getElementById("nea-confirm-faq");

  neaFaqField = document.getElementById("nea-ai-faq");

  const faqModes = document.querySelectorAll('input[name="nea-faq-mode"]');

  const customQuestionsContainer = document.getElementById(
    "nea-custom-questions",
  );

  /*
  |--------------------------------------------------------------------------
  | OPEN FAQ MODAL
  |--------------------------------------------------------------------------
  */

  if (faqButton && faqModal) {
    faqButton.addEventListener("click", function () {
      faqModal.style.display = "block";
    });
  }

  /*
  |--------------------------------------------------------------------------
  | CLOSE FAQ MODAL
  |--------------------------------------------------------------------------
  */

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
  | FAQ CONTENT EDITING
  |--------------------------------------------------------------------------
  */

  if (neaFaqContent) {
    neaFaqContent.addEventListener("input", function () {
      neaSyncFaqField();
    });

    neaFaqContent.addEventListener("blur", function () {
      neaSyncFaqField();
    });
  }

  /*
  |--------------------------------------------------------------------------
  | GENERATE FAQ
  |--------------------------------------------------------------------------
  */

  if (!confirmFaqButton) {
    return;
  }

  confirmFaqButton.addEventListener("click", async function () {
    try {
      /*
        |--------------------------------------------------------------------------
        | Product Title
        |--------------------------------------------------------------------------
        */

      const titleField = document.getElementById("title");

      const productTitle = titleField ? titleField.value.trim() : "";

      /*
        |--------------------------------------------------------------------------
        | Product Title Validation
        |--------------------------------------------------------------------------
        */

      if (!productTitle) {
        alert("Product title missing");

        return;
      }

      /*
        |--------------------------------------------------------------------------
        | Product Information
        |--------------------------------------------------------------------------
        */

      const productInfoField = document.getElementById("nea-faq-product-info");

      const productInfo = productInfoField ? productInfoField.value : "";

      /*
        |--------------------------------------------------------------------------
        | FAQ Mode
        |--------------------------------------------------------------------------
        */

      const selectedMode = document.querySelector(
        'input[name="nea-faq-mode"]:checked',
      );

      const faqMode = selectedMode ? selectedMode.value : "auto";

      /*
        |--------------------------------------------------------------------------
        | Custom Questions
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

        /*
          |--------------------------------------------------------------------------
          | Custom Question Validation
          |--------------------------------------------------------------------------
          */

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

      /*
        |--------------------------------------------------------------------------
        | HTTP Error
        |--------------------------------------------------------------------------
        */

      if (!response.ok) {
        throw new Error("Server error while generating FAQ.");
      }

      /*
        |--------------------------------------------------------------------------
        | Parse JSON
        |--------------------------------------------------------------------------
        */

      const data = await response.json();

      /*
        |--------------------------------------------------------------------------
        | AJAX Error
        |--------------------------------------------------------------------------
        */

      if (!data.success) {
        alert(data.data?.message || "AI generation failed");

        return;
      }

      /*
        |--------------------------------------------------------------------------
        | Get FAQ
        |--------------------------------------------------------------------------
        */

      const faq = data.data?.faq || "";

      /*
        |--------------------------------------------------------------------------
        | Empty Response
        |--------------------------------------------------------------------------
        */

      if (!faq.trim()) {
        alert("No FAQ generated");

        return;
      }

      /*
        |--------------------------------------------------------------------------
        | Update Visible FAQ Content
        |--------------------------------------------------------------------------
        */

      if (neaFaqContent) {
        neaFaqContent.innerHTML = faq;
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
        | Sync Hidden FAQ Field
        |--------------------------------------------------------------------------
        */

      neaSyncFaqField();

      /*
        |--------------------------------------------------------------------------
        | Close FAQ Modal
        |--------------------------------------------------------------------------
        */

      if (faqModal) {
        faqModal.style.display = "none";
      }

      /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

      alert("FAQ Generated Successfully");
    } catch (error) {
      console.error("FAQ generation error:", error);

      alert(error.message || "Something went wrong while generating the FAQ.");
    } finally {
      confirmFaqButton.disabled = false;

      confirmFaqButton.innerText = "Generate FAQ";
    }
  });
}

/*
|--------------------------------------------------------------------------
| Expose Functions To Main Product Editor
|--------------------------------------------------------------------------
*/

window.neaInitFaqGenerator = neaInitFaqGenerator;

window.neaSyncFaqField = neaSyncFaqField;

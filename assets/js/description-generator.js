/*
|--------------------------------------------------------------------------
| Native eCommerce AI Assistant
| Description Generator
|--------------------------------------------------------------------------
*/

function neaInitDescriptionGenerator() {
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
  | OPEN DESCRIPTION MODAL
  |--------------------------------------------------------------------------
  */

  if (descriptionButton && descriptionModal) {
    descriptionButton.addEventListener("click", function () {
      descriptionModal.style.display = "block";
    });
  }

  /*
  |--------------------------------------------------------------------------
  | CLOSE DESCRIPTION MODAL
  |--------------------------------------------------------------------------
  */

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

  if (!confirmDescriptionButton) {
    return;
  }

  confirmDescriptionButton.addEventListener("click", async function () {
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
        | Product Context
        |--------------------------------------------------------------------------
        */

      const productContextField = document.getElementById(
        "nea-product-context",
      );

      const productContext = productContextField
        ? productContextField.value
        : "";

      /*
        |--------------------------------------------------------------------------
        | Benefits
        |--------------------------------------------------------------------------
        */

      const benefitsField = document.getElementById("nea-benefits");

      const benefits = benefitsField ? benefitsField.value : "";

      /*
        |--------------------------------------------------------------------------
        | Tone
        |--------------------------------------------------------------------------
        */

      const toneField = document.getElementById("nea-tone");

      const tone = toneField ? toneField.value : "";

      /*
        |--------------------------------------------------------------------------
        | Description Length
        |--------------------------------------------------------------------------
        */

      const lengthField = document.getElementById("nea-length");

      const length = lengthField ? lengthField.value : "";

      /*
        |--------------------------------------------------------------------------
        | Disable Button
        |--------------------------------------------------------------------------
        */

      confirmDescriptionButton.disabled = true;

      confirmDescriptionButton.innerText = "Generating...";

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
          action: "nea_generate_description",

          product_title: productTitle,

          product_context: productContext,

          benefits: benefits,

          tone: tone,

          length: length,
        }),
      });

      /*
        |--------------------------------------------------------------------------
        | HTTP Error
        |--------------------------------------------------------------------------
        */

      if (!response.ok) {
        throw new Error("Server error while generating description.");
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
        | Get Description
        |--------------------------------------------------------------------------
        */

      const description = data.data?.description || "";

      /*
        |--------------------------------------------------------------------------
        | Empty Response
        |--------------------------------------------------------------------------
        */

      if (!description.trim()) {
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

      /*
        |--------------------------------------------------------------------------
        | Update TinyMCE
        |--------------------------------------------------------------------------
        */

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

      /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

      alert("Description Generated Successfully");
    } catch (error) {
      console.error("Description generation error:", error);

      alert(
        error.message ||
          "Something went wrong while generating the description.",
      );
    } finally {
      confirmDescriptionButton.disabled = false;

      confirmDescriptionButton.innerText = "Generate Description";
    }
  });
}

/*
|--------------------------------------------------------------------------
| Expose Description Generator
|--------------------------------------------------------------------------
|
| Make the initializer available to product-editor.js
|
*/

window.neaInitDescriptionGenerator = neaInitDescriptionGenerator;

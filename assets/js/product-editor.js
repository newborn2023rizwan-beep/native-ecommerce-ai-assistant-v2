console.log("Native AI JS Loaded");

document.addEventListener("DOMContentLoaded", function () {
  const button = document.getElementById("nea-generate-description");

  if (!button) {
    console.log("Button Not Found");
    return;
  }

  console.log("Button Found");

  button.addEventListener("click", async function () {
    console.log("Button Clicked");

    try {
      const titleField = document.getElementById("title");

      const productTitle = titleField ? titleField.value : "";

      if (!productTitle) {
        alert("Product title missing");

        return;
      }

      button.disabled = true;

      button.innerText = "Generating...";

      const response = await fetch(ajaxurl, {
        method: "POST",

        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },

        body: new URLSearchParams({
          action: "nea_generate_description",

          product_title: productTitle,
        }),
      });

      const data = await response.json();

      console.log("AI Response:", data);

      if (!data.success) {
        alert("AI generation failed");

        return;
      }

      const description = data.data.description;

      if (!description) {
        alert("No description generated");

        return;
      }

      console.log("Generated Description:", description);

      /*
       * Update WordPress Description Editor
       */

      const editorField = document.getElementById("content");

      if (editorField) {
        editorField.value = description;

        console.log("Editor Updated");
      }

      /*
       * Sync Visual Editor
       */

      if (typeof tinymce !== "undefined") {
        const editor = tinymce.get("content");

        if (editor) {
          editor.setContent(description);

          editor.save();

          console.log("Visual Editor Synced");
        }
      }

      alert("Description Generated Successfully");
    } catch (error) {
      console.error(error);

      alert(error.message);
    } finally {
      button.disabled = false;

      button.innerText = "Generate Description";
    }
  });
});

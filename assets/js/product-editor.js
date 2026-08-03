console.log("Native AI Product Editor Loaded");

document.addEventListener("DOMContentLoaded", function () {
  /*
  |--------------------------------------------------------------------------
  | INITIALIZE DESCRIPTION MODULE
  |--------------------------------------------------------------------------
  */

  if (typeof neaInitDescriptionGenerator === "function") {
    neaInitDescriptionGenerator();
  }

  /*
  |--------------------------------------------------------------------------
  | INITIALIZE FAQ MODULE
  |--------------------------------------------------------------------------
  */

  if (typeof neaInitFaqGenerator === "function") {
    neaInitFaqGenerator();
  }

  /*
  |--------------------------------------------------------------------------
  | PRODUCT FORM SAVE
  |--------------------------------------------------------------------------
  */

  const productForm = document.getElementById("post");

  if (!productForm) {
    return;
  }

  productForm.addEventListener("submit", function () {
    /*
    |--------------------------------------------------------------------------
    | Save WooCommerce Description Editor
    |--------------------------------------------------------------------------
    */

    const hiddenDescription = document.getElementById("nea-ai-description");

    if (typeof tinymce !== "undefined") {
      const editor = tinymce.get("content");

      if (editor && hiddenDescription) {
        editor.save();

        hiddenDescription.value = editor.getContent();
      }
    }

    /*
    |--------------------------------------------------------------------------
    | Save FAQ
    |--------------------------------------------------------------------------
    */

    if (typeof neaSyncFaqField === "function") {
      neaSyncFaqField();
    }
  });
});

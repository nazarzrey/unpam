console.log("Content script loaded...");

// Override XMLHttpRequest buat ngintip data API
const open = XMLHttpRequest.prototype.open;
XMLHttpRequest.prototype.open = function (method, url) {
  if (url.includes("unpam.ac.id") && url.includes("api")) {
    this.addEventListener("load", function () {
      try {
        const contentType = this.getResponseHeader("Content-Type");
        console.log("Content-Type:", contentType);

        if (contentType && contentType.includes("application/json")) {
          const jsonResponse = JSON.parse(this.responseText);
          console.log("Intercepted JSON Response:", jsonResponse);
        } else {
          console.log("Non-JSON Response:", this.responseText);
        }
      } catch (error) {
        console.error("Error parsing response:", error);
      }
    });
  }
  open.apply(this, arguments);
};

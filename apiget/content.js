console.log("Content script loaded...");

chrome.runtime.onMessage.addListener(function (message, sender, sendResponse) {
  console.log("Message received in content script:", message);

  if (message.action === "api_caught") {
    console.log("API URL from background:", message.url);

    setTimeout(() => {
      fetch(message.url)
        .then((response) => response.json())
        .then((data) => {
          console.log("API Response JSON:", data);
        })
        .catch((error) => {
          console.error("Fetch error:", error);
        });
    }, 2000);
  }
});

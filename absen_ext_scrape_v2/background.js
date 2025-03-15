console.log("Background script running...");

chrome.webRequest.onCompleted.addListener(
  function (details) {
    if (details.url.includes("unpam.ac.id") && details.url.includes("api")) {
      console.log("API Request caught:", details.url);

      chrome.tabs.query({ active: true, currentWindow: true }, function (tabs) {
        if (tabs[0]) {
          chrome.tabs.sendMessage(
            tabs[0].id,
            { action: "api_caught", url: details.url },
            function (response) {
              if (chrome.runtime.lastError) {
                console.warn(
                  "Content script belum siap:",
                  chrome.runtime.lastError.message
                );
              }
            }
          );
        }
      });
    }
  },
  { urls: ["<all_urls>"] }
);

console.log("Background script running...");

let capturedUrls = new Set();

chrome.webRequest.onCompleted.addListener(
  function (details) {
    if (
      details.url.includes("unpam.ac.id") &&
      details.url.includes("api") &&
      details.method === "GET" &&
      details.statusCode === 200
    ) {
      if (!capturedUrls.has(details.url)) {
        capturedUrls.add(details.url);
        console.log("API Request caught:", details.url);

        chrome.tabs.query(
          { active: true, currentWindow: true },
          function (tabs) {
            if (tabs[0]) {
              console.log("Sending message to content script...");
              chrome.tabs.sendMessage(
                tabs[0].id,
                { action: "api_caught", url: details.url },
                function (response) {
                  if (chrome.runtime.lastError) {
                    console.warn(
                      "Content script belum siap:",
                      chrome.runtime.lastError.message
                    );
                  } else {
                    console.log("Message sent successfully!");
                  }
                }
              );
            } else {
              console.warn("No active tab found.");
            }
          }
        );
      }
    }
  },
  { urls: ["<all_urls>"] }
);

chrome.tabs.onUpdated.addListener((tabId, changeInfo, tab) => {
  if (changeInfo.status === "complete") {
    console.log("Page changed, clearing captured URLs");
    capturedUrls.clear();
  }
});

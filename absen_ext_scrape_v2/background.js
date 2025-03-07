// background.js

// Fungsi untuk melacak API calls
function trackApiCalls() {
  console.log("Tracking API calls...");

  // Menangkap semua API requests
  chrome.webRequest.onCompleted.addListener(
    function (responseDetails) {
      if (responseDetails.method === "GET") {
        console.log("API Request Detected:", responseDetails.url);

        // Mengambil response body (opsional)
        fetch(responseDetails.url)
          .then((response) => response.json())
          .then((data) => {
            console.log("Response Data:", data);
          })
          .catch((error) => {
            console.error("Error fetching response data:", error);
          });
      }
    },
    { urls: ["<all_urls>"] } // Menangkap semua requests dari semua URL
  );
}

// Melacak perubahan tab
chrome.tabs.onUpdated.addListener(function (tabId, changeInfo, tab) {
  console.log("Tab updated:", tabId, changeInfo);
  if (changeInfo.status === "complete" && tab.url) {
    console.log("Tab fully loaded:", tab.url);

    // Mulai melacak API calls setelah URL berubah
    trackApiCalls();
  }
});

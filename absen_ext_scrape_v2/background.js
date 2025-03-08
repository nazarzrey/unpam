// console.log("Background script running...");

// function attachDebugger(tabId) {
//   console.log("Trying to attach debugger to tab:", tabId);
//   chrome.debugger.attach({ tabId: tabId }, "1.3", function () {
//     if (chrome.runtime.lastError) {
//       console.error("Debugger attach error:", chrome.runtime.lastError.message);
//       return;
//     }

//     console.log("Debugger attached successfully");
//     chrome.debugger.sendCommand(
//       { tabId: tabId },
//       "Network.enable",
//       {},
//       function () {
//         if (chrome.runtime.lastError) {
//           console.error(
//             "Network.enable error:",
//             chrome.runtime.lastError.message
//           );
//           return;
//         }
//         console.log("Network monitoring enabled");
//       }
//     );

//     chrome.debugger.onEvent.addListener(function (source, method, params) {
//       console.log("Debugger event received:", method);
//       console.log("Event params:", params);

//       if (method === "Network.requestWillBeSent") {
//         console.log("Request Intercepted:", params.request.url);
//         console.log("Request Details:", params.request);
//       }

//       if (method === "Network.responseReceived") {
//         console.log("API Call Intercepted:", params.response.url);
//         console.log("Response Status:", params.response.status);

//         setTimeout(() => {
//           // Tambahkan delay untuk memastikan respons sudah siap
//           chrome.debugger.sendCommand(
//             { tabId: source.tabId },
//             "Network.getResponseBody",
//             { requestId: params.requestId },
//             function (response) {
//               if (chrome.runtime.lastError) {
//                 console.error(
//                   "getResponseBody error:",
//                   chrome.runtime.lastError.message
//                 );
//                 return;
//               }
//               console.log("Response Body:", response.body);
//             }
//           );
//         }, 1000); // Delay 1 detik
//       }
//     });
//   });
// }

// chrome.tabs.onActivated.addListener(function (activeInfo) {
//   console.log("Tab activated:", activeInfo);
//   attachDebugger(activeInfo.tabId);
// });

// chrome.tabs.onUpdated.addListener(function (tabId, changeInfo, tab) {
//   console.log("Tab updated:", tabId, changeInfo);
//   if (changeInfo.status === "complete") {
//     console.log("Tab fully loaded:", tab.url);
//     attachDebugger(tabId);
//   }
// });
console.log("🔥 Background script running...");

function attachDebugger(tabId) {
  console.log("🛠️ Trying to attach debugger to tab:", tabId);
  chrome.debugger.attach({ tabId: tabId }, "1.3", function () {
    if (chrome.runtime.lastError) {
      console.error(
        "❌ Debugger attach error:",
        chrome.runtime.lastError.message
      );
      return;
    }

    console.log("✅ Debugger attached successfully");
    chrome.debugger.sendCommand(
      { tabId: tabId },
      "Network.enable",
      {},
      function () {
        if (chrome.runtime.lastError) {
          console.error(
            "❌ Network.enable error:",
            chrome.runtime.lastError.message
          );
          return;
        }
        console.log("🌐 Network monitoring enabled");
      }
    );

    chrome.debugger.onEvent.addListener(function (source, method, params) {
      if (method === "Network.requestWillBeSent") {
        if (params.request.url.includes("/api/")) {
          // Filter hanya request API
          console.log("🚀 API Request Intercepted:", params.request.url);
          console.log("📨 Request Details:", params.request);
        }
      }

      if (
        method === "Network.responseReceived" &&
        params.response.url.includes("/api/")
      ) {
        console.log("📥 API Response Intercepted:", params.response.url);
        console.log("📊 Response Status:", params.response.status);

        setTimeout(() => {
          chrome.debugger.sendCommand(
            { tabId: source.tabId },
            "Network.getResponseBody",
            { requestId: params.requestId },
            function (response) {
              if (chrome.runtime.lastError) {
                console.error(
                  "❌ getResponseBody error:",
                  chrome.runtime.lastError.message
                );
                return;
              }

              try {
                const responseBody = JSON.parse(response.body);
                console.log("📝 Parsed JSON Response:", responseBody);
              } catch (e) {
                console.log("📝 Raw Response Body (not JSON):", response.body);
              }
            }
          );
        }, 1000); // Delay biar response siap
      }
    });
  });
}

chrome.tabs.onActivated.addListener(function (activeInfo) {
  console.log("🖱️ Tab activated:", activeInfo);
  attachDebugger(activeInfo.tabId);
});

chrome.tabs.onUpdated.addListener(function (tabId, changeInfo, tab) {
  console.log("🔄 Tab updated:", tabId, changeInfo);
  if (changeInfo.status === "complete" && tab.url) {
    console.log("✅ Tab fully loaded:", tab.url);
    attachDebugger(tabId);
  }
});

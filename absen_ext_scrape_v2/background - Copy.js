/*
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
// console.log("🔥 Background script running...");

// function attachDebugger(tabId) {
//   console.log("🛠️ Trying to attach debugger to tab:", tabId);
//   chrome.debugger.attach({ tabId: tabId }, "1.3", function () {
//     if (chrome.runtime.lastError) {
//       console.error(
//         "❌ Debugger attach error:",
//         chrome.runtime.lastError.message
//       );
//       return;
//     }

//     console.log("✅ Debugger attached successfully");
//     chrome.debugger.sendCommand(
//       { tabId: tabId },
//       "Network.enable",
//       {},
//       function () {
//         if (chrome.runtime.lastError) {
//           console.error(
//             "❌ Network.enable error:",
//             chrome.runtime.lastError.message
//           );
//           return;
//         }
//         console.log("🌐 Network monitoring enabled");
//       }
//     );

//     chrome.debugger.onEvent.addListener(function (source, method, params) {
//       if (method === "Network.requestWillBeSent") {
//         if (params.request.url.includes("/api/")) {
//           // Filter hanya request API
//           console.log("🚀 API Request Intercepted:", params.request.url);
//           console.log("📨 Request Details:", params.request);
//         }
//       }

//       if (
//         method === "Network.responseReceived" &&
//         params.response.url.includes("/api/")
//       ) {
//         console.log("📥 API Response Intercepted:", params.response.url);
//         console.log("📊 Response Status:", params.response.status);

//         setTimeout(() => {
//           chrome.debugger.sendCommand(
//             { tabId: source.tabId },
//             "Network.getResponseBody",
//             { requestId: params.requestId },
//             function (response) {
//               if (chrome.runtime.lastError) {
//                 console.error(
//                   "❌ getResponseBody error:",
//                   chrome.runtime.lastError.message
//                 );
//                 return;
//               }

//               try {
//                 const responseBody = JSON.parse(response.body);
//                 console.log("📝 Parsed JSON Response:", responseBody);
//               } catch (e) {
//                 console.log("📝 Raw Response Body (not JSON):", response.body);
//               }
//             }
//           );
//         }, 1000); // Delay biar response siap
//       }
//     });
//   });
// }

// chrome.tabs.onActivated.addListener(function (activeInfo) {
//   console.log("🖱️ Tab activated:", activeInfo);
//   attachDebugger(activeInfo.tabId);
// });

// chrome.tabs.onUpdated.addListener(function (tabId, changeInfo, tab) {
//   console.log("🔄 Tab updated:", tabId, changeInfo);
//   if (changeInfo.status === "complete" && tab.url) {
//     console.log("✅ Tab fully loaded:", tab.url);
//     attachDebugger(tabId);
//   }
// });

// console.log("🔥 Background script running with webRequest...");

// chrome.webRequest.onBeforeRequest.addListener(
//   function (details) {
//     if (details.url.includes("/api/")) {
//       console.log("🚀 API Request Intercepted:", details.url);
//       if (details.requestBody) {
//         const body = details.requestBody.raw
//           ? new TextDecoder("utf-8").decode(details.requestBody.raw[0].bytes)
//           : details.requestBody;
//         console.log("📨 Request Body:", body);
//       }
//     }
//   },
//   { urls: ["<all_urls>"] },
//   ["requestBody"]
// );
// chrome.webRequest.onCompleted.addListener(
//   async function (details) {
//     if (details.url.includes("/api/")) {
//       console.log("✅ API Response:", details.url);
//       console.log("📊 Status:", details.statusCode);
//       console.log("⏱️ Timing:", details.timeStamp);
//     }
//   },
//   { urls: ["<all_urls>"] }
// );
// console.log("🛠️ Background script running...");

// // Listener buat dengerin request API
// chrome.webRequest.onCompleted.addListener(
//   function (details) {
//     if (details.url.includes("/api/")) {
//       console.log("✅ API Call Detected:", details.url);
//       console.log("📊 Status Code:", details.statusCode);
//     }
//   },
//   { urls: ["<all_urls>"] }
// );
*/
console.log("Background script running...");

// Monitor semua request ke API, misalnya URL yang mengandung "/api/"
chrome.webRequest.onBeforeRequest.addListener(
  function (details) {
    console.log("API Request detected:", details.url);
    if (details.method === "POST" || details.method === "PUT") {
      const requestBody = details.requestBody;
      if (requestBody) {
        console.log("Request Body:", requestBody);
      }
    }
  },
  { urls: ["<all_urls>"] },
  ["requestBody"]
);

chrome.webRequest.onCompleted.addListener(
  function (details) {
    console.log("API Response received:", details.url);
    console.log("Response details:", details);
  },
  { urls: ["<all_urls>"] },
  ["responseHeaders"]
);



// function lg(val){
//   console.log(val)
// }
// console.log("Bg running")
// var urikls = ""
// chrome.storage.local.get(['urlAbsen', 'urlKLS'], function(data) {
//   console.log(data.urlAbsen); // Cetak nilai urlAbsen
//   urikls = data.urlKLS; // Cetak nilai urlKLS
// });
//   // if (!storedDataURL) {
//   //   lg("URL tidak ditemukan silahkan di input dulu");
//   // }
//   // if (!storedDataKLS) {
//   //   var msg1 = "Data kelas tidak ada..!!!";
//   //   var msg2 = "Aplikasi tidak bisa jalan";
//   //   lg(msg1+" "+msg2);
//   // }

// // const linkedInListViewURL = storedDataURL; 
// const linkedInListViewURL = urikls; 


// function getJobDescriptionClassName(url) {
//   return url.startsWith(linkedInListViewURL)
//     ? "forum-post-container"
//     : "forumpost";
// }

// function grabJobDescription(className) {
//  const forumPostContainer = document.body.querySelector(`.${className}`); // Ambil elemen forum-post-container
//   const jobDetailsElements = forumPostContainer.querySelectorAll('.forumpost'); // Ambil semua elemen forumpost di dalam forum-post-container

//   const results = []; // Array untuk menyimpan hasil

//   jobDetailsElements.forEach(jobDetailsElement => {
//     const aElement = jobDetailsElement.querySelector('a'); // Ambil elemen <a> di dalam elemen forumpost
//     const timeElement = jobDetailsElement.querySelector('time'); // Ambil elemen <time> di dalam elemen forumpost

//     const aText = aElement ? aElement.textContent.trim() : null; // Ambil teks dari elemen <a>, jika ada
//     const timeText = timeElement ? timeElement.textContent.trim() : null; // Ambil teks dari elemen <time>, jika ada

//     const result = {
//       aText: aText,
//       timeText: timeText
//     };

//     results.push(result); // Tambahkan hasil ke dalam array
//   });

//   return results; // Kembalikan array yang berisi objek-objek dengan teks dari elemen <a> dan <time>

// }
// chrome.tabs.onUpdated.addListener(function (tabId, changeInfo, tab) {
//     console.log("Event Triggered")
//   if (changeInfo.status === "complete" && tab.active) {
//     if (
//       tab.url?.startsWith(linkedInListViewURL) 
//     ) {
//       chrome.scripting
//         .executeScript({
//           target: { tabId: tabId },
//           func: grabJobDescription,
//           args: [getJobDescriptionClassName(tab.url)],
//         })
//         .then((queryResult) => {   
//           lg(queryResult);
//           lg(queryResult[0].result);
//         });
//     }
//   }
// });
// function lg(val){
//   console.log(val)
// }

// console.log("Bg running");

// chrome.storage.local.get(['urlAbsen', 'urlKLS'], function(data) {
//   const storedDataURL = data.urlAbsen;
//   const storedDataKLS = data.urlKLS;
  
//   if (!storedDataURL || !storedDataKLS) {
//     const msg1 = "Data URL Absen atau URL KLS tidak ditemukan..!!!";
//     const msg2 = "Aplikasi tidak bisa berjalan.";
//     alert(msg1 + " " + msg2);
//   }else{    
//   }
// });
// const linkedInListViewURL = "http://localhost/web/absenunpam/";
// function getJobDescriptionClassName(url) {
//   return url.startsWith(linkedInListViewURL)
//     ? "forum-post-container"
//     : "forumpost";
// }

// function grabJobDescription(className) {
//   const forumPostContainer = document.body.querySelector(`.${className}`); // Ambil elemen forum-post-container
//   const jobDetailsElements = forumPostContainer.querySelectorAll('.forumpost'); // Ambil semua elemen forumpost di dalam forum-post-container

//   const results = []; // Array untuk menyimpan hasil

//   jobDetailsElements.forEach(jobDetailsElement => {
//     const aElement = jobDetailsElement.querySelector('a'); // Ambil elemen <a> di dalam elemen forumpost
//     const timeElement = jobDetailsElement.querySelector('time'); // Ambil elemen <time> di dalam elemen forumpost

//     const aText = aElement ? aElement.textContent.trim() : null; // Ambil teks dari elemen <a>, jika ada
//     const timeText = timeElement ? timeElement.textContent.trim() : null; // Ambil teks dari elemen <time>, jika ada

//     const result = {
//       aText: aText,
//       timeText: timeText
//     };

//     results.push(result); // Tambahkan hasil ke dalam array
//   });

//   return results; // Kembalikan array yang berisi objek-objek dengan teks dari elemen <a> dan <time>
// }

// chrome.tabs.onUpdated.addListener(function (tabId, changeInfo, tab) {
//   console.log("Event Triggered");
//   if (changeInfo.status === "complete" && tab.active) {
//     if (tab.url?.startsWith(linkedInListViewURL)) {
//       chrome.scripting.executeScript({
//         target: { tabId: tabId },
//         func: grabJobDescription,
//         args: [getJobDescriptionClassName(tab.url)],
//       }).then((queryResult) => {   
//         lg(queryResult);
//         lg(queryResult[0].result);
//       });
//     }
//   }
// });


function lg(val){
    console.log(val)
  }
  
  console.log("Bg running");
  
  chrome.storage.local.get(['urlAbsen', 'urlKLS'], function(data) {
    const storedDataURL = data.urlAbsen;
    const storedDataKLS = data.urlKLS;
    
    if (!storedDataURL || !storedDataKLS) {
      const msg1 = "Data URL Absen atau URL KLS tidak ditemukan..!!!";
      const msg2 = "Aplikasi tidak bisa berjalan.";
      alert(msg1 + " " + msg2);
    }else{    
    }
  });
  const linkedInListViewURL = "http://localhost/web/absenunpam/";
  function getJobDescriptionClassName(url) {
    return url.startsWith(linkedInListViewURL)
      ? "forum-post-container"
      : "forumpost";
  }
  
  function grabJobDescription(className) {
    const forumPostContainer = document.body.querySelector(`.${className}`); // Ambil elemen forum-post-container
    const jobDetailsElements = forumPostContainer.querySelectorAll('.forumpost'); // Ambil semua elemen forumpost di dalam forum-post-container
  
    const results = []; // Array untuk menyimpan hasil
  
    jobDetailsElements.forEach(jobDetailsElement => {
      const aElement = jobDetailsElement.querySelector('a'); // Ambil elemen <a> di dalam elemen forumpost
      const timeElement = jobDetailsElement.querySelector('time'); // Ambil elemen <time> di dalam elemen forumpost
  
      const aText = aElement ? aElement.textContent.trim() : null; // Ambil teks dari elemen <a>, jika ada
      const timeText = timeElement ? timeElement.textContent.trim() : null; // Ambil teks dari elemen <time>, jika ada
  
      const result = {
        aText: aText,
        timeText: timeText
      };
  
      results.push(result); // Tambahkan hasil ke dalam array
    });
  
    return results; // Kembalikan array yang berisi objek-objek dengan teks dari elemen <a> dan <time>
  }
  
  chrome.tabs.onUpdated.addListener(function (tabId, changeInfo, tab) {
    console.log("Event Triggered");
    if (changeInfo.status === "complete" && tab.active) {
      if (tab.url?.startsWith(linkedInListViewURL)) {
        chrome.scripting.executeScript({
          target: { tabId: tabId },
          func: grabJobDescription,
          args: [getJobDescriptionClassName(tab.url)],
        }).then((queryResult) => {   
          lg(queryResult);
          lg(queryResult[0].result);
        });
      }
    }
  });
  
function lg(val){
  console.log(val)
}
console.log("Bg running")

// const linkedInListViewURL = "http://localhost/web/absenunpam"; 
//const linkedInListViewURL = "http://localhost/web/unpam_project/contoh/"; 
//const linkedInListViewURL = "https://e-learning.unpam.id/mod/forum/"; 
const linkedInListViewURL = "https://e-learning.unpam.ac.id/mod/forum/"; 

// const linkedInListViewURL = "https://e-learning.unpam.id/mod/forum/"; //konsepnya ambil dari api aja dah storej susah benerr

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
      nama: aText,
      waktu: timeText
    };

    results.push(result); // Tambahkan hasil ke dalam array
  });

  return results; // Kembalikan array yang berisi objek-objek dengan teks dari elemen <a> dan <time>

}
chrome.tabs.onUpdated.addListener(function (tabId, changeInfo, tab) {
    console.log("Event Triggered")
  if (changeInfo.status === "complete" && tab.active) {
    if (
      tab.url?.startsWith(linkedInListViewURL) 
    ) {
      chrome.scripting
        .executeScript({
          target: { tabId: tabId },
          func: grabJobDescription,
          args: [getJobDescriptionClassName(tab.url)],
        })
        .then((queryResult) => {
          lg(queryResult[0].result);
          var url = tab.url
          
    // var currentURL = tabs[0].url;
    // console.log('Current URL:', currentURL);
          send_data(queryResult[0].result,url)
        });
    }
  }
});

function send_data(obj_data,url){
  if (Object.keys(obj_data).length === 0 && obj_data.constructor === Object) {
      console.log("Data is empty, skipping the send request.");
      return;
  }
  var UriServer = 'http://localhost/web/unpam_project/absen_ci3_backend/receive_data'
  //var UriServer = "https://nazrey.com/project/unpam/absen_ci3_backend/receive_data"
  fetch(UriServer, {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json'
      },
      // body: JSON.stringify(data)
      
      body: JSON.stringify({
        url: url, // Menyertakan URL saat ini bersama data
        data: obj_data
    })
  })
  .then(response => {
      if (!response.ok) {
          throw new Error('Failed to send data to server.');
      }
      console.log('Data sent successfully.');
  })
  .catch(error => {
      console.error('Error:', error);
  });
}
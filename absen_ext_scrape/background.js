function lg(val){
  console.log(val)
}
console.log("unpam cek absensi Bg running")

// const UrlCrawl = "http://localhost/web/absenunpam"; 
// const UrlCrawl = "http://localhost/web/unpam_project/contoh/"; 
// const UrlCrawl = "https://e-learning.unpam.ac.id/mod/forum/"; 
// const UrlCrawl = "https://e-learning.unpam.id/mod/forum/"; //konsepnya ambil dari api aja dah storej susah benerr

var backUrlCrawl = "";
var backUrlKelas = "";
var backUrlAdmin = "";
function UrlCrawl(tipe){
  if(tipe=="url"){
    chrome.storage.local.get(['UrlMatKul'], function(result) {
        if (!result.UrlMatKul) {
            console.log("URL tidak ditemukan jadi pakai yang lain");
            backUrlCrawl = "http://localhost/web/unpam_project/contoh/"; 
        }else{
          backUrlCrawl = result.UrlMatKul; 
        }
      })
      return backUrlCrawl;
  }else if(tipe=="kelas"){
    chrome.storage.local.get(['urlKLS'], function(result) {
        if (!result.urlKLS) {
            console.log("URL tidak ditemukan jadi pakai yang lain");
            backUrlKelas = "TPLE004"; 
        }else{
          backUrlKelas = result.urlKLS; 
        }
      })
      return backUrlKelas;    
  }else{
    chrome.storage.local.get(['UrlAdmin'], function(result) {
        if (!result.UrlAdmin) {
            console.log("URL tidak ditemukan jadi pakai yang lain");
            backUrlAdmin = "Nazar"; 
        }else{
          backUrlAdmin = result.UrlAdmin; 
        }
      })
      return backUrlAdmin;    
  }
}

function getJobDescriptionClassName(url) {
  return url.startsWith(UrlCrawl("url"))
    ? "forum-post-container"
    : "forumpost";
}

function grabJobDescription(className) {
 const forumPostContainer = document.body.querySelector(`.${className}`); // Ambil elemen forum-post-container
  const jobDetailsElements = forumPostContainer.querySelectorAll('.forumpost'); // Ambil semua elemen forumpost di dalam forum-post-container

  const results = []; // Array untuk menyimpan hasil
  const title = [];
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

  // Get values from your specified elements
  const pageContentValue = document.querySelector("#page-content .discussionname")?.textContent?.trim();
  const pageHeaderValue = document.querySelector("#page-header .h2")?.textContent?.trim();
  // Add them to the results if they exist
  if (pageContentValue) {
    title.push({ fordistitle: pageContentValue });
  }
  if (pageHeaderValue) {
    title.push({ fordiske: pageHeaderValue });
  }

  return [results,title];
}

chrome.tabs.onUpdated.addListener(function (tabId, changeInfo, tab) {
    console.log("Event Triggered")
  if (changeInfo.status === "complete" && tab.active) {
    // console.log("cek url "+UrlCrawl("url")+" -> "+tab.url);
    var Kls   = UrlCrawl("kelas");
    var Admin = UrlCrawl("admin");
    if (
      tab.url?.startsWith(UrlCrawl("url")) 
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
          send_data(queryResult[0].result,url,Kls,Admin)
        });
    }
  }
});

function send_data(obj_data,url,kls,adm){
  if (Object.keys(obj_data).length === 0 && obj_data.constructor === Object) {
      console.log("Data is empty, skipping the send request.");
      return;
  }
  var UriServer = 'http://localhost/web/unpam_project/absen_ci3_backend/receive_data'
  fetch(UriServer, {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json'
      },      
      body: JSON.stringify({
        url: url,
        data: obj_data[0],
        fordis: obj_data[1],
        kelas:kls,
        admin:adm
    })
  })
  .then(response => response.json())
  .then(data => {
      if (data.message) {
          console.log(data.message);            
          chrome.runtime.sendMessage({message: data.message});
      }
  })
  .catch(error => {
      console.error('Error:', error);
  });
}
function lg(val){
  console.log(val)
}
// dari skrip di atas  saya mau tambahakan mengambil elemen dg kriteria spt ini
// elemnnya #page-content get value dari .discussionname
// elemennya #page-header get value dari .h2

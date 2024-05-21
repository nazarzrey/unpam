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
  const elementDataFordis = forumPostContainer.querySelectorAll('.forumpost'); // Ambil semua elemen forumpost di dalam forum-post-container

  const results = []; // Array untuk menyimpan hasil
  const title = [];
  const utama = [];
  elementDataFordis.forEach(FordisDetailsElement => {
    const aElement = FordisDetailsElement.querySelector('a');
    const timeElement = FordisDetailsElement.querySelector('time');
    const postId = FordisDetailsElement.getAttribute('data-post-id');

    const aText = aElement ? aElement.textContent.trim() : null;
    const timeText = timeElement ? timeElement.textContent.trim() : null;
    const IDPost = postId ? postId.trim() : null;

    const result = {
      nama: aText,
      waktu: timeText,
      postid:IDPost
    };
    results.push(result);
  });

  const pageContentValue = document.querySelector("#page-content .discussionname")?.textContent?.trim();
  const pageHeaderValue = document.querySelector("#page-header .h2")?.textContent?.trim();

  const elementDataKelas = document.querySelectorAll('#page-navbar'); // Ambil semua elemen forumpost di dalam forum-post-container  
  console.log(elementDataFordis);
  console.log(elementDataKelas);
  elementDataKelas.forEach(KelasDetailsElement => {    
    const aKlsElement = KelasDetailsElement.querySelector('a');
    const aKlsData = aKlsElement ? aKlsElement.textContent.trim() : null;    
    const hasil = {
      kepalas: aKlsData
    };
    utama.push(hasil);
  })
  // Add them to the results if they exist
  if (pageContentValue) {
    title.push({ fordistitle: pageContentValue });
  }
  if (pageHeaderValue) {
    title.push({ fordiske: pageHeaderValue });
  }

  return [results,title,utama];
}

chrome.tabs.onUpdated.addListener(function (tabId, changeInfo, tab) {
    console.log("Event Triggered")
  if (changeInfo.status === "complete" && tab.active) {
    var Kls   = UrlCrawl("kelas");
    var Admin = UrlCrawl("admin");
    if (typeof tab.url !== 'undefined'){
      var tabUrl = tab.url.replace(".ac.id",".id");
        if(tabUrl?.startsWith(UrlCrawl("url"))) {
        chrome.scripting
          .executeScript({
            target: { tabId: tabId },
            func: grabJobDescription,
            args: [getJobDescriptionClassName(tabUrl)],
          })
          .then((queryResult) => {
            lg(queryResult[0].result);
            var url = tabUrl
            send_data(queryResult[0].result,url,Kls,Admin)
          });
      }
    }
  }
});

function send_data(obj_data,url,kls,adm){
  if (Object.keys(obj_data).length === 0 && obj_data.constructor === Object) {
      console.log("Data is empty, skipping the send request.");
      return;
  }
  var get7an = 'https://nazrey.com/project/unpam/absen_ci3_backend/receive_data'
  chrome.storage.local.get(['UrlTarget'], function(result) {
    if (chrome.runtime.lastError) {
      console.error("Error retrieving URL from local storage:", chrome.runtime.lastError.message);
      // Handle error (e.g., use a default URL)
      UriServer = get7an; // Or alternative URL
    } else {
      if (result.UrlTarget) {
        UriServer = result.UrlTarget;
      } else {
        UriServer = get7an; // Use default URL if not set
      }
    }
  });
  
  if (typeof UriServer === 'undefined'){
    console.log("URL server blum di definiskan, silahkan refresh");    
    chrome.runtime.sendMessage({message: "URL server blum di definiskan, silahkan refresh"});
    return;
  }
  //var UriServer = 'http://localhost/web/unpam_project/absen_ci3_backend/receive_data';
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

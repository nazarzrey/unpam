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
var backUserName = "";
var backselisih = "";
function UrlCrawl(tipe){
  if(tipe=="url"){
    chrome.storage.local.get(['UrlLearn'], function(result) {
        if (!result.UrlLearn) {
            console.log("URL tidak ditemukan jadi pakai yang lain");
            backUrlCrawl = "http://localhost/web/unpam_project/contoh/"; 
        }else{
          backUrlCrawl = result.UrlLearn; 
        }
      })
      return backUrlCrawl;
  }else if(tipe=="sync"){
    chrome.storage.local.get(['syncServer'], function(result) {
        if (!result.syncServer) {
            console.log("URL tidak ditemukan jadi pakai yang lain");
            backUrlCrawl = "https://absenunpam.my.id/"; 
        }else{
          backUrlCrawl = result.syncServer; 
        }
      })
      return backUrlCrawl;
  }else if(tipe=="kelas"){
    chrome.storage.local.get(['KelasName'], function(result) {
        if (!result.KelasName) {
            console.log("URL tidak ditemukan jadi pakai yang lain");
            backUrlKelas = "TPLE004"; 
        }else{
          backUrlKelas = result.KelasName; 
        }
      })
      return backUrlKelas;    
  }else if(tipe=="admin"){
    chrome.storage.local.get(['UserName'], function(result) {
        if (!result.UserName) {
            console.log("Data UserName tidak ditemukan jadi pakai TPLE004");
            backUserName = "Users"; 
        }else{
          backUserName = result.UserName; 
        }
      })
      return backUserName;    
  }else if(tipe=="selisih"){
    chrome.storage.local.get(['selisih'], function(result) {
        if (!result.selisih) {
            console.log("Data selisih tidak ditemukan jadi pakai 0");
            backselisih = "z"; 
        }else{
          backselisih = result.selisih; 
        }
      })
      return backselisih;    
  }else{
    return "zero";        
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
  const matkul = [];
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

  const elementDataKelas = document.querySelectorAll('#page-navbar');
  if(elementDataKelas){
    elementDataKelas.forEach(KelasDetailsElement => {    
      const aKlsElement = KelasDetailsElement.querySelector('a');
      const aKlsData = aKlsElement ? aKlsElement.textContent.trim() : null;    
      const Klshasil = {
        pelajaran: aKlsData
      };
      matkul.push(Klshasil);
    })
  }
  // Add them to the results if they exist
  if (pageContentValue) {
    title.push({ fordistitle: pageContentValue });
  }
  if (pageHeaderValue) {
    title.push({ fordiske: pageHeaderValue });
  }

  return [results,title,matkul];
}

chrome.tabs.onUpdated.addListener(function (tabId, changeInfo, tab) {
    console.log("Event Triggered")
  if (changeInfo.status === "complete" && tab.active) {
    var Kls   = UrlCrawl("kelas");
    var Admin = UrlCrawl("admin");
    if (typeof tab.url !== 'undefined'){
 //     var tabUrl = tab.url.replace(".ac.id",".id");
      var tabUrl = tab.url;
        console.log("URL TAB "+tabUrl);
        if(tabUrl?.startsWith(UrlCrawl("url"))) {
        chrome.scripting
          .executeScript({
            target: { tabId: tabId },
            func: grabJobDescription,
            args: [getJobDescriptionClassName(tabUrl)],
          })
          .then((queryResult) => {
            // lg(queryResult[0].result);
            var url = tabUrl
            send_data(queryResult[0].result,url,Kls,Admin);
            // lg(UrlCrawl("selisih")+"AABC")
            setTimeout(() => {              
              if(UrlCrawl("selisih")=="1"){
            
                setTimeout(() => {              
                  getUrl("get");
                }, 200);
                setTimeout(() => {              
                  getUrl("send");
                }, 300);
                
                lg("jalanin get ke server otomatis krna datanya gagal di get")

              }else if(UrlCrawl("selisih")==""){
            
                setTimeout(() => {              
                  getUrl("get");
                }, 200);
                setTimeout(() => {              
                  getUrl("send");
                }, 300);
                
                lg("jalanin get ke server otomatis krna datanya kosong")
              }
            }, 2500);
          });
      }else{
        let msg = "Url pada browser tidak sama dengan inputan URL...!!!"
        console.log(msg);
        // chrome.runtime.sendMessage({message: msg});
      }
    }
  }
});

function checkKeywordInUrl(keyword) {
  let currentUrl = window.location.href;
  let isKeywordFound = currentUrl.toLowerCase().includes(keyword.toLowerCase());

  if (isKeywordFound) {
    return "Kata '" + keyword + "' ditemukan dalam URL.";
  } else {
    return "Kata '" + keyword + "' tidak ditemukan dalam URL.";
  }
}

/*
let keywordToSearch = "unpam";
let result = checkKeywordInUrl(keywordToSearch);
console.log(result);

// Untuk menampilkan pesan di halaman, misalnya dalam sebuah elemen dengan id "result":
document.getElementById("result").textContent = result;
*/

function send_data(obj_data,url,kls,adm){
  if(obj_data){
    if (Object.keys(obj_data).length === 0 && obj_data.constructor === Object) {
        console.log("Data is empty, skipping the send request.");
        return;
    }
    //var get7an = 'https://nazrey.com/project/unpam/absen_ci3_backend/receive_data'
    var get7an = 'https://absenunpam.my.id/receive_data'
    //var UriServer = 'http://localhost/web/unpam_project/absen_ci3_backend/receive_data';
    chrome.storage.local.get(['UrlServer'], function(result) {
      if (chrome.runtime.lastError) {
        console.error("Error retrieving URL from local storage:", chrome.runtime.lastError.message);
        // Handle error (e.g., use a default URL)
        UriServer = get7an; // Or alternative URL
      } else {
        if (result.UrlServer) {
          UriServer = result.UrlServer;
        } else {
          UriServer = get7an; // Use default URL if not set
        }
      }
    });
    
    if (typeof UriServer === 'undefined'){
      console.log("URL server blum di definiskan, silahkan refresh");    
      chrome.runtime.sendMessage({message: "URL server blum di definiskan, silahkan refresh"});
      if(adm.toLowerCase() == "nazar"){
        lg("refresh page karna super admin");
        chrome.tabs.reload(); //matikan dulu auto reload servernya supaya ga berat2in
      }
      return;
    }
    fetch(UriServer, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },      
        body: JSON.stringify({
          url: url,
          data: obj_data[0],
          fordis: obj_data[1],
          matkul: obj_data[2],
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
}
function lg(val){
  console.log(val)
}
async function getUrl(tipe) {
  console.log(UrlCrawl("syncServer"))
  try {
      let response = await fetch('https://absenunpam.my.id/xhr/get/link-'+tipe);
      // let response = await fetch('http://localhost/web/unpam_project/absen_ci3_backend/xhr/get/link-'+tipe);
      if (!response.ok) {
          throw new Error('Network response was not ok');
      }
      let data = await response.json();
      let url = data.url;
      if(isValid(url)){
          if(tipe=="get"){
              // chrome.storage.local.set({UrlLearn: url}, function() {
              //     console.log('UrlLearn : ' + url);
              // });              
              chrome.runtime.sendMessage({UrlLearn: data.url});
          }else{
              // chrome.storage.local.set({UrlServer: url}, function() {
              //     console.log('UrlServer : ' + url);
              // });
              chrome.runtime.sendMessage({UrlServer: data.url});
          }
      }
  } catch (error) {
      console.error('There was a problem with the fetch operation:', error);
  }
}
// dari skrip di atas  saya mau tambahakan mengambil elemen dg kriteria spt ini
// elemnnya #page-content get value dari .discussionname
// elemennya #page-header get value dari .h2


function isValid(value) {
  return value !== null && value !== undefined && value !== "";
}
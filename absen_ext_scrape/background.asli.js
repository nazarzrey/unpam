function lg(val){
  console.log(val)
}
console.log("Bg running cusy")
var  linkedInListViewURL = "Abc";
// URL untuk mengambil data JSON
const GET_URL = "http://localhost/web/unpam_project/absen_ci3_backend/api_link";
fetch(GET_URL)
  .then(response => response.json()) // Mengubah respon menjadi objek JSON
  .then(data => {
    // Menetapkan linkedInListViewURL dengan hasil balikan JSON
    linkedInListViewURL = data.url; // Ubah 'url' menjadi kunci yang sesuai dengan hasil JSON yang Anda terima
    // Sekarang Anda dapat menggunakan linkedInListViewURL di dalam skrip Anda sesuai kebutuhan
  })
  .catch(error => {
    console.error('Error fetching data:', error); // Tangani kesalahan jika terjadi
  });


function getJobDescriptionClassName(url) {
  lg(linkedInListViewURL);
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
        });
    }
  }
});
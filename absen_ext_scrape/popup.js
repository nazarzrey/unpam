document.addEventListener('DOMContentLoaded', function () {
    var h1 = document.getElementById('h1');
    var h2 = document.getElementById('h2');
    var inputKLS = document.getElementById('inputKLS');
    var inputMatKul = document.getElementById('inputMatKul');
    var inputAdmin = document.getElementById('inputAdmin');
    var saveButton = document.getElementById('saveButton');
    var targetUrlSH = document.getElementById('targetUrl');
    var Urltujuan = document.getElementById('urlTarget');
    // const currentURL = window.location.href;
    // const isLocalhost = currentURL.includes('localhost');
    // var cekHost = "Z";
    // chrome.tabs.onUpdated.addListener(function(tabId, changeInfo, tab) {
    //     if (tab.active) {
    //     const activeTabUrl = tab.url;
    //         if (activeTabUrl.includes('localhost')) {
    //             document.getElementById('targetUrl').style.display = 'block';
    //             cekHost = "Y"
    //         } else {
    //             document.getElementById('targetUrl').style.display = 'none';
    //             cekHost = "N";
    //         }
    //     }
    //     console.log(cekHost);
    // });
    // if(cekHost=="Z"){
    //     chrome.tabs.query({ active: true, currentWindow: true }, (tabs) => {
    //         chrome.tabs.reload(tabs[0].id);
    //     });
    // }
    saveButton.addEventListener('click', function () {
        var inputKLSValue = inputKLS.value.trim();
        var inputMatKulValue = inputMatKul.value.trim();
        var inputAdminValue = inputAdmin.value.trim();
        var UrltujuanValue = Urltujuan.value.trim();

        if (inputMatKulValue === "") {
            h1.innerHTML = "Inputan MatKul tidak boleh kosong!";
        } else if (inputKLSValue === "") {
            h1.innerHTML = "Inputan Kelas tidak boleh kosong!";
        } else if (inputAdminValue === "") {
            h1.innerHTML = "Admin tidak boleh kosong!";
        } else {
            h1.innerHTML = "Data berhasil disimpan!";             
            localStorage.setItem("urlKLS", inputKLSValue);                 
            chrome.storage.local.set({urlKLS: inputKLSValue}, function() {
                console.log('Kelas : ' + inputKLSValue);
            });  
            localStorage.setItem("UrlMatKul", inputMatKulValue);   
            chrome.storage.local.set({UrlMatKul: inputMatKulValue}, function() {
                console.log('Url : ' + inputMatKulValue);
            });
            localStorage.setItem("UrlAdmin", inputAdminValue);   
            chrome.storage.local.set({UrlAdmin: inputAdminValue}, function() {
                console.log('Admin : ' + inputAdminValue);
            });
            localStorage.setItem("UrlTarget", UrltujuanValue);   
            chrome.storage.local.set({UrlTarget: UrltujuanValue}, function() {
                console.log('UrlTarget : ' + UrltujuanValue);
            });
            setTimeout(() => {
                chrome.tabs.query({ active: true, currentWindow: true }, (tabs) => {
                    chrome.tabs.reload(tabs[0].id);
                });
            }, 2000);
        } 
        setTimeout(() => {
            h1.innerHTML = "";
            h2.innerHTML = "";
        }, 5000);
    });

    // Cek apakah ada data di localStorage saat halaman dimuat
    var storedMatkulURL = localStorage.getItem("UrlMatKul");
    var storedDataKLS = localStorage.getItem("urlKLS");
    var storedDataAdmin = localStorage.getItem("UrlAdmin");
    var storedData7an = localStorage.getItem("UrlTarget");
    if (storedDataAdmin) {
        inputAdmin.value = storedDataAdmin;
    }
    if (storedMatkulURL) {
        inputMatKul.value = storedMatkulURL;
    }
    if (storedData7an) {
        Urltujuan.value = storedData7an;
    }
    if (storedDataKLS) {
        inputKLS.value = storedDataKLS;
    } else {
        var msg1 = "Data kelas tidak ada..!!!";
        var msg2 = "Aplikasi tidak bisa jalan";
        h1.innerHTML = msg1;
        h2.innerHTML = msg2;
    }
    if (storedDataAdmin != null) {
        if (storedDataAdmin.toLowerCase()=="nazar") {
            targetUrlSH.style.display = 'block'; // Tampilkan elemen
        } else {
            targetUrlSH.style.display = 'none'; // Tampilkan elemen
        }
    }
});

// Tambahkan event listener untuk menerima pesan dari background.js
chrome.runtime.onMessage.addListener(function (request, sender, sendResponse) {
    var balikan = request.message
    var cetakBalikan = document.getElementById('balikan1'); 
    if (balikan) {
        cetakBalikan.innerHTML= request.message;
        setTimeout(() => {
            cetakBalikan.innerHTML = "";
        }, 5000);
    }else{
        cetakBalikan.innerHTML = "";
    }
});
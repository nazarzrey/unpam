document.addEventListener('DOMContentLoaded', function () {
    var h1 = document.getElementById('h1');
    var h2 = document.getElementById('h2');
    var inputKLS = document.getElementById('inputKLS');
    var inputAdmin = document.getElementById('inputAdmin');
    var saveButton = document.getElementById('saveButton');
    // var targetUrlSH = document.getElementById('targetUrl'); //alias aja
    var urlLearning = document.getElementById('urlLearn');
    var UrlServer = document.getElementById('UrlServer');   

    // function hitungSelisihMenit(waktuTersimpan) {
    //     let waktuInput = new Date(waktuTersimpan).toLocaleString();
    //     let sekarang = new Date().toLocaleString();
    //     let selisihMiliDetik = sekarang - waktuInput;
    //     let selisihMenit = Math.floor(selisihMiliDetik / 60000);
    //     return selisihMenit;
    // }
    
    // var lastSync = new Date().toLocaleString();
    // var selisih = hitungSelisihMenit();
    function hitungSelisihMenit(waktuTersimpan) {
        // Konversi waktu tersimpan ke objek Date
        if(!isValid(waktuTersimpan)){
            return "ya"
        }else{
            let parts = waktuTersimpan.split('/');
            let waktuInputFormatted = `${parts[2]}-${parts[1]}-${parts[0]}`;  // Format YYYY-MM-DD
        
            let waktuInput = new Date(waktuInputFormatted).toLocaleDateString('id-ID');
            
            // Ambil tanggal hari ini
            let sekarang = new Date().toLocaleDateString('id-ID');
            
            console.log(waktuTersimpan+" past: " + waktuInput + " now: " + sekarang);
            
            // Bandingkan dua tanggal yang sudah diformat menjadi string
            if (waktuInput !== sekarang) {
                return "ya";
            } else {
                return "tidak";
            }
        }
    }
    function isValid(value) {
        return value !== null && value !== undefined && value !== "";
    }

    // Contoh penggunaan fungsi

    function loadDataInput(){
        // Cek apakah ada data di localStorage saat halaman dimuat
        var storedDataKLS = localStorage.getItem("KelasName");
        var storedDataAdmin = localStorage.getItem("UserName");
        var storeLearnURL = localStorage.getItem("UrlLearn");
        var storeServerURL = localStorage.getItem("UrlServer");
        console.log(storeLearnURL+" load ");
        console.log(storeServerURL+" load ");
        if (storedDataAdmin) {
            inputAdmin.value = storedDataAdmin;
        }
        if (storeLearnURL) {
            urlLearning.value = storeLearnURL;
        }
        if (storeServerURL) {
            UrlServer.value = storeServerURL;
        }
        if (storedDataKLS) {
            inputKLS.value = storedDataKLS;
        } else {
            var msg1 = "Data kelas tidak ada..!!!";
            var msg2 = "Aplikasi tidak bisa jalan";
            h1.innerHTML = msg1;
            h2.innerHTML = msg2;
        }
    }
    async function getUrl(tipe) {
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
                    localStorage.setItem("UrlLearn", url);   
                    chrome.storage.local.set({UrlLearn: url}, function() {
                        // console.log('UrlLearn : ' + url);
                    });
                }else{
                    localStorage.setItem("UrlServer", url);   
                    chrome.storage.local.set({UrlServer: url}, function() {
                        // console.log('UrlServer : ' + url);
                    });
                }
            }
        } catch (error) {
            console.error('There was a problem with the fetch operation:', error);
        }
    }    
    
    saveButton.addEventListener('click', function () {
        var inputKLSValue = inputKLS.value.trim();
        var inputAdminValue = inputAdmin.value.trim(); 
        var lasttime = localStorage.getItem("lastSync");
        console.log(lasttime)
        var selisih = hitungSelisihMenit(lasttime);
        setTimeout(() => {            
            var lastSync = new Date().toLocaleDateString('id-ID');
            if (inputKLSValue === "") {
                h1.innerHTML = "Inputan Kelas tidak boleh kosong!";
            } else if (inputAdminValue === "") {
                h1.innerHTML = "Admin tidak boleh kosong!";
            } else {
                h1.innerHTML = "Data berhasil disimpan!";             
                localStorage.setItem("KelasName", inputKLSValue);                 
                chrome.storage.local.set({KelasName: inputKLSValue}, function() {
                    console.log('Kelas : ' + inputKLSValue);
                });              
                setTimeout(() => {              
                  getUrl("get");
                }, 100);
                setTimeout(() => {              
                  getUrl("send");
                }, 300);
                localStorage.setItem("UserName", inputAdminValue);   
                chrome.storage.local.set({UserName: inputAdminValue}, function() {
                    console.log('Admin : ' + inputAdminValue);
                });
                localStorage.setItem("selisih", selisih);   
                chrome.storage.local.set({selisih: selisih}, function() {
                    console.log('selisih : ' + selisih);
                });
                localStorage.setItem("lastSync", lastSync);   
                chrome.storage.local.set({lastSync: lastSync}, function() {
                    console.log('lastSync : ' + lastSync);
                });
                setTimeout(() => {
                    chrome.tabs.query({ active: true, currentWindow: true }, (tabs) => {
                        chrome.tabs.reload(tabs[0].id);
                    });
                }, 2000);
            } 
        }, 500);
        setTimeout(() => {
            h1.innerHTML = "";
            h2.innerHTML = "";
        }, 2500);
        setTimeout(() => {
            loadDataInput();
        }, 500);
    });
    loadDataInput();
});

// Tambahkan event listener untuk menerima pesan dari background.js
chrome.runtime.onMessage.addListener(function (request, sender, sendResponse) {
    console.log(request)
    var balikan = request.message
    var UrlSrv  = request.UrlServer
    var UrlELE  = request.UrlLearn
    // console.log(balikan+" "+UrlSrv+" "+UrlELE+" ABCD");
    var cetakBalikan = document.getElementById('balikan1');  
    if (balikan) {
        cetakBalikan.innerHTML= request.message;
        setTimeout(() => {
            cetakBalikan.innerHTML = "";
        }, 2500);
    }else{
        cetakBalikan.innerHTML = "";
    }    
    if (UrlSrv) {
        document.getElementById('UrlServer').value = UrlSrv;
        localStorage.setItem("UrlServer", UrlSrv);   
        chrome.storage.local.set({UrlServer: UrlSrv});
    }
    if (UrlELE) {
        document.getElementById('urlLearn').value = UrlELE;
        localStorage.setItem("UrlLearn", UrlELE);   
        chrome.storage.local.set({UrlLearn: UrlELE});
    }
});
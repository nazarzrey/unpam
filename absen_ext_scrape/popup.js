document.addEventListener('DOMContentLoaded', function () {
    var h1 = document.getElementById('h1');
    var h2 = document.getElementById('h2');
    var inputKLS = document.getElementById('inputKLS');
    var inputMatKul = document.getElementById('inputMatKul');
    var inputAdmin = document.getElementById('inputAdmin');
    var saveButton = document.getElementById('saveButton');

    saveButton.addEventListener('click', function () {
        var inputKLSValue = inputKLS.value.trim();
        var inputMatKulValue = inputMatKul.value.trim();
        var inputAdminValue = inputAdmin.value.trim();

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
        } 
    });

    // Cek apakah ada data di localStorage saat halaman dimuat
    var storedMatkulURL = localStorage.getItem("UrlMatKul");
    var storedDataKLS = localStorage.getItem("urlKLS");
    var storedDataAdmin = localStorage.getItem("UrlAdmin");
    if (storedDataAdmin) {
        inputAdmin.value = storedDataAdmin;
    }
    if (storedMatkulURL) {
        inputMatKul.value = storedMatkulURL;
    }
    if (storedDataKLS) {
        inputKLS.value = storedDataKLS;
    } else {
        var msg1 = "Data kelas tidak ada..!!!";
        var msg2 = "Aplikasi tidak bisa jalan";
        h1.innerHTML = msg1;
        h2.innerHTML = msg2;
    }
});

// Tambahkan event listener untuk menerima pesan dari background.js
chrome.runtime.onMessage.addListener(function (request, sender, sendResponse) {
    var balikan = request.message
    if (balikan) {
        if(balikan.length>50){
            document.getElementById('balikan1').innerHTML = request.message;
        }else{
            document.getElementById('balikan2').innerHTML = request.message;
        }
    }else{
        document.getElementById('balikan2').innerHTML = "";
        document.getElementById('balikan1').innerHTML = "";
    }
});
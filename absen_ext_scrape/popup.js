document.addEventListener('DOMContentLoaded', function () {
    var h1 = document.getElementById('h1');
    var h2 = document.getElementById('h2');
    var inputKLS = document.getElementById('kls');
    var inputField = document.getElementById('inputField');
    var saveButton = document.getElementById('saveButton');

    saveButton.addEventListener('click', function () {
        var inputValue = inputField.value.trim(); // Trim untuk menghapus spasi ekstra di awal dan akhir input
https://e-learning.unpam.id/mod/forum/
        if (inputValue === "") {
            alert("Inputan tidak boleh kosong!");
        } else {
            // Simpan nilai ke localStorage
            localStorage.setItem('urlAbsen', inputValue);
            h1.innerHTML = "Data berhasil disimpan!";
            
            var dataToStore = {
                urlAbsen: inputKLS,
                urlKLS: inputValue
            };
              
            chrome.storage.local.set(dataToStore, function() {
            console.log('Data telah disimpan.');
            });
        } 

    });

    // Cek apakah ada data di localStorage saat halaman dimuat
    var storedDataURL = localStorage.getItem('urlAbsen');
    var storedDataKLS = localStorage.getItem('urlKLS');
    if (storedDataURL) {
        inputField.value = storedDataURL;
    }
    if (storedDataKLS) {
        inputKLS.value = storedDataKLS;
    }else{
        var msg1 = "Data kelas tidak ada..!!!"
        var msg2 = "Aplikasi tidak bisa jalan  "
        h1.innerHTML = msg1;
        h2.innerHTML = msg2;
    }
    
});

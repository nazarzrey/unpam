// Ambil data dari localStorage halaman web
document.getElementById("getData").addEventListener("click", () => {
  chrome.tabs.query({ active: true, currentWindow: true }, (tabs) => {
    chrome.tabs.sendMessage(
      tabs[0].id,
      { action: "getMatkulData" },
      (response) => {
        if (response) {
          alert(JSON.stringify(response));
        } else {
          alert("Data tidak ditemukan");
        }
      }
    );
  });
});

// Simpan data ke localStorage halaman web
document.getElementById("saveData").addEventListener("click", () => {
  const dataMatkul = {
    matkul: ["aljabar", "algoritma", "graph"],
    sks: [2, 3, 2],
  };

  chrome.tabs.query({ active: true, currentWindow: true }, (tabs) => {
    chrome.tabs.sendMessage(tabs[0].id, {
      action: "saveMatkulData",
      data: dataMatkul,
    });
  });
  alert("Data disimpan!");
});

// Fungsi untuk menandai mata kuliah berdasarkan data di localStorage dan memungkinkan input dengan UI yang lebih rapi
(function highlightMatkul() {
  console.log("HighlightMatkul: mulai eksekusi");

  function getDataMatkul() {
    const data = JSON.parse(localStorage.getItem("matkulData"));
    if (!data) {
      console.log(
        "HighlightMatkul: dataMatkul tidak ditemukan di localStorage"
      );
      return { matkul: [], sks: [], status: [] };
    }
    console.log("HighlightMatkul: dataMatkul ditemukan", data);
    return data;
  }

  function saveDataMatkul(data) {
    localStorage.setItem("matkulData", JSON.stringify(data));
    console.log("HighlightMatkul: dataMatkul berhasil disimpan", data);
  }

  function deleteMatkul(index) {
    const dataMatkul = getDataMatkul();
    dataMatkul.matkul.splice(index, 1);
    dataMatkul.sks.splice(index, 1);
    dataMatkul.status.splice(index, 1);
    saveDataMatkul(dataMatkul);
    applyHighlight(dataMatkul);
    renderMatkulList();
  }

  function applyHighlight(dataMatkul) {
    const cards = document.querySelectorAll(".card.MuiBox-root");
    console.log(`HighlightMatkul: ${cards.length} elemen card ditemukan`);

    cards.forEach((card) => {
      const text = card.textContent.toLowerCase();
      console.log("HighlightMatkul: memeriksa card dengan teks:", text);

      dataMatkul.matkul.forEach((matkul, index) => {
        if (text.includes(matkul.toLowerCase())) {
          const sks = dataMatkul.sks[index];
          const status = dataMatkul.status[index];
          console.log(
            `HighlightMatkul: cocok dengan matkul "${matkul}", SKS: ${sks}, Status: ${status}`
          );

          if (status === "offline") {
            card.style.backgroundColor = sks === 2 ? "gray" : "brown";
          } else if (status === "online") {
            card.style.backgroundColor = sks === 2 ? "lightblue" : "tomato";
          } else {
            card.style.backgroundColor = "";
          }
        }
      });
    });
  }

  function renderMatkulList() {
    const dataMatkul = getDataMatkul();
    const listContainer = document.getElementById("matkulList");
    listContainer.innerHTML = "";

    dataMatkul.matkul.forEach((matkul, index) => {
      const listItem = document.createElement("div");
      listItem.style.display = "flex";
      listItem.style.justifyContent = "space-between";
      listItem.style.marginTop = "5px";

      listItem.textContent = `${matkul} (${dataMatkul.sks[index]} SKS, ${dataMatkul.status[index]})`;
      const deleteButton = document.createElement("button");
      deleteButton.textContent = "❌";
      deleteButton.onclick = () => deleteMatkul(index);

      listItem.appendChild(deleteButton);
      listContainer.appendChild(listItem);
    });
  }

  function createInputForm() {
    const container = document.createElement("div");
    container.style.position = "fixed";
    container.style.bottom = "10px";
    container.style.right = "10px";
    container.style.zIndex = "10000";

    const toggleButton = document.createElement("button");
    toggleButton.textContent = "➕ Matkul";
    toggleButton.onclick = () => {
      formContainer.style.display =
        formContainer.style.display === "none" ? "block" : "none";
    };

    const formContainer = document.createElement("div");
    formContainer.style.display = "none";
    formContainer.style.backgroundColor = "white";
    formContainer.style.padding = "10px";
    formContainer.style.border = "1px solid black";
    formContainer.style.borderRadius = "8px";
    formContainer.style.boxShadow = "0 2px 8px rgba(0,0,0,0.1)";

    const inputMatkul = document.createElement("input");
    inputMatkul.placeholder = "Nama Matkul";
    inputMatkul.style.marginRight = "5px";

    const inputSks = document.createElement("input");
    inputSks.type = "number";
    inputSks.placeholder = "Jumlah SKS";
    inputSks.style.marginRight = "5px";

    const inputStatus = document.createElement("select");
    const optionOffline = document.createElement("option");
    optionOffline.value = "offline";
    optionOffline.textContent = "Offline";
    const optionOnline = document.createElement("option");
    optionOnline.value = "online";
    optionOnline.textContent = "Online";
    inputStatus.appendChild(optionOffline);
    inputStatus.appendChild(optionOnline);
    inputStatus.style.marginRight = "5px";

    const saveButton = document.createElement("button");
    saveButton.textContent = "Simpan";
    saveButton.onclick = () => {
      const dataMatkul = getDataMatkul();
      const matkul = inputMatkul.value.trim();
      const sks = parseInt(inputSks.value);
      const status = inputStatus.value;

      if (matkul && (sks === 2 || sks === 3)) {
        dataMatkul.matkul.push(matkul);
        dataMatkul.sks.push(sks);
        dataMatkul.status.push(status);
        saveDataMatkul(dataMatkul);
        applyHighlight(dataMatkul);
        renderMatkulList();
        inputMatkul.value = "";
        inputSks.value = "";
      } else {
        alert("Masukkan data yang valid");
      }
    };

    const listContainer = document.createElement("div");
    listContainer.id = "matkulList";

    formContainer.appendChild(inputMatkul);
    formContainer.appendChild(inputSks);
    formContainer.appendChild(inputStatus);
    formContainer.appendChild(saveButton);
    formContainer.appendChild(listContainer);

    container.appendChild(toggleButton);
    container.appendChild(formContainer);
    document.body.appendChild(container);

    renderMatkulList();
  }

  const dataMatkul = getDataMatkul();

  applyHighlight(dataMatkul);

  const observer = new MutationObserver(() => {
    console.log(
      "HighlightMatkul: perubahan DOM terdeteksi, menjalankan highlight ulang"
    );
    applyHighlight(getDataMatkul());
  });

  observer.observe(document.body, { childList: true, subtree: true });

  console.log("HighlightMatkul: observer aktif");

  createInputForm();
})();

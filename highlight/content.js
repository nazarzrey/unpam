// Fungsi untuk menandai mata kuliah berdasarkan data di localStorage dan memungkinkan input dengan UI yang lebih rapi
(function highlightMatkul() {
  console.log("HighlightMatkul: mulai eksekusi");

  function getDataMatkul() {
    const data = JSON.parse(localStorage.getItem("matkulData"));
    if (!data) {
      console.log(
        "HighlightMatkul: dataMatkul tidak ditemukan di localStorage"
      );
      return { matkul: [], sks: [] };
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
    saveDataMatkul(dataMatkul);
    renderMatkulList();
    applyHighlight(dataMatkul); // Tambahan agar perubahan langsung terlihat di halaman
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
          console.log(
            `HighlightMatkul: cocok dengan matkul "${matkul}", SKS: ${sks}`
          );
          if (sks === 2) {
            card.style.backgroundColor = "lightgreen";
          } else if (sks === 3) {
            card.style.backgroundColor = "#f4f523";
            card.style.console = "#f4f523";
          } else {
            card.style.backgroundColor = "";
          }
        }
      });
    });
  }

  function createInputForm() {
    const container = document.createElement("div");
    container.style.position = "fixed";
    container.style.bottom = "10px";
    container.style.right = "10px";
    container.style.backgroundColor = "white";
    container.style.padding = "10px";
    container.style.border = "1px solid #dddd";
    container.style.zIndex = "10000";
    container.style.borderRadius = "8px";
    container.style.fontSize = "12px";
    container.style.boxShadow = "0 2px 8px rgba(0,0,0,0.1)";
    container.style.height = "45px";

    const toggleButton = document.createElement("button");
    toggleButton.textContent = "⚙️Setting Matkul";
    toggleButton.style.marginBottom = "5px";
    toggleButton.onclick = () => {
      formContainer.style.display =
        formContainer.style.display === "none" ? "block" : "none";
      formContainer.style.display === "none"
        ? (container.style.height = "45px")
        : (container.style.height = "auto");
    };

    const formContainer = document.createElement("div");
    formContainer.style.display = "none";

    const inputMatkul = document.createElement("input");
    inputMatkul.placeholder = "Nama Matkul";
    inputMatkul.style.marginRight = "5px";

    const inputSks = document.createElement("input");
    inputSks.type = "number";
    inputSks.placeholder = "Jumlah SKS";
    inputSks.style.marginRight = "5px";

    const saveButton = document.createElement("button");
    saveButton.textContent = "Simpan";
    saveButton.onclick = () => {
      const dataMatkul = getDataMatkul();
      const matkul = inputMatkul.value.trim();
      const sks = parseInt(inputSks.value);

      if (matkul && (sks === 2 || sks === 3)) {
        dataMatkul.matkul.push(matkul);
        dataMatkul.sks.push(sks);
        saveDataMatkul(dataMatkul);
        applyHighlight(dataMatkul);
        renderMatkulList();
        inputMatkul.value = "";
        inputSks.value = "";
      } else {
        alert("Masukkan data yang valid");
      }
    };

    formContainer.appendChild(inputMatkul);
    formContainer.appendChild(inputSks);
    formContainer.appendChild(saveButton);

    const listContainer = document.createElement("ul");
    listContainer.style.padding = "0";
    listContainer.style.listStyle = "none";

    function renderMatkulList() {
      listContainer.innerHTML = "";
      const dataMatkul = getDataMatkul();
      dataMatkul.matkul.forEach((matkul, index) => {
        const listItem = document.createElement("li");
        listItem.style.display = "flex";
        listItem.style.justifyContent = "space-between";
        listItem.style.marginTop = "5px";

        listItem.innerHTML = `${matkul} - ${dataMatkul.sks[index]} SKS`;

        const deleteButton = document.createElement("button");
        deleteButton.textContent = "❌";
        deleteButton.onclick = () => deleteMatkul(index);

        listItem.appendChild(deleteButton);
        listContainer.appendChild(listItem);
      });
    }

    container.appendChild(toggleButton);
    container.appendChild(formContainer);
    container.appendChild(listContainer);
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

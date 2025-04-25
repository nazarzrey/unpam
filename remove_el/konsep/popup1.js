document.addEventListener("DOMContentLoaded", function () {
  setupGetTextButton();
});

// Fungsi untuk setup tombol getText
function setupGetTextButton() {
  const getTextButton = document.getElementById("getText");
  const resultDiv = document.getElementById("result");

  if (!getTextButton || !resultDiv) {
    console.error(
      'Tombol "getText" atau elemen "result" tidak ditemukan di popup.'
    );
    return;
  }

  getTextButton.addEventListener("click", async () => {
    resultDiv.textContent = "Memproses...";

    try {
      const [tab] = await chrome.tabs.query({
        active: true,
        currentWindow: true,
      });

      const results = await chrome.scripting.executeScript({
        target: { tabId: tab.id },
        func: processPageElements,
      });

      if (results?.[0]?.result) {
        resultDiv.innerHTML = `
          <strong>Text dari result-text:</strong><br>
          ${results[0].result.originalText || "Tidak ditemukan"}<br><br>
          <strong>Proses Span:</strong><br>
          ${
            results[0].result.spanReport || "Tidak ada span yang diproses"
          }<br><br>
          <strong>Proses Mark:</strong><br>
          ${results[0].result.markReport || "Tidak ada mark yang diproses"}
        `;
      } else {
        resultDiv.textContent = "Tidak ada hasil yang didapatkan.";
      }
    } catch (error) {
      console.error("Error:", error);
      resultDiv.textContent = "Error: " + error.message;
    }
  });
}

// Fungsi ini akan dijalankan di halaman aktif
// Fungsi ini akan dijalankan di halaman aktif
function processPageElements() {
  const result = {
    originalText: null,
    spanReport: null,
    markReport: null,
  };

  const container = document.getElementById("result-text");

  if (!container) {
    result.originalText = "Elemen #result-text tidak ditemukan.";
    return result;
  }

  result.originalText = container.textContent;

  // Ambil semua <span> di dalam #result-text
  const spans = container.querySelectorAll("span");
  let spanRemovedCount = 0;
  let spanKeptCount = 0;

  spans.forEach((span) => {
    span.removeAttribute("style");
    span.removeAttribute("class");

    if (!span.hasAttribute("data-countername")) {
      span.remove();
      spanRemovedCount++;
    } else {
      spanKeptCount++;
    }
  });

  result.spanReport = `
    Total span: ${spans.length}<br>
    Dihapus: ${spanRemovedCount}<br>
    Disimpan: ${spanKeptCount}
  `;

  // Ambil semua <mark> di dalam #result-text
  const marks = container.querySelectorAll("mark");
  let markRemovedCount = 0;
  let markKeptCount = 0;

  marks.forEach((mark) => {
    mark.removeAttribute("style");
    mark.removeAttribute("class");

    if (!mark.hasAttribute("data-countername")) {
      mark.remove();
      markRemovedCount++;
    } else {
      markKeptCount++;
    }
  });

  result.markReport = `
    Total mark: ${marks.length}<br>
    Dihapus: ${markRemovedCount}<br>
    Disimpan: ${markKeptCount}
  `;

  return result;
}

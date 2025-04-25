document.getElementById("inject").addEventListener("click", async () => {
  const [tab] = await chrome.tabs.query({ active: true, currentWindow: true });

  chrome.scripting.executeScript({
    target: { tabId: tab.id },
    func: renderPlagiarismMessage,
  });
});

function renderPlagiarismMessage() {
  const targetElement = document.querySelector(".cus_scrollbar.plg-acco");

  if (!targetElement) {
    console.error('Elemen ".plg-acco" tidak ditemukan.');
    alert('Elemen ".plg-acco" tidak ditemukan di halaman.');
    return;
  }

  targetElement.innerHTML = `
    <div id="accordion" class="text-break"></div>
    <div class="align-items-center justify-content-center empty-sec d-flex">
      <div class="text-center">
        <img src="https://plagiarismdetector.net/pd-imgs/plg-not-found.svg" alt="impressive content" class="img-fluid plg-not-found">
        <h5 class="clr_fff fw_600 f16 mt-4">Congratulations</h5>
        <p class="clr_fff fw_600 mt-2">Plagiarism not found!</p>
      </div>
    </div>
  `;
}

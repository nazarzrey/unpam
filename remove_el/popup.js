document.addEventListener("DOMContentLoaded", function () {
  const mainActionBtn = document.getElementById("mainActionBtn");
  const statusElement = document.getElementById("status");

  if (!mainActionBtn || !statusElement) {
    console.error("Required elements not found in popup");
    return;
  }

  mainActionBtn.addEventListener("click", async () => {
    statusElement.textContent = "Processing all elements...";
    statusElement.className = "processing";

    try {
      const [tab] = await chrome.tabs.query({
        active: true,
        currentWindow: true,
      });

      // Eksekusi semua fungsi sekaligus
      await chrome.scripting.executeScript({
        target: { tabId: tab.id },
        func: processAllElements,
      });

      statusElement.textContent = "All elements processed successfully!";
      statusElement.className = "success";
    } catch (error) {
      console.error("Error:", error);
      statusElement.textContent = "Error: " + error.message;
      statusElement.className = "error";
    }
  });
});

function processAllElements() {
  // 1. Proses element result-text (span dan mark)
  const container = document.getElementById("result-text");
  if (container) {
    // Proses span
    const spans = container.querySelectorAll("span");
    spans.forEach((span) => {
      span.removeAttribute("style");
      span.removeAttribute("class");
      if (!span.hasAttribute("data-countername")) {
        span.remove();
      }
    });

    // Proses mark
    const marks = container.querySelectorAll("mark");
    marks.forEach((mark) => {
      mark.removeAttribute("style");
      mark.removeAttribute("class");
      if (!mark.hasAttribute("data-countername")) {
        mark.remove();
      }
    });
  }

  // 2. Modifikasi elemen plagiarisme
  const circles = [
    { id: "id_here1", keepClass: "border_per100" },
    { id: "id_here2", keepClass: "" },
    { id: "id_here3", keepClass: "" },
    { id: "id_here4", keepClass: "" },
  ];

  circles.forEach((circle) => {
    const element = document.getElementById(circle.id);
    if (element) {
      const classes = element.className.split(" ");
      const newClasses = classes.filter(
        (cls) => !cls.startsWith("border_per") || cls === circle.keepClass
      );

      if (circle.keepClass && !newClasses.includes(circle.keepClass)) {
        newClasses.push(circle.keepClass);
      }

      element.className = newClasses.join(" ");
    }
  });

  // 3. Update persentase
  const plagiarismElements = [
    ".plagiarized_final",
    ".plagiarized",
    ".plagiarized_partial",
  ];

  plagiarismElements.forEach((selector) => {
    const elements = document.querySelectorAll(selector);
    elements.forEach((el) => {
      el.textContent = "0%";
      if (el.hasAttribute("data-count")) {
        el.setAttribute("data-count", "0");
      }
    });
  });

  // 4. Set unique ke 100%
  const uniqueElement = document.querySelector(".unique");
  if (uniqueElement) {
    uniqueElement.textContent = "100%";
    if (uniqueElement.hasAttribute("data-count")) {
      uniqueElement.setAttribute("data-count", "100");
    }
  }

  // 5. Bersihkan hasil plagiarisme dan tampilkan pesan
  const targetElement = document.querySelector(".cus_scrollbar.plg-acco");
  if (targetElement) {
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

  console.log("All elements processed successfully");
}

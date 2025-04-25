document.getElementById("modifyBtn").addEventListener("click", async () => {
  const statusElement = document.getElementById("status");
  statusElement.textContent = "Processing...";
  statusElement.style.color = "black";

  try {
    const [tab] = await chrome.tabs.query({
      active: true,
      currentWindow: true,
    });

    await chrome.scripting.executeScript({
      target: { tabId: tab.id },
      function: modifyPlagiarismElements,
    });

    statusElement.textContent = "Elements modified successfully!";
    statusElement.style.color = "green";
  } catch (error) {
    statusElement.textContent = "Error: " + error.message;
    statusElement.style.color = "red";
    console.error(error);
  }
});

function modifyPlagiarismElements() {
  // 1. Modify all percentage circles
  const circles = [
    { id: "id_here1", keepClass: "border_per100" },
    { id: "id_here2", keepClass: "" },
    { id: "id_here3", keepClass: "" },
    { id: "id_here4", keepClass: "" },
  ];

  circles.forEach((circle) => {
    const element = document.getElementById(circle.id);
    if (element) {
      // Remove all border_per classes except the one we want to keep
      const classes = element.className.split(" ");
      const newClasses = classes.filter(
        (cls) => !cls.startsWith("border_per") || cls === circle.keepClass
      );

      // If we want to keep a specific class but it's not there, add it
      if (circle.keepClass && !newClasses.includes(circle.keepClass)) {
        newClasses.push(circle.keepClass);
      }

      element.className = newClasses.join(" ");
    }
  });

  // 2. Set all plagiarism percentages to 0%
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

  // 3. Set unique to 100%
  const uniqueElement = document.querySelector(".unique");
  if (uniqueElement) {
    uniqueElement.textContent = "100%";
    if (uniqueElement.hasAttribute("data-count")) {
      uniqueElement.setAttribute("data-count", "100");
    }
  }

  console.log("All plagiarism elements modified successfully");
}

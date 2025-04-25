function modifyElements() {
  console.log("[Element Modifier] Starting modification process...");

  // 1. Modifikasi elemen dengan id result-text
  const resultTextElements = document.querySelectorAll("#result-text span");
  console.log(
    `[Element Modifier] Found ${resultTextElements.length} span elements in #result-text`
  );

  resultTextElements.forEach((span, index) => {
    console.log(`[Element Modifier] Processing span #${index + 1}`);

    // Hapus semua atribut style dan class
    if (span.hasAttribute("style")) {
      console.log(`[Element Modifier] Removing style from span #${index + 1}`);
      span.removeAttribute("style");
    }

    if (span.hasAttribute("class")) {
      console.log(`[Element Modifier] Removing class from span #${index + 1}`);
      span.removeAttribute("class");
    }

    // Cek apakah memiliki data-countername
    if (!span.hasAttribute("data-countername")) {
      console.log(
        `[Element Modifier] Removing span #${index + 1} (no data-countername)`
      );
      span.remove();
    } else {
      console.log(
        `[Element Modifier] Keeping span #${index + 1} (has data-countername)`
      );
    }
  });

  // 2. Modifikasi elemen dengan id id_here2
  const idHere2Element = document.getElementById("id_here2");
  if (idHere2Element) {
    console.log("[Element Modifier] Found #id_here2 element");
    const classes = idHere2Element.className.split(" ");
    console.log(`[Element Modifier] Current classes: ${classes.join(", ")}`);

    if (classes.includes("border_per38")) {
      const newClasses = classes.filter((cls) => cls !== "border_per38");
      idHere2Element.className = newClasses.join(" ");
      console.log("[Element Modifier] Removed border_per38 class");
      console.log(`[Element Modifier] New classes: ${newClasses.join(", ")}`);
    } else {
      console.log(
        "[Element Modifier] border_per38 class not found, no changes made"
      );
    }
  } else {
    console.log("[Element Modifier] #id_here2 element not found");
  }

  // 3. Modifikasi elemen plagiarized_final
  const plagiarizedElement = document.querySelector(".plagiarized_final");
  if (plagiarizedElement) {
    console.log("[Element Modifier] Found .plagiarized_final element");
    console.log(
      `[Element Modifier] Original content: ${plagiarizedElement.textContent}`
    );

    plagiarizedElement.textContent = "0%";
    plagiarizedElement.innerHTML = "0%";

    console.log("[Element Modifier] Changed content to 0%");
  } else {
    console.log("[Element Modifier] .plagiarized_final element not found");
  }

  console.log("[Element Modifier] Modification process completed!");
}

// Make the function available to the window object
window.modifyElements = modifyElements;

// Global state
const slides = [];
let editingIndex = -1;

// DOM elements
const contentPreview = document.getElementById("content-preview");
/* Input */
const titleInput = document.getElementById("Title");
const subtitleInput = document.getElementById("Subtitle");
const mainLink = document.getElementById("Main-link");
const imgLink = document.getElementById("img-link");
const radiusInput = document.getElementById("Radius");
const gridInput = document.getElementById("Grid");
const altInput = document.getElementById("alt");
const imageUrlInput = document.getElementById("ImageURL");
const SizeInput = document.getElementById("Size");
const GapInput = document.getElementById("Gap");
/* Button */
const addSlideBtn = document.getElementById("addSlideBtn");
const copyBtn = document.getElementById("copyBtn");
const importBtn = document.getElementById("importBtn");
/* container */
const codeOutput = document.getElementById("codeOutput");
const slidesList = document.getElementById("slidesList");
const subtitleContainer = document.getElementById("subtitleContainer");
const mainLinkContainer = document.getElementById("mainLinkContainer");
const gridContainer = document.getElementById("gridContainer");
const desktopRadios = document.querySelectorAll(
  'input[name="desktopTemplate"]'
);
const mobileRadios = document.querySelectorAll('input[name="mobileTemplate"]');
let currentUUID = crypto.randomUUID().slice(0, 8);

// Template selection
const carouselTemplateRadios = document.querySelectorAll(
  'input[name="carouselTemplate"]'
);

// Initialize
function init() {
  // Setup event listeners
  addSlideBtn.addEventListener("click", addSlide);
  copyBtn.addEventListener("click", copyCode);
  importBtn.addEventListener("click", importSlidesOnly);

  // Setup template change listeners
  carouselTemplateRadios.forEach((radio) => {
    radio.addEventListener("change", updateTemplateVisibility);
  });

  desktopRadios.forEach((radio) => {
    radio.addEventListener("change", updateAll);
  });
  mobileRadios.forEach((radio) => {
    radio.addEventListener("change", updateAll);
  });

  // Input change listeners for live preview
  titleInput.addEventListener("input", updateAll);
  subtitleInput.addEventListener("input", updateAll);
  gridInput.addEventListener("change", updateAll);
  altInput.addEventListener("input", updateAll);
  imageUrlInput.addEventListener("input", updateAll);
  radiusInput.addEventListener("change", updateAll);
  SizeInput.addEventListener("input", updateAll);
  GapInput.addEventListener("input", updateAll);
  imgLink.addEventListener("input", updateAll);
  mainLink.addEventListener("input", updateAll);

  document
    .getElementById("textColorPicker")
    .addEventListener("input", updateAll);
  document.getElementById("bgColorPicker").addEventListener("input", updateAll);

  // Initial setup
  updateTemplateVisibility();
  updatePreview();
  updateSlidesList();
}

function updateAll() {
  const textColorPicker = document.getElementById("textColorPicker");
  const bgColorPicker = document.getElementById("bgColorPicker");

  // Normalize picker values to hex
  textColorPicker.value = convertColorToHex(textColorPicker.value);
  bgColorPicker.value = convertColorToHex(bgColorPicker.value);

  updateTemplateVisibility();
  updatePreview();
  updateCodeOutput();
}

function convertColorToHex(color) {
  const ctx = document.createElement("canvas").getContext("2d");
  ctx.fillStyle = color;
  return ctx.fillStyle; // canvas จะ normalize ให้เป็น hex เสมอ
}

// Add a new slide
function addSlide() {
  const alt = altInput.value.trim();
  const imageUrl = imageUrlInput.value.trim();
  const link = imgLink.value.trim();

  if (!imageUrl) {
    alert("Please enter an image URL");
    return;
  }

  const slide = {
    alt: alt,
    imageUrl,
    link,
  };

  if (editingIndex >= 0) {
    // Update existing slide
    slides[editingIndex] = slide;
    editingIndex = -1;
    addSlideBtn.textContent = "➕ Add Slide";
  } else {
    // Add new slide
    slides.push(slide);
  }

  // Clear inputs
  clearInputs();

  // Update UI
  updatePreview();
  updateSlidesList();
  updateCodeOutput();
}

// Clear input fields
function clearInputs() {
  altInput.value = "";
  imageUrlInput.value = "";
  imgLink.value = "";
}

// Edit a slide
function editSlide(index) {
  const slide = slides[index];
  altInput.value = slide.alt;
  imageUrlInput.value = slide.imageUrl;
  imgLink.value = slide.link;
  editingIndex = index;

  // Change button to "Update"
  addSlideBtn.textContent = "🔄 Update Slide";
  addSlideBtn.scrollIntoView({ behavior: "smooth", block: "nearest" });
}

// Delete a slide
function deleteSlide(index) {
  if (confirm("Are you sure you want to delete this slide?")) {
    slides.splice(index, 1);
    updatePreview();
    updateSlidesList();
    updateCodeOutput();
  }
}

// Update template visibility based on selection
function updateTemplateVisibility() {
  const selectedTemplate = document.querySelector(
    'input[name="carouselTemplate"]:checked'
  ).value;

  const isSplitView =
    document.querySelector('input[name="desktopTemplate"]') &&
    document.querySelector('input[name="mobileTemplate"]');

  const desktopTemplate = document.querySelector(
    'input[name="desktopTemplate"]:checked'
  ).value;
  const mobileTemplate = document.querySelector(
    'input[name="mobileTemplate"]:checked'
  ).value;

  const toggleBtn = document.getElementById("viewToggleBtns");

  // Show/hide subtitle and grid fields
  subtitleContainer.classList.toggle(
    "hidden",
    selectedTemplate !== "hero" &&
      desktopTemplate !== "hero" &&
      mobileTemplate !== "hero"
  );

  mainLinkContainer.classList.toggle(
    "hidden",
    selectedTemplate !== "hero" &&
      desktopTemplate !== "hero" &&
      mobileTemplate !== "hero"
  );

  gridContainer.classList.toggle(
    "hidden",
    selectedTemplate !== "grid" &&
      desktopTemplate !== "grid" &&
      mobileTemplate !== "grid"
  );

  // Show toggle buttons only if using split templatess
  if (isSplitView && selectedTemplate === "split") {
    toggleBtn.classList.remove("hidden");
    toggleBtn.classList.add("flex");
    showDesktopPreview(); // default
  } else {
    toggleBtn.classList.add("hidden");
    toggleBtn.classList.remove("flex");
    // show both previews stacked
    document
      .querySelectorAll(".desktop-preview, .mobile-preview")
      .forEach((el) => (el.style.display = "block"));
  }

  updatePreview();
  updateCodeOutput();
}

// Update preview
function updatePreview() {
  const selectedTemplate = document.querySelector(
    'input[name="carouselTemplate"]:checked'
  ).value;
  const title = titleInput.value.trim();
  const subtitle = subtitleInput.value.trim();
  const gridCols = gridInput.value;
  const textColor = document.getElementById("textColorPicker").value;
  const bgColor = document.getElementById("bgColorPicker").value;
  const uuid = currentUUID; // Generate a short UUID for the carousel ID
  const radius = radiusInput.value;
  const size = SizeInput.value;
  const gap = GapInput.value;
  const carouselLink = mainLink.value;

  const [desktopSize, mobileSize] = size.split(":");

  // Generate slides HTML
  let slidesHTML = "";
  slides.forEach((slide, index) => {
    slidesHTML += `
      <div class="relative flex-none w-full text-center overflow-hidden snap-start slide-container group">
        <a id="link-to" href="${slide.link}" target="_blank" class="absolute inset-0 z-10"></a>
        <img 
          src="${slide.imageUrl}" 
          alt="${slide.alt}" 
          class="object-cover w-full h-auto carousel-image ${radius}"
        />
          <p class="sm:text-xl text-[17px] mt-[10px] font-bebas-neue">${slide.alt}</p>
        <div class="absolute flex gap-1 slide-controls top-2 right-2 z-20">
          <button onclick="editSlide(${index})" class="p-2 text-white bg-blue-500 rounded-full hover:bg-blue-600">✏️</button>
          <button onclick="deleteSlide(${index})" class="p-2 text-white bg-red-500 rounded-full hover:bg-red-600">🗑️</button>
        </div>
      </div>
    `;
  });

  if (slides.length === 0) {
    slidesHTML = `
      <div class="flex items-center justify-center w-full h-64">
        <p class="text-gray-500">No slides added yet. Add some slides to see the preview.</p>
      </div>
    `;
  }

  // 📌 ถ้าเป็น split view
  if (selectedTemplate === "split") {
    const desktopTemplate = document.querySelector(
      'input[name="desktopTemplate"]:checked'
    ).value;
    const mobileTemplate = document.querySelector(
      'input[name="mobileTemplate"]:checked'
    ).value;

    let desktopHTML = "";
    let mobileHTML = "";

    if (desktopTemplate === "normal") {
      desktopHTML = `<div class="desktop-preview">${templates.normalDesktopTemplate(
        title,
        slidesHTML,
        textColor,
        bgColor,
        uuid,
        desktopSize,
        gap
      )}</div>`;
    } else if (desktopTemplate === "hero") {
      desktopHTML = `<div class="desktop-preview">${templates.heroDesktopTemplate(
        title,
        subtitle,
        slidesHTML,
        textColor,
        bgColor,
        uuid,
        desktopSize,
        gap,
        carouselLink
      )}</div>`;
    } else if (desktopTemplate === "grid") {
      desktopHTML = `<div class="desktop-preview">${templates.gridDesktopTemplate(
        title,
        gridCols,
        slidesHTML,
        textColor,
        bgColor,
        uuid
      )}</div>`;
    }

    if (mobileTemplate === "normal") {
      mobileHTML = `<div class="mobile-preview">${templates.normalMobileTemplate(
        title,
        slidesHTML,
        textColor,
        bgColor,
        uuid,
        mobileSize,
        gap
      )}</div>`;
    } else if (mobileTemplate === "hero") {
      mobileHTML = `<div class="mobile-preview">${templates.heroMobileTemplate(
        title,
        subtitle,
        slidesHTML,
        textColor,
        bgColor,
        uuid,
        mobileSize,
        gap,
        carouselLink
      )}</div>`;
    } else if (mobileTemplate === "grid") {
      mobileHTML = `<div class="mobile-preview">${templates.gridMobileTemplate(
        title,
        gridCols,
        slidesHTML,
        textColor,
        bgColor,
        uuid
      )}</div>`;
    }

    contentPreview.innerHTML = desktopHTML + mobileHTML;
  } else {
    // 🔁 แบบปกติ
    if (selectedTemplate === "normal") {
      contentPreview.innerHTML = templates.normal(
        title,
        slidesHTML,
        textColor,
        bgColor,
        uuid,
        desktopSize,
        mobileSize,
        gap
      );
    } else if (selectedTemplate === "hero") {
      contentPreview.innerHTML = templates.hero(
        title,
        subtitle,
        slidesHTML,
        textColor,
        bgColor,
        uuid,
        desktopSize,
        mobileSize,
        gap,
        carouselLink
      );
    } else if (selectedTemplate === "grid") {
      contentPreview.innerHTML = templates.grid(
        title,
        gridCols,
        slidesHTML,
        textColor,
        bgColor,
        uuid
      );
    }
  }
}

function showDesktopPreview() {
  document
    .querySelectorAll(".mobile-preview")
    .forEach((el) => (el.style.display = "none"));
  document
    .querySelectorAll(".desktop-preview")
    .forEach((el) => (el.style.display = "block"));
}

function showMobilePreview() {
  document
    .querySelectorAll(".desktop-preview")
    .forEach((el) => (el.style.display = "none"));
  document
    .querySelectorAll(".mobile-preview")
    .forEach((el) => (el.style.display = "block"));
}

// Update slides list in config panel
function updateSlidesList() {
  slidesList.innerHTML = "";

  if (slides.length === 0) {
    slidesList.innerHTML =
      '<p class="text-sm italic text-gray-500">No slides added</p>';
    return;
  }

  slides.forEach((slide, index) => {
    const slideItem = document.createElement("div");
    slideItem.className =
      "flex items-center justify-between p-2 border-b border-gray-200";
    slideItem.innerHTML = `
            <div class="flex items-center gap-2">
              <img src="${
                slide.imageUrl
              }" alt="Thumbnail" class="object-cover w-8 h-8 rounded">
              <span class="text-sm truncate max-w-[140px]">${
                slide.alt || "Slide " + (index + 1)
              }</span>
            </div>
            <div class="flex gap-1">
              <button onclick="editSlide(${index})" class="p-1 text-blue-500 hover:text-blue-700">
                ✏️
              </button>
              <button onclick="deleteSlide(${index})" class="p-1 text-red-500 hover:text-red-700">
                🗑️
              </button>
            </div>
          `;
    slidesList.appendChild(slideItem);
  });
}

// Generate code output
function updateCodeOutput() {
  const selectedTemplate = document.querySelector(
    'input[name="carouselTemplate"]:checked'
  ).value;
  const title = titleInput.value.trim();
  const subtitle = subtitleInput.value.trim();
  const gridCols = gridInput.value;
  const textColor = document.getElementById("textColorPicker").value;
  const bgColor = document.getElementById("bgColorPicker").value;
  const uuid = currentUUID; // Generate a short UUID for the carousel ID
  const radius = radiusInput.value;
  const size = SizeInput.value;
  const gap = GapInput.value;
  const carouselLink = mainLink.value;

  const [desktopSize, mobileSize] = size.split(":");

  // Generate slides HTML for code output
  let slidesHTML = "";
  slides.forEach((slide) => {
    slidesHTML += `
      <div class="relative flex-none w-full text-center overflow-hidden">
        <a id="link-to" href="${slide.link}" target="_blank" class="absolute inset-0 z-10"></a>
        <img 
          src="${slide.imageUrl}" 
          alt="${slide.alt}" 
          class="object-cover w-full h-auto ${radius}"
        />
        <p class="sm:text-xl text-[17px] mt-[10px] font-bebas-neue">${slide.alt}</p>
      </div>
    `;
  });

  let output = "";

  if (selectedTemplate === "split") {
    const desktopTemplate = document.querySelector(
      'input[name="desktopTemplate"]:checked'
    ).value;
    const mobileTemplate = document.querySelector(
      'input[name="mobileTemplate"]:checked'
    ).value;

    let desktopOutput = "";
    let mobileOutput = "";

    if (desktopTemplate === "normal") {
      desktopOutput = templates.normalDesktopTemplate(
        title,
        slidesHTML,
        textColor,
        bgColor,
        uuid,
        desktopSize,
        gap
      );
    } else if (desktopTemplate === "hero") {
      desktopOutput = templates.heroDesktopTemplate(
        title,
        subtitle,
        slidesHTML,
        textColor,
        bgColor,
        uuid,
        desktopSize,
        gap,
        carouselLink
      );
    } else if (desktopTemplate === "grid") {
      desktopOutput = templates.gridDesktopTemplate(
        title,
        gridCols,
        slidesHTML,
        textColor,
        bgColor,
        uuid
      );
    }

    if (mobileTemplate === "normal") {
      mobileOutput = templates.normalMobileTemplate(
        title,
        slidesHTML,
        textColor,
        bgColor,
        uuid,
        mobileSize,
        gap
      );
    } else if (mobileTemplate === "hero") {
      mobileOutput = templates.heroMobileTemplate(
        title,
        subtitle,
        slidesHTML,
        textColor,
        bgColor,
        uuid,
        mobileSize,
        gap,
        carouselLink
      );
    } else if (mobileTemplate === "grid") {
      mobileOutput = templates.gridMobileTemplate(
        title,
        gridCols,
        slidesHTML,
        textColor,
        bgColor,
        uuid
      );
    }

    output = desktopOutput + "\n\n" + mobileOutput;
  } else {
    // ใช้ template ปกติ
    if (selectedTemplate === "normal") {
      output = templates.normal(
        title,
        slidesHTML,
        textColor,
        bgColor,
        uuid,
        desktopSize,
        mobileSize,
        gap
      );
    } else if (selectedTemplate === "hero") {
      output = templates.hero(
        title,
        subtitle,
        slidesHTML,
        textColor,
        bgColor,
        uuid,
        desktopSize,
        mobileSize,
        gap,
        carouselLink
      );
    } else if (selectedTemplate === "grid") {
      output = templates.grid(
        title,
        gridCols,
        slidesHTML,
        textColor,
        bgColor,
        uuid
      );
    }
  }

  // Format the output for readability
  codeOutput.value = output.replace(/\n\s+/g, "\n").trim();
}

// Copy code to clipboard
function copyCode() {
  const slideInput = document.getElementById("Slide");
  const completeCode = `
<script src="https://cdn.tailwindcss.com"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
      .hide-scrollbar::-webkit-scrollbar {
        display: none;
      }
      .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
      }
    </style>
${codeOutput.value}
<script>
function carouselPrev(carouselId) {
const el = document.getElementById(carouselId);
const slideWidth = el.querySelector("div")?.offsetWidth || 200;
el.scrollBy({ left: -slideWidth * ${slideInput.value}, behavior: "smooth" });
}

function carouselNext(carouselId) {
const el = document.getElementById(carouselId);
const slideWidth = el.querySelector("div")?.offsetWidth || 200;
el.scrollBy({ left: slideWidth * ${slideInput.value}, behavior: "smooth" });
}
(function enableCarouselDrag() {
    const carousel = document.getElementById("carousel-${currentUUID}");
    let isDragging = false;
    let startX;
    let scrollLeft;
    
    carousel.addEventListener("mousedown", (e) => {
      isDragging = true;
      e.preventDefault();
      carousel.classList.add("cursor-grabbing");
      startX = e.pageX - carousel.offsetLeft;
      scrollLeft = carousel.scrollLeft;
    });

    carousel.addEventListener("mouseleave", () => {
      isDragging = false;
      carousel.classList.remove("cursor-grabbing");
    });

    carousel.addEventListener("mouseup", () => {
      isDragging = false;
      carousel.classList.remove("cursor-grabbing");
    });

    carousel.addEventListener("mousemove", (e) => {
      if (!isDragging) return;
      e.preventDefault();
      const x = e.pageX - carousel.offsetLeft;
      const walk = (x - startX) * 0.7; // multiplier for faster scroll
      carousel.scrollLeft = scrollLeft - walk;
    });
  })();
</script>
  `.trim();

  navigator.clipboard
    .writeText(completeCode)
    .then(() => {
      // Show confirmation
      const originalText = copyBtn.textContent;
      copyBtn.textContent = "✓ Copied!";
      setTimeout(() => {
        copyBtn.textContent = originalText;
      }, 2000);
    })
    .catch((err) => {
      alert("Failed to copy code: " + err);
    });
}

// Import code back into the editor
function importSlidesOnly() {
  const importArea = document.getElementById("importCode");
  const htmlString = importArea.value.trim();
  if (!htmlString) return;

  const tempDiv = document.createElement("div");
  tempDiv.innerHTML = htmlString;

  const containers = tempDiv.querySelectorAll("div[id^='carousel-container-']");

  // ✅ เก็บ container ที่ไม่ใช่ mobile สำหรับใช้ดึงรูป
  const validContainers = Array.from(containers).filter(
    (container) => !container.id.includes("-mobile")
  );

  let validImages = [];
  let validLinks = [];

  validContainers.forEach((container) => {
    const images = container.querySelectorAll("img");
    const image_link_to = container.querySelectorAll("a#link-to");
    const heroLink = container.querySelector("a#hero-link");
    const titleEl = container.querySelector("h1#Title");
    const subtitleEl = container.querySelector("p#Subtitle");

    // ป้องกัน error หาก element ไม่เจอ
    if (heroLink) {
      mainLink.value = heroLink.getAttribute("href") || "";
    }
    if (titleEl) {
      titleInput.value = titleEl.textContent.trim();
    }
    if (subtitleEl) {
      subtitleInput.value = subtitleEl.textContent.trim();
    }

    images.forEach((img) => {
      if (!img.closest("button")) {
        validImages.push(img);
      }
    });
    image_link_to.forEach((link) => {
      validLinks.push(link);
    });
  });

  if (validImages.length === 0) {
    alert("ไม่พบรูปภาพที่สามารถนำเข้าได้ (ยกเว้นในปุ่ม และใน mobile template)");
    return;
  }

  validImages.forEach((img, index) => {
    const imageUrl = img.getAttribute("src")?.trim();
    const alt = img.getAttribute("alt")?.trim() || "";
    const link = validLinks[index]?.getAttribute("href")?.trim() || "";

    if (imageUrl) {
      slides.push({ alt, imageUrl, link });
    }
  });

  // แยกและ set ค่า Setting
  const sizes = extractGridSettings(htmlString);
  if (sizes) {
    document.getElementById(
      "Size"
    ).value = `${sizes.desktopSize}:${sizes.mobileSize}`;
    document.getElementById("Gap").value = sizes.gap || "4";
  }

  const colors = extractColorsFromImport(htmlString);
  if (colors) {
    document.getElementById("textColorPicker").value =
      colors.textColor || "#000000";
    document.getElementById("bgColorPicker").value =
      colors.bgColor || "#ffffff";
  }

  // ✅ ใส่ container ที่ไม่ใช่ mobile ลงใน codeOutput
  const nonMobileContainer = Array.from(containers).find(
    (c) => !c.id.includes("-mobile")
  );
  if (nonMobileContainer) {
    codeOutput.value = nonMobileContainer.outerHTML.trim();
  } else {
    codeOutput.value = htmlString;
  }

  // ✅ อัปเดต radio template ตามชื่อ
  if (containers.length === 1) {
    const id = containers[0].id;
    const template = id.replace("carousel-container-", "");
    const radio = document.querySelector(
      `input[name="carouselTemplate"][value="${template}"]`
    );
    if (radio) radio.checked = true;
  } else {
    containers.forEach((container) => {
      const id = container.id;
      if (id.includes("-desktop")) {
        const desktopType = id
          .replace("carousel-container-", "")
          .replace("-desktop", "");
        const radio = document.querySelector(
          `input[name="desktopTemplate"][value="${desktopType}"]`
        );
        if (radio) radio.checked = true;
      } else if (id.includes("-mobile")) {
        const mobileType = id
          .replace("carousel-container-", "")
          .replace("-mobile", "");
        const radio = document.querySelector(
          `input[name="mobileTemplate"][value="${mobileType}"]`
        );
        if (radio) radio.checked = true;
      }
    });

    const splitRadio = document.querySelector(
      `input[name="carouselTemplate"][value="split"]`
    );
    if (splitRadio) splitRadio.checked = true;
  }

  // อัปเดต UI
  importArea.value = "";
  updateSlidesList();
  updateTemplateVisibility();
  updatePreview();
  updateCodeOutput();
}

// // ดึงค่า Setting ออกมาจาก import html
function extractGridSettings(htmlString) {
  const tempDiv = document.createElement("div");
  tempDiv.innerHTML = htmlString;

  const carouselDivs = tempDiv.querySelectorAll("div.hide-scrollbar");

  if (carouselDivs.length === 0) {
    alert("ไม่พบ carousel div ที่มี class 'hide-scrollbar'");
    return null;
  }

  let desktopSize = "25";
  let mobileSize = "45";
  let gap = "4";

  carouselDivs.forEach((carouselDiv) => {
    const classList = carouselDiv.className.split(/\s+/);

    classList.forEach((cls) => {
      if (cls.startsWith("md:auto-cols-[calc(")) {
        const match = cls.match(/md:auto-cols-\[calc\((\d+)%/);
        if (match) desktopSize = match[1];
      } else if (cls.startsWith("auto-cols-[calc(")) {
        const match = cls.match(/auto-cols-\[calc\((\d+)%/);
        if (match) mobileSize = match[1];
      } else if (cls.startsWith("md:gap-")) {
        gap = cls.replace("md:gap-", "");
      }
    });
  });
  console.log("Setting:", { desktopSize, mobileSize, gap });
  return { desktopSize, mobileSize, gap };
}

// ดึงค่าสีออกมาจาก import html
function extractColorsFromImport(htmlString) {
  const tempDiv = document.createElement("div");
  tempDiv.innerHTML = htmlString;

  // เลือก div ที่มี id ขึ้นต้นด้วย "carousel-container-"
  const containerDiv = tempDiv.querySelector("div[id^='carousel-container-']");

  if (!containerDiv) {
    alert("ไม่พบ container div ในโค้ดที่นำเข้า");
    return null;
  }

  const rawTextColor = containerDiv.style.color;
  const rawBgColor = containerDiv.style.backgroundColor;

  const textColor = convertColorToHex(rawTextColor);
  const bgColor = convertColorToHex(rawBgColor);

  console.log("Extracted colors:", { textColor, bgColor });

  return { textColor, bgColor };
}

// แปลงสีที่ได้จาก RGB ไปเป็น HEX
function convertColorToHex(color) {
  if (!color) return "#000000"; // fallback

  const ctx = document.createElement("canvas").getContext("2d");
  ctx.fillStyle = color; // browser จะ parse rgb/hsl ให้เป็น hex
  return ctx.fillStyle;
}

// Initialize the app
window.addEventListener("load", init);

// Make functions globally available for inline handlers
window.editSlide = editSlide;
window.deleteSlide = deleteSlide;


<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<style>
  .ql-container {
    height: 200px;
    width: 100%;
  }
</style>
<?php
session_start();
  // Load lang.json
  $lang = $_SESSION['lang'];
?>
<div class="container mx-auto max-w-[1440px] p-4 font-cpn">
  <h1 class="mb-4 text-3xl font-bold text-gray-800"><?= $lang['accordion']['name'] ?></h1>

  <!-- input field -->
  <div>
    <label for="accordion-title" class="block my-2"><?= $lang['accordion']['title']['label'] ?>:</label>
    <input
      type="text"
      id="accordion-title"
      class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
      placeholder="<?= $lang['accordion']['title']['placeholder'] ?>" />

    <label for="accordion-content" class="block my-2"><?= $lang['accordion']['desc']['label'] ?>:</label>
    
      <div id="editor">
      
      </div>

    <button
      onclick="createAccordion()"
      class="px-4 py-2 mt-2 text-white bg-blue-500">
      ➕ <?= $lang['accordion']['addButton'] ?>
    </button>
  </div>

  <!-- Preview Content -->
  <div class="my-8">
    <h2 class="mb-4 text-xl font-bold text-gray-800"><?= $lang['preview'] ?></h2>
    <div id="content-preview" class="w-full overflow-hidden bg-white"></div>
  </div>

  <!-- Export/Import Buttons -->
  <div class="flex items-start gap-4">
    <button
      id="copyBtn"
      class="p-2 mt-2 text-white bg-blue-600 rounded hover:bg-blue-700">
      📋 <?= $lang['copy'] ?>
    </button>
  </div>

  <!-- Import Section -->
  <div class="mt-8">
    <h2 class="mb-2 text-xl font-bold">📥 <?= $lang['accordion']['import']['label'] ?></h2>
    <textarea
      id="importCode"
      class="w-full h-48 p-4 mb-2 border border-gray-300 rounded"
      placeholder="<?= $lang['accordion']['import']['placeholder'] ?>"></textarea>
    <button
      onclick="importAccordion()"
      class="px-4 py-2 text-white bg-green-600 rounded">
      📥 <?= $lang['import'] ?>
    </button>
  </div>

  <!-- Export Code -->
  <div id="code-section" class="hidden mt-8 select-none">
    <h2 class="mb-4 text-xl font-bold text-gray-800">Generated Code</h2>
    <textarea
      id="codeOutput"
      readonly
      class="w-full h-64 p-4 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"></textarea>
  </div>


</div>
<script>
  const titleInput = document.getElementById("accordion-title");
  const preview = document.getElementById("content-preview");
  const codeOutput = document.getElementById("codeOutput");
  const codeSection = document.getElementById("code-section");
  let isEditing = false;
  let editingId = null;
  let dragSourceId = null;
  /**/
  let accordionData = []; // ✅ array เก็บข้อมูล accordion ทั้งหมด
  const copyBtn = document.getElementById("copyBtn");

  const fullToolbarOptions = [
  [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown

  ['bold', 'italic', 'underline', 'strike'],        // toggled buttons

  [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
  [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript

  [{ 'header': 1 }, { 'header': 2 }],               // custom button values
  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
  [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
  [{ 'direction': 'rtl' }],                         // text direction

  [{ 'align': [] }],

  ['link', 'image', 'video', 'formula'],            // media

  ['blockquote', 'code-block'],

  [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

  ['clean']                                         // remove formatting
];


  const quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
    //toolbar: fullToolbarOptions
  }
  });

  function init() {
    copyBtn.addEventListener("click", copyCode);

    // Initialize preview
    preview.innerHTML = "";
  }

  function escapeHtml(text) {
    return text
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }

  function createAccordion() {
    const editor = quill.root.innerHTML;
    console.log(editor);
    const title = titleInput.value.trim();
    // const content = addStyleToContent(editor);
    if (!title || !editor) return;

    accordionData.push({
      id: editingId || `accordion-${crypto.randomUUID()}`,
      title,
      content: editor,
    });

    console.log(accordionData);

    // Reset state  
    titleInput.value = "";
    isEditing = false;
    editingId = null;

    renderAccordions();
  }

  function addStyleToContent(content) {
    const temp = document.createElement("div");
    temp.innerHTML = content;
    let newHtml = '';
    temp.querySelectorAll("a").forEach((a) => {
      a.classList.add("text-blue-500", "underline");
    });

    return temp.innerHTML;
  }

  function editAccordion(id) {
    if (isEditing) {
      alert(
        "You are already editing an accordion. Please finish or cancel that first."
      );
      return;
    }

    const target = accordionData.find((acc) => acc.id === id);
    if (!target) return;

    titleInput.value = target.title;
    // Restore content to Quill editor
    let temp = document.createElement("div");
    temp.innerHTML = target.content;
    quill.clipboard.dangerouslyPasteHTML(target.content);

    editingId = id;
    isEditing = true;
    accordionData = accordionData.filter((acc) => acc.id !== id);

    renderAccordions();
  }

  function deleteAccordion(id) {
    accordionData = accordionData.filter((acc) => acc.id !== id);
    renderAccordions();
  }

  function renderAccordions() {
    preview.innerHTML = "";

    accordionData.forEach(({
      id,
      title,
      content
    }) => {
      const html = `
      <div class="w-full mb-2 overflow-hidden border-b" data-id="${id}" draggable="true" ondragstart="handleDragStart(event)" ondragover="handleDragOver(event)" ondrop="handleDrop(event)">
        <input type="checkbox" id="${id}" class="hidden peer" />
        <label
          for="${id}"
          class="flex items-center justify-between w-full px-4 py-3 transition-colors duration-200 cursor-pointer"
        >
          <h2 class="text-lg font-medium">${escapeHtml(title)}</h2>
          <div class="flex items-center gap-2">
            <button onclick="editAccordion('${id}')" class="text-sm text-blue-600 hover:underline">✏️</button>
            <button onclick="deleteAccordion('${id}')" class="text-sm text-red-600 hover:underline">🗑️</button>
            <div class="relative w-6 h-6">
              <svg
                class="absolute inset-0 w-full h-full transition-transform duration-300 transform peer-checked:rotate-180"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7"
                />
              </svg>
            </div>
          </div>
        </label>
        <div
          class="overflow-hidden transition-all duration-300 bg-white max-h-0 peer-checked:max-h-96"
        >
          <div id="content" class="p-4">
            ${content}
          </div>
        </div>
      </div>`;
      preview.insertAdjacentHTML("beforeend", html);
    });

    updateCodeOutput();
  }

  function updateCodeOutput() {
    const exportHTML = accordionData
      .map(({
        id,
        title,
        content
      }) => {
        return `
<div class="accordion" data-id="${id}">
    <input type="checkbox" id="${id}" class="accordion-toggle" />
    <label for="${id}" class="accordion-header">
        <h2>${escapeHtml(title)}</h2>
        <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </label>
    <div class="accordion-content">
        <div class="accordion-inner">
            ${content}
        </div>
    </div>
</div>`;
      })
      .join("");

    codeOutput.value = exportHTML.trim();
  }

  function copyCode() {
    codeOutput.select();
    const completeCode = `
<style>
    .accordion {
        width: 100%;
        margin-bottom: 0.5rem;
        border-bottom: 1px solid #ddd;
        overflow: hidden;
    }

    .accordion-toggle {
        display: none;
    }

    .accordion-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .accordion-header h2 {
        font-size: 1.125rem;
        /* text-lg */
        font-weight: 500;
        margin: 0;
    }

    .accordion-header .icon {
        position: relative;
        width: 1.5rem;
        height: 1.5rem;
    }

    .accordion-header svg {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        transition: transform 0.3s ease;
    }

    .accordion-toggle:checked+.accordion-header svg {
        transform: rotate(180deg);
    }

    /* Content animation */
    .accordion-content {
        max-height: 0;
        overflow: hidden;
        background: #fff;
        transition: max-height 0.3s ease;
    }

    .accordion-toggle:checked~.accordion-content {
        max-height: 24rem;
        /* similar to max-h-96 */
    }

    .accordion-inner {
        padding: 1rem;
    }

    .accordion-inner a {
        text-decoration: underline; 
        color: #3B82F6; 
    }
</style>
${codeOutput.value}
`.trim();
    navigator.clipboard
      .writeText(completeCode)
      .then(() => {
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

  function importAccordion() {
    const importArea = document.getElementById("importCode");
    const htmlString = importArea.value.trim();
    if (!htmlString) return;

    const tempDiv = document.createElement("div");
    tempDiv.innerHTML = htmlString;

    const existingIds = new Set(accordionData.map((acc) => acc.id));

    tempDiv.querySelectorAll(".accordion").forEach((acc) => {
      let id = acc.getAttribute("data-id");
      const title = acc.querySelector("h2")?.innerText || "Untitled";
      const content = acc.querySelector(".accordion-inner")?.innerHTML || "";

      if (existingIds.has(id)) {
        // generate new id
        id = `accordion-${crypto.randomUUID()}`;
      }

      accordionData.push({
        id,
        title,
        content
      });
    });

    importArea.value = "";
    renderAccordions();
  }

  function handleDragStart(e) {
    dragSourceId = e.currentTarget.getAttribute("data-id");
  }

  function handleDragOver(e) {
    e.preventDefault(); // จำเป็นเพื่อให้ drop ทำงาน
  }

  function handleDrop(e) {
    e.preventDefault();
    const targetId = e.currentTarget.getAttribute("data-id");

    if (!dragSourceId || dragSourceId === targetId) return;

    // หาตำแหน่งของ source และ target
    const fromIndex = accordionData.findIndex(
      (acc) => acc.id === dragSourceId
    );
    const toIndex = accordionData.findIndex((acc) => acc.id === targetId);

    if (fromIndex < 0 || toIndex < 0) return;

    const movedItem = accordionData.splice(fromIndex, 1)[0];
    accordionData.splice(toIndex, 0, movedItem);

    renderAccordions();
  }

  // Initialize on page load
  window.addEventListener("load", init);
</script>
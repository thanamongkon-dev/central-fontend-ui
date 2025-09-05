<style>
  .hide-scrollbar::-webkit-scrollbar {
    display: none;
  }

  .hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
  }

  textarea {
    font-family: monospace;
    white-space: pre;
  }

  .carousel-image {
    transition: transform 0.3s ease;
  }

  .carousel-image:hover {
    transform: scale(1.03);
  }

  .slide-controls {
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .slide-container:hover .slide-controls {
    opacity: 1;
  }

  .carousel-btn {
    transition: all 0.2s ease;
  }

  .carousel-btn:hover {
    transform: scale(1.1);
    background-color: rgba(255, 255, 255, 0.9) !important;
  }

  .carousel-btn:active {
    transform: scale(0.95);
  }
</style>
<?php
  session_start();
  // Load lang.json
  $lang = $_SESSION['lang'];
?>

<div class="relative overflow-x-hidden rounded hide-scrollbar">
  <!-- Config Panel -->
  <!-- ⚙️ Drawer Toggle Button -->
  <button
    onclick="openDrawer()"
    class="fixed z-40 p-2 text-white bg-blue-600 rounded shadow-md top-20 right-4 hover:bg-blue-700">
    ⚙️
  </button>

  <!-- 🔲 Backdrop (click to close) -->
  <div
    id="drawerBackdrop"
    class="fixed inset-0 z-40 hidden"
    onclick="closeDrawer()"></div>

  <!-- 👉 Drawer Panel -->
  <div
    id="configDrawer"
    class="fixed top-0 bottom-0 right-0 hide-scrollbar min-w-[280px] overflow-y-scroll bg-white shadow-lg z-50 transform translate-x-full transition-transform duration-300 ease-in-out border-l border-gray-200">
    <div class="p-4 space-y-6">
      <h2 class="text-lg font-bold text-gray-800">⚙️ Configuration</h2>

      <!-- Carousel Template Selection -->
      <div>
        <p class="mb-2 font-medium text-gray-700"><?= $lang['carousel']['config']['template']['label'] ?></p>
        <div class="grid grid-cols-2 space-y-2">
          <label class="flex items-center space-x-2">
            <input
              type="radio"
              name="carouselTemplate"
              value="normal"
              checked />
            <span>🖼 <?= $lang['carousel']['config']['template']['options']['normal'] ?></span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="radio" name="carouselTemplate" value="hero" />
            <span>🦸 <?= $lang['carousel']['config']['template']['options']['hero'] ?></span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="radio" name="carouselTemplate" value="grid" />
            <span>🔲 <?= $lang['carousel']['config']['template']['options']['grid'] ?></span>
          </label>

          <label class="flex items-center space-x-2">
            <input type="radio" name="carouselTemplate" value="split" />
            <span>🖥📱 <?= $lang['carousel']['config']['template']['options']['custom'] ?></span>
          </label>
        </div>
      </div>

      <!-- Update the template selection UI in the config drawer -->
      <div class="space-y-2">
        <p class="mb-2 font-medium text-gray-700"><?= $lang['carousel']['config']['template']['label2'] ?></p>
        <div class="flex gap-4">
          <div class="flex-1">
            <p class="mb-1 text-sm font-medium">Desktop</p>
            <div class="space-y-2">
              <label class="flex items-center space-x-2">
                <input
                  type="radio"
                  name="desktopTemplate"
                  value="normal"
                  checked />
                <span>🖼 <?= $lang['carousel']['config']['template']['options']['normal'] ?></span>
              </label>
              <label class="flex items-center space-x-2">
                <input type="radio" name="desktopTemplate" value="hero" />
                <span>🦸 <?= $lang['carousel']['config']['template']['options']['hero'] ?></span>
              </label>
              <label class="flex items-center space-x-2">
                <input type="radio" name="desktopTemplate" value="grid" />
                <span>🔲 <?= $lang['carousel']['config']['template']['options']['grid'] ?></span>
              </label>
            </div>
          </div>
          <div class="flex-1">
            <p class="mb-1 text-sm font-medium">Mobile</p>
            <div class="space-y-2">
              <label class="flex items-center space-x-2">
                <input
                  type="radio"
                  name="mobileTemplate"
                  value="normal"
                  checked />
                <span>🖼 <?= $lang['carousel']['config']['template']['options']['normal'] ?></span>
              </label>
              <label class="flex items-center space-x-2">
                <input type="radio" name="mobileTemplate" value="hero" />
                <span>🦸 <?= $lang['carousel']['config']['template']['options']['hero'] ?></span>
              </label>
              <label class="flex items-center space-x-2">
                <input type="radio" name="mobileTemplate" value="grid" />
                <span>🔲 <?= $lang['carousel']['config']['template']['options']['grid'] ?></span>
              </label>
            </div>
          </div>
        </div>
      </div>
      <!-- Slide by number -->
      <div>
        <label
          for="Slide"
          class="block mb-1 text-sm font-medium text-gray-700"><?= $lang['carousel']['config']['slideby'] ?></label>
        <select
          id="Slide"
          class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4" selected>4</option>
          <option value="5">5</option>
        </select>
      </div>

      <!-- border Radius -->
      <div>
        <label
          for="Radius"
          class="block mb-1 text-sm font-medium text-gray-700"> <?= $lang['carousel']['config']['shape']['label'] ?> </label>
        <select
          id="Radius"
          class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
          <option value="rounded-none" selected>⬜ <?= $lang['carousel']['config']['shape']['options']['square'] ?> </option>
          <option value="rounded">⬛ <?= $lang['carousel']['config']['shape']['options']['rounded'] ?></option>
          <option value="rounded-full">⚪ <?= $lang['carousel']['config']['shape']['options']['circle'] ?></option>
        </select>
      </div>

      <!-- Items Size -->
      <div>
        <label for="Size" class="block mb-1 text-sm font-medium text-gray-700"> <?= $lang['carousel']['config']['size'] ?> </label>
        <select
          id="Size"
          class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
          <option value="20:33" selected>5:3</option>
          <option value="25:45">4:2.8</option>
          <option value="33:90">3:1.8</option>
        </select>
      </div>

      <!-- Items Gap -->
      <div>
        <label for="Gap" class="block mb-1 text-sm font-medium text-gray-700"><?= $lang['carousel']['config']['gap'] ?> </label>
        <select
          id="Gap"
          class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
          <option value="2" selected>8px</option>
          <option value="3">12px</option>
          <option value="4">16px</option>
          <option value="5">20px</option>
          <option value="6">24px</option>
        </select>
      </div>

      <!-- 🎨 Color Picker Section -->
      <div>
        <p class="mb-2 font-medium text-gray-700">🎨 <?= $lang['carousel']['config']['color']['label'] ?> </p>
        <div class="flex flex-col space-y-3">
          <label class="flex items-center justify-between">
            <span class="text-sm text-gray-600"><?= $lang['carousel']['config']['color']['text'] ?></span>
            <input
              type="color"
              id="textColorPicker"
              value="#1f2937"
              class="w-10 h-6 p-0 border border-gray-300 rounded cursor-pointer" />
          </label>
          <label class="flex items-center justify-between">
            <span class="text-sm text-gray-600"><?= $lang['carousel']['config']['color']['bg'] ?></span>
            <input
              type="color"
              id="bgColorPicker"
              value="#ffffff"
              class="w-10 h-6 p-0 border border-gray-300 rounded cursor-pointer" />
          </label>
        </div>
      </div>

      <!-- Export/Import Buttons -->
      <div>
        <p class="mb-2 font-medium text-gray-700">Export/Import</p>
        <button
          id="copyBtn"
          class="w-full p-2 mt-2 text-white bg-blue-600 rounded hover:bg-blue-700">
          📋 <?= $lang['copy'] ?>
        </button>
        <button
          id="importABC"
          class="w-full p-2 mt-2 text-white bg-green-600 rounded hover:bg-green-700">
          📂 <?= $lang['import'] ?>
        </button>
      </div>

      <!-- Preview Toggle Buttons -->
      <div id="viewToggleBtns" class="hidden mb-4 space-x-2">
        <button
          onclick="showDesktopPreview()"
          class="px-4 py-2 text-white bg-blue-600 rounded">
          Desktop View
        </button>
        <button
          onclick="showMobilePreview()"
          class="px-4 py-2 text-white bg-blue-600 rounded">
          Mobile View
        </button>
      </div>

      <!-- Slides List -->
      <div class="pt-4 border-t border-gray-200">
        <p class="mb-2 font-medium text-gray-700">Slides</p>
        <div id="slidesList" class="overflow-y-auto max-h-64">
          <!-- Slide items will appear here -->
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container flex px-4 mx-auto">
    <div class="w-full">
      <h1 class="mb-4 text-3xl font-bold text-gray-800">
        <?= $lang['carousel']['name'] ?>
      </h1>

      <!-- Input Field -->
      <div
        class="grid w-full grid-cols-1 gap-4 p-6 bg-white rounded-lg shadow-md">
        <div class="flex flex-col w-full gap-3">
          <label class="text-xl font-bold"><?= $lang['carousel']['info1'] ?></label>
          <div>
            <label
              for="Title"
              class="block mb-1 text-sm font-medium text-gray-700"><?= $lang['carousel']['title']['label'] ?></label>
            <input
              type="text"
              name="Title"
              id="Title"
              class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
              placeholder="<?= $lang['carousel']['title']['placeholder'] ?>" />
          </div>

          <div id="subtitleContainer" class="hidden">
            <label
              for="Subtitle"
              class="block mb-1 text-sm font-medium text-gray-700"><?= $lang['carousel']['subtitle']['label'] ?></label>
            <input
              type="text"
              name="Subtitle"
              id="Subtitle"
              class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
              placeholder="<?= $lang['carousel']['subtitle']['placeholder'] ?>" />
          </div>

          <div id="mainLinkContainer" class="hidden">
            <label
              for="Main-link"
              class="block mb-1 text-sm font-medium text-gray-700"><?= $lang['carousel']['link']['label'] ?></label>
            <input
              type="text"
              name="Main-link"
              id="Main-link"
              class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
              placeholder="<?= $lang['carousel']['link']['placeholder'] ?>" />
          </div>

          <div id="gridContainer" class="hidden">
            <label
              for="Grid"
              class="block mb-1 text-sm font-medium text-gray-700">Grid Columns</label>
            <select
              id="Grid"
              class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
              <option value="2">2 Columns</option>
              <option value="3" selected>3 Columns</option>
              <option value="4">4 Columns</option>
              <option value="5">5 Columns</option>
            </select>
          </div>
        </div>

        <div class="flex flex-col w-full gap-3">
          <label class="text-xl font-bold"><?= $lang['carousel']['info2'] ?></label>
          <div>
            <label
              for="alt"
              class="block mb-1 text-sm font-medium text-gray-700"><?= $lang['carousel']['desc']['label'] ?></label>
            <input
              type="text"
              name="alt"
              id="alt"
              class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
              placeholder="<?= $lang['carousel']['desc']['placeholder'] ?>" />
          </div>

          <div>
            <label
              for="img-link"
              class="block mb-1 text-sm font-medium text-gray-700"><?= $lang['carousel']['link']['label'] ?></label>
            <input
              type="text"
              name="img-link"
              id="img-link"
              class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
              placeholder="<?= $lang['carousel']['link']['placeholder'] ?>" />
          </div>

          <div>
            <label
              for="ImageURL"
              class="block mb-1 text-sm font-medium text-gray-700"><?= $lang['carousel']['img']['label'] ?></label>
            <input
              type="text"
              name="ImageURL"
              id="ImageURL"
              class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
              placeholder="<?= $lang['carousel']['img']['placeholder'] ?>" />
          </div>

          <div class="flex items-end">
            <button
              id="addSlideBtn"
              class="w-full p-2 font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
              ➕ <?= $lang['carousel']['addButton'] ?>
            </button>
          </div>
        </div>
      </div>

      <!-- Preview Content -->
      <div class="my-8">
        <h2 class="mb-4 text-xl font-bold text-gray-800"><?= $lang['preview'] ?></h2>
        <div
          id="content-preview"
          class="w-full overflow-hidden bg-white rounded-lg shadow-md"></div>
      </div>

      <textarea
        id="importCode"
        class="w-full h-48 p-4 mb-2 bg-white border border-gray-300 rounded"
        placeholder="Paste your HTML here..."></textarea>
      <button
        id="importBtn"
        class="px-4 py-2 text-white bg-green-600 rounded">
        📥 <?= $lang['import'] ?>
      </button>

      <!-- Export Code -->
      <div class="hidden mt-8 select-none">
        <h2 class="mb-4 text-xl font-bold text-gray-800">Generated Code</h2>
        <textarea
          id="codeOutput"
          readonly
          class="w-full h-64 p-4 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"></textarea>
      </div>
    </div>
  </div>
</div>
<script src="./js/template.js"></script>
<script src="./js/carousel-editor.js"></script>

<script>
  function openDrawer() {
    document
      .getElementById("configDrawer")
      .classList.remove("translate-x-full");
    document.getElementById("drawerBackdrop").classList.remove("hidden");
  }

  function closeDrawer() {
    document
      .getElementById("configDrawer")
      .classList.add("translate-x-full");
    document.getElementById("drawerBackdrop").classList.add("hidden");
  }
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeDrawer();
  });
</script>

<script>
  const slideInput = document.getElementById("Slide");

  function getSlideValue() {
    return parseInt(slideInput.value, 10) || 1;
  }

  function carouselNext(eleId) {
    const carousel = document.getElementById(eleId);
    const item = carousel.querySelector("div");
    if (!carousel || !item) return;

    const itemWidth = item.offsetWidth;
    const gap = parseInt(window.getComputedStyle(carousel).gap) || 8;
    const scrollAmount = (itemWidth + gap) * getSlideValue();

    carousel.scrollBy({
      left: scrollAmount,
      behavior: "smooth"
    });
  }

  function carouselPrev(eleId) {
    const carousel = document.getElementById(eleId);
    const item = carousel.querySelector("div");
    if (!carousel || !item) return;

    const itemWidth = item.offsetWidth;
    const gap = parseInt(window.getComputedStyle(carousel).gap) || 8;
    const scrollAmount = (itemWidth + gap) * getSlideValue();

    carousel.scrollBy({
      left: -scrollAmount,
      behavior: "smooth"
    });
  }
</script>
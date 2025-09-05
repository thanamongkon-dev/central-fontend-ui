<?php
session_start();
// Load lang.json
$lang = $_SESSION['lang'];
$pro = $lang['promotion'] ?? [];
?>
<style>
    .promo-wrapper {
        position: relative;
        display: flex;
        flex-direction: column;
        padding-left: 1rem;
        color: #1d1d1f;
        font-size: 0.75rem
            /* 12px */
        ;
        line-height: 1rem
            /* 16px */
        ;
    }

    .promo-title {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        font-size: 1.25rem
            /* 20px */
        ;
        font-weight: bold;
        text-align: left;
    }

    .promo-container {
        display: grid;
        grid-auto-flow: column;
        flex-direction: column-reverse;
        grid-auto-columns: calc(80% - 0.5rem
                /* 8px */
            );
        width: 100%;
        gap: 0.75rem;
        padding-right: 1rem;
        overflow-y: hidden;
        overflow-x: scroll;
        scroll-behavior: smooth;
        scroll-snap-type: x var(--tw-scroll-snap-strictness);
        --tw-scroll-snap-strictness: mandatory;
    }

    .promo-card {
        position: relative;
        width: 100%;
        text-align: start;
        scroll-snap-align: start;
        border-radius: 0.375rem;
        border: 1px solid #b1b1b1;
        background-color: #fff;
        font-size: 0.75rem;
    }

    .promo-img {
        width: 100%;
        height: auto;
        border-radius: 0.375rem;
    }

    .promo-content {
        display: flex;
        flex-direction: column;
        height: 100%;
        padding: 0.75rem 0.5rem 0.75rem 0.5rem;
    }

    .promo-heading {
        font-size: 1.125rem;
        font-weight: bold;
        margin: 0 0 0.5rem 0;
    }

    .carousel-prev {
        position: absolute;
        left: 0;
        z-index: 1;
        display: none;
        padding: 0.5rem;
        background-color: rgba(255, 255, 255, 0.75);
        transition: background-color 0.3s ease;
        top: 50%;
        transform: translateY(-50%);
        border: none;
    }

    .carousel-next {
        position: absolute;
        right: 0;
        z-index: 1;
        display: none;
        padding: 0.5rem;
        background-color: rgba(255, 255, 255, 0.75);
        transition: background-color 0.3s ease;
        top: 50%;
        transform: translateY(-50%);
        border: none;
    }

    .sub-list {
        padding-left: 1.5rem;
        list-style-type: disc;
        margin: 0;
        line-height: 1.4;
    }

    .promo-link {
        position: absolute;
        inset: 0;
        z-index: 1;
    }

    @media (min-width: 768px) {
        .promo-wrapper {
            padding-left: 0;
            font-size: 1rem
                /* 16px */
            ;
            line-height: 1.5rem
                /* 24px */
            ;
        }

        .promo-title {
            font-size: 1.875rem
                /* 30px */
            ;
            margin-top: 2rem;
            margin-bottom: 1.5rem;
        }

        .promo-container {
            grid-auto-columns: calc(40% - 0.5rem
                    /* 8px */
                );
            gap: 1.5rem;
        }

        .promo-content {
            padding: 0.75rem;
        }

        .promo-heading {
            font-size: 1.625rem
                /* 26px */
            ;
        }

        .promo-list {
            padding-left: 1.5rem;
            list-style-type: disc;
            margin: 0;
            line-height: 1.4;
        }

        .carousel-prev {
            display: block;
        }

        .carousel-next {
            display: block;
        }

    }

    .carousel-prev:hover {
        background-color: #d1d5db;
        /* Gray 300 */
    }

    .carousel-next:hover {
        background-color: #d1d5db;
        /* Gray 300 */
    }
</style>
<div class="container mx-auto max-w-[1440px] p-4">
    <h1 class="mb-4 text-2xl font-bold"><?= $pro['name'] ?></h1>

    <div class="flex flex-col space-y-4">
        <label>
            <span class="block mb-2 font-semibold"><?= $pro['title']['label'] ?></span>
            <input
                type="text"
                id="title"
                required
                placeholder="<?= $pro['title']['placeholder'] ?>"
                class="w-full p-2 border border-gray-300 rounded" />
        </label>
        <label>
            <span class="block mb-2 font-semibold"><?= $pro['image']['label'] ?></span>
            <input
                type="text"
                id="imgUrl"
                required
                placeholder="<?= $pro['image']['placeholder'] ?>"
                class="w-full p-2 border border-gray-300 rounded" />
        </label>
        <label>
            <span class="block mb-2 font-semibold"><?= $pro['link']['label'] ?></span>
            <input
                type="text"
                id="link"
                required
                placeholder="<?= $pro['link']['placeholder'] ?>"
                class="w-full p-2 border border-gray-300 rounded" />
        </label>
        <label>
            <span class="block mb-2 font-semibold"><?= $pro['startDate'] ?></span>
            <input
                type="date"
                id="start-date"
                required
                class="w-full p-2 border border-gray-300 rounded" />
        </label>
        <label>
            <span class="block mb-2 font-semibold"><?= $pro['endDate'] ?></span>
            <input
                type="date"
                id="end-date"
                required
                class="w-full p-2 border border-gray-300 rounded" />
        </label>
    </div>

    <div id="list-container" class="my-6 space-y-4"></div>

    <div class="flex items-start gap-4">
        <button
            onclick="addListItem()"
            class="px-4 py-2 mt-2 text-white bg-blue-600 rounded hover:bg-blue-700">
            ➕ <?= $pro['addList'] ?>
        </button>

        <button
            onclick="addPromotion()"
            class="px-4 py-2 mt-2 text-white bg-purple-600 rounded hover:bg-purple-700">
            ➕ <?= $pro['addButton'] ?>
        </button>

        <button
            id="copyBtn"
            onclick="copyCode()"
            class="p-2 mt-2 text-white bg-blue-600 rounded hover:bg-blue-700">
            📋 <?= $lang['copy'] ?>
        </button>

        <!-- CheckBox Ignore Start Date -->
        <div class="p-2 mt-2 text-white bg-yellow-400 rounded">
            <label class="flex items-center gap-2">
                <input type="checkbox" id="ignore-start-date" class="w-5 h-5" />
                <span class="text-base"><?= $pro['ignore'] ?></span>
            </label>
        </div>
    </div>

    <div class="mt-6">
        <h2 class="mb-2 text-lg font-semibold"><?= $lang['preview'] ?></h2>
        <div
            id="promotions-wrapper"
            class="promo-wrapper">
            <h2 class="promo-title">
                Promotions
            </h2>
            <div
                id="PROMOTIONS-container"
                class="promo-container"></div>

            <button class="carousel-prev prevBtn" onclick="carouselPrev('PROMOTIONS-container')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 1.5rem; height: 1.5rem;">
                    <path fill-rule="evenodd"
                        d="M7.72 12.53a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 1 1 1.06 1.06L9.31 12l6.97 6.97a.75.75 0 1 1-1.06 1.06l-7.5-7.5Z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>

            <button class="carousel-next nextBtn" onclick="carouselNext('PROMOTIONS-container')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 1.5rem; height: 1.5rem;">
                    <path fill-rule="evenodd"
                        d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>

        <textarea
            id="import-list"
            rows="2"
            placeholder="<?= $pro['importList']['placeholder'] ?>"
            class="w-full p-2 mt-4 border border-gray-300 rounded"></textarea>
        <button
            onclick="importHtmlLists()"
            class="px-4 py-2 mt-2 text-white bg-green-600 rounded hover:bg-green-700">
            📥 <?= $pro['importList']['label'] ?>
        </button>

        <textarea
            id="import-code"
            rows="2"
            placeholder="<?= $pro['import']['placeholder'] ?>"
            class="w-full p-2 mt-4 border border-gray-300 rounded"></textarea>
        <button
            onclick="importPromotionsFromHTML()"
            class="px-4 py-2 mt-2 text-white bg-green-600 rounded hover:bg-green-700">
            📥 <?= $pro['import']['label'] ?>
        </button>
    </div>


</div>
<script>
    let listId = 0;
    let cardsData = [];
    let editingIndex = null;
    const listContainer = document.getElementById("list-container");
    const previewContainer = document.getElementById("PROMOTIONS-container");
    const copyBtn = document.getElementById("copyBtn");
    const promotionsWrapper = document.getElementById("promotions-wrapper");
    const ignoreStartDateCheckbox =
        document.getElementById("ignore-start-date");

    function addListItem(listItem = {
        text: "",
        sub: []
    }) {
        const itemId = `list-${listId++}`;
        const wrapper = document.createElement("div");
        wrapper.className = "p-4 border rounded space-y-2 bg-gray-50";
        wrapper.innerHTML = `
      <input type="text" value="${
        listItem.text
      }" placeholder="Main list item" class="w-full p-2 border border-gray-300 rounded" />
      <label class="flex items-center gap-2">
        <input type="checkbox" onchange="toggleSublist('${itemId}')" ${
          listItem.sub.length > 0 ? "checked" : ""
        }/> Add sublist
      </label>
      <div id="${itemId}" class="${
          listItem.sub.length > 0 ? "" : "hidden"
        } pl-4 space-y-2 border-l-2 border-gray-300 sublist"></div>
      <button onclick="addSubListItem('${itemId}')" class="${
          listItem.sub.length > 0 ? "" : "hidden"
        } text-xs text-blue-600 hover:underline" id="${itemId}-btn">➕ Add Sublist Item</button>
    `;
        listContainer.appendChild(wrapper);

        const sublistContainer = wrapper.querySelector(`#${itemId}`);
        listItem.sub.forEach((sub) => {
            const input = document.createElement("input");
            input.type = "text";
            input.placeholder = "Sublist item";
            input.className = "w-full p-2 border border-gray-200 rounded";
            input.value = sub;
            sublistContainer.appendChild(input);
        });
    }

    function toggleSublist(id) {
        document.getElementById(id).classList.toggle("hidden");
        document.getElementById(`${id}-btn`).classList.toggle("hidden");
    }

    function addSubListItem(id) {
        const sublist = document.getElementById(id);
        const input = document.createElement("input");
        input.type = "text";
        input.placeholder = "Sublist item";
        input.className = "w-full p-2 border border-gray-200 rounded";
        sublist.appendChild(input);
    }

    function validatePromotionInput() {
        const title = document.getElementById("title").value.trim();
        const link = document.getElementById("link").value.trim();
        const imgUrl = document.getElementById("imgUrl").value.trim();
        const startDate = document.getElementById("start-date").value;
        const endDate = document.getElementById("end-date").value;

        const urlRegex = /^https?:\/\/[\w\-]+(\.[\w\-]+)+[/#?]?.*$/;

        if (!title) {
            alert("Promotion title is required.");
            return false;
        }

        if (!urlRegex.test(imgUrl)) {
            alert(
                "Please enter a valid image URL (must start with http or https)."
            );
            return false;
        }

        if (!urlRegex.test(link)) {
            alert(
                "Please enter a valid link URL (must start with http or https)."
            );
            return false;
        }

        if (!startDate || !endDate) {
            alert("Both start and end dates are required.");
            return false;
        }

        if (new Date(startDate) > new Date(endDate)) {
            alert("Start date must be earlier than or equal to end date.");
            return false;
        }

        return true;
    }

    function collectCurrentPromotion() {
        const title = document.getElementById("title").value;
        const link = document.getElementById("link").value;
        const imgUrl = document.getElementById("imgUrl").value;
        const startDate = document.getElementById("start-date").value;
        const endDate = document.getElementById("end-date").value;
        const ignoreStartDate =
            document.getElementById("ignore-start-date").checked;

        const lists = [];
        const allItems = listContainer.querySelectorAll(".p-4");
        allItems.forEach((wrapper) => {
            const mainText = wrapper.querySelector("input[type='text']").value;
            const item = {
                text: mainText,
                sub: []
            };

            const hasSublist = wrapper.querySelector(
                "input[type='checkbox']"
            ).checked;
            if (hasSublist) {
                const subInputs = wrapper.querySelectorAll(".sublist input");
                subInputs.forEach((sub) => {
                    item.sub.push(sub.value);
                });
            }
            lists.push(item);
        });
        return {
            title,
            link,
            imgUrl,
            startDate,
            endDate,
            lists,
            ignoreStartDate,
        };
    }

    function addPromotion() {
        if (!validatePromotionInput()) return;
        const data = collectCurrentPromotion();

        if (editingIndex !== null) {
            cardsData[editingIndex] = data;
            editingIndex = null;
        } else {
            cardsData.push(data);
        }
        clearInputs();
        renderAllPromotions();
    }

    function clearInputs() {
        document.getElementById("title").value = "";
        document.getElementById("link").value = "";
        document.getElementById("imgUrl").value = "";
        document.getElementById("start-date").value = "";
        document.getElementById("end-date").value = "";
        document.getElementById("ignore-start-date").checked = false;
        listContainer.innerHTML = "";
    }

    function renderAllPromotions(skipButtons = false) {
        // Sort promotions by startDate before rendering
        cardsData.sort((a, b) => new Date(a.startDate) - new Date(b.startDate));

        previewContainer.innerHTML = "";
        cardsData.forEach((card, index) => {
            const ul = document.createElement("ul");
            ul.className = "promo-list";

            // ✅ เพิ่มรายการจริง
            card.lists.forEach((item) => {
                const li = document.createElement("li");
                li.textContent = item.text;

                if (item.sub.length > 0) {
                    const subUl = document.createElement("ul");
                    subUl.className = "sub-list";
                    item.sub.forEach((sub) => {
                        const subLi = document.createElement("li");
                        subLi.textContent = sub;
                        subUl.appendChild(subLi);
                    });
                    li.appendChild(subUl);
                }
                ul.appendChild(li);
            });

            const promoCard = document.createElement("div");
            promoCard.className =
                "promo-card";
            promoCard.setAttribute("data-index", index);
            promoCard.setAttribute("draggable", "true");
            promoCard.setAttribute("data-start", card.startDate);
            promoCard.setAttribute("data-end", card.endDate);
            promoCard.setAttribute("ispreview", card.ignoreStartDate);

            promoCard.innerHTML = `
        <img src="${card.imgUrl}" class="promo-img"/>
        <a href="${card.link}" target="_blank" class="promo-link"></a>
        <div class="promo-content">
          <h3 class="promo-heading">${card.title}</h2>
        </div>
      `;

            promoCard.querySelector(".promo-content").appendChild(ul);

            if (!skipButtons) {
                const btnGroup = document.createElement("div");
                btnGroup.className =
                    "flex justify-end px-2 gap-2 pb-2 absolute bottom-0 right-0 z-20";
                btnGroup.innerHTML = `
          <button onclick="editPromotion(${index})" class="text-sm text-blue-600 hover:underline">Edit</button>
          <button onclick="deletePromotion(${index})" class="text-sm text-red-600 hover:underline">Delete</button>
        `;
                promoCard.appendChild(btnGroup);
            }

            previewContainer.appendChild(promoCard);
        });
        enableDragSort();
    }

    // This function enables drag-and-drop sorting of promotion cards
    function enableDragSort() {
        let draggedItem = null;

        previewContainer
            .querySelectorAll("[draggable=true]")
            .forEach((item) => {
                item.addEventListener("dragstart", (e) => {
                    draggedItem = item;
                    e.dataTransfer.effectAllowed = "move";
                });

                item.addEventListener("dragover", (e) => {
                    e.preventDefault();
                    const draggingOver = e.currentTarget;
                    if (draggedItem !== draggingOver) {
                        const draggedIndex = +draggedItem.dataset.index;
                        const overIndex = +draggingOver.dataset.index;
                        if (draggedIndex !== overIndex) {
                            const newOrder = [...cardsData];
                            const [moved] = newOrder.splice(draggedIndex, 1);
                            newOrder.splice(overIndex, 0, moved);
                            cardsData = newOrder;
                            renderAllPromotions();
                        }
                    }
                });
            });
    }

    function editPromotion(index) {
        const data = cardsData[index];
        document.getElementById("title").value = data.title;
        document.getElementById("link").value = data.link;
        document.getElementById("imgUrl").value = data.imgUrl;
        document.getElementById("start-date").value = data.startDate;
        document.getElementById("end-date").value = data.endDate;
        document.getElementById("ignore-start-date").checked =
            data.ignoreStartDate || false;

        listContainer.innerHTML = "";
        data.lists.forEach((item) => addListItem(item));
        editingIndex = index;
    }

    function deletePromotion(index) {
        if (confirm("Are you sure you want to delete this promotion?")) {
            cardsData.splice(index, 1);
            renderAllPromotions();
        }
    }

    function carouselNext(eleId) {
        const carousel = document.getElementById(eleId);
        if (!carousel) return;
        const item = carousel.querySelector("div");
        const itemWidth = item?.offsetWidth || 300;
        const gap = parseInt(window.getComputedStyle(carousel).gap) || 8;
        carousel.scrollBy({
            left: itemWidth + gap,
            behavior: "smooth"
        });
    }

    function carouselPrev(eleId) {
        const carousel = document.getElementById(eleId);
        if (!carousel) return;
        const item = carousel.querySelector("div");
        const itemWidth = item?.offsetWidth || 300;
        const gap = parseInt(window.getComputedStyle(carousel).gap) || 8;
        carousel.scrollBy({
            left: -(itemWidth + gap) * 4,
            behavior: "smooth"
        });
    }

    function copyCode() {
        // Temporarily render cards without Edit/Delete buttons
        renderAllPromotions(true, ignoreStartDateCheckbox.checked);
        const code = promotionsWrapper.innerHTML;
        const completeCode = `
        <style>
        /* Hide scrollbar in all modern browsers */
        #slider::-webkit-scrollbar {
            display: none;
        }

        #slider {
            -ms-overflow-style: none;
            /* IE/Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .promo-wrapper {
            position: relative;
            display: flex;
            flex-direction: column;
            padding-left: 1rem;
            color: #1d1d1f;
            font-size: 0.75rem
            /* 12px */
            ;
            line-height: 1rem
            /* 16px */
            ;
        }

        .promo-title {
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            font-size: 1.25rem
            /* 20px */
            ;
            font-weight: bold;
            text-align: left;
        }

        .promo-container {
            display: grid;
            grid-auto-flow: column;
            flex-direction: column-reverse;
            grid-auto-columns: calc(80% - 0.5rem /* 8px */);
            width: 100%;
            gap: 0.75rem;
            padding-right: 1rem;
            overflow-y: hidden;
            overflow-x: scroll;
            scroll-behavior: smooth;
            scroll-snap-type: x var(--tw-scroll-snap-strictness);
            --tw-scroll-snap-strictness: mandatory;
        }

        .promo-card {
            position: relative;
            width: 100%;
            text-align: start;
            scroll-snap-align: start;
            border-radius: 0.375rem;
            border: 1px solid #b1b1b1;
            background-color: #fff;
            font-size: 0.75rem;
        }

        .promo-img {
            width: 100%;
            height: auto;
            border-radius: 0.375rem;
        }

        .promo-content {
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 0.75rem 0.5rem 0.75rem 0.5rem;
        }

        .promo-heading {
            font-size: 1.125rem;
            font-weight: bold;
            margin: 0 0 0.5rem 0;
        }

        .carousel-prev {
            position: absolute;
            left: 0;
            z-index: 1;
            display: none;
            padding: 0.5rem;
            background-color: rgba(255, 255, 255, 0.75);
            transition: background-color 0.3s ease;
            top: 50%;
            transform: translateY(-50%);
            border: none;
        }

        .carousel-next {
            position: absolute;
            right: 0;
            z-index: 1;
            display: none;
            padding: 0.5rem;
            background-color: rgba(255, 255, 255, 0.75);
            transition: background-color 0.3s ease;
            top: 50%;
            transform: translateY(-50%);
            border: none;
        }

        .sub-list {
            padding-left: 1.5rem;
            list-style-type: disc;
            margin: 0;
            line-height: 1.4;
        }

        .promo-link {
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        @media (min-width: 768px) {
            .promo-wrapper {
            padding-left: 0;
            font-size: 1rem /* 16px */;
            line-height: 1.5rem/* 24px */;
            }

            .promo-title {
            font-size: 1.875rem/* 30px */;
            margin-top: 2rem;
            margin-bottom: 1.5rem;
            }

            .promo-container {
            grid-auto-columns: calc(40% - 0.5rem /* 8px */);
            gap: 1.5rem;
            }

            .promo-content {
            padding: 0.75rem;
            }

            .promo-heading {
            font-size: 1.625rem /* 26px */;
            }

            .promo-list {
            padding-left: 1.5rem;
            list-style-type: disc;
            margin: 0;
            line-height: 1.4;
            }

            .carousel-prev {
            display: block;
            }

            .carousel-next {
            display: block;
            }

        }

        .carousel-prev:hover {
            background-color: #d1d5db; /* Gray 300 */
        }

        .carousel-next:hover {
            background-color: #d1d5db; /* Gray 300 */
        }
        </style>
        <div id="promotions-wrapper" class="promo-wrapper">
            ${code}
        </div>
        <script>
            function carouselPrev(carouselId) {
              const el = document.getElementById(carouselId);
              const slideWidth = el.querySelector("div")?.offsetWidth || 200;
              el.scrollBy({ left: -slideWidth * 4, behavior: "smooth" });
            }

            function carouselNext(carouselId) {
              const el = document.getElementById(carouselId);
              const slideWidth = el.querySelector("div")?.offsetWidth || 200;
              el.scrollBy({ left: slideWidth * 4, behavior: "smooth" });
            }
            document.addEventListener("load", function () {
              const now = new Date();
              const promotionItems = document.querySelectorAll('#PROMOTIONS-container > div');

              promotionItems.forEach((item) => {
                const startStr = item.getAttribute('data-start');
                const endStr = item.getAttribute('data-end');
                const isPreview = item.getAttribute('ispreview') === 'true';

                const startDate = new Date(startStr);
                const endDate = new Date(endStr);
                endDate.setHours(23, 59, 59, 999);

                const isWithinDate = now >= startDate && now <= endDate;
                const isBeforeEnd = now <= endDate;

                if ((isPreview && isBeforeEnd) || (!isPreview && isWithinDate)) {
                  item.style.display = 'block';
                } else {
                  item.style.display = 'none';
                }
              });
            });
          <\/script>
        `;

        navigator.clipboard
            .writeText(completeCode)
            .then(() => {
                const originalText = copyBtn.textContent;
                copyBtn.textContent = "✓ Copied!";
                setTimeout(() => {
                    copyBtn.textContent = originalText;
                    renderAllPromotions(); // Restore with buttons
                }, 2000);
            })
            .catch((err) => {
                alert("Failed to copy code: " + err);
            });
    }

    function importPromotionsFromHTML() {
        const textarea = document.getElementById("import-code");
        const html = textarea.value;
        const temp = document.createElement("div");
        temp.innerHTML = html;

        const promoDivs = temp.querySelectorAll("[data-index]");
        const newCards = [];

        promoDivs.forEach((div) => {
            const title = div.querySelector("h3")?.textContent.trim() || "";
            const imgUrl = div.querySelector("img")?.src || "";
            const link = div.querySelector("a")?.href || "";
            const start = div.getAttribute("data-start") || "";
            const end = div.getAttribute("data-end") || "";
            const ispreview = div.getAttribute("ispreview") === "true";

            const parsedLists = [];
            const allLis = div.querySelectorAll("ul > li");

            allLis.forEach((li) => {
                const isDateLine = li.classList.contains("font-semibold");
                if (isDateLine) return;

                const subUl = li.querySelector("ul");
                if (subUl) {
                    const mainText = li.firstChild.textContent.trim();
                    const subItems = Array.from(subUl.querySelectorAll("li")).map(
                        (sub) => sub.textContent.trim()
                    );
                    parsedLists.push({
                        text: mainText,
                        sub: subItems
                    });
                } else if (!li.closest("ul").closest("li")) {
                    parsedLists.push({
                        text: li.textContent.trim(),
                        sub: []
                    });
                }
            });

            newCards.push({
                title,
                link,
                imgUrl,
                startDate: start,
                endDate: end,
                ignoreStartDate: ispreview,
                lists: parsedLists,
            });
        });

        cardsData = newCards;
        textarea.value = ""; // ✅ เคลียร์ textarea ที่ถูกต้อง
        renderAllPromotions();
        alert("✅ Promotions imported successfully!");
    }

    function importHtmlLists() {
        const textarea = document.getElementById("import-list");
        const html = textarea.value;
        const temp = document.createElement("div");
        temp.innerHTML = html;

        const mainLis = temp.querySelectorAll("ul > li");
        const parsedLists = [];

        mainLis.forEach((li) => {
            const subUl = li.querySelector("ul");
            if (subUl) {
                const mainText = li.childNodes[0].textContent.trim();
                const subItems = Array.from(subUl.querySelectorAll("li")).map(
                    (sub) => sub.textContent.trim()
                );
                parsedLists.push({
                    text: mainText,
                    sub: subItems
                });
            } else if (!li.closest("ul").closest("li")) {
                // only push main-level <li> (not nested inside another <li>)
                parsedLists.push({
                    text: li.textContent.trim(),
                    sub: []
                });
            }
        });

        // ล้าง list เดิมแล้วโหลดใหม่ทั้งหมด
        listContainer.innerHTML = "";
        textarea.value = "";
        parsedLists.forEach((item) => addListItem(item));

        alert("✅ Lists imported successfully!");
    }
</script>
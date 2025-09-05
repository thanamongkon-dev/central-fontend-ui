<?php
session_start();
// Load lang.json
$lang = $_SESSION['lang'];
$top = $lang['storeTop'] ?? [];
?>
<style>
    .store-container {
        font-size: 0.875rem;
        max-width: 1440px;
        margin: 1.5rem auto;
        padding: 0;
        color: #1d1d1f;
        display: flex;
        flex-direction: column;
        background: #f7f6f5;
    }

    .store-header {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
    }

    .store-grid {
        display: grid;
        grid-template-columns: 1fr;
    }

    .store-info {
        gap: 0.5rem;
        padding: 0.75rem 1rem 1rem;
    }

    .store-name {
        font-size: 2.25rem;
        font-weight: 500;
        line-height: 1;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: -0.02em;
        white-space: pre-line;
    }

    .store-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .store-table {
        text-align: left;
        color: #1d1d1f;
    }

    .store-table td:nth-child(2) {
        padding-left: 0.75rem;
    }

    .store-table td:first-child {
        padding-right: 0.75rem;
    }

    .store-table td:nth-child(2) {
        border-left: 1px solid #333;
    }

    .store-desc {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
        padding: 0.75rem 1rem 1.5rem;
        font-size: 0.875rem;
    }

    .clamped {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        /* Standard property for compatibility */
        /* 2 lines */
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin: 0;
    }

    .discover-btn {
        background: none;
        border: none;
        text-decoration: underline;
        cursor: pointer;
        font-size: 0.875rem;
        padding: 0;
    }

    .hidden {
        display: none;
    }

    @media (min-width: 768px) {
        .store-container {
            font-size: 1rem;
        }

        .store-grid {
            grid-template-columns: 1fr 1fr;
        }

        .store-info {
            padding: 64px 2rem 2rem;
            gap: 1rem;
        }

        .store-name {
            font-size: 52px;
        }

        .store-desc {
            padding: 0.75rem 2rem 1.5rem;
        }
    }
</style>
<div class="container mx-auto max-w-[1440px] p-4">
    <h1 class="mb-4 text-2xl font-bold"><?= $top['name'] ?></h1>

    <!-- input container -->
    <div class="flex flex-col space-y-4">
        <label>
            <span class="block mb-2 font-semibold"><?= $top['title']['label'] ?></span>
            <input type="text" id="store-name-input" placeholder="<?= $top['title']['placeholder'] ?>"
                class="w-full p-2 border border-gray-300 rounded" />
        </label>

        <label>
            <span class="block mb-2 font-semibold"><?= $top['img']['label'] ?></span>
            <input type="text" id="store-image-input" placeholder="<?= $top['img']['placeholder'] ?>"
                class="w-full p-2 border border-gray-300 rounded" />
        </label>

        <fieldset class="fieldset">
            <div class="flex items-center gap-2">
                <legend class="fieldset-legend"><?= $top['openTime']['label'] ?></legend>
                <!-- info -->
                <span class="text-lg cursor-pointer tooltip tooltip-right"
                    data-tip="Set store open hours per day.
                  You can choose specific time ranges for each weekday.
                  If ‘Everyday’ is checked, other weekdays will be disabled.
                  If any weekday is checked after 'Everyday', it will automatically uncheck 'Everyday'.">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v3m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <table class="w-1/2 text-left border-separate border-spacing-y-2">
                <tbody>

                    <tr>
                        <td class="pr-4">
                            <label class="label" for="open-everyday">
                                <input type="checkbox" class="checkbox" id="open-everyday" />
                                <?= $top['openTime']['days']['all'] ?>
                            </label>
                        </td>
                        <td><input type="time" class="input" id="open-everyday-start" /></td>
                        <td class="px-2 text-center">-</td>
                        <td><input type="time" class="input" id="open-everyday-end" /></td>
                    </tr>

                    <tr>
                        <td class="pr-4">
                            <label class="label" for="open-monday">
                                <input type="checkbox" class="checkbox" id="open-monday" />
                                <?= $top['openTime']['days']['mon'] ?>
                            </label>
                        </td>
                        <td><input type="time" class="input" id="open-monday-start" /></td>
                        <td class="px-2 text-center">-</td>
                        <td><input type="time" class="input" id="open-monday-end" /></td>
                    </tr>

                    <tr>
                        <td class="pr-4">
                            <label class="label" for="open-tuesday">
                                <input type="checkbox" class="checkbox" id="open-tuesday" />
                                <?= $top['openTime']['days']['tue'] ?>
                            </label>
                        </td>
                        <td><input type="time" class="input" id="open-tuesday-start" /></td>
                        <td class="px-2 text-center">-</td>
                        <td><input type="time" class="input" id="open-tuesday-end" /></td>
                    </tr>

                    <tr>
                        <td class="pr-4">
                            <label class="label" for="open-wednesday">
                                <input type="checkbox" class="checkbox" id="open-wednesday" />
                                <?= $top['openTime']['days']['wed'] ?>
                            </label>
                        </td>
                        <td><input type="time" class="input" id="open-wednesday-start" /></td>
                        <td class="px-2 text-center">-</td>
                        <td><input type="time" class="input" id="open-wednesday-end" /></td>
                    </tr>

                    <tr>
                        <td class="pr-4">
                            <label class="label" for="open-thursday">
                                <input type="checkbox" class="checkbox" id="open-thursday" />
                                <?= $top['openTime']['days']['thu'] ?>
                            </label>
                        </td>
                        <td><input type="time" class="input" id="open-thursday-start" /></td>
                        <td class="px-2 text-center">-</td>
                        <td><input type="time" class="input" id="open-thursday-end" /></td>
                    </tr>

                    <tr>
                        <td class="pr-4">
                            <label class="label" for="open-friday">
                                <input type="checkbox" class="checkbox" id="open-friday" />
                                <?= $top['openTime']['days']['fri'] ?>
                            </label>
                        </td>
                        <td><input type="time" class="input" id="open-friday-start" /></td>
                        <td class="px-2 text-center">-</td>
                        <td><input type="time" class="input" id="open-friday-end" /></td>
                    </tr>

                    <tr>
                        <td class="pr-4">
                            <label class="label" for="open-saturday">
                                <input type="checkbox" class="checkbox" id="open-saturday" />
                                <?= $top['openTime']['days']['sat'] ?>
                            </label>
                        </td>
                        <td><input type="time" class="input" id="open-saturday-start" /></td>
                        <td class="px-2 text-center">-</td>
                        <td><input type="time" class="input" id="open-saturday-end" /></td>
                    </tr>

                    <tr>
                        <td class="pr-4">
                            <label class="label" for="open-sunday">
                                <input type="checkbox" class="checkbox" id="open-sunday" />
                                <?= $top['openTime']['days']['sun'] ?>
                            </label>
                        </td>
                        <td><input type="time" class="input" id="open-sunday-start" /></td>
                        <td class="px-2 text-center">-</td>
                        <td><input type="time" class="input" id="open-sunday-end" /></td>
                    </tr>

                </tbody>
            </table>
        </fieldset>

        <label>
            <span class="block mb-2 font-semibold"><?= $top['contact']['label'] ?></span>
            <input type="text" id="contact-input" placeholder="<?= $top['contact']['placeholder'] ?>"
                class="w-full p-2 border border-gray-300 rounded" />
        </label>

        <label>
            <span class="block mb-2 font-semibold"><?= $top['address']['label'] ?></span>
            <input type="text" id="address-input" placeholder="<?= $top['address']['placeholder'] ?>"
                class="w-full p-2 border border-gray-300 rounded" />
        </label>

        <label>
            <span class="block mb-2 font-semibold"><?= $top['desc']['label'] ?></span>
            <textarea rows="4" id="text-discover" placeholder="<?= $top['desc']['placeholder'] ?>"
                class="w-full p-2 border border-gray-300 rounded"></textarea>
        </label>
    </div>

    <!-- Button -->
    <div class="flex items-start gap-4 mt-2">
        <!-- Switch btn toggle Central or Robinson -->
        <div class="flex">
            <button id="centralBtn" onclick="toggleBrand('central')"
                class="px-4 py-2 text-white bg-red-500 rounded-l toggle-btn">
                Central
            </button>
            <button id="robinsonBtn" onclick="toggleBrand('robinson')"
                class="px-4 py-2 text-gray-800 bg-gray-300 rounded-r toggle-btn">
                Robinson
            </button>
        </div>

        <button id="copyBtn" onclick="copyCode()" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
            📋 <?= $lang['copy'] ?>
        </button>
    </div>

    <!-- Preview -->
    <div class="mt-6">
        <h2 class="mb-2 text-lg font-bold"><?= $lang['preview'] ?></h2>
        <div id="preview-container">
            <div class="store-container">
                <div>
                    <div class="store-header">
                        <div class="store-grid">
                            <img id="store-image" class="store-image"
                                src="https://www.central.co.th/adobe/dynamicmedia/deliver/dm-aid--a34fdadc-dd2d-4614-b6b4-8d4a24c35da1/10104-central-lardprao.jpg?width=768&amp;preferwebp=true&amp;quality=60"
                                alt="Central Ladprao">
                            <div class="store-info">
                                <h1 id="store-name" class="store-name font-central-sang-bleu">
                                    central&nbsp;
                                    ladprao
                                </h1>
                                <table class="store-table">
                                    <tbody>
                                        <tr>
                                            <td>Hours</td>
                                            <td id="open-hours">Everyday at 10:00 - 22:00</td>
                                        </tr>
                                        <tr>
                                            <td style="height:8px;"></td>
                                        </tr>
                                        <tr>
                                            <td>Contact</td>
                                            <td id="contact">02-5411111</td>
                                        </tr>
                                        <tr>
                                            <td style="height:8px;"></td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td id="address">1691 Pahonyothin Road, Bangkok, 10900</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="store-desc">
                        <p id="Discover" class="clamped">
                            Central Ladprao (Central Plaza Ladprao) is one of the most
                            popular shopping malls in the Central Group in Thailand. It is
                            notable for being the country's first comprehensive shopping
                            center, having opened its doors in 1983. Located on Vibhavadi
                            Rangsit Road, the mall spans over 78,700 square meters. The
                            surrounding area includes condominiums, educational
                            institutions, and public parks. The complex features a 7-story
                            shopping center, a 25-story office building, and the Centara
                            Grand Hotel. Its proximity to the Ladprao intersection makes it
                            easily accessible by private car or public transport, including
                            the MRT and BTS Skytrain. Future plans include transforming the
                            area into a major transportation hub linking all 7 train lines.
                            The design concept of Central Ladprao is contemporary, blending
                            modern elements with a nature-inspired theme ("Trend Eco +
                            Modern Green"). This concept brings nature into the urban
                            environment through the addition of green spaces, natural light
                            via skylight installations, roof gardens, and the use of
                            sustainable materials to reduce energy consumption and
                            pollution. The exterior of the building features LED lighting
                            and more than 1,000 square meters of interactive displays,
                            seamlessly integrating modern lifestyle elements with a natural
                            theme.
                        </p>
                        <button id="show-btn" onclick="show()" class="discover-btn">View more</button>
                        <button id="hide-btn" onclick="hide()" class="hidden discover-btn">View less</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let openDays = [];
    let lang = "<?php echo $_SESSION['lang_code'] ?? 'en'; ?>";
    /*Element Input*/
    const titleInput = document.getElementById("store-name-input");
    const imageUrlInput = document.getElementById("store-image-input");
    const openHoursInput = document.getElementById("open-hours-input");
    const contactInput = document.getElementById("contact-input");
    const addressInput = document.getElementById("address-input");
    const discoverInput = document.getElementById("text-discover");
    const copyBtn = document.getElementById("copyBtn");

    /*Element Preview*/
    const title = document.getElementById("store-name");
    const imageUrl = document.getElementById("store-image");
    const openHours = document.getElementById("open-hours");
    const contact = document.getElementById("contact");
    const address = document.getElementById("address");
    const discover = document.getElementById("Discover");

    /*Live update Preview*/
    titleInput.addEventListener("input", () => {
        const value = titleInput.value.trim();
        title.textContent = value;
        imageUrl.alt = value;

        if (isThai(value)) {
            // console.log("Thai input detected");
            if (title.classList.contains("font-central-sang-bleu")) {
                title.classList.replace("font-central-sang-bleu", "font-cpn-bold-condensed");
            }
        } else if (isEnglish(value)) {
            // console.log("English input detected");
            if (title.classList.contains("font-cpn-bold-condensed")) {
                title.classList.replace("font-cpn-bold-condensed", "font-central-sang-bleu");
            }
        } else {
            // console.log("Mixed or other language");
            if (title.classList.contains("font-central-sang-bleu")) {
                title.classList.replace("font-central-sang-bleu", "font-cpn-bold-condensed");
            }
        }
    });

    imageUrlInput.addEventListener("input", () => {
        imageUrl.src = imageUrlInput.value;
    });

    contactInput.addEventListener("input", () => {
        contact.textContent = contactInput.value;
    });

    addressInput.addEventListener("input", () => {
        address.textContent = addressInput.value;
    });

    discoverInput.addEventListener("input", () => {
        discover.textContent = discoverInput.value;
    });

    function isThai(text) {
        return /^[\u0E00-\u0E7F\s]+$/.test(text);
    }

    function isEnglish(text) {
        return /^[A-Za-z0-9\s]+$/.test(text);
    }


    const days = [
        "everyday", "monday", "tuesday", "wednesday", "thursday",
        "friday", "saturday", "sunday"
    ];

    const daysTH = [
        "ทุกวัน", "จันทร์", "อังคาร", "พุธ", "พฤหัส", "ศุกร์", "เสาร์", "อาทิตย์"
    ];

    const usedDays = lang === 'th' ? daysTH : days;

    days.forEach((day, index) => {
        const checkbox = document.getElementById(`open-${day}`);
        const startInput = document.getElementById(`open-${day}-start`);
        const endInput = document.getElementById(`open-${day}-end`);

        if (checkbox && startInput && endInput) {
            checkbox.addEventListener("change", () => updateOpenHours(day, index));
            startInput.addEventListener("input", () => updateOpenHours(day, index));
            endInput.addEventListener("input", () => updateOpenHours(day, index));
        }
    });


    function updateOpenHours(day, id) {
        const openCheckbox = document.getElementById(`open-${day}`);
        const startTime = document.getElementById(`open-${day}-start`).value;
        const endTime = document.getElementById(`open-${day}-end`).value;

        // ถ้าเลือก everyday → uncheck วันอื่น
        if (day === "everyday" && openCheckbox.checked) {
            const otherDays = [
                "monday", "tuesday", "wednesday", "thursday",
                "friday", "saturday", "sunday"
            ];

            otherDays.forEach((d, i) => {
                const cb = document.getElementById(`open-${d}`);
                cb.checked = false;
                openDays = openDays.filter((entry) => entry.day.toLowerCase() !== d);
            });
        }

        // ถ้า everyday ถูกเช็คอยู่ แล้วเช็ควันอื่นตามมา → uncheck everyday
        if (day !== "everyday") {
            const everydayCheckbox = document.getElementById("open-everyday");
            if (everydayCheckbox.checked) {
                everydayCheckbox.checked = false;
                openDays = openDays.filter((entry) => entry.day.toLowerCase() !== "everyday");
            }
        }

        if (openCheckbox.checked) {
            if (startTime && endTime) {
                openDays = openDays.filter((d) => d.id !== id);
                openDays.push({
                    id: id,
                    day: day.charAt(0).toUpperCase() + day.slice(1),
                    start: startTime,
                    end: endTime
                });
            } else {
                alert("Please enter both start and end times for " + day);
                openCheckbox.checked = false;
            }
        } else {
            openDays = openDays.filter((d) => d.id !== id);
        }
        updateOpenHoursDisplay()
        // console.log(openDays);
    }

    function updateOpenHoursDisplay() {
        const openHoursContainer = document.getElementById("open-hours");
        if (openDays.length === 0) {
            openHoursContainer.textContent = lang === 'th' ? "ปิดทำการ" : "Closed";
            return;
        }

        const sortedDays = openDays.sort((a, b) => a.id - b.id);
        openDays = sortedDays;

        const grouped = [];
        let group = [sortedDays[0]];

        for (let i = 1; i < sortedDays.length; i++) {
            const current = sortedDays[i];
            const last = group[group.length - 1];

            // ถ้าเวลา start-end ตรงกันกับกลุ่มปัจจุบัน → รวมกลุ่ม
            if (current.start === last.start && current.end === last.end) {
                group.push(current);
            } else {
                grouped.push(group);
                group = [current];
            }
        }

        grouped.push(group);

        // ใช้ usedDays สำหรับแสดงชื่อวันตามภาษา
        const usedDays = lang === 'th' ? daysTH : days.map(d => d.charAt(0).toUpperCase() + d.slice(1));

        // สร้างข้อความแสดงผล
        const lines = grouped.map(group => {
            const start = group[0].start;
            const end = group[0].end;
            const firstDay = usedDays[group[0].id];
            const lastDay = usedDays[group[group.length - 1].id];

            if (lang === 'th') {
                if (group.length === 1) {
                    return `${firstDay} ตั้งแต่ ${start} ถึง ${end}`;
                } else {
                    return `${firstDay} - ${lastDay} ตั้งแต่ ${start} ถึง ${end}`;
                }
            } else {
                if (group.length === 1) {
                    return `${firstDay} at ${start} - ${end}`;
                } else {
                    return `${firstDay} - ${lastDay} at ${start} - ${end}`;
                }
            }
        });

        openHoursContainer.innerHTML = lines.join("<br>");
    }



    function toggleBrand(brand) {
        const centralBtn = document.getElementById("centralBtn");
        const robinsonBtn = document.getElementById("robinsonBtn");

        const brandStyles = {
            central: {
                btn: ["bg-red-500", "text-white"],
                inactiveBtn: ["bg-gray-300", "text-gray-800"],
                titleColor: "#1d1d1f",
            },
            robinson: {
                btn: ["bg-emerald-500", "text-white"],
                inactiveBtn: ["bg-gray-300", "text-gray-800"],
                titleColor: "#10b981",
            },
        };

        if (brand === "central") {
            centralBtn.classList.add(...brandStyles.central.btn);
            centralBtn.classList.remove(...brandStyles.central.inactiveBtn);

            robinsonBtn.classList.add(...brandStyles.robinson.inactiveBtn);
            robinsonBtn.classList.remove(...brandStyles.robinson.btn);

            title.style.color = brandStyles.central.titleColor;
            // title.classList.add(brandStyles.central.titleColor);
            // title.classList.remove(brandStyles.robinson.titleColor);
        } else {
            robinsonBtn.classList.add(...brandStyles.robinson.btn);
            robinsonBtn.classList.remove(...brandStyles.robinson.inactiveBtn);

            centralBtn.classList.add(...brandStyles.central.inactiveBtn);
            centralBtn.classList.remove(...brandStyles.central.btn);

            title.style.color = brandStyles.robinson.titleColor;
            // title.classList.add(brandStyles.robinson.titleColor);
            // title.classList.remove(brandStyles.central.titleColor);
        }
    }

    function show() {
        document.getElementById("Discover").classList.remove("clamped");
        document.getElementById("show-btn").classList.add("hidden");
        document.getElementById("hide-btn").classList.remove("hidden");
    }

    function hide() {
        document.getElementById("Discover").classList.add("clamped");
        document.getElementById("show-btn").classList.remove("hidden");
        document.getElementById("hide-btn").classList.add("hidden");
    }


    function copyCode() {
        const content = document.getElementById("preview-container").innerHTML;
        const completeCode = `
    <style>
        .store-container {
            font-size: 0.875rem;
            max-width: 1440px;
            margin: 1.5rem auto;
            padding: 0;
            color: #1d1d1f;
            display: flex;
            flex-direction: column;
            background: #f7f6f5;
        }

        .store-header {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
        }

        .store-grid {
            display: grid;
            grid-template-columns: 1fr;
        }

        .store-info {
            gap: 0.5rem;
            padding: 0.75rem 1rem 1rem;
        }

        .store-name {
            font-size: 2.25rem;
            font-weight: 500;
            line-height: 1;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: -0.02em;
            white-space: pre-line;
        }

        .store-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .store-table {
            text-align: left;
            color: #1d1d1f;
        }

        .store-table td:nth-child(2) {
            padding-left: 0.75rem;
        }

        .store-table td:first-child {
            padding-right: 0.75rem;
        }

        .store-table td:nth-child(2) {
            border-left: 1px solid #333;
        }

        .store-desc {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
            padding: 0.75rem 1rem 1.5rem;
            font-size: 0.875rem;
        }

        .clamped {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            /* Standard property for compatibility */
            /* 2 lines */
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin: 0;
        }

        .discover-btn {
            background: none;
            border: none;
            text-decoration: underline;
            cursor: pointer;
            font-size: 0.875rem;
            padding: 0;
        }

        .hidden {
            display: none;
        }

        @media (min-width: 768px) {
            .store-container {
                font-size: 1rem;
            }

            .store-grid {
                grid-template-columns: 1fr 1fr;
            }

            .store-info {
                padding: 64px 2rem 2rem;
                gap: 1rem;
            }

            .store-name {
                font-size: 52px;
            }

            .store-desc {
                padding: 0.75rem 2rem 1.5rem;
            }
        }
    </style>
      ${content}
      <script>
        function show() {
            document.getElementById("Discover").classList.remove("clamped");
            document.getElementById("show-btn").classList.add("hidden");
            document.getElementById("hide-btn").classList.remove("hidden");
        }

        function hide() {
            document.getElementById("Discover").classList.add("clamped");
            document.getElementById("show-btn").classList.remove("hidden");
            document.getElementById("hide-btn").classList.add("hidden");
        }
      <\/script>
      `;
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
</script>
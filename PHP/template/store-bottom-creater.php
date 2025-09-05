<?php
session_start();
// Load lang.json
$lang = $_SESSION['lang'];
$bot = $lang['storeBot'] ?? [];
$loc = $bot['location'] ?? [];
$res = $bot['restaurant'] ?? [];
$dir = $bot['directories'] ?? [];
$ser = $bot['services'] ?? [];
?>
<link rel="stylesheet" href="https://prod-assets.central.co.th/file-assets/assets/CMS/evm/assets/css/Highlight.css">
<div class="relative container mx-auto max-w-[1440px] p-4 font-cpn">
  <h1 class="mb-4 text-2xl font-bold"><?= $bot['name'] ?></h1>
  <div class="flex justify-between w-full gap-4">
    <div role="tablist" class="tabs tabs-lift">
      <a id="Today-tab" onclick="activeTab('Today')" role="tab" class="text-xl tab tab-active">What's Happening</a>
      <a id="Location-tab" onclick="activeTab('Location')" role="tab" class="text-xl tab">Location</a>
      <a id="Restaurant-tab" onclick="activeTab('Restaurant')" role="tab" class="text-xl tab">Restaurant</a>
      <a id="Directories-tab" onclick="activeTab('Directories')" role="tab" class="text-xl tab">Directories</a>
      <a id="Services-tab" onclick="activeTab('Services')" role="tab" class="text-xl tab">Services</a>
    </div>
    <!-- Side Config -->
    <div class="absolute flex flex-col gap-1 top-20 right-16">
      <fieldset class="w-64 p-4 border fieldset bg-base-100 border-base-300 rounded-box">
        <legend class="fieldset-legend"><?= $bot['config']['h1'] ?></legend>

        <label class="label">
          <input onchange="hideTab('Today')" id="Today-checkbox" type="checkbox" checked="checked" class="checkbox" />
          What's Happening
        </label>

        <!-- <label class="label">
          <input onchange="hideTab('Location')" id="Location-checkbox" type="checkbox" checked="checked"
            class="checkbox" />
          Location
        </label> -->

        <label class="label">
          <input onchange="hideTab('Restaurant')" id="Restaurant-checkbox" type="checkbox" checked="checked"
            class="checkbox" />
          Restaurant
        </label>

        <label class="label">
          <input onchange="hideTab('Directories')" id="Directories-checkbox" type="checkbox" checked="checked"
            class="checkbox" />
          Directories
        </label>

        <label class="label">
          <input onchange="hideTab('Services')" id="Services-checkbox" type="checkbox" checked="checked"
            class="checkbox" />
          Services
        </label>
      </fieldset>
      <legend class="fieldset-legend"><?= $bot['config']['h2'] ?></legend>
      <div class="join join-vertical lg:join-horizontal">

        <button id="chidlomBtn" onclick="toggleBrand('chidlom')"
          class="px-4 py-1.5 join-item cursor-pointer bg-red-300 text-white">
          Chidlom
        </button>
        <button id="centralBtn" onclick="toggleBrand('central')"
          class="px-4 py-1.5 text-gray-800 bg-gray-300 join-item cursor-pointer">
          Central
        </button>
        <button id="robinsonBtn" onclick="toggleBrand('robinson')"
          class="px-4 py-1.5 text-gray-800 bg-gray-300 join-item cursor-pointer">
          Robinson
        </button>
      </div>
    </div>
  </div>

  <!-- Today's Event -->
  <fieldset id="Today-fieldset" class="active">
    <div class="grid w-1/2 grid-cols-2 gap-2">

      <div>
        <legend class="fieldset-legend"><?= $bot['event']['title']['label'] ?></legend>
        <input id="event-title" type="text" class="input" placeholder="<?= $bot['event']['title']['placeholder'] ?>" />
      </div>

      <div>
        <legend class="fieldset-legend"><?= $bot['event']['location']['label'] ?></legend>
        <input id="event-loc" type="text" class="input" placeholder="<?= $bot['event']['location']['placeholder'] ?>" />
      </div>

      <div>
        <legend class="fieldset-legend"><?= $bot['event']['img']['label'] ?></legend>
        <input id="event-image-url" type="text" class="input" placeholder="<?= $bot['event']['img']['placeholder'] ?>" />
      </div>

      <div>
        <legend class="fieldset-legend"><?= $bot['event']['type']['label'] ?></legend>
        <select id="event-options" class="select">
        </select>
      </div>


    </div>
    <div class="grid w-1/2 grid-cols-2 gap-2">
      <div>
        <legend class="fieldset-legend"><?= $bot['event']['start'] ?></legend>
        <input id="start-date" type="date" class="input">
      </div>

      <div>
        <legend class="fieldset-legend"><?= $bot['event']['end'] ?></legend>
        <input id="end-date" type="date" class="input">
      </div>
    </div>
    <div>
      <textarea id="event-desc" rows="2" placeholder="<?= $bot['event']['desc']['placeholder'] ?>"
        class="w-full p-2 mt-4 border border-gray-300 rounded"></textarea>
    </div>

    <textarea id="import-code" rows="1" placeholder="<?= $lang['importPlaceholder'] ?>"
      class="w-full p-2 mt-4 border border-gray-300 rounded"></textarea>
    <button onclick="importHTML()" class="px-4 py-2 mt-2 text-white bg-green-600 rounded hover:bg-green-700">
      📥 <?= $lang['import'] ?>
    </button>

    <div class="flex items-start gap-4 text-base">


      <button onclick="addEvent()" class="px-4 py-2 mt-2 text-white bg-purple-600 rounded hover:bg-purple-700">
        ➕ <?= $bot['event']['addButton'] ?>
      </button>

      <!-- CheckBox Ignore Start Date -->
      <div class="p-2 mt-2 text-white bg-yellow-400 rounded">
        <label class="flex items-center gap-2">
          <input type="checkbox" id="ignore-start-date" class="w-4 h-4" />
          <span class="text-base"><?= $bot['event']['ignore'] ?></span>
        </label>
      </div>

      <!-- Is Chidlom -->
      <!-- <div id="chidlomBtn" class="p-2 mt-2 text-white bg-red-300 rounded">
        <label class="flex items-center gap-2">
          <input type="checkbox" id="isChidlom" class="w-4 h-4" />
          <span class="text-base">Is Chidlom</span>
        </label>
      </div> -->
    </div>

  </fieldset>

  <!-- Location Field -->
  <fieldset id="Location-fieldset" class="hidden">
    <div>
      <legend class="fieldset-legend"><?= $loc['latitude']['label'] ?></legend>
      <input id="latitude" type="text" class="input" placeholder="<?= $loc['latitude']['placeholder'] ?>" />

      <legend class="fieldset-legend"><?= $loc['longitude']['label'] ?></legend>
      <input id="longitude" type="text" class="input" placeholder="<?= $loc['longitude']['placeholder'] ?>" />
    </div>

    <fieldset class="fieldset">
      <legend class="fieldset-legend"><?= $loc['select'] ?></legend>
      <select id="store-select" class="select">
      </select>
      <span class="label">Optional</span>
    </fieldset>

    <button onclick="updateMap()" class="mt-2 w-fit btn btn-primary">🔁 <?= $loc['update'] ?></button>
  </fieldset>

  <!-- Restaurant Field -->
  <fieldset id="Restaurant-fieldset" class="hidden">
    <div>
      <legend class="fieldset-legend"><?= $res['img']['label'] ?></legend>
      <input id="res-url" type="text" class="input" placeholder="<?= $res['img']['placeholder'] ?>">

      <legend class="fieldset-legend"><?= $res['title']['label'] ?></legend>
      <input id="res-name" type="text" class="input" placeholder="<?= $res['title']['placeholder'] ?>">

      <legend class="fieldset-legend"><?= $res['type']['label'] ?></legend>
      <input type="text" id="res-type" class="input" placeholder="<?= $res['type']['placeholder'] ?>">

      <legend class="fieldset-legend"><?= $res['location']['label'] ?></legend>
      <input id="res-loc" type="text" class="input" placeholder="<?= $res['location']['placeholder'] ?>">

      <legend class="fieldset-legend"><?= $res['open'] ?></legend>
      <div>
        <input type="time" class="input" id="res-start" /> &nbsp; - &nbsp; <input type="time" class="input"
          id="res-end" />
      </div>
    </div>

    <button onclick="addRestaurant()" class="mt-2 w-fit btn btn-primary">➕ <?= $res['addBtn'] ?></button>

  </fieldset>

  <!-- Directory Field -->
  <fieldset id="Directories-fieldset" class="hidden">
    <legend class="fieldset-legend"><?= $dir['img']['label'] ?></legend>
    <input id="directory-image-url" type="text" class="input" placeholder="<?= $dir['img']['placeholder'] ?>">

    <button onclick="addDir()" class="mt-2 w-fit btn btn-primary">➕ Add Image</button>
  </fieldset>

  <!-- Service Field -->
  <fieldset id="Services-fieldset" class="hidden w-2/3 grid-cols-2">
    <div>
      <legend class="fieldset-legend"><?= $ser['title']['label'] ?></legend>
      <input id="service-name" type="text" class="input" placeholder="<?= $ser['title']['placeholder'] ?>">

      <legend class="fieldset-legend"><?= $ser['img']['label'] ?></legend>
      <input id="service-image-url" type="text" class="input" placeholder="<?= $ser['img']['placeholder'] ?>">

      <legend class="fieldset-legend"><?= $ser['tel']['label'] ?></legend>
      <input id="service-tel" type="text" class="input" placeholder="<?= $ser['tel']['placeholder'] ?>">

      <legend class="fieldset-legend"><?= $ser['desc']['label'] ?></legend>
      <input id="service-desc" type="text" class="input" placeholder="<?= $ser['desc']['placeholder'] ?>">
    </div>

    <fieldset class="grid w-full grid-cols-2 p-4 border fieldset bg-base-100 border-base-300 rounded-box">
      <legend class="fieldset-legend">Defalut Service</legend>

      <label class="label">
        <input onchange="toggleAllServices(this)" id="service-all" type="checkbox" class="checkbox" />
        All Service
      </label>

      <label class="label">
        <input onchange="toggleService('babysitter')" id="service-babysitter" type="checkbox" class="checkbox" />
        BABYSITTER
      </label>

      <label class="label">
        <input onchange="toggleService('babystrollers')" id="service-babystrollers" type="checkbox" class="checkbox" />
        BABY STROLLERS
      </label>

      <label class="label">
        <input onchange="toggleService('breastfeeding')" id="service-breastfeeding" type="checkbox" class="checkbox" />
        BREASTFEEDING
      </label>

      <label class="label">
        <input onchange="toggleService('eordering')" id="service-eordering" type="checkbox" class="checkbox" />
        E-ORDERING
      </label>

      <label class="label">
        <input onchange="toggleService('giftregistry')" id="service-giftregistry" type="checkbox" class="checkbox" />
        GIFT REGISTRY
      </label>

      <label class="label">
        <input onchange="toggleService('homehotel')" id="service-homehotel" type="checkbox" class="checkbox" />
        HOME & HOTEL
      </label>

      <label class="label">
        <input onchange="toggleService('delivery')" id="service-delivery" type="checkbox" class="checkbox" />
        INTERNATIONAL DELIVERY
      </label>

      <label class="label">
        <input onchange="toggleService('interpreter')" id="service-interpreter" type="checkbox" class="checkbox" />
        INTERPRETER
      </label>

      <label class="label">
        <input onchange="toggleService('muskimprayer')" id="service-muskimprayer" type="checkbox" class="checkbox" />
        MUSKIM PRAYER
      </label>

      <label class="label">
        <input onchange="toggleService('personalshopper')" id="service-personalshopper" type="checkbox"
          class="checkbox" />
        PERSONAL SHOPPER
      </label>

      <label class="label">
        <input onchange="toggleService('porter')" id="service-porter" type="checkbox" class="checkbox" />
        PORTER
      </label>

      <label class="label">
        <input onchange="toggleService('shuttle')" id="service-shuttle" type="checkbox" class="checkbox" />
        SHUTTLE
      </label>

      <label class="label">
        <input onchange="toggleService('specialist')" id="service-specialist" type="checkbox" class="checkbox" />
        SPECIALIST
      </label>

      <label class="label">
        <input onchange="toggleService('vatrefund')" id="service-vatrefund" type="checkbox" class="checkbox" />
        VAT-REFUND
      </label>

      <label class="label">
        <input onchange="toggleService('wheelchairs')" id="service-wheelchairs" type="checkbox" class="checkbox" />
        WHEELCHAIRS
      </label>
    </fieldset>


    <button onclick="addService()" class="mt-2 w-fit btn btn-primary">➕ <?= $ser['addBtn'] ?></button>
    <button onclick="renderServices()" class="mt-2 w-fit btn btn-primary">🔁 <?= $ser['update'] ?></button>
  </fieldset>


  <!-- Preview -->
  <div class="my-6">
    <div class="flex items-center justify-between text-center">
      <h2 class="text-lg font-bold"><?= $lang['preview'] ?></h2>
      <button id="copyBtn" onclick="copyCode()" class="p-2 text-white bg-blue-600 rounded hover:bg-blue-700">
        📋 <?= $lang['copy'] ?>
      </button>
    </div>
    <!-- Preview wrapper -->
    <div id="preview-container">

      <!-- Content -->
      <div class="highlight-container">
        <!-- btn section -->
        <div class="btn-group">
          <button class="tab-style active-tab" onclick="changeTab('Today')" id="Today">What's Happening</button>
          <button class="tab-style" onclick="changeTab('Location')" id="Location">Location</button>
          <button class="tab-style" onclick="changeTab('Restaurant')" id="Restaurant">Restaurant</button>
          <button class="tab-style" onclick="changeTab('Directories')" id="Directories">Directories</button>
          <button class="tab-style" onclick="changeTab('Services')" id="Services">Services</button>
        </div>

        <!-- content section -->
        <div id="store-highlight-container" class="content-container" style="border-top: 6px solid #ef4444;">
          <div class="Today-container content active-content">
            <h2 class="seo-header">What's Happening</h2>
            <div id="today-container" class="today-content scroll-smooth snap-x snap-mandatory hide-scrollbar">

              <div class="event-card" style="background-color: #fff;">
                <img
                  src="https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/summer-fest-demo.png"
                  alt="" class="event-image">
                <div class="event-details">
                  <div class="event-header">
                    <p>Event & Activities</p>
                    <h3 class="event-title" style="color: #fca5a5;">Central Summer Fest</h3>
                  </div>
                  <div class="event-info">
                    <p>event hall 2nd floor</p>
                    <p>18 jul 2025 - 27 jul 2025</p>
                  </div>
                  <p class="event-description">Join us for a week of summer fun with activities, food stalls, and live
                    music!</p>
                </div>
              </div>

              <!-- Central -->
              <div class="event-card" style="background-color: #fff;">
                <img
                  src="https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/summer-fest-demo.png"
                  alt="" class="event-image">
                <div class="event-details">
                  <div class="event-header2">
                    <h3 class="event-title" style="color: #ef4444;">Central Summer Fest</h3>
                    <p class="font-central-sang-bleu">Event & Activities</p>
                  </div>
                  <div class="event-info">
                    <p>event hall 2nd floor</p>
                    <p>18 jul 2025 - 27 jul 2025</p>
                  </div>
                  <p class="event-description">Join us for a week of summer fun with activities, food stalls, and live
                    music!</p>
                </div>
              </div>

              <!-- Robinson -->
              <div class="event-card" style="background-color: #4ade80;">
                <img
                  src="https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/summer-fest-demo.png"
                  alt="" class="event-image">
                <div class="event-details">
                  <div class="event-header2" style="color: #fff;">
                    <h3 class="event-title">Central Summer Fest</h3>
                    <p class="font-central-sang-bleu">Event & Activities</p>
                  </div>
                  <div class="event-info">
                    <p>event hall 2nd floor</p>
                    <p>18 jul 2025 - 27 jul 2025</p>
                  </div>
                  <p class="event-description">Join us for a week of summer fun with activities, food stalls, and live
                    music!</p>
                </div>
              </div>

              <button class="carousel-prev prevBtn" onclick="carouselPrev('PROMOTIONS-container')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                  style="width: 1.5rem; height: 1.5rem;">
                  <path fill-rule="evenodd"
                    d="M7.72 12.53a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 1 1 1.06 1.06L9.31 12l6.97 6.97a.75.75 0 1 1-1.06 1.06l-7.5-7.5Z"
                    clip-rule="evenodd"></path>
                </svg>
              </button>

              <button class="carousel-next nextBtn" onclick="carouselNext('PROMOTIONS-container')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                  style="width: 1.5rem; height: 1.5rem;">
                  <path fill-rule="evenodd"
                    d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z"
                    clip-rule="evenodd"></path>
                </svg>
              </button>

            </div>
          </div>

          <div class="Location-container content" style="width: 100%;">
            <h2 class="seo-header">Location</h2>
            <div style="width: 100%; height: auto;">
              <iframe id="map" class="map-iframe"
                src="https://maps.google.com/maps?q=13.816796,100.561667&amp;hl=th&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
                frameborder="0">
              </iframe>
            </div>
          </div>

          <div class="Restaurant-container content" style="width: 100%;">
            <h2 class="seo-header">Restaurant</h2>
            <div class="res-grid">

              <div class="res-card">
                <img class="res-img"
                  src="https://www.central.co.th/adobe/dynamicmedia/deliver/dm-aid--1bdf8525-ba1e-45c8-abfd-2c319d8a7758/shichi-japanese-restaurant.png"
                  alt="">
                <div class="res-details">
                  <p id="res-name-text" class="res-title">Restaurant Name</p>
                  <p id="res-type-text"> <strong>ประเภทอาหาร:</strong> </p>
                  <p id="res-loc-text"> <strong>ที่ตั้ง:</strong> </p>
                  <p id="res-hours-text"> <strong>เวลาเปิด-ปิด:</strong> 10:00 - 22:00</p>
                </div>
              </div>

              <div class="res-card">
                <img class="res-img"
                  src="https://www.central.co.th/adobe/dynamicmedia/deliver/dm-aid--1bdf8525-ba1e-45c8-abfd-2c319d8a7758/shichi-japanese-restaurant.png"
                  alt="">
                <div class="res-details">
                  <p id="res-name-text" class="res-title">Restaurant Name</p>
                  <p id="res-type-text"> <strong>ประเภทอาหาร:</strong> </p>
                  <p id="res-loc-text"> <strong>ที่ตั้ง:</strong> </p>
                  <p id="res-hours-text"> <strong>เวลาเปิด-ปิด:</strong> 10:00 - 22:00</p>
                </div>
              </div>

              <div class="res-card">
                <img class="res-img"
                  src="https://www.central.co.th/adobe/dynamicmedia/deliver/dm-aid--1bdf8525-ba1e-45c8-abfd-2c319d8a7758/shichi-japanese-restaurant.png"
                  alt="">
                <div class="res-details">
                  <p id="res-name-text" class="res-title">Restaurant Name</p>
                  <p id="res-type-text"> <strong>ประเภทอาหาร:</strong> </p>
                  <p id="res-loc-text"> <strong>ที่ตั้ง:</strong> </p>
                  <p id="res-hours-text"> <strong>เวลาเปิด-ปิด:</strong> 10:00 - 22:00</p>
                </div>
              </div>

              <div class="res-card">
                <img class="res-img"
                  src="https://www.central.co.th/adobe/dynamicmedia/deliver/dm-aid--1bdf8525-ba1e-45c8-abfd-2c319d8a7758/shichi-japanese-restaurant.png"
                  alt="">
                <div class="res-details">
                  <p id="res-name-text" class="res-title">Restaurant Name</p>
                  <p id="res-type-text"> <strong>ประเภทอาหาร:</strong> </p>
                  <p id="res-loc-text"> <strong>ที่ตั้ง:</strong> </p>
                  <p id="res-hours-text"> <strong>เวลาเปิด-ปิด:</strong> 10:00 - 22:00</p>
                </div>
              </div>

            </div>
          </div>

          <div class="Directories-container content" style="width: 100%;">
            <h2 class="seo-header">Directories</h2>

            <div class="slide-wrapper">
              <div id="slider" class="slide-container snap-x snap-mandatory hide-scrollbar">
                <div class="slide-item">
                  <img src="" alt="">
                </div>
              </div>

              <div id="dots" class="dot-container">
                <button class="dot active-dot">0</button>
                <button class="dot">1</button>
                <button class="dot">2</button>
                <button class="dot">3</button>
              </div>
            </div>


          </div>

          <div class="Services-container content" style="width: 100%;">
            <h2 class="seo-header">Services</h2>
            <div id="service-grid" class="ser-grid">

              <div class="service-card">
                <img
                  src="https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/BABYSITTER.png"
                  alt="">
                <div class="service-details">
                  <h3 class="service-title">BABYSITTER @CENTRAL KIDS CLUB</h3>
                  <div class="service-desc">
                    <p>Central kids club offers childcare services for children with age 3-12 years old by well-trained
                      staff while you enjoy shopping in our store.</p>
                    <a href="" class="service-tel"><img class="img-tel"
                        src="https://www.central.co.th/content/dam/cds/icons/img-call-now.gif" alt="">
                    </a>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>

<script>
  let slides = [];
  let services = [];
  let usedTabs = [
    'Today',
    'Location',
    'Restaurant',
    'Directories',
    'Services'
  ];
  let lang = "<?php echo $_SESSION['lang_code'] ?? 'en'; ?>";
  let currentStore = localStorage.getItem("currentStore") || "chidlom";

  const serviceTemplates = {
    "babysitter": {
      id: "babysitter",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/BABYSITTER.png",
      name: "BABYSITTER @CENTRAL KIDS CLUB",
      desc: "Central kids club offers childcare services for children with age 3-12 years old by well-trained staff while you enjoy shopping in our store."
    },
    "babystrollers": {
      id: "babystrollers",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/BABY-STROLLERS.png",
      name: "BABY STROLLERS",
      desc: "To make life easier with your little ones, there are baby strollers available. To request a baby stroller, please contact the Customer Services."
    },
    "breastfeeding": {
      id: "breastfeeding",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/BREASTFEEDING.png",
      name: "BREASTFEEDING ROOM",
      desc: "A dedicated breastfeeding room is available to offer you a quiet and comfortable space in the Infant’s Department."
    },
    "giftregistry": {
      id: "giftregistry",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/GIFT-REGISTRY.png",
      name: "CENTRAL GIFT REGISTRY",
      desc: "Central gladly introduces its gift registry services - an easy and effective way to let your guests know what you want on your birthday, wedding, baby showers, and other special occasions."
    },
    "homehotel": {
      id: "homehotel",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/HOME-at-HOTEL.png",
      name: "HOME & HOTEL DELIVERY",
      desc: "Your shopping can be delivered directly to your home or hotel for your convenience free of charge (with a minimum 3,000 Baht same-day, single store purchase)."
    },
    "delivery": {
      id: "delivery",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/INTERNATIONAL-DELIVERY.png",
      name: "INTERNATIONAL DELIVERY",
      desc: "Central provides safe and reliable international delivery service by courier from our stores to your final destination."
    },
    "interpreter": {
      id: "interpreter",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/INTERPRETER.png",
      name: "INTERPRETER",
      desc: "Our interpreters are on hand to assist our international guests. The service is available in English, Mandarin Chinese, Arabic and Russian."
    },
    "eordering": {
      id: "eordering",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/E-ORDERING.png",
      name: "E-ORDERING",
      desc: "If the size or colour that you want is out of stock, we are able to check availability at our other branches and have them transferred for you."
    },
    "muskimprayer": {
      id: "muskimprayer",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/MUSKIM-PRAYER.png",
      name: "MUSLIM PRAYER ROOM",
      desc: "A dedicated prayer room is offered to our Muslim guests."
    },
    "personalshopper": {
      id: "personalshopper",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/PERSONAL-SHOPPER.png",
      name: "PERSONAL SHOPPER SERVICE",
      desc: "Our renowned fashion stylists provide professional advice on attire, make-up, hair styling and accessories….and it's FREE!"
    },
    "porter": {
      id: "porter",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/PORTER.png",
      name: "PORTER SERVICE",
      desc: "Central makes your shopping easier by helping you carry shopping bags to your car boot or BTS Skytrain station."
    },
    "shuttle": {
      id: "shuttle",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/SHUTTLE.png",
      name: "SHUTTLE SERVICE",
      desc: "We offer complimentary shuttle service to Central Department Store (Chidlom Branch)."
    },
    "specialist": {
      id: "specialist",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/SPECIALIST.png",
      name: "THE SPECIALIST @ CENTRAL",
      desc: "Let our trained specialists offer you advice & assistance on lingerie and shoes purchases."
    },
    "vatrefund": {
      id: "vatrefund",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/VAT-REFUND.png",
      name: "VAT REFUND FOR TOURIST",
      desc: "When you spend more than 2,000 Baht in a single day, you are entitled to claim for VAT Refund."
    },
    "wheelchairs": {
      id: "wheelchairs",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/WHEELCHAIRS.png",
      name: "WHEELCHAIR",
      desc: "If you are in need of a wheelchair, please contact store staff near each entrance or the Customer Services."
    }
  };
  const serviceTemplatesTH = {
    "babysitter": {
      id: "babysitter",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/BABYSITTER.png",
      name: "บริการรับเลี้ยงเด็ก @เซ็นทรัล คิดส์คลับ",
      desc: "เซ็นทรัลคิดส์คลับมีบริการรับเลี้ยงเด็กอายุ 3-12 ปี โดยพี่เลี้ยงที่ผ่านการอบรม ให้คุณช้อปปิ้งได้อย่างสบายใจ"
    },
    "babystrollers": {
      id: "babystrollers",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/BABY-STROLLERS.png",
      name: "รถเข็นเด็ก",
      desc: "อำนวยความสะดวกสำหรับครอบครัวที่มีเด็กเล็ก สามารถขอรับรถเข็นเด็กได้ที่จุดบริการลูกค้า"
    },
    "breastfeeding": {
      id: "breastfeeding",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/BREASTFEEDING.png",
      name: "ห้องให้นมบุตร",
      desc: "มีห้องให้นมบุตรโดยเฉพาะ เพื่อความสะดวกและเป็นส่วนตัวสำหรับคุณแม่และลูกน้อย"
    },
    "giftregistry": {
      id: "giftregistry",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/GIFT-REGISTRY.png",
      name: "บริการจดทะเบียนของขวัญ",
      desc: "บริการจดทะเบียนของขวัญสำหรับวันเกิด งานแต่งงาน งานรับขวัญบุตร และโอกาสพิเศษต่าง ๆ"
    },
    "homehotel": {
      id: "homehotel",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/HOME-at-HOTEL.png",
      name: "บริการจัดส่งถึงบ้าน/โรงแรม",
      desc: "บริการจัดส่งสินค้าถึงบ้านหรือโรงแรมฟรี เมื่อซื้อสินค้าครบ 3,000 บาทขึ้นไปในวันเดียวกัน"
    },
    "delivery": {
      id: "delivery",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/INTERNATIONAL-DELIVERY.png",
      name: "บริการจัดส่งระหว่างประเทศ",
      desc: "บริการจัดส่งสินค้าระหว่างประเทศอย่างปลอดภัยและเชื่อถือได้ถึงปลายทางของคุณ"
    },
    "interpreter": {
      id: "interpreter",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/INTERPRETER.png",
      name: "บริการล่ามแปลภาษา",
      desc: "มีล่ามแปลภาษาอังกฤษ จีนกลาง อาหรับ และรัสเซีย คอยให้บริการลูกค้าต่างชาติ"
    },
    "eordering": {
      id: "eordering",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/E-ORDERING.png",
      name: "บริการสั่งสินค้าข้ามสาขา",
      desc: "หากสินค้าที่ต้องการหมดสต็อก สามารถตรวจสอบและสั่งสินค้าจากสาขาอื่นได้"
    },
    "muskimprayer": {
      id: "muskimprayer",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/MUSKIM-PRAYER.png",
      name: "ห้องละหมาดมุสลิม",
      desc: "มีห้องละหมาดสำหรับลูกค้ามุสลิมโดยเฉพาะ"
    },
    "personalshopper": {
      id: "personalshopper",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/PERSONAL-SHOPPER.png",
      name: "บริการผู้ช่วยช้อปส่วนตัว",
      desc: "มีผู้เชี่ยวชาญด้านแฟชั่นให้คำแนะนำเรื่องการแต่งกาย เมคอัพ ทรงผม และเครื่องประดับ ฟรี!"
    },
    "porter": {
      id: "porter",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/PORTER.png",
      name: "บริการพนักงานยกของ",
      desc: "ช่วยยกถุงช้อปปิ้งไปยังรถยนต์หรือสถานีรถไฟฟ้า BTS เพื่อความสะดวกของคุณ"
    },
    "shuttle": {
      id: "shuttle",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/SHUTTLE.png",
      name: "บริการรถรับ-ส่ง",
      desc: "มีบริการรถรับ-ส่งฟรีไปยังเซ็นทรัลดีพาร์ทเม้นท์สโตร์ (สาขาชิดลม)"
    },
    "specialist": {
      id: "specialist",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/SPECIALIST.png",
      name: "ผู้เชี่ยวชาญเฉพาะด้าน",
      desc: "มีผู้เชี่ยวชาญให้คำแนะนำและช่วยเหลือในการเลือกซื้อชุดชั้นในและรองเท้า"
    },
    "vatrefund": {
      id: "vatrefund",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/VAT-REFUND.png",
      name: "บริการคืนภาษีมูลค่าเพิ่ม (VAT Refund)",
      desc: "เมื่อซื้อสินค้าครบ 2,000 บาทขึ้นไปใน 1 วัน สามารถขอคืนภาษีมูลค่าเพิ่มได้"
    },
    "wheelchairs": {
      id: "wheelchairs",
      img: "https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/images/store/service/WHEELCHAIRS.png",
      name: "บริการรถเข็นผู้พิการ",
      desc: "หากต้องการใช้รถเข็น กรุณาติดต่อพนักงานใกล้ทางเข้า หรือจุดบริการลูกค้า"
    }
  };
  const usedServices = lang === "th" ? serviceTemplatesTH : serviceTemplates;
  const copyBtn = document.getElementById("copyBtn");
  const ignoreStartDateCheckbox = document.getElementById("ignore-start-date");
  const CentralMap = [{
      name: "เซ็นทรัล ชิดลม",
      latitude: 13.7446,
      longitude: 100.5442
    },
    {
      name: "เซ็นทรัล สีลม คอมเพล็กซ์",
      latitude: 13.7266441,
      longitude: 100.5305863,
    },
    {
      name: "เซ็นทรัล ลาดพร้าว",
      latitude: 13.816944,
      longitude: 100.56
    },
    {
      name: "เซ็นทรัล รามอินทรา",
      latitude: 13.872283,
      longitude: 100.602004
    },
    {
      name: "เซ็นทรัล ฟิวเจอร์ ปาร์ค รังสิต",
      latitude: 13.989444,
      longitude: 100.618057
    },
    {
      name: "เซ็นทรัล ปิ่นเกล้า",
      latitude: 13.7785,
      longitude: 100.4766
    },
    {
      name: "เซ็นทรัลเวิลด์",
      latitude: 13.746944,
      longitude: 100.539719
    },
    {
      name: "เซ็นทรัล บางนา",
      latitude: 13.6684,
      longitude: 100.6344
    },
    {
      name: "เซ็นทรัล พระราม 2",
      latitude: 13.663395,
      longitude: 100.438031
    },
    {
      name: "เซ็นทรัล พระราม 3",
      latitude: 13.6976,
      longitude: 100.5378
    },
    {
      name: "เซ็นทรัล ภูเก็ต",
      latitude: 7.8920431,
      longitude: 98.3649044,
    },
    {
      name: "เซ็นทรัล แจ้งวัฒนะ",
      latitude: 13.9038425,
      longitude: 100.525576,
    },
    {
      name: "เซ็นทรัล พัทยา",
      latitude: 12.927608,
      longitude: 100.877083,
    },
    {
      name: "เซ็นทรัล เชียงใหม่",
      latitude: 18.769236,
      longitude: 98.975721,
    },
    {
      name: "เซ็นทรัล หาดใหญ่",
      latitude: 13.72264,
      longitude: 100.52931,
    },
    {
      name: "เซ็นทรัล สมุย",
      latitude: 9.53223,
      longitude: 100.0583381,
    },
    {
      name: "เซ็นทรัล ศาลายา",
      latitude: 13.786693,
      longitude: 100.27583
    },
    {
      name: "เซ็นทรัล เวสต์เกต",
      latitude: 13.8764725,
      longitude: 100.4115431,
    },
    {
      name: "เซ็นทรัล อีสต์วิลล์",
      latitude: 13.8034041,
      longitude: 100.6115021,
    },
    {
      name: "เซ็นทรัล โคราช",
      latitude: 14.9973807,
      longitude: 102.1131134,
    },
    {
      name: "เซ็นทรัล บางรัก",
      latitude: 13.729008,
      longitude: 100.529716,
    },
    {
      name: "เซ็นทรัล ขอนแก่น",
      latitude: 16.432604,
      longitude: 102.825183
    },
    {
      name: "เซ็นทรัล เมกาบางนา",
      latitude: 13.648608,
      longitude: 100.679807
    },
    {
      name: "เซ็นทรัล อุดรธานี",
      latitude: 17.405827,
      longitude: 102.79979
    },
    {
      name: "เซ็นทรัล ป่าตอง",
      latitude: 7.8925024,
      longitude: 98.2950178,
    },
    {
      name: "เซ็นทรัล เวสต์วิลล์",
      latitude: 13.804418,
      longitude: 100.4463808,
    },
    {
      name: "เซ็นทรัล นครสวรรค์",
      latitude: 15.7027318,
      longitude: 100.1147484,
    },
    {
      name: "เซ็นทรัล นครปฐม",
      latitude: 13.8055,
      longitude: 100.0485
    }
  ];
  const RobinsonMap = [{
      name: "โรบินสัน ฟิวเจอร์พาร์ค รังสิต",
      latitude: 13.9902158,
      longitude: 100.6165899
    },
    {
      name: "โรบินสัน ศรีราชา",
      latitude: 13.168363,
      longitude: 100.9308755
    },
    {
      name: "โรบินสัน พระนครศรีอยุธยา 2 (เซ็นทรัล อยุธยา)",
      latitude: 14.3315429,
      longitude: 100.6112557
    },
    {
      name: "โรบินสัน ชลบุรี",
      latitude: 13.2004448,
      longitude: 100.8599312
    },
    {
      name: "โรบินสัน สุขุมวิท",
      latitude: 13.7379627,
      longitude: 100.5595224
    },
    {
      name: "โรบินสันไลฟ์สไตล์ ตรัง",
      latitude: 7.5637278,
      longitude: 99.6263744
    },
    {
      name: "โรบินสัน เชียงราย",
      latitude: 19.8859539,
      longitude: 99.8326379
    },
    {
      name: "โรบินสัน พิษณุโลก",
      latitude: 16.8411807,
      longitude: 100.2320876
    },
    {
      name: "โรบินสัน พระราม 9",
      latitude: 13.7592408,
      longitude: 100.5664699
    },
    {
      name: "โรบินสันไลฟ์สไตล์ สุพรรณบุรี",
      latitude: 14.4577582,
      longitude: 100.1299222
    },
    {
      name: "โรบินสัน สุราษฎร์ธานี",
      latitude: 9.1117142,
      longitude: 99.301439
    },
    {
      name: "โรบินสัน ลำปาง",
      latitude: 18.2820235,
      longitude: 99.4938196
    },
    {
      name: "โรบินสันไลฟ์สไตล์ กาญจนบุรี",
      latitude: 14.0225725,
      longitude: 99.5532237
    },
    {
      name: "Robinson Ubon Ratchathani",
      latitude: 15.2409943,
      longitude: 104.8232781
    },
    {
      name: "โรบินสันไลฟ์สไตล์ สกลนคร",
      latitude: 17.1781793,
      longitude: 104.1195843
    },
    {
      name: "โรบินสัน ไลฟ์สไตล์ สระบุรี",
      latitude: 14.5405086,
      longitude: 100.9488782
    },
    {
      name: "โรบินสันไลฟ์สไตล์ สุรินทร์",
      latitude: 14.8760076,
      longitude: 103.532759
    },
    {
      name: "โรบินสันไลฟ์สไตล์ ฉะเชิงเทรา",
      latitude: 13.6679113,
      longitude: 101.0485104
    },
    {
      name: "โรบินสันไลฟ์สไตล์ ร้อยเอ็ด",
      latitude: 16.0605374,
      longitude: 103.6179212
    },
    {
      name: "โรบินสันไลฟ์สไตล์ สมุทรปราการ",
      latitude: 13.583549,
      longitude: 100.6095619
    },
    {
      name: "โรบินสันไลฟ์สไตล์ ปราจีนบุรี",
      latitude: 14.0589108,
      longitude: 101.3959336
    },
    {
      name: "โรบินสันไลฟ์สไตล์ มุกดาหาร",
      latitude: 16.5692569,
      longitude: 104.7194567
    },
    {
      name: "โรบินสัน ระยอง",
      latitude: 12.6960138,
      longitude: 101.2684318
    },
    {
      name: "โรบินสันไลฟ์สไตล์ บุรีรัมย์",
      latitude: 14.9728833,
      longitude: 103.0611894
    },
    {
      name: "โรบินสันไลฟ์สไตล์ ศรีสมาน",
      latitude: 13.9403604,
      longitude: 100.5534668
    },
    {
      name: "โรบินสันไลฟ์สไตล์ แม่สอด",
      latitude: 16.72269,
      longitude: 98.5838775
    },
    {
      name: "โรบินสันไลฟ์สไตล์ ลพบุรี",
      latitude: 14.7752199,
      longitude: 100.6927337
    },
    {
      name: "โรบินสันไลฟ์สไตล์ เพชรบุรี",
      latitude: 13.0634013,
      longitude: 99.9465404
    },
    {
      name: "โรบินสัน มหาชัย",
      latitude: 13.5718878,
      longitude: 100.2865096
    },
    {
      name: "โรบินสันไลฟ์สไตล์ กำแพงเพชร",
      latitude: 16.4758708,
      longitude: 99.5493822
    },
    {
      name: "โรบินสันไลฟ์สไตล์ ชลบุรี",
      latitude: 13.2236422,
      longitude: 100.8419654
    },
    {
      name: "โรบินสัน โอเชี่ยน นครศรีธรรมราช",
      latitude: 8.4373277,
      longitude: 99.9696324
    },
    {
      name: "โรบินสัน หาดใหญ่",
      latitude: 7.002902,
      longitude: 100.4687144
    },
    {
      name: "โรบินสัน เชียงใหม่ แอร์พอร์ต",
      latitude: 18.7688771,
      longitude: 98.9762897
    },
    {
      name: "โรบินสันไลฟ์สไตล์ ราชบุรี",
      latitude: 13.5341871,
      longitude: 99.8117662
    },
    {
      name: "โรบินสัน ไลฟ์สไตล์ จันทบุรี",
      latitude: 12.5998346,
      longitude: 102.1156746
    },
    {
      name: "ท็อปส์ พลาซา & โรบินสัน พะเยา",
      latitude: 19.1852983,
      longitude: 99.8915285
    },
    {
      name: "โรบินสัน โอเชี่ยน นครศรีธรรมราช",
      latitude: 8.437333,
      longitude: 99.9670575
    },
    {
      name: "โรบินสันไลฟ์สไตล์ ชัยภูมิ",
      latitude: 15.7870726,
      longitude: 102.030777
    },
    {
      name: "โรบินสันไลฟ์สไตล์ ลาดกระบัง",
      latitude: 13.7199886,
      longitude: 100.7249462
    },
    {
      name: "โรบินสันไลฟ์สไตล์ บ่อวิน",
      latitude: 13.0403771,
      longitude: 101.0826751
    },
    {
      name: "โรบินสัน จังซีลอน",
      latitude: 7.8906922,
      longitude: 98.3001682
    },
    {
      name: "โรบินสันไลฟ์สไตล์ บ้านฉาง",
      latitude: 12.7388404,
      longitude: 101.0809014
    },
    {
      name: "โรบินสันไลฟ์สไตล์ ถลาง",
      latitude: 7.9808329,
      longitude: 98.3622201
    }
  ];
  let selectField = document.getElementById("store-select");
  selectField.addEventListener("input", () => {
    console.log(selectField.value);
    let latitude = document.getElementById('latitude');
    let longitude = document.getElementById('longitude');

    // ตรวจสอบว่าเลือกค่าที่ถูกต้องหรือยัง
    if (selectField.value) {
      const [lat, long] = selectField.value.split(":");
      latitude.value = lat || "";
      longitude.value = long || "";
    } else {
      latitude.value = "";
      longitude.value = "";
    }

    updateMap();
  });

  function toggleService(serviceKey) {
    const all = document.getElementById('service-all')
    const checkbox = document.getElementById(`service-${serviceKey}`);

    // หา index ใน services โดยเช็ค id
    const existingIndex = services.findIndex(s => s.id === serviceKey);

    if (checkbox.checked) {
      if (existingIndex === -1 && usedServices[serviceKey]) {
        services.push(usedServices[serviceKey]);
      }
    } else {
      if (existingIndex !== -1) {
        services.splice(existingIndex, 1);
      }
    }

    // ตรวจว่าทุก service ถูกเช็คหรือไม่ เพื่ออัปเดต checkbox "เลือกทั้งหมด"
    const serviceKeys = Object.keys(usedServices).filter(key => key !== 'all');
    const allChecked = serviceKeys.every(key => {
      const input = document.getElementById(`service-${key}`);
      return input && input.checked;
    });

    document.getElementById('service-all').checked = allChecked;

    // console.log("Current services:", services);
    renderServices();
  }

  function toggleAllServices(allCheckbox) {
    const isChecked = allCheckbox.checked;

    const serviceKeys = Object.keys(usedServices).filter(key => key !== 'all');
    services = []; // เคลียร์ก่อน แล้วจะ push ตาม checkbox ที่ติ๊ก

    serviceKeys.forEach(key => {
      const input = document.getElementById(`service-${key}`);
      if (input) {
        input.checked = isChecked;

        if (isChecked && usedServices[key]) {
          services.push(usedServices[key]);
        }
      }
    });

    renderServices();
  }

  async function importHTML() {
    const textarea = document.getElementById("import-code");
    const html = textarea.value;
    const temp = document.createElement("div");
    temp.innerHTML = html;

    const Map = temp.querySelector("#map");
    const Dir = temp.querySelector("#slider");
    const Ser = temp.querySelector("#service-grid");
    const Today = temp.querySelector("#today-container");
    const Restaurant = temp.querySelector("#res-grid");

    textarea.value = "";
    // ✅ รอทุกฟังก์ชันทำงานเสร็จ
    await Promise.all([
      extractMap(Map),
      extractDir(Dir),
      extractService(Ser),
      extractTodayEvent(Today),
      extractRestaurant(Restaurant),
    ]);

    // ✅ แสดงผลลัพธ์
    alert("✅ Import และแสดงผลทั้งหมดเสร็จสมบูรณ์แล้ว!");

  }

  function extractMap(map) {
    return new Promise((resolve) => {
      if (!map) {
        console.warn("ไม่พบ Map");
        return resolve();
      }
      let latitude = document.getElementById('latitude');
      let longitude = document.getElementById('longitude');

      const lat = map.getAttribute("data-latitude");
      const long = map.getAttribute("data-longitude");

      latitude.value = lat || "";
      longitude.value = long || "";
      updateMap();
      resolve();
    });
  }

  function extractDir(dir) {
    return new Promise((resolve) => {
      if (!dir) {
        console.warn("ไม่พบ #slider");
        return resolve();
      }
      const imgs = dir.querySelectorAll("img");
      imgs.forEach((img) => {
        slides.push(img.src);
      });
      addDir(false, true); // skipButtons = true, isImport = true
      resolve();
    });
  }

  function extractService(ser) {
    return new Promise((resolve) => {
      if (!ser) {
        console.warn("ไม่พบ service");
        return resolve();
      }

      const serviceElems = ser.querySelectorAll(".service-card");
      const serviceData = Array.from(serviceElems).map(service => {
        return {
          img: service.querySelector("#service-image")?.src || "",
          name: service.querySelector("#service-name")?.textContent || "",
          desc: service.querySelector("#service-desc")?.textContent || "",
        };
      });

      services = serviceData;
      renderServices(false); // skipButtons = true
      resolve();
    });
  }

  function toggleBrand(brand) {
    const centralBtn = document.getElementById("centralBtn");
    const robinsonBtn = document.getElementById("robinsonBtn");
    const chidlomBtn = document.getElementById("chidlomBtn");
    const bottomContainer = document.getElementById("store-highlight-container")

    const brandStyles = {
      chidlom: {
        btn: ["bg-red-300", "text-white"],
        inactiveBtn: ["bg-gray-300", "text-gray-800"],
        borderColor: "6px solid #ef4444",
      },
      central: {
        btn: ["bg-red-500", "text-white"],
        inactiveBtn: ["bg-gray-300", "text-gray-800"],
        borderColor: "6px solid #ef4444",
      },
      robinson: {
        btn: ["bg-emerald-500", "text-white"],
        inactiveBtn: ["bg-gray-300", "text-gray-800"],
        borderColor: "6px solid #4ade80",
      },
    };

    if (brand === "central") {
      centralBtn.classList.add(...brandStyles.central.btn);
      centralBtn.classList.remove(...brandStyles.central.inactiveBtn);

      robinsonBtn.classList.add(...brandStyles.robinson.inactiveBtn);
      robinsonBtn.classList.remove(...brandStyles.robinson.btn);

      chidlomBtn.classList.add(...brandStyles.chidlom.inactiveBtn);
      chidlomBtn.classList.remove(...brandStyles.chidlom.btn);

      bottomContainer.style.borderTop = `6px solid ${brandStyles.central.borderColor}`;


    } else if (brand === "robinson") {
      robinsonBtn.classList.add(...brandStyles.robinson.btn);
      robinsonBtn.classList.remove(...brandStyles.robinson.inactiveBtn);

      centralBtn.classList.add(...brandStyles.central.inactiveBtn);
      centralBtn.classList.remove(...brandStyles.central.btn);

      chidlomBtn.classList.add(...brandStyles.chidlom.inactiveBtn);
      chidlomBtn.classList.remove(...brandStyles.chidlom.btn);

      bottomContainer.style.borderTop = `6px solid ${brandStyles.robinson.borderColor}`;

    } else if (brand === "chidlom") {
      centralBtn.classList.add(...brandStyles.central.inactiveBtn);
      centralBtn.classList.remove(...brandStyles.central.btn);

      robinsonBtn.classList.add(...brandStyles.robinson.inactiveBtn);
      robinsonBtn.classList.remove(...brandStyles.robinson.btn);

      chidlomBtn.classList.add(...brandStyles.chidlom.btn);
      chidlomBtn.classList.remove(...brandStyles.chidlom.inactiveBtn);

      bottomContainer.style.borderTop = `6px solid ${brandStyles.chidlom.borderColor}`;

    }

    if (brand === "central") {
      createOptions(CentralMap)
      createStoreOptions(CdsOptions)

    } else if (brand === "robinson") {
      createOptions(RobinsonMap)
      createStoreOptions(RbsOptions)

    } else if (brand === "chidlom") {
      createStoreOptions(ChidlomOptions);
    }

    currentStore = brand;
    localStorage.setItem("currentStore", brand);
    renderEvent();
  }

  function createOptions(mapLists) {
    let selectField = document.getElementById("store-select");
    let newOptions = '<option disabled selected>-- Pick a Store --</option>';
    mapLists.forEach((item, index) => {
      const lat = item.latitude ?? '';
      const long = item.longitude ?? '';
      const disabled = (lat === '' || long === '') ? 'disabled' : '';
      newOptions += `<option value="${lat}:${long}" ${disabled}>${item.name}</option>`;
    });
    selectField.innerHTML = newOptions;
  }

  function activeTab(eleId) {
    /*Active Tab manage*/
    const active = document.getElementById(eleId + "-tab");
    const lastActive = document.querySelector(".tab-active");
    if (lastActive) lastActive.classList.remove("tab-active");
    active.classList.add("tab-active")

    /*Field Active*/
    const allFieldset = document.querySelector(".active");
    if (allFieldset) {
      allFieldset.classList.add("hidden");
      allFieldset.classList.remove("active");
      allFieldset.classList.remove("fieldset");
    }

    const activeField = document.getElementById(`${eleId}-fieldset`);
    if (activeField) {
      activeField.classList.remove("hidden");
      activeField.classList.add("active");
      activeField.classList.add("fieldset");
    }
    changeTab(eleId);
  }

  function changeTab(tabId) {
    const tabs = document.querySelectorAll('.tab-style');
    const contents = document.querySelectorAll('.content');

    tabs.forEach(tab => {
      tab.classList.remove('active-tab');
    });

    contents.forEach(content => {
      content.classList.remove('active-content');
    });

    document.getElementById(tabId).classList.add('active-tab');
    document.querySelector(`.${tabId}-container`).classList.add('active-content');
  }

  function updateMap() {
    let latitude = document.getElementById('latitude');
    let longitude = document.getElementById('longitude');
    const Map = document.getElementById('map');

    const lat = parseFloat(latitude.value);
    const long = parseFloat(longitude.value);

    // ✅ Validate: ต้องเป็นตัวเลข และอยู่ในช่วง lat [-90, 90], long [-180, 180]
    if (
      isNaN(lat) || isNaN(long) ||
      lat < -90 || lat > 90 ||
      long < -180 || long > 180
    ) {
      alert("❌ Latitude หรือ Longitude ไม่ถูกต้อง");
      return;
    }

    Map.setAttribute("data-latitude", lat);
    Map.setAttribute("data-longitude", long);
    Map.src = `https://maps.google.com/maps?q=${lat},${long}&hl=th&t=&z=15&ie=UTF8&iwloc=&output=embed`;

    latitude.value = '';
    longitude.value = '';
  }

  function addDir(skipButtons = false, isImport = false) {
    const imgInput = document.getElementById("directory-image-url");
    const slideContainer = document.getElementById("slider");
    const dotBtnContainer = document.getElementById("dot-btn");
    const img = imgInput.value.trim();

    // ✅ Validate URL ก่อน (เฉพาะกรณีไม่ใช่ import)
    if (!isImport) {
      const isValidImage = /^https?:\/\/.*\.(jpg|jpeg|png|webp|gif|svg)$/i.test(img);
      if (!img || !isValidImage) {
        alert("❌ กรุณาใส่ลิงก์รูปภาพที่ถูกต้อง (.jpg, .png, .webp, .gif, .svg)");
        return;
      }

      // เก็บ slide URL ใน array
      if (!slides) slides = [];
      slides.push(img);
    }

    // ✅ Render สไลด์
    let slideHTML = '';
    let dotHTML = '';
    slides.forEach((slide, index) => {
      if (!skipButtons) {
        slideHTML += `
        <div class="slide-item">
          <img src="${slide}" alt="Floor ${index + 1}" />
          <div class="absolute flex gap-1 top-2 right-2">
            <button onclick="editDir(${index})" class="px-2 py-1 text-sm bg-yellow-400 rounded">✏️</button>
            <button onclick="deleteDir(${index})" class="px-2 py-1 text-sm text-white bg-red-500 rounded">🗑</button>
          </div>  
        </div>
      `;
        dotHTML += `<button class="dot">${index + 1}</button>`;
      } else {
        slideHTML += `
        <div class="slide-item">
          <img src="${slide}" alt="Floor ${index + 1}" />
        </div>`;
        dotHTML += `<button class="dot">${index + 1}</button>`;
      }
    });

    // ใส่ใน DOM
    slideContainer.innerHTML = slideHTML;
    dotBtnContainer.innerHTML = dotHTML;

    // เคลียร์ input
    imgInput.value = '';
    initSlider();
  }

  function deleteDir(index) {
    slides.splice(index, 1);
    addDirRender(); // render ใหม่
  }

  function editDir(index) {
    const image = slides[index].url;
    document.getElementById("directory-image-url").value = image;

    slides.splice(index, 1);
    addDirRender(); // render ใหม่
  }

  function renderServices(skipButtons = false) {
    const container = document.getElementById("service-grid");
    const tel = document.getElementById("service-tel").value;

    container.innerHTML = ""; // เคลียร์ก่อน render ใหม่

    let html = "";
    services.forEach((service, index) => {
      html += `
      <div class="service-card">
        <img id="service-image" src="${service.img}" alt="${service.name}">
        <div class="service-details">
          <h3 id="service-name" class="service-title">${service.name}</h3>
          <div class="service-desc">
            <p id="service-desc">${service.desc}</p>
            <a href="tel:${tel}" class="service-tel"><img class="img-tel" src="https://www.central.co.th/content/dam/cds/icons/img-call-now.gif"></a>
          </div>
        </div>
        ${!skipButtons ? `
          <div class="absolute flex gap-2 top-2 right-2">
            <button onclick="editService(${index})" class="px-2 py-1 text-sm bg-yellow-400 rounded">✏️</button>
            <button onclick="deleteService(${index})" class="px-2 py-1 text-sm text-white bg-red-500 rounded">🗑</button>
          </div>
        ` : ""}
      </div>
    `;
    });

    container.innerHTML = html;
  }

  function clearServiceInputs() {
    document.getElementById("service-name").value = "";
    document.getElementById("service-image-url").value = "";
    document.getElementById("service-desc").value = "";
  }

  function addService() {
    const name = document.getElementById("service-name");
    const img = document.getElementById("service-image-url");
    const desc = document.getElementById("service-desc");

    const nameVal = name.value.trim();
    const imgVal = img.value.trim();
    const descVal = desc.value.trim();

    // ✅ ตรวจสอบว่าช่องใดว่างบ้าง
    if (!nameVal || !imgVal || !descVal) {
      alert("❌ กรุณากรอกข้อมูลให้ครบทุกช่อง (ชื่อ, รูปภาพ, รายละเอียด)");
      return;
    }

    // ✅ ตรวจสอบว่าเป็นลิงก์รูปภาพที่ถูกต้องหรือไม่
    const isValidImage = /^https?:\/\/.*\.(jpg|jpeg|png|webp|gif|svg)$/i.test(imgVal);
    if (!isValidImage) {
      alert("❌ กรุณาใส่ URL รูปภาพที่ถูกต้อง (.jpg, .png, .webp, .gif, .svg)");
      img.classList.add("border", "border-red-500");
      return;
    }
    img.classList.remove("border", "border-red-500");

    const data = {
      name: nameVal,
      img: imgVal,
      desc: descVal,
    };

    if (editingIndex !== null) {
      services[editingIndex] = data;
      editingIndex = null;
    } else {
      services.push(data);
    }

    renderServices();
    clearServiceInputs();
  }

  function copyCode() {
    /* Today */
    if (usedTabs.includes('Today') && cardsData.length > 0) {
      renderEvent(true, ignoreStartDateCheckbox.checked);
    }
    /* Directories */
    if (usedTabs.includes('Directories') && slides.length > 0) {
      addDir(true, true);
    }
    /* Services */
    if (usedTabs.includes('Services') && services.length > 0) {
      renderServices(true);
    }
    /* Restaurant */
    if (usedTabs.includes('Restaurant') && restaurantList.length > 0) {
      renderRestaurant(true);
    }

    console.log(usedTabs);

    let previewContainer = document.getElementById("preview-container");
    const code = previewContainer.innerHTML;
    const completeCode = `
    <link rel="stylesheet" href="https://prod-assets.central.co.th/file-assets/assets/CMS/evm/assets/css/Highlight.css">
    ${code}
    <script>
      function changeTab(tabId) {
        const tabs = document.querySelectorAll('.tab-style');
        const contents = document.querySelectorAll('.content');

        tabs.forEach(tab => {
          tab.classList.remove('active-tab');
        });

        contents.forEach(content => {
          content.classList.remove('active-content');
        });

        document.getElementById(tabId).classList.add('active-tab');
        document.querySelector('.'+tabId+'-container').classList.add('active-content');
      }

      function carouselNext(eleId) {
        const carousel = document.getElementById(eleId);
        if (!carousel) return;
        const item = carousel.querySelector("div");
        const itemWidth = item?.offsetWidth || 300;
        const gap = parseInt(window.getComputedStyle(carousel).gap) || 8;
        carousel.scrollBy({ left: itemWidth + gap, behavior: "smooth" });
      }

      function carouselPrev(eleId) {
        const carousel = document.getElementById(eleId);
        if (!carousel) return;
        const item = carousel.querySelector("div");
        const itemWidth = item?.offsetWidth || 300;
        const gap = parseInt(window.getComputedStyle(carousel).gap) || 8;
        carousel.scrollBy({ left: -(itemWidth + gap) * 4, behavior: "smooth" });
      }

      document.addEventListener("load", function () {
        const now = new Date();
        const promotionItems = document.querySelectorAll('#today-container > div');

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

      window.addEventListener("load", () => {
        changeTab("${usedTabs[0]}");
        initSlider();
      })
    <\/script>
    <script>
      function initSlider() {
        const slider = document.getElementById("slider");
        const dots = document.querySelectorAll(".dot");
        const slides = slider.querySelectorAll(".slide-item");
        let currentIndex = 0;
        let intervalId;
        const isDesktop = window.innerWidth >= 1024;

        function scrollToIndex(index) {
          const scrollAmount = slides[index].offsetLeft;
          slider.scrollTo({ left: scrollAmount, behavior: "smooth" });
          currentIndex = index;
        }

        function autoScroll() {
          currentIndex = (currentIndex + 1) % slides.length;
          scrollToIndex(currentIndex);
        }

        function startAutoSlide() {
          intervalId = setInterval(autoScroll, 5000);
        }

        function stopAutoSlide() {
          clearInterval(intervalId);
        }

        dots.forEach((dot, index) => {
          dot.addEventListener("click", () => {
            scrollToIndex(index);
            if (isDesktop) {
              stopAutoSlide();
              startAutoSlide();
            }
          });
        });

        slider.addEventListener("mouseenter", () => {
          if (isDesktop) stopAutoSlide();
        });
        slider.addEventListener("mouseleave", () => {
          if (isDesktop) startAutoSlide();
        });

        scrollToIndex(0);
        if (isDesktop) startAutoSlide();
      }

      
    <\/script>
    `;

    navigator.clipboard
      .writeText(completeCode)
      .then(() => {
        const originalText = copyBtn.textContent;
        copyBtn.textContent = "✓ Copied!";
        setTimeout(() => {
          copyBtn.textContent = originalText;
          renderEvent(); // Restore with buttons
        }, 2000);
      })
      .catch((err) => {
        alert("Failed to copy code: " + err);
      });
  }

  let TodayTemp = '';
  let ServiceTemp = '';
  let RestaurantTemp = '';
  let MapTemp = '';
  let DirTemp = '';


  function hideTab(eleId) {
    // check from check box
    const tab = document.querySelector(`#${eleId}.tab-style`);
    const container = document.querySelector(`.${eleId}-container`);
    const checkbox = document.getElementById(`${eleId}-checkbox`);
    if (!checkbox.checked) {
      tab.style.display = "none";
      switch (eleId) {
        case 'Today':
          TodayTemp = container.innerHTML;
          container.innerHTML = '';
          break;
        case 'Directories':
          DirTemp = container.innerHTML;
          container.innerHTML = '';
          break;
        case 'Services':
          ServiceTemp = container.innerHTML;
          container.innerHTML = '';
          break;
        case 'Restaurant':
          RestaurantTemp = container.innerHTML;
          container.innerHTML = '';
          break;
        case 'Map':
          MapTemp = container.innerHTML;
          container.innerHTML = '';
          break;
      }
      usedTabs = usedTabs.filter(id => id !== eleId);
    } else {
      tab.style.display = "block";
      switch (eleId) {
        case 'Today':
          container.innerHTML = TodayTemp;
          renderEvent(); // Restore with buttons
          break;
        case 'Directories':
          container.innerHTML = DirTemp;
          addDir(false, true); // skipButtons = true, isImport = true
          break;
        case 'Services':
          container.innerHTML = ServiceTemp;
          renderServices(false); // skipButtons = true
          break;
        case 'Restaurant':
          container.innerHTML = RestaurantTemp;
          renderRestaurant(false); // skipButtons = true
          break;
        case 'Map':
          container.innerHTML = MapTemp;
          updateMap();
          break;
      }
      if (!usedTabs.includes(eleId)) {
        usedTabs.push(eleId);
      }
    }
    console.log(usedTabs);
  }

  function deleteService(index) {
    services.splice(index, 1);
    renderServices(); // render ใหม่
  }

  function editService(index) {
    const service = services[index];
    console.log(service)
    document.getElementById("service-name").value = service.name;
    document.getElementById("service-image-url").value = service.img;
    document.getElementById("service-desc").value = service.desc;

    services.splice(index, 1);
    editingIndex = index;
    renderServices(); // render ใหม่
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


  window.addEventListener("load", () => {
    createStoreOptions(ChidlomOptions);
    createOptions(CentralMap);
    toggleBrand(currentStore);
    activeTab("Today");
  });
</script>

<!-- Restaurant Script -->
<script>
  let restaurantList = [];
  let restaurantEditingIndex = null;
  const restaurantContainer = document.getElementById("res-grid");

  function addRestaurant() {
    const name = document.getElementById("res-name").value.trim();
    const img = document.getElementById("res-url").value.trim();
    const foodType = document.getElementById("res-type").value.trim();
    const loc = document.getElementById("res-loc").value.trim();
    const start = document.getElementById("res-start").value.trim();
    const end = document.getElementById("res-end").value.trim();

    const newData = {
      name: name,
      img: img,
      type: foodType,
      loc: loc,
      start: start,
      end: end
    };

    if (restaurantEditingIndex !== null) {
      // แทรกข้อมูลใหม่โดยไม่ลบของเดิม
      restaurantList.splice(restaurantEditingIndex, 0, newData);
      restaurantEditingIndex = null;
    } else {
      restaurantList.push(newData);
    }
    clearRestaurantInputs();
    renderRestaurant();
  }

  function renderRestaurant(skipButtons = false) {
    restaurantContainer.innerHTML = "";
    restaurantList.forEach((res, index) => {
      const resCard = document.createElement('div');
      resCard.className = "res-card";
      resCard.setAttribute("data-index", index);
      resCard.innerHTML = `
        <img id="res-image"
             src="${res.img}"
             alt="${res.name}" 
             class="res-img"
        />
        <div class="res-details">
          <h3 id="res-name" class="res-title">${res.name}</h3>
            <p id="res-type"> <strong>${lang === 'th' ? 'ประเภทอาหาร':'Food Type'}:</strong> ${res.type} </p>
            <p id="res-loc"> <strong>${lang === 'th' ? 'ที่ตั้ง':'Locations'}:</strong> ${res.loc} </p>
            <p id="res-hours"> <strong>${lang === 'th' ? 'เวลาเปิด-ปิด':'Open Hours'}:</strong> ${res.start} - ${res.end} </p>
        </div>
      `;

      if (!skipButtons) {
        const btnGroup = document.createElement("div");
        btnGroup.className =
          "flex justify-end px-2 gap-2 pb-2 absolute top-2 right-2 z-20";
        btnGroup.innerHTML = `
            <button onclick="editRes(${index})" class="px-2 py-1 text-sm bg-yellow-400 rounded">✏️</button>
            <button onclick="deleteRes(${index})" class="px-2 py-1 text-sm text-white bg-red-500 rounded">🗑</button>
        `;
        resCard.appendChild(btnGroup);
      }
      restaurantContainer.appendChild(resCard);
    });
  }

  function editRes(index) {
    const res = restaurantList[index];
    document.getElementById("res-name").value = res.name;
    document.getElementById("res-url").value = res.img;
    document.getElementById("res-type").value = res.type;
    document.getElementById("res-loc").value = res.loc;
    document.getElementById("res-start").value = res.start;
    document.getElementById("res-end").value = res.end;

    restaurantList.splice(index, 1);
    restaurantEditingIndex = index;
    renderRestaurant(); // render ใหม่
  }

  function deleteRes(index) {
    restaurantList.splice(index, 1);
    renderRestaurant(); // render ใหม่
  }

  function clearRestaurantInputs() {
    document.getElementById("res-name").value = "";
    document.getElementById("res-url").value = "";
    document.getElementById("res-type").value = "";
    document.getElementById("res-loc").value = "";
    document.getElementById("res-start").value = "";
    document.getElementById("res-end").value = "";
  }

  function extractRestaurant(resContainer) {
    return new Promise((resolve) => {
      if (!resContainer) {
        console.warn("ไม่พบ Restaurant");
        return resolve();
      }

      const resElems = resContainer.querySelectorAll(".res-card");
      const resData = Array.from(resElems).map(res => {
        return {
          img: res.querySelector("#res-image")?.src || "",
          name: res.querySelector("#res-name")?.textContent || "",
          type: res.querySelector("#res-type")?.textContent || "",
          loc: res.querySelector("#res-loc")?.textContent || "",
          start: res.querySelector("#res-hours")?.textContent.split(" - ")[0] || "",
          end: res.querySelector("#res-hours")?.textContent.split(" - ")[1] || ""
        };
      });

      restaurantList = resData;
      renderRestaurant(false); // skipButtons = true
      resolve();
    });
  }
</script>

<!-- Today Event Script -->
<script>
  let listId = 0;
  let cardsData = [];
  let editingIndex = null;
  const ChidlomOptions = [
    "New Brand",
    "Limited Edition",
    "New Drop",
    "Trending Products",
    "Only at Central Chidlom",
    "Brand Pop-up",
    "Events & Activities",
    "Brand Promotion",
    "Eats & Treats"
  ];
  const RbsOptions = [
    "แบรนด์ดังเปิดใหม่",
    "สินค้ารุ่นพิเศษ",
    "สินค้าใหม่",
    "สินค้าฮิต",
    "พิเศษเฉพาะที่โรบินสัน",
    "กิจกรรม",
    "โปรโมชั่นพิเศษ",
  ];
  const CdsOptions = [
    "New Brand",
    "Limited Edition",
    "New Drop",
    "Trending Products",
    "Only at Central Chidlom",
    "Brand Pop-up",
    "Events & Activities",
    "Brand Promotion",
  ];
  const previewContainer = document.getElementById("today-container");

  function createStoreOptions(options) {
    let selectField = document.getElementById("event-options");
    selectField.innerHTML = ""; // Clear existing options
    let newOptions = '<option disabled selected>-- Pick an Event --</option>';
    options.forEach((item, index) => {
      newOptions += `<option value="${item}">${item}</option>`;
    });
    selectField.innerHTML = newOptions;
  }

  function collectCurrentEvent() {
    const title = document.getElementById("event-title").value;
    const img = document.getElementById("event-image-url").value;
    const type = document.getElementById("event-options").value;
    const loc = document.getElementById("event-loc").value;
    const start = document.getElementById("start-date").value;
    const end = document.getElementById("end-date").value;
    const desc = document.getElementById("event-desc").value;
    const ignoreStartDate = document.getElementById("ignore-start-date").checked;

    return {
      title: title,
      img: img,
      type: type,
      loc: loc,
      start: start,
      end: end,
      desc: desc,
      ignoreStartDate: ignoreStartDate,
    }
  }

  function validatePromotionInput() {
    const title = document.getElementById("event-title").value;
    const imgUrl = document.getElementById("event-image-url").value;
    const type = document.getElementById("event-options").value;
    const loc = document.getElementById("event-loc").value;
    const startDate = document.getElementById("start-date").value;
    const endDate = document.getElementById("end-date").value;
    const ignoreStartDate =
      document.getElementById("ignore-start-date").checked;
    const urlRegex = /^https?:\/\/[\w\-]+(\.[\w\-]+)+[/#?]?.*$/;

    if (!title) {
      alert("Event title is required.");
      return false;
    }

    if (!loc) {
      alert("Event location is required");
      return;
    }

    if (!type) {
      alert("Event Type is required please select one.");
      return;
    }

    if (!urlRegex.test(imgUrl)) {
      alert(
        "Please enter a valid image URL (must start with http or https)."
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

  function addEvent() {
    // if (!validatePromotionInput()) return;
    const data = collectCurrentEvent();

    if (editingIndex !== null) {
      cardsData[editingIndex] = data;
      editingIndex = null;
    } else {
      cardsData.push(data);
    }
    clearInputs();
    console.log(cardsData)
    renderEvent();
  }

  function clearInputs() {
    document.getElementById("event-title").value = "";
    document.getElementById("event-image-url").value = "";
    document.getElementById("event-options").value = "";
    document.getElementById("event-loc").value = "";
    document.getElementById("start-date").value = "";
    document.getElementById("end-date").value = "";
    document.getElementById("event-desc").value = "";
    document.getElementById("ignore-start-date").checked = false;
  }

  function renderEvent(skipButtons = false) {
    const previewContainer = document.getElementById("today-container");
    cardsData.sort((a, b) => new Date(a.start) - new Date(b.start));

    previewContainer.innerHTML = "";

    cardsData.forEach((card, index) => {
      const eventCard = document.createElement('div');

      let classList = "event-card";

      if (currentStore === "robinson") {
        eventCard.style.backgroundColor = "#4ade80"; // Emerald 50
      } else {
        eventCard.style.backgroundColor = "#fff";
      }

      eventCard.className = classList;

      eventCard.setAttribute("data-index", index);
      eventCard.setAttribute("draggable", true);
      eventCard.setAttribute("data-start", card.start);
      eventCard.setAttribute("data-end", card.end);
      eventCard.setAttribute("ispreview", card.ignoreStartDate);

      const startDateText = formatDateToText(card.start);
      const endDateText = formatDateToText(card.end);

      let topSection = '';
      if (currentStore === "chidlom") {
        topSection += `
        <div class="event-header">
          <p id="type">${card.type}</p>
          <h3 id="title" class="event-title" style="color: #fca5a5;">${card.title}</h3>
        </div>
        `;
      } else {
        const titleColor = currentStore === "robinson" ? "#fff" : "#ef4444";
        const textColor = currentStore === "robinson" ? "#fff" : "#000";
        topSection += `
          <div class="event-header2" style="color: ${textColor};">
            <h2 id="title" class="event-title" style="color: ${titleColor};">
              ${card.title}
            </h2>
            <p id="type" class="font-central-sang-bleu">${card.type}</p>
          </div>
        `;
      }

      const content = `
        <img src="${card.img}" class="event-image" />
        <div class="event-details" style="background-color: ${currentStore === 'robinson' ? '#4ade80' : '#fff'};">
          ${topSection}
          <div class="event-info">
            <p id="loc">${card.loc}</p>
            <p id="open-hours">${startDateText} - ${endDateText}</p>
          </div>
          <p id="desc" class="event-description">
            ${card.desc}
          </p>
        </div>
      `;

      eventCard.innerHTML = content;

      if (!skipButtons) {
        const btnGroup = document.createElement("div");
        btnGroup.className =
          "flex justify-end px-2 gap-2 pb-2 absolute top-2 right-2 z-20";
        btnGroup.innerHTML = `
            <button onclick="editEvent(${index})" class="px-2 py-1 text-sm bg-yellow-400 rounded">✏️</button>
            <button onclick="deleteEvent(${index})" class="px-2 py-1 text-sm text-white bg-red-500 rounded">🗑</button>
        `;
        eventCard.appendChild(btnGroup);
      }

      previewContainer.appendChild(eventCard);
    });
    enableDragSort();
  }

  function editEvent(index) {
    const card = cardsData[index];
    document.getElementById("event-title").value = card.title;
    document.getElementById("event-image-url").value = card.img;
    document.getElementById("event-options").value = card.type;
    document.getElementById("event-loc").value = card.loc;
    document.getElementById("start-date").value = card.start;
    document.getElementById("end-date").value = card.end;
    document.getElementById("event-desc").value = card.desc;
    document.getElementById("ignore-start-date").checked = card.ignoreStartDate;
    editingIndex = index;
    cardsData.splice(index, 1);
    renderEvent(); // render
  }

  function deleteEvent(index) {
    cardsData.splice(index, 1);
    renderEvent(); // render ใหม่
  }

  function enableDragSort() {
    let draggedItem = null;

    const draggableItems = previewContainer.querySelectorAll("[draggable='true']");

    draggableItems.forEach((item) => {
      item.addEventListener("dragstart", (e) => {
        draggedItem = item;
        e.dataTransfer.effectAllowed = "move";
        e.dataTransfer.setData("text/plain", item.dataset.index); // เผื่อใช้ต่อยอด
        item.classList.add("opacity-50"); // เอฟเฟกต์ตอนลาก
      });

      item.addEventListener("dragover", (e) => {
        e.preventDefault(); // สำคัญมากเพื่อให้ drop ทำงานได้
      });

      item.addEventListener("drop", (e) => {
        e.preventDefault();
        const dropTarget = e.currentTarget;

        if (!draggedItem || draggedItem === dropTarget) return;

        const draggedIndex = +draggedItem.dataset.index;
        const dropIndex = +dropTarget.dataset.index;

        if (draggedIndex !== dropIndex) {
          const newOrder = [...cardsData];
          const [moved] = newOrder.splice(draggedIndex, 1);
          newOrder.splice(dropIndex, 0, moved);
          cardsData = newOrder;

          renderEvent(); // ต้อง render ใหม่หลังสลับลำดับ
        }
      });

      item.addEventListener("dragend", () => {
        draggedItem = null;
        item.classList.remove("opacity-50");
      });
    });
  }

  function extractTodayEvent(todayContainer) {
    return new Promise((resolve) => {
      if (!todayContainer) {
        console.warn("ไม่พบ Today Event Container");
        return resolve();
      }

      const eventElems = todayContainer.querySelectorAll("div[data-start][data-end]");
      eventElems.forEach(event => {
        const start = event.getAttribute("data-start");
        const end = event.getAttribute("data-end");
        const isPreview = event.getAttribute("ispreview") === "true";
        const isChidlom = event.getAttribute("ischidlom") === "true";

        cardsData.push({
          title: event.querySelector("#title").textContent,
          img: event.querySelector("img").src,
          type: event.querySelector("#type").textContent,
          loc: event.querySelector("#loc").textContent,
          start: start,
          end: end,
          desc: event.querySelector("#desc").textContent,
          ignoreStartDate: isPreview,
          isChidlom: isChidlom
        });
      });

      renderEvent(false); // skipButtons = true
      resolve();
    });
  }

  function formatDateToText(dateStr) {
    const date = new Date(dateStr);
    if (lang === "th") {
      // Thai month abbreviations
      const thMonths = [
        "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.",
        "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
      ];
      const d = date.getDate().toString().padStart(2, "0");
      const m = thMonths[date.getMonth()];
      const y = (date.getFullYear() + 543).toString(); // Buddhist year
      return `${d} ${m} ${y}`;
    } else {
      return date.toLocaleDateString("en-GB", {
        day: "2-digit",
        month: "short",
        year: "numeric"
      });
    }
  }
</script>

<script>
  function initSlider() {
    const slider = document.getElementById("slider");
    const dots = document.querySelectorAll(".dot");
    const slides = slider.querySelectorAll(".slide-item");
    let currentIndex = 0;
    let intervalId;
    const isDesktop = window.innerWidth >= 1024;

    function scrollToIndex(index) {
      const scrollAmount = slides[index].offsetLeft;
      slider.scrollTo({
        left: scrollAmount,
        behavior: "smooth"
      });
      currentIndex = index;
    }

    function autoScroll() {
      currentIndex = (currentIndex + 1) % slides.length;
      scrollToIndex(currentIndex);
    }

    function startAutoSlide() {
      intervalId = setInterval(autoScroll, 5000);
    }

    function stopAutoSlide() {
      clearInterval(intervalId);
    }

    dots.forEach((dot, index) => {
      dot.addEventListener("click", () => {
        scrollToIndex(index);
        if (isDesktop) {
          stopAutoSlide();
          startAutoSlide();
        }
      });
    });

    slider.addEventListener("mouseenter", () => {
      if (isDesktop) stopAutoSlide();
    });
    slider.addEventListener("mouseleave", () => {
      if (isDesktop) startAutoSlide();
    });

    scrollToIndex(0);
    if (isDesktop) startAutoSlide();
  }

  initSlider();
</script>
<?php
session_start();

// If not logged in, redirect
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("Location: login.php");
  exit;
}

$_SESSION['last_activity'] = time(); // update last activity time

// รับค่าหน้าจาก URL
$page = $_GET['page'] ?? 'accordion'; // default = accordion

// ตรวจสอบ POST การเปลี่ยนภาษา
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['changeLang'])) {
  $langCode = $_POST['changeLang'];
  $filePath = "./lang/{$langCode}.json";

  if (!file_exists($filePath)) {
    $langCode = 'en';
    $filePath = "./lang/en.json";
  }

  $_SESSION['lang_code'] = $langCode;
  $_SESSION['lang'] = json_decode(file_get_contents($filePath), true);

  // รีโหลดหน้าปัจจุบันหลังเปลี่ยนภาษา
  header("Location: " . $_SERVER['REQUEST_URI']);
  exit;
}

// โหลดภาษาเริ่มต้นถ้ายังไม่ได้โหลด
if (!isset($_SESSION['lang'])) {
  $_SESSION['lang_code'] = 'en';
  $_SESSION['lang'] = json_decode(file_get_contents("./lang/en.json"), true);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HTML Generetor</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://test-php.free.nf/font.css">
  <link rel="stylesheet" href="https://uat-assets.central.co.th/file-assets/assets/CMS/evm/assets/css/fonts.css">
  <script>
    let expiredTime = 60000 * 30; //1min * 30
    setInterval(() => {
      fetch('session_check.php')
        .then(res => res.json())
        .then(data => {
          if (data.status === 'expired') {
            alert("Session expired due to inactivity. Redirecting to login.");
            window.location.href = 'login.php?timeout=1';
          }
        });
    }, expiredTime); // 60000 ms = 1 minute
  </script>
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

    * {
      font-family: 'CPN', sans-serif;
    }

    .border {
      border-width: 1px;
      border-style: solid;
    }
  </style>
</head>

<body class="container w-full h-auto mx-auto overflow-x-hidden bg-gray-50">
  <div class="drawer">
    <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
    <div class="flex flex-col drawer-content">
      <!-- Navbar -->
      <div class="w-full mb-4 bg-black navbar">
        <div class="flex-none lg:hidden">
          <label
            for="my-drawer-3"
            aria-label="open sidebar"
            class="btn btn-square btn-ghost">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              class="inline-block w-6 h-6 text-white stroke-current">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </label>
        </div>
        <div class="flex-1 px-2 mx-2 text-xl font-bold text-white">HTML Generetor</div>
        <div class="flex-none hidden lg:block">
          <ul class="items-center text-white menu menu-horizontal">
            <?php
            $menuList = $_SESSION['menu'] ?? [];

            // เมนูหลักที่แสดงตรงๆ
            $simpleMenu = ['accordion', 'carousel', 'promotions', 'store-top', 'store-bottom'];

            echo "<li><details><summary>SEO Tools</summary><ul class='p-2 bg-black rounded-t-none'>";
            foreach ($simpleMenu as $key) {
              if (isset($menuList[$key])) {
                $label = ucfirst(str_replace('-', ' ', $key));
                echo "<li><a href='?page=$key'>$label</a></li>";
              }
            }
            echo "</ul></details></li>";

            // เมนูแบบกลุ่ม (SKU Tools)
            $skuMenu = [
              'extract-url' => 'Extract Url',
              'context-rule' => 'Context Rule',
              'product-stock' => 'Product Stock',
              'management' => 'Brands Management',
              'users-management' => 'Users Management'
            ];

            $hasSkuMenu = false;
            foreach ($skuMenu as $key => $label) {
              if (isset($menuList[$key])) {
                $hasSkuMenu = true;
                break;
              }
            }

            if ($hasSkuMenu) {
              echo "<li><details><summary>SKU Tools</summary><ul class='p-2 bg-black rounded-t-none'>";
              foreach ($skuMenu as $key => $label) {
                if (isset($menuList[$key])) {
                  echo "<li><a href='?page=$key'>$label</a></li>";
                }
              }
              echo "</ul></details></li>";
            }
            ?>

            <li>
              <form method="post" class="join">
                <button name="changeLang" value="en" onclick="localStorage.setItem('lang','en')" class="join-item cursor-pointer btn <?= ($_SESSION['lang_code'] ?? 'en') === 'en' ? 'btn-active' : '' ?>">EN</button>
                <button name="changeLang" value="th" onclick="localStorage.setItem('lang','th')" class="join-item cursor-pointer btn <?= ($_SESSION['lang_code'] ?? 'en') === 'th' ? 'btn-active' : '' ?>">TH</button>
              </form>
            </li>
            <li><a href="logout.php" class='btn btn-error'>Logout</a></li>
          </ul>
        </div>

      </div>


      <!-- Page content here -->
      <div class="p-4">
        <?php
        // 🔐 ป้องกัน page ที่ไม่อยู่ในสิทธิ์
        $pagesForUser = $_SESSION['menu'] ?? [];
        if (array_key_exists($page, $pagesForUser)) {
          include $pagesForUser[$page];
        } else {
          echo "<p class='text-red-500'>Page not found or access denied.</p>";
        }

        ?>
      </div>


    </div>
    <div class="drawer-side">
      <label
        for="my-drawer-3"
        aria-label="close sidebar"
        class="drawer-overlay"></label>
      <ul class="min-h-full p-4 menu bg-base-200 w-80">
        <!-- Sidebar content here -->
        <li><a href="?page=accordion">Accordion</a></li>
        <li><a href="?page=carousel">Carousel</a></li>
        <li><a href="?page=promotions">Promotions</a></li>
        <li><a href="?page=store-top">Store Top</a></li>
        <li><a href="?page=store-bottom">Store Bottom</a></li>
      </ul>
    </div>
  </div>

  <!-- ✅ Axios -->
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</body>

</html>
    <!-- ✅ Vanilla DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" />
    <!-- Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet" />
    <div class="container w-full mx-auto max-w-[1440px] flex flex-col items-start justify-center gap-4 p-4">

        <div class="flex flex-col items-start w-full gap-4">
            <!-- Radio Options -->
            <fieldset class="flex flex-col items-start w-full">
                <legend class="mb-2 font-semibold">Select Type</legend>

                <div class="flex flex-col w-full gap-4">
                    <!-- Brand radio -->
                    <div class="flex flex-col w-full cursor-pointer label">
                        <div class="self-start">
                            <input type="radio" name="input-type" value="brand" class="radio checked:bg-blue-500"
                                onchange="toggleInput(this.value)" />
                            <span class="ml-2 label-text">Brand</span>
                        </div>

                        <div id="brand-container" class="hidden w-full">
                            <label class="label"><span class="font-semibold label-text">Select Brands</span></label>
                            <select id="brandlist" multiple placeholder="Choose brands..."
                                class="w-1/2 text-sm border rounded"></select>
                        </div>
                    </div>

                    <!-- SKU radio -->
                    <div class="flex flex-col w-full cursor-pointer label">
                        <div class="self-start">
                            <input type="radio" name="input-type" value="sku" class="radio checked:bg-blue-500" checked
                                onchange="toggleInput(this.value)" />
                            <span class="ml-2 label-text">SKU</span>
                        </div>

                        <div id="sku-container" class="flex flex-col w-full">
                            <label class="label"><span class="font-semibold label-text">Enter SKU Here</span></label>
                            <textarea id="textarea" class="w-full textarea textarea-bordered"></textarea>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>



        <div class="flex flex-col w-full">
            <legend class="fieldset-legend">SELECT TABEL</legend>
            <div class="flex w-full gap-2">

                <label class="label">
                    <input onchange="hideTable('in-stock-checkbox','table-in-stock')" id="in-stock-checkbox" type="checkbox" checked="checked"
                        class="checkbox" />
                    In Stock
                </label>

                <label class="label">
                    <input onchange="hideTable('out-stock-checkbox','table-out-stock')" id="out-stock-checkbox" type="checkbox" checked="checked"
                        class="checkbox" />
                    Out Stock
                </label>

                <label class="label">
                    <input onchange="hideTable('unknow-checkbox','table-unknown-stock')" id="unknow-checkbox" type="checkbox" checked="checked"
                        class="checkbox" />
                    Unknow
                </label>
            </div>
        </div>

        <div>
            <button id="brand-generate" onclick="getByBrand()" class="hidden p-4 btn-success">GENERATE</button>
            <button id="sku-generate" onclick="extractSKU()" class="btn btn-success">GENERATE</button>
            <button onclick="clearSku()" class="bg-gray-300 btn">CLEAR</button>
        </div>

        <!-- ✅ In Stock Table -->
        <div class="flex flex-col w-full overflow-x-auto border rounded-box">
            <h2 class="p-4 text-xl font-bold">In Stock</h2>
            <table id="table-in-stock" class="table w-full table-zebra">
                <thead>
                    <tr class="text-white bg-green-300">
                        <th class="text-center">NO.</th>
                        <!-- <th class="text-center">Image</th> -->
                        <th class="text-center">Brand</th>
                        <th class="text-center">SKU</th>
                        <th class="text-center">PARENT</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">DISCOUNT</th>
                        <th class="text-center">DISCOUNT %</th>
                        <th class="text-center">FINAL PRICE</th>
                        <th class="text-center">STOCK</th>
                        <th class="text-center">VISIBILITY</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <button onclick="copyAllDataFrom('#table-in-stock')" class="self-end m-4 btn btn-outline">
                📋 Copy All In-Stock
            </button>
        </div>

        <!-- ✅ Out of Stock Table -->
        <div class="flex flex-col w-full overflow-x-auto border rounded-box">
            <h2 class="p-4 text-xl font-bold">Out of Stock</h2>
            <table id="table-out-stock" class="table w-full table-zebra">
                <thead>
                    <tr class="text-white bg-red-300">
                        <th class="text-center">NO.</th>
                        <!-- <th class="text-center">Image</th> -->
                        <th class="text-center">Brand</th>
                        <th class="text-center">SKU</th>
                        <th class="text-center">PARENT</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">DISCOUNT</th>
                        <th class="text-center">DISCOUNT %</th>
                        <th class="text-center">FINAL PRICE</th>
                        <th class="text-center">STOCK</th>
                        <th class="text-center">VISIBILITY</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <button onclick="copyAllDataFrom('#table-out-stock')" class="self-end m-4 btn btn-outline">
                📋 Copy All Out-of-Stock
            </button>
        </div>

        <!-- ✅ Unknown Stock Table -->
        <div class="flex flex-col w-full overflow-x-auto border rounded-box">
            <h2 class="p-4 text-xl font-bold">Unknown Stock</h2>
            <table id="table-unknown-stock" class="table w-full table-zebra">
                <thead>
                    <tr class="text-white bg-yellow-300">
                        <th class="text-center">NO.</th>
                        <!-- <th class="text-center">Image</th> -->
                        <th class="text-center">Brand</th>
                        <th class="text-center">SKU</th>
                        <th class="text-center">PARENT</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">DISCOUNT</th>
                        <th class="text-center">DISCOUNT %</th>
                        <th class="text-center">FINAL PRICE</th>
                        <th class="text-center">STOCK</th>
                        <th class="text-center">VISIBILITY</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <button onclick="copyAllDataFrom('#table-unknown-stock')" class="self-end m-4 btn btn-outline">
                📋 Copy All Unknown Stock
            </button>
        </div>

    </div>
    <!-- ✅ Vanilla DataTables JS -->
    <script src="https://cdn.jsdelivr.net/npm/vanilla-datatables@latest/dist/vanilla-dataTables.min.js"></script>
    <!-- Tom Select JS -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <!-- ✅ Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const uri = 'https://jl22xxdcs9-dsn.algolia.net/1/indexes/cds_th_products_final_price_desc/query?x-algolia-agent=Algolia%20for%20JavaScript%20(4.5.1)%3B%20Browser%20(lite)&x-algolia-api-key=4e54e0448663400fb173d25f74e622fe&x-algolia-application-id=JL22XXDCS9';

        let skulist = [];

        let dataTableInStock, dataTableOutStock, dataTableUnknownStock;

        let allBrands = [];

        let brandList = [];

        async function getBrand() {
            try {
                const res = await axios.get("/json/brands.json");
                allBrands = res.data;
                createOptions();
            } catch (error) {
                console.error(error);
            }
        }

        function createOptions() {
            const select = document.getElementById("brandlist");
            let html = '';

            allBrands.forEach(brand => {
                html += `<option value="${brand.id}">${brand.name}</option>`;
            });
            select.innerHTML = html;

            // ✅ Initialize Tom Select AFTER injecting options
            new TomSelect("#brandlist", {
                plugins: ['remove_button'],
                maxItems: null,
                create: false,
                render: {
                    item: function(data, escape) {
                        return `<div class="inline-block px-2 py-1 mb-1 mr-1 text-blue-800 bg-blue-100 rounded">${escape(data.text)}</div>`;
                    }
                }
            });
        }

        getBrand();

        function hideTable(checkBoxId, tableId) {
            const box = document.getElementById(checkBoxId);
            const table = document.getElementById(tableId);
            table.classList.toggle("hidden", !box.checked);
        }


        function toggleInput(type) {
            document.getElementById("brand-container").classList.toggle("hidden", type !== 'brand');
            document.getElementById("sku-container").classList.toggle("hidden", type !== 'sku');

            if (type !== 'sku') {
                document.getElementById("brand-generate").classList.add("btn");
                document.getElementById("brand-generate").classList.remove("hidden");

                document.getElementById("sku-generate").classList.add("hidden");
                document.getElementById("sku-generate").classList.remove("btn");
            } else {
                document.getElementById("sku-generate").classList.add("btn");
                document.getElementById("sku-generate").classList.remove("hidden");

                document.getElementById("brand-generate").classList.add("hidden");
                document.getElementById("brand-generate").classList.remove("btn");
            }
        }

        async function loadProducts(filterContext = "") {
            try {
                const res = await axios.post(uri, {
                    hitsPerPage: 100000,
                    // filters: "brand_id:10525 OR brand_id:844",
                    filters: filterContext,
                    distinct: true
                });

                const products = res.data.hits;

                const inStockRows = [];
                const outOfStockRows = [];
                const unknownStockRows = [];

                const tbody = document.querySelector("#testTable tbody");

                let inStockIndex = 1,
                    outOfStockIndex = 1,
                    unknownStockIndex = 1;

                products.forEach((p) => {
                    const discount = (p.price || 0) - (p.final_price || 0);
                    const stockStatus = p.stock?.is_in_stock;
                    let rowHTML = "";
                    if (stockStatus === true) {
                        rowHTML = `
                            <tr>
                                <td class="text-center">${inStockIndex++}</td>

                                <td class="text-center">${p.brand_name || ""}</td>
                                <td class="text-center">${p.sku}</td>
                                <td class="text-center">${p.parent_sku || ""}</td>
                                <td class="text-left">${p.name || ""}</td>
                                <td class="text-center">${p.price || 0}</td>
                                <td class="text-center">${p.discount_amount}</td>
                                <td class="text-center">${p.discount_percentage}</td>
                                <td class="text-center">${p.final_price || 0}</td>
                                <td class="text-center">YES</td>
                                <td class="text-center">${p.visibility ?? "-"}</td>
                            </tr>
                        `;
                        inStockRows.push(rowHTML);
                    } else if (stockStatus === false) {
                        rowHTML = `
                            <tr>
                                <td class="text-center">${outOfStockIndex++}</td>

                                <td class="text-center">${p.brand_name || ""}</td>
                                <td class="text-center">${p.sku}</td>
                                <td class="text-center">${p.parent_sku || ""}</td>
                                <td class="text-left">${p.name || ""}</td>
                                <td class="text-center">${p.price || 0}</td>
                                <td class="text-center">${p.discount_amount}</td>
                                <td class="text-center">${p.discount_percentage}</td>
                                <td class="text-center">${p.final_price || 0}</td>
                                <td class="text-center">NO</td>
                                <td class="text-center">${p.visibility ?? "-"}</td>
                            </tr>
                        `;
                        outOfStockRows.push(rowHTML);
                    } else {
                        rowHTML = `
                            <tr>
                                <td class="text-center">${unknownStockIndex++}</td>

                                <td class="text-center">${p.brand_name || ""}</td>
                                <td class="text-center">${p.sku}</td>
                                <td class="text-center">${p.parent_sku || ""}</td>
                                <td class="text-left">${p.name || ""}</td>
                                <td class="text-center">${p.price || 0}</td>
                                <td class="text-center">${p.discount_amount}</td>
                                <td class="text-center">${p.discount_percentage}</td>
                                <td class="text-center">${p.final_price || 0}</td>
                                <td class="text-center">-</td>
                                <td class="text-center">${p.visibility ?? "-"}</td>
                            </tr>
                        `;
                        unknownStockRows.push(rowHTML);
                    }
                });

                // 💡 Add to each table
                document.querySelector("#table-in-stock tbody").innerHTML = inStockRows.join('');
                document.querySelector("#table-out-stock tbody").innerHTML = outOfStockRows.join('');
                document.querySelector("#table-unknown-stock tbody").innerHTML = unknownStockRows.join('');


                // ✅ init all 3 DataTables
                dataTableInStock = new DataTable("#table-in-stock");
                dataTableOutStock = new DataTable("#table-out-stock");
                dataTableUnknownStock = new DataTable("#table-unknown-stock");


            } catch (err) {
                console.error("Error loading data:", err);
            }
        }


        function copyAllDataFrom(tableId) {
            let dataTable;

            if (tableId === '#table-in-stock') {
                dataTable = dataTableInStock;
            } else if (tableId === '#table-out-stock') {
                dataTable = dataTableOutStock;
            } else if (tableId === '#table-unknown-stock') {
                dataTable = dataTableUnknownStock;
            }

            if (!dataTable) return;

            const headers = ["NO.", "BRAND", "SKU", "PARENT", "NAME", "PRICE", "DISCOUNT", "FINAL PRICE", "STOCK", "VISIBILITY"];
            let text = headers.join('\t') + '\n';

            dataTable.data.forEach((row, i) => {
                const cells = row.cells;
                const line = [
                    i + 1,
                    cells[1]?.data,
                    cells[2]?.data,
                    cells[3]?.data,
                    cells[4]?.data,
                    cells[5]?.data,
                    cells[6]?.data,
                    cells[7]?.data,
                    cells[8]?.data,
                    cells[9]?.data,
                ].map(val => val?.toString().trim() || '').join('\t');
                text += line + '\n';
            });

            navigator.clipboard.writeText(text)
                .then(() => alert(`✅ Copied all data from ${tableId} to clipboard!`))
                .catch(err => console.error("Copy failed", err));
        }

        function extractSKU() {
            const input = document.getElementById("textarea");
            const raw = input.value.trim();

            if (!raw) {
                alert("Please input value first and try again!");
                return;
            }

            let lines = raw
                .replace(/(\r\n|\n|\r)/gm, ",")
                .replace(/,\s*/g, ",")
                .replace(/\s\s+/g, ",")
                .replace(/\s+/g, ",")
                .split(",");

            let filterContext = "";

            skulist = lines.filter(sku => sku.trim() !== "");
            if (skulist.length > 0) {
                filterContext = skulist.map(sku => `sku:${sku.trim()}`).join(" OR ");
                console.log(filterContext);
            }

            loadProducts(filterContext);
        }

        function getByBrand() {
            const brands = document.getElementById('brandlist');
            const filterContext = Array.from(brands.selectedOptions)
                .map(option => `brand_id:${option.value}`)
                .join(" OR ");

            loadProducts(filterContext);
        }




        // ⏱ Start when page is ready
        // document.addEventListener("DOMContentLoaded", loadProducts);
    </script>
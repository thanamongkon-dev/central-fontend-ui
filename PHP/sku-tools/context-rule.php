<!-- <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> -->
<div class=" container w-full mx-auto max-w-[1440px] flex flex-col items-start justify-center gap-4 p-4">
    <h1 class="text-xl font-bold">Context Rule</h1>
    <fieldset class="w-full fieldset">
        <legend class="fieldset-legend">Context Rule Name or Url</legend>
        <input id="sku-input" class="w-1/2 input" type="text"
            placeholder="https://www.central.co.th/en/promotion-campaign/n-5">
    </fieldset>

    <div>
        <button onclick="extract()" class="text-white btn btn-success">GENERATE</button>
        <button onclick="clearSku()" class="text-white bg-gray-300 btn">CLEAR</button>
    </div>

    <div class="flex flex-col items-start w-full gap-4">
        <textarea id="result" rows="20" class="min-w-full textarea" readonly></textarea>
        <button onclick="copySku()" class="text-white btn btn-success">COPY</button>
    </div>

    <script>
        const uri = 'https://jl22xxdcs9-dsn.algolia.net/1/indexes/cds_en_products_recommened_sort_order_desc/query?x-algolia-agent=Algolia%20for%20JavaScript%20(4.5.1)%3B%20Browser%20(lite)&x-algolia-api-key=4e54e0448663400fb173d25f74e622fe&x-algolia-application-id=JL22XXDCS9';

        function extract() {
            let skuInput = document.getElementById("sku-input");

            const rawValue = skuInput.value.trim();
            const value = rawValue.split('?')[0].split('/').pop();

            if (value) {
                console.log(value);
                getContextRule(value)
            } else {
                alert('Please input value first and try again!');
            }
        }

        async function getContextRule(value) {
            try {
                const res = await axios.post(uri, {
                    ruleContexts: value,
                    hitsPerPage: "100000",
                    facetFilters: "*",
                    distinct: true
                });
                console.log(res.data.hits)
                const sku = res.data.hits;
                if (sku.length > 0) {
                    extractSKU(sku)
                } else {
                    alert('SKU not found');
                }
            } catch (error) {
                console.error("เกิดข้อผิดพลาด:", error)
            }
        }

        function extractSKU(data) {
            let result = document.getElementById("result");
            result.value = '';

            data.forEach(item => {
                result.value += item.sku + "\r\n";
            });

        }

        function clearSku() {
            const result = document.getElementById("result");

            result.value = '';
        }

        function copySku() {
            const textarea = document.getElementById("result");
            const textToCopy = textarea.value;

            navigator.clipboard.writeText(textToCopy)
                .then(() => {
                    alert("Copied to clipboard!");
                })
                .catch(err => {
                    console.error("Failed to copy: ", err);
                });
        }
    </script>
</div>
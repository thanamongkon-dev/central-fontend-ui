<!-- <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> -->
<div class="container mx-auto max-w-[1440px] flex flex-col items-start justify-center gap-4 p-4">
    <legend class="fieldset-legend">Enter Url Here</legend>
    <textarea id="textarea" rows="8" class="min-w-full textarea"></textarea>

    <div>
        <button onclick="extractSKU()" class="text-white btn btn-success">GENERATE</button>
        <button onclick="clearSku()" class="text-white bg-gray-300 btn">CLEAR</button>
    </div>

    <textarea id="result" rows="18" class="min-w-full textarea" readonly></textarea>
    <button onclick="copySku()" class="text-white btn btn-success">COPY</button>
</div>

<script>
    function extractSKU() {
        const input = document.getElementById("textarea");
        const output = document.getElementById("result");
        output.value = '';

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

        const skus = [];

        lines.forEach(line => {
            const parts = line.split("-");
            let sku = parts[parts.length - 1];

            if (!sku) return;

            sku = sku.split("#")[0];
            sku = sku.toUpperCase();

            skus.push(sku)
        });

        output.value = skus.join("\t");
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
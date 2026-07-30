import { addData, STORES } from "./indexeddb";

document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("company-form");
console.log(form);
    if (!form) return;

    // -----------------------
    // 給与計算
    // -----------------------

    const kihon = document.getElementById("kihon");
    const other = document.getElementById("other");
    const salary = document.getElementById("salary");
    const salaryText = document.getElementById("salaryText");

    function calcSalary() {

        const total =
            (Number(kihon.value) || 0) +
            (Number(other.value) || 0);

        salary.value = total;
        salaryText.textContent = total;
    }

    kihon.addEventListener("input", calcSalary);
    other.addEventListener("input", calcSalary);

    calcSalary();

    // -----------------------
    // URL追加
    // -----------------------

    const urlList = document.getElementById("url-list");
    const addButton = document.getElementById("add-url");

    let index = 1;

    addButton.addEventListener("click", () => {

        const row = document.createElement("div");

        row.className = "flex flex-col sm:flex-row gap-3 mt-3";

        row.innerHTML = `
            <input
                type="text"
                name="urls[${index}][memo]"
                placeholder="詳細"
                class="w-full sm:w-1/3 border rounded p-2">

            <input
                type="url"
                name="urls[${index}][url]"
                placeholder="https://"
                class="w-full sm:flex-1 border rounded p-2">

            <button
                type="button"
                class="delete-url p-2 bg-slate-400 text-white rounded">
                削除
            </button>
        `;

        row.querySelector(".delete-url")
            .addEventListener("click", () => row.remove());

        urlList.appendChild(row);

        index++;

    });

    // -----------------------
    // 登録
    // -----------------------

    form.addEventListener("submit", async (e) => {

        e.preventDefault();

        const formData = new FormData(form);

        // URL一覧
        const urls = [];

        document.querySelectorAll("[name^='urls']").forEach(input => {

            const match = input.name.match(/urls\[(\d+)\]\[(memo|url)\]/);

            if (!match) return;

            const i = Number(match[1]);

            if (!urls[i]) {
                urls[i] = {
                    memo: "",
                    url: ""
                };
            }

            urls[i][match[2]] = input.value;

        });

        const company = {

            name: formData.get("name"),

            level: Number(formData.get("level") ?? 3),

            address: formData.get("address"),

            industry: formData.get("industry"),

            salary: Number(formData.get("salary")),

            basic_salary: Number(formData.get("basic_salary")) || 0,

            other_salary: Number(formData.get("other_salary")) || 0,

            start_time: formData.get("start_time"),

            end_time: formData.get("end_time"),

            break_time: Number(formData.get("break_time")) || 0,

            training_period:

                Number(formData.get("training_year")) * 12 +

                Number(formData.get("training_month")),

            ses_level: formData.get("ses_level"),

            benefits_memo: formData.get("benefits_memo"),

            free_memo: formData.get("free_memo"),

            urls: urls.filter(url =>
                url &&
                (url.memo || url.url)
            ),

            created_at: new Date().toISOString(),

            updated_at: new Date().toISOString()

        };

        try {

            await addData(STORES.COMPANIES, company);

        } catch (error) {

            console.error(error);

        }

        location.href = "/companies";

    });

});

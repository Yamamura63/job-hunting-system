import { updateData, getData, STORES } from "./indexeddb";

const form = document.getElementById("company-edit-form");

const id = form.dataset.id;

async function loadCompany() {

    const company = await getData(
        STORES.COMPANIES,
        id
    );

    if (!company) {
        alert("企業データがありません");
        return;
    }

    form.querySelector("[name='name']").value =
        company.name ?? "";

    form.querySelector("[name='address']").value =
        company.address ?? "";

    form.querySelector("[name='industry']").value =
        company.industry ?? "";
    form.querySelector("[name='basic_salary']").value =
        company.basic_salary ?? "";
    form.querySelector("[name='other_salary']").value =
        company.other_salary ?? "";
    form.querySelector("[name='salary']").value =
        company.salary ?? "";

    form.querySelector('[name="start_time"]').value =
        company.start_time ?? '';
    form.querySelector('[name="end_time"]').value =
        company.end_time ?? '';
    form.querySelector('[name="break_time"]').value =
        company.break_time ?? '';

    form.querySelector('[name="training_year"]').value =
        Math.floor((company.training_period ?? 0) / 12);
    form.querySelector('[name="training_month"]').value =
        (company.training_period ?? 0) % 12;

    form.querySelector("[name='benefits_memo']").value =
        company.benefits_memo ?? "";

    form.querySelector("[name='free_memo']").value =
        company.free_memo ?? "";

    form.querySelectorAll("[name='level']").forEach(input => {
        input.checked =
            Number(input.value) === Number(company.level);
    });

    form.querySelectorAll("[name='ses_level']").forEach(input => {
        input.checked =
            input.value === company.ses_level;
    });

    const urlContainer = document.getElementById("url-list");
    // 既存URLを表示
    if (company.urls && company.urls.length > 0) {
        company.urls.forEach((urlData, index) => {
            let row;
            // 最初のURL欄は既存のものを利用
            if (index === 0) {
                row = form.querySelector("[name='urls[0][memo]']")
                    .closest(".flex");
            } else {
                row = document.createElement("div");
                row.className =
                    "flex flex-col sm:flex-row gap-3 mt-3 min-w-0";
                row.innerHTML = `
                <input
                    type="text"
                    name="urls[${index}][memo]"
                    class="memo w-full sm:w-1/3 border rounded p-2"
                    placeholder="詳細">
                <input
                    type="url"
                    name="urls[${index}][url]"
                    class="url w-full sm:flex-1 border rounded p-2"
                    placeholder="https://">
                <button
                    type="button"
                    class="delete-url p-2 text-white bg-slate-400 rounded">
                    削除
                </button>
            `;
                urlContainer.appendChild(row);
            }
            row.querySelector("input[name$='[memo]']").value =
                urlData.memo ?? "";

            row.querySelector("input[name$='[url]']").value =
                urlData.url ?? "";
        });

    }

}

loadCompany();

if (form) {

    // ------------------------
    // 給与計算
    // ------------------------

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

    // ------------------------
    // URL追加
    // ------------------------

    const urlList = document.getElementById("url-list");
    const addButton = document.getElementById("add-url");

    let index =
        document.querySelectorAll("input[name$='[url]']").length;

    addButton.addEventListener("click", () => {

        const div = document.createElement("div");

        div.className =
            "flex flex-col sm:flex-row gap-3 mt-3 min-w-0";

        div.innerHTML = `
<input
type="text"
name="urls[${index}][memo]"
placeholder="詳細"
class="memo w-full sm:w-1/3 border rounded p-2">

<input
type="url"
name="urls[${index}][url]"
placeholder="https://"
class="url w-full sm:flex-1 border rounded p-2">

<button
type="button"
class="delete-url p-2 text-white bg-slate-400 rounded">
削除
</button>
`;

        urlList.appendChild(div);

        index++;

    });

    // ------------------------
    // URL削除
    // ------------------------

    document.addEventListener("click", e => {

        if (e.target.classList.contains("delete-url")) {

            e.target.closest(".flex").remove();

        }

        if (e.target.classList.contains("clear-url")) {

            const row = e.target.closest(".flex");

            row.querySelector(".memo").value = "";
            row.querySelector(".url").value = "";

        }

    });

    // ------------------------
    // 更新
    // ------------------------

    form.addEventListener("submit", async e => {

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

        const oldCompany = await getData(
            STORES.COMPANIES,
            form.dataset.id
        );

        const company = {
            ...oldCompany,

            id: Number(form.dataset.id),

            name: formData.get("name"),
            level: Number(formData.get("level")),

            address: formData.get("address"),
            industry: formData.get("industry"),

            salary: Number(formData.get("salary")),
            basic_salary: Number(formData.get("basic_salary")),
            other_salary: Number(formData.get("other_salary")),

            start_time: formData.get("start_time"),
            end_time: formData.get("end_time"),
            break_time: Number(formData.get("break_time")),

            training_period:
                Number(formData.get("training_year")) * 12 +
                Number(formData.get("training_month")),

            ses_level: formData.get("ses_level"),

            benefits_memo: formData.get("benefits_memo"),
            free_memo: formData.get("free_memo"),

            urls: urls.filter(url =>
                url && (url.memo || url.url)
            ),

            created_at: oldCompany.created_at,
            updated_at: new Date().toISOString(),
        };


        await updateData(
            STORES.COMPANIES,
            form.dataset.id,
            company
        );
        location.href = "/companies";

    });

}

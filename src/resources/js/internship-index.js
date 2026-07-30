import { getAllData, addData, deleteData, STORES } from "./indexeddb";

const internshipList = document.getElementById("internship-list");
const template = document.getElementById("internship-card-template");

const searchInput = document.querySelector("input[name='searchI']");
const searchButton = document.querySelector("button[type='submit']");
const sortSelect = document.getElementById("sort");
const appliedCheckbox = document.querySelector("input[name='applied']");
const joinedCheckbox = document.querySelector("input[name='joined']");

let companies = [];
let internships = [];
companies = await getAllData(STORES.COMPANIES);
internships = await getAllData(STORES.INTERNSHIPS);

async function initializeInternships() {
    try {
        const storedInternships = await getAllData(STORES.INTERNSHIPS);

        if (storedInternships.length === 0 && initialInternships.length > 0) {
            for (const internship of initialInternships) {
                await addData(STORES.INTERNSHIPS, internship);
            }
        }

        internships = await getAllData(STORES.INTERNSHIPS);

        renderInternships();

    } catch (error) {
        console.error("インターンシップの読み込みに失敗しました", error);

        internshipList.innerHTML = `
            <p class="px-6 mt-5 text-red-500">
                インターンシップの読み込みに失敗しました
            </p>
        `;
    }
}

function renderInternships() {
    const searchWord = searchInput.value.trim().toLowerCase();
    const sortType = sortSelect.value;
    const appliedOnly = appliedCheckbox.checked;
    const joinedOnly = joinedCheckbox.checked;

    let filteredInternships = internships.filter(internship => {
        const name = (internship.name ?? "").toLowerCase();

        if (!name.includes(searchWord)) return false;
        if (appliedOnly && !internship.applied) return false;
        if (joinedOnly && internship.joined) return false;

        return true;
    });

    if (sortType === "old") {
        filteredInternships.sort((a, b) => {
            const dateA = new Date(a.start_datetime ?? 0);
            const dateB = new Date(b.start_datetime ?? 0);
            return dateA - dateB;
        });
    } else {
        filteredInternships.sort((a, b) => {
            const dateA = new Date(a.start_datetime ?? 0);
            const dateB = new Date(b.start_datetime ?? 0);
            return dateB - dateA;
        });
    }

    internshipList.innerHTML = "";

    if (filteredInternships.length === 0) {
        internshipList.innerHTML = `
            <p class="px-6 mt-5">
                インターンシップが登録されていません。
            </p>
        `;
        return;
    }

    const container = document.createElement("div");
    container.className = "mx-auto max-w-6xl rounded-lg p-8";

    const grid = document.createElement("div");
    grid.className = "grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-start";

    filteredInternships.forEach(internship => {
        const card = createInternshipCard(internship);
        grid.appendChild(card);
    });

    container.appendChild(grid);
    internshipList.appendChild(container);
}

function createInternshipCard(internship) {
    const card = template.content.cloneNode(true);

    // インターンシップ名
    card.querySelector(".internship-name").textContent =
        internship.name ?? "名称なし";

    // 企業名
    const company = companies.find(
        company => company.id === internship.company_id
    );

    card.querySelector(".internship-company").textContent =
        company?.name ?? "企業未登録";

    // 日程
    let dateText = "";

    if (internship.start_datetime) {
        const start = new Date(internship.start_datetime);

        dateText +=
            `${start.getFullYear()}/` +
            `${String(start.getMonth() + 1).padStart(2, "0")}/` +
            `${String(start.getDate()).padStart(2, "0")} ` +
            `${String(start.getHours()).padStart(2, "0")}:` +
            `${String(start.getMinutes()).padStart(2, "0")}`;
    }

    if (internship.end_datetime) {
        const end = new Date(internship.end_datetime);

        dateText +=
            ` ～ ${end.getFullYear()}/` +
            `${String(end.getMonth() + 1).padStart(2, "0")}/` +
            `${String(end.getDate()).padStart(2, "0")} ` +
            `${String(end.getHours()).padStart(2, "0")}:` +
            `${String(end.getMinutes()).padStart(2, "0")}`;
    }

    card.querySelector(".internship-datetime").textContent = dateText || "未設定";

    // URL
    const urlContainer = card.querySelector(".internship-url");

    if (internship.url) {
        urlContainer.innerHTML = `
            <strong>URL：</strong>
            <a href="${internship.url}" target="_blank" rel="noopener noreferrer" class="text-blue-500 underline">
                インターンシップ詳細ページ
            </a>
        `;
    } else {
        urlContainer.innerHTML = `
            <strong>URL：</strong>
            <span>登録なし</span>
        `;
    }
    // 応募状況
    const appliedElement = card.querySelector(".internship-applied");
    appliedElement.textContent = internship.applied ? "応募済み" : "未応募";
    if (internship.applied) {
        appliedElement.classList.add("text-green-600");
    }

    // 参加状況
    const joinedElement = card.querySelector(".internship-joined");
    joinedElement.textContent = internship.joined ? "参加済み" : "未参加";
    if (internship.joined) {
        joinedElement.classList.add("text-green-600");
    }

    // 開催場所
    card.querySelector(".internship-place").textContent =
        internship.place || "なし";

    // 最寄り駅
    card.querySelector(".internship-station").textContent =
        internship.station || "なし";

    // 内容
    card.querySelector(".internship-content").textContent =
        internship.content || "なし";

    // 交通費支給
    card.querySelector(".internship-carfare").textContent =
        internship.carfare ? "あり" : "なし";

    // 自費交通費
    card.querySelector(".internship-carfare-price").textContent =
        internship.carfare_price || "なし";

    // 昼食支給
    card.querySelector(".internship-lunch").textContent =
        internship.lunch ? "あり" : "なし";

    // 参加後メモ
    card.querySelector(".internship-joined-memo").textContent =
        internship.joined_memo || "なし";

    // 編集
    card.querySelector(".edit-link").href =
        `/internships/${internship.id}/edit`;

    // 削除
    const deleteButton = card.querySelector(".delete-button");

    deleteButton.addEventListener("click", async () => {
        const confirmed = confirm("このインターンシップを削除しますか？");
        if (!confirmed) return;

        try {
            await deleteData(STORES.INTERNSHIPS, internship.id);

            internships = internships.filter(item => item.id !== internship.id);

            renderInternships();

        } catch (error) {
            console.error("インターンシップの削除に失敗しました", error);
            alert("インターンシップの削除に失敗しました");
        }
    });

    // 詳細を閉じる
    const closeButton = card.querySelector(".close-details");

    closeButton.addEventListener("click", () => {
        const details = closeButton.closest("details");
        details.removeAttribute("open");
    });

    return card;
}

// 検索
searchButton.addEventListener("click", event => {
    event.preventDefault();
    renderInternships();
});

// Enterキーでも検索
searchInput.addEventListener("keydown", event => {
    if (event.key === "Enter") {
        event.preventDefault();
        renderInternships();
    }
});

// 並べ替え
sortSelect.addEventListener("change", renderInternships);

// 応募済みフィルタ
appliedCheckbox.addEventListener("change", renderInternships);

// 未参加フィルタ
joinedCheckbox.addEventListener("change", renderInternships);

// 初期化
initializeInternships();

document.addEventListener("DOMContentLoaded", () => {
    loadInternships();
});

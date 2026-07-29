import {
    getAllData,
    addData,
    deleteData,
    STORES
} from './indexeddb.js';

const companyList = document.getElementById('company-list');
const template = document.getElementById('company-card-template');

const searchInput = document.getElementById('search');
const searchButton = document.getElementById('search-button');
const sortSelect = document.getElementById('sort');


// 現在表示する企業データ
let companies = [];


// 初期データをIndexedDBへ保存
async function initializeCompanies() {
    try {
        const storedCompanies = await getAllData(STORES.COMPANIES);

        // IndexedDBにデータがない場合のみ初期データを保存
        if (storedCompanies.length === 0 && initialCompanies.length > 0) {

            for (const company of initialCompanies) {
                await addData(STORES.COMPANIES, company);
            }
        }

        // IndexedDBから企業データを取得
        companies = await getAllData(STORES.COMPANIES);

        renderCompanies();

    } catch (error) {
        console.error('企業情報の読み込みに失敗しました', error);

        companyList.innerHTML = `
            <p class="px-6 mt-5 text-red-500">
                企業情報の読み込みに失敗しました
            </p>
        `;
    }
}


// 企業一覧を表示
function renderCompanies() {

    const searchWord = searchInput.value.trim().toLowerCase();
    const sortType = sortSelect.value;


    // 検索
    let filteredCompanies = companies.filter(company => {

        const name = company.name ?? '';

        return name.toLowerCase().includes(searchWord);
    });


    // 並べ替え
    if (sortType === 'high') {

        filteredCompanies.sort((a, b) => {
            return Number(b.level ?? 0) - Number(a.level ?? 0);
        });

    } else if (sortType === 'low') {

        filteredCompanies.sort((a, b) => {
            return Number(a.level ?? 0) - Number(b.level ?? 0);
        });

    } else {

        // 登録日時が新しい順
        filteredCompanies.sort((a, b) => {

            const dateA = new Date(a.created_at ?? 0);
            const dateB = new Date(b.created_at ?? 0);

            return dateB - dateA;
        });
    }


    // 一覧をクリア
    companyList.innerHTML = '';


    // 企業がない場合
    if (filteredCompanies.length === 0) {

        companyList.innerHTML = `
            <p class="px-6 mt-5">
                企業が登録されていません。
            </p>
        `;

        return;
    }


    // カードを配置するコンテナ
    const container = document.createElement('div');

    container.className =
        'mx-auto max-w-6xl rounded-lg p-8';

    const grid = document.createElement('div');

    grid.className =
        'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-start';


    filteredCompanies.forEach(company => {

        const card = createCompanyCard(company);

        grid.appendChild(card);

    });


    container.appendChild(grid);

    companyList.appendChild(container);
}


// 企業カードを作成
function createCompanyCard(company) {

    const card =
        template.content.cloneNode(true);


    // 企業名
    card.querySelector('.company-name').textContent =
        company.name ?? '企業名なし';


    // 志望度
    const level =
        Number(company.level ?? 0);

    let stars = '';

    for (let i = 1; i <= 5; i++) {
        stars += i <= level ? '★' : '☆';
    }

    card.querySelector('.company-level').textContent =
        stars;


    // 給与
    card.querySelector('.company-salary').textContent =
        company.salary ?? 0;


    // 勤務時間
    const startTime =
        company.start_time
            ? company.start_time.substring(0, 5)
            : '';

    const endTime =
        company.end_time
            ? company.end_time.substring(0, 5)
            : '';

    card.querySelector('.company-working-time').textContent =
        `${startTime} ～ ${endTime}`;


    // SES度
    card.querySelector('.company-ses-level').textContent =
        company.ses_level ?? '不明';


    // URL
    const urlsContainer =
        card.querySelector('.company-urls');

    if (company.urls && company.urls.length > 0) {

        company.urls.forEach(urlData => {

            const div =
                document.createElement('div');

            const strong =
                document.createElement('strong');

            strong.textContent = 'URL：';

            const link =
                document.createElement('a');

            link.href = urlData.url;
            link.target = '_blank';
            link.rel = 'noopener noreferrer';

            link.className =
                'text-blue-500 underline';

            link.textContent =
                urlData.memo || urlData.url;


            div.appendChild(strong);
            div.appendChild(link);

            urlsContainer.appendChild(div);

        });

    } else {

        urlsContainer.innerHTML = `
            <div>
                <strong>URL：</strong>
                <span>登録なし</span>
            </div>
        `;
    }


    // 所在地
    card.querySelector('.company-address').textContent =
        company.address || 'なし';


    // 業種
    card.querySelector('.company-industry').textContent =
        company.industry || 'なし';


    // 給与内訳
    card.querySelector('.company-basic-salary').textContent =
        company.basic_salary ?? 0;

    card.querySelector('.company-other-salary').textContent =
        company.other_salary ?? 0;


    // 休憩時間
    card.querySelector('.company-break-time').textContent =
        company.break_time ?? 0;


    // 研修期間
    const trainingPeriod =
        Number(company.training_period ?? 0);

    const trainingYear =
        Math.floor(trainingPeriod / 12);

    const trainingMonth =
        trainingPeriod % 12;

    card.querySelector('.company-training-period').textContent =
        `${trainingYear}年 ${trainingMonth}か月`;


    // 福利厚生メモ
    card.querySelector('.company-benefits-memo').textContent =
        company.benefits_memo || 'なし';


    // メモ
    card.querySelector('.company-free-memo').textContent =
        company.free_memo || 'なし';


    // 編集リンク
    const editLink =
        card.querySelector('.edit-link');

    editLink.href =
        `/company/${company.id}/edit`;


    // 削除
    const deleteButton =
        card.querySelector('.delete-button');

    deleteButton.addEventListener('click', async () => {

        const confirmed =
            confirm('この企業を削除しますか？');

        if (!confirmed) {
            return;
        }

        try {

            await deleteData(
                STORES.COMPANIES,
                company.id
            );

            // 現在の配列から削除
            companies =
                companies.filter(
                    item => item.id !== company.id
                );

            renderCompanies();

        } catch (error) {

            console.error(
                '企業の削除に失敗しました',
                error
            );

            alert(
                '企業の削除に失敗しました'
            );
        }
    });


    // 詳細を閉じる
    const closeButton =
        card.querySelector('.close-details');

    closeButton.addEventListener('click', () => {

        const details =
            closeButton.closest('details');

        details.removeAttribute('open');

    });


    return card;
}


// 検索
searchButton.addEventListener(
    'click',
    renderCompanies
);


// Enterキーでも検索
searchInput.addEventListener(
    'keydown',
    event => {

        if (event.key === 'Enter') {

            event.preventDefault();

            renderCompanies();
        }
    }
);


// 並べ替え
sortSelect.addEventListener(
    'change',
    renderCompanies
);


// 初期化
initializeCompanies();

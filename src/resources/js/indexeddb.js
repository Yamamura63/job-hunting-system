const DB_NAME = 'job-hunting-system';
const DB_VERSION = 1;

const STORES = {
    SELF_PRS: 'self_prs',
    COMPANIES: 'companies',
    INTERNSHIPS: 'internships',
    SELECTIONS: 'selections',
};

let dbPromise = null;

function openDB() {
    if (dbPromise) {
        return dbPromise;
    }

    dbPromise = new Promise((resolve, reject) => {
        const request = indexedDB.open(DB_NAME, DB_VERSION);

        request.onupgradeneeded = event => {
            const db = event.target.result;

            if (!db.objectStoreNames.contains(STORES.SELF_PRS)) {
                db.createObjectStore(STORES.SELF_PRS, {
                    keyPath: 'id',
                    autoIncrement: true
                });
            }

            if (!db.objectStoreNames.contains(STORES.COMPANIES)) {
                db.createObjectStore(STORES.COMPANIES, {
                    keyPath: 'id',
                    autoIncrement: true
                });
            }

            if (!db.objectStoreNames.contains(STORES.INTERNSHIPS)) {
                db.createObjectStore(STORES.INTERNSHIPS, {
                    keyPath: 'id',
                    autoIncrement: true
                });
            }

            if (!db.objectStoreNames.contains(STORES.SELECTIONS)) {
                db.createObjectStore(STORES.SELECTIONS, {
                    keyPath: 'id',
                    autoIncrement: true
                });
            }
        };

        request.onsuccess = event => {
            resolve(event.target.result);
        };

        request.onerror = event => {
            reject(event.target.error);
        };
    });

    return dbPromise;
}


// 全件取得
export async function getAllData(storeName) {
    const db = await openDB();

    return new Promise((resolve, reject) => {
        const transaction = db.transaction(storeName, 'readonly');
        const store = transaction.objectStore(storeName);
        const request = store.getAll();

        request.onsuccess = () => {
            resolve(request.result);
        };

        request.onerror = () => {
            reject(request.error);
        };
    });
}


// 1件取得
export async function getData(storeName, id) {
    const db = await openDB();

    return new Promise((resolve, reject) => {
        const transaction = db.transaction(storeName, 'readonly');
        const store = transaction.objectStore(storeName);

        const request = store.get(Number(id));

        request.onsuccess = () => {
            resolve(request.result);
        };

        request.onerror = () => {
            reject(request.error);
        };
    });
}


// 新規登録
export async function addData(storeName, data) {
    const db = await openDB();

    return new Promise((resolve, reject) => {
        const transaction = db.transaction(storeName, 'readwrite');
        const store = transaction.objectStore(storeName);

        const request = store.add(data);

        request.onsuccess = () => {
            resolve(request.result);
        };

        request.onerror = () => {
            reject(request.error);
        };
    });
}


// 更新
export async function updateData(storeName, id, data) {
    const db = await openDB();

    return new Promise((resolve, reject) => {
        const transaction = db.transaction(storeName, 'readwrite');
        const store = transaction.objectStore(storeName);

        const request = store.put({
            ...data,
            id: Number(id)
        });

        request.onsuccess = () => {
            resolve(request.result);
        };

        request.onerror = () => {
            reject(request.error);
        };
    });
}


// 削除
export async function deleteData(storeName, id) {
    const db = await openDB();

    return new Promise((resolve, reject) => {
        const transaction = db.transaction(storeName, 'readwrite');
        const store = transaction.objectStore(storeName);

        const request = store.delete(Number(id));

        request.onsuccess = () => {
            resolve();
        };

        request.onerror = () => {
            reject(request.error);
        };
    });
}

export {
    STORES
};

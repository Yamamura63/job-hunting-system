const DB_NAME = 'job-hunting-system';
const DB_VERSION = 1;

const STORES = [
    'self_prs',
    'companies',
    'internships',
    'selections'
];

function openDB() {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open(DB_NAME, DB_VERSION);

        request.onupgradeneeded = event => {
            const db = event.target.result;

            STORES.forEach(storeName => {
                if (!db.objectStoreNames.contains(storeName)) {
                    db.createObjectStore(storeName, {
                        keyPath: 'id',
                        autoIncrement: true
                    });
                }
            });
        };

        request.onsuccess = event => {
            resolve(event.target.result);
        };

        request.onerror = event => {
            reject(event.target.error);
        };
    });
}

export async function addData(storeName, data) {
    const db = await openDB();

    return new Promise((resolve, reject) => {
        const transaction = db.transaction(storeName, 'readwrite');
        const store = transaction.objectStore(storeName);

        const request = store.add({
            ...data,
            created_at: new Date().toISOString(),
            updated_at: new Date().toISOString()
        });

        request.onsuccess = () => {
            resolve(request.result);
        };

        request.onerror = event => {
            reject(event.target.error);
        };
    });
}

export async function getAllData(storeName) {
    const db = await openDB();

    return new Promise((resolve, reject) => {
        const transaction = db.transaction(storeName, 'readonly');
        const store = transaction.objectStore(storeName);

        const request = store.getAll();

        request.onsuccess = () => {
            resolve(request.result);
        };

        request.onerror = event => {
            reject(event.target.error);
        };
    });
}

export async function getData(storeName, id) {
    const db = await openDB();

    return new Promise((resolve, reject) => {
        const transaction = db.transaction(storeName, 'readonly');
        const store = transaction.objectStore(storeName);

        const request = store.get(Number(id));

        request.onsuccess = () => {
            resolve(request.result);
        };

        request.onerror = event => {
            reject(event.target.error);
        };
    });
}

export async function updateData(storeName, id, data) {
    const db = await openDB();

    return new Promise((resolve, reject) => {
        const transaction = db.transaction(storeName, 'readwrite');
        const store = transaction.objectStore(storeName);

        const request = store.put({
            ...data,
            id: Number(id),
            updated_at: new Date().toISOString()
        });

        request.onsuccess = () => {
            resolve(request.result);
        };

        request.onerror = event => {
            reject(event.target.error);
        };
    });
}

export async function deleteData(storeName, id) {
    const db = await openDB();

    return new Promise((resolve, reject) => {
        const transaction = db.transaction(storeName, 'readwrite');
        const store = transaction.objectStore(storeName);

        const request = store.delete(Number(id));

        request.onsuccess = () => {
            resolve();
        };

        request.onerror = event => {
            reject(event.target.error);
        };
    });
}

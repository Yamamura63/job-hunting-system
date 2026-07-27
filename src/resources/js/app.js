import './bootstrap';
import './indexeddb';

import {
    addData,
    getAllData,
    getData,
    updateData,
    deleteData
} from './indexeddb';

window.indexedDBService = {
    addData,
    getAllData,
    getData,
    updateData,
    deleteData
};

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/service-worker.js')
            .then(registration => {
                console.log(
                    'Service Worker registered:',
                    registration.scope
                );
            })
            .catch(error => {
                console.error(
                    'Service Worker registration failed:',
                    error
                );
            });
    });
}

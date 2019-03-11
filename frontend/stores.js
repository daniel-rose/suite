const stores = new Map();

stores.set('default', {
    name: '',
    theme: 'default'
});

stores.set('DE', {
    name: 'DE',
    theme: 'custom-de'
})

function getStore(key) {
    if (stores.has(key)) {
        console.log(`Store "${key}" loaded.`);
        return printStoreInfo(stores.get(key));
    }

    console.warn(`Store "${key}" does not exist. Default store loaded instead.`);
    return printStoreInfo(stores.get('default'));
}

function getAllStores() {
    console.log(`All stores loaded.`);
    return Array
        .from(stores.values())
        .map(printStoreInfo);
}

function printStoreInfo(store) {
    console.log('- name:', store.name);
    console.log('- theme:', store.theme);
    return store;
}

module.exports = {
    getStore,
    getAllStores
}

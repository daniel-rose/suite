const stores = require('../stores');

function printWrongStoreIdMessage(name) {
    console.warn(`Store "${name}" does not exist.`);
}

function printStoreInfoMessage(store) {
    if (store.isDefault) {
        console.log('Default store.');
        return store;
    }

    console.log(`Store "${store.name}" with theme "${store.theme}".`);
    return store;
}

function enrich(store) {
    return {
        ...store,
        isDefault: (store.name === '' && store.theme === 'default')
    }
}

function getStoresByIds(ids) {
    if (ids.length === 0) {
        console.warn('Type the ID of the store you want to build.');
        console.warn('Or type "all" to build every store.');
        return [];
    }

    if (ids.length === 1 && ids[0] === 'all') {
        console.log(`Full frontend build (${stores.size} stores).`);
        console.log(`Functionality in development...`);
        return []; //stores
    }

    ids
        .filter(id => !stores.has(id))
        .forEach(printWrongStoreIdMessage);

    return ids
        .filter(id => stores.has(id))
        .map(id => stores.get(id))
        .map(enrich)
        .map(printStoreInfoMessage);
}

module.exports = {
    getStoresByIds
}

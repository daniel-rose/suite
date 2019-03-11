const stores = [
    {
        name: 'DE',
        theme: 'custom-de'
    }
];

function get(name) {
    return stores.find(store => store.name === name);
}

function exists(name) {
    return !!get(name);
}

function printWrongStoreNameMessage(name) {
    console.warn(`Store "${name}" does not exist.`);
}

function printStoreInfoMessage(name, store) {
    console.log(`Store "${store.name}" with theme "${store.theme}".`);
}

function getStoresByNames(names) {
    if (names.length === 0) {
        console.error('Provide the name of the target store or "all" to build the whole frontend.');
        return [];
    }

    if (names.length === 1 && names[0] === 'all') {
        console.error('Full frontend build (all stores).');
        return stores;
    }

    names
        .filter(name => !exists(name))
        .forEach(printWrongStoreNameMessage);

    return names
        .filter(name => exists(name))
        .map(name => {
            const store = get(name);
            printStoreInfoMessage(name, store);
            return store;
        });
}

module.exports = {
    getStoresByNames
}

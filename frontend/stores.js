const stores = [
    {
        name: 'DE',
        theme: 'custom-de'
    }
];

function getStoreByName(name) {
    return stores.find(store => store.name === name);
}

function exists(name) {
    return !!getStoreByName(name);
}

function printWrongStoreNameMessage(name) {
    console.warn(`Store "${name}" does not exist.`);
}

function printStoreInfoMessage(store) {
    console.log(`Store "${store.name}" with theme "${store.theme}".`);
    return store;
}

function getStoresByNames(names) {
    if (names.length === 0) {
        console.error('Provide the name of the target store or "all" to build the whole frontend.');
        return [];
    }

    if (names.length === 1 && names[0] === 'all') {
        console.log(`Full frontend build (${stores.length} stores).`);
        console.log(`Functionality in development...`);
        return []; //stores
    }

    names
        .filter(name => !exists(name))
        .forEach(printWrongStoreNameMessage);

    return names
        .filter(exists)
        .map(getStoreByName)
        .map(printStoreInfoMessage);
}

module.exports = {
    getStoresByNames
}

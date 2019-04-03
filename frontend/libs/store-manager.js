const stores = require('../stores');

if (stores.has('default')) {
    console.warn('Your store registry contains a "default".');
    console.warn('Default store is reserved for the system and cannot be customised.');
    console.warn('it\'s orginal configuration will be restored.');
}

stores.set('default', {
    name: '',
    themes: ['default']
});

function getCurrentThemesFallbackChain(store) {
    const currentThemeIndex = store
        .themesFallbackChain
        .indexOf(store.theme);

    const chain = [
        ...store.themesFallbackChain,
        'default'
    ];

    return chain.slice(currentThemeIndex);
}

function printWrongStoreIdMessage(name) {
    console.warn(`Store "${name}" does not exist.`);
}

function printStoreInfoMessage(store) {
    if (store.isDefault) {
        console.log('Default store.\n');
        return store;
    }

    console.log(`Store "${store.name}" with theme "${store.theme}".`);
    console.log(`Theme fallback chain: ${getCurrentThemesFallbackChain(store).join(', ')}\n`);
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
        console.warn('Type the ID of the store you want to build:');
        console.warn('npm run yves [storeId]\n');
        console.warn('Or type "which" to get the list of available stores:');
        console.warn('npm run yves which\n');
        return [];
    }

    if (ids.length === 1 && ids[0] === 'which') {
        console.log('Available stores:');
        Array.from(stores.keys()).map(id => console.log(`- ${id}`));
        console.log('');
        return [];
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

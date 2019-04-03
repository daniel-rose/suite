const stores = new Map();

stores.set('de', {
    name: 'DE',
    theme: 'a-blue-theme',
    themesFallbackChain: [
        'a-blue-theme'
    ]
});

stores.set('us', {
    name: 'US',
    theme: 'a-red-theme',
    themesFallbackChain: [
        'a-red-theme',
        'a-green-theme'
    ]
});

module.exports = stores;

const stores = new Map();

stores.set('default', {
    name: '',
    theme: 'default'
});

stores.set('de', {
    name: 'DE',
    theme: 'a-blue-theme'
});

stores.set('us', {
    name: 'US',
    theme: 'a-red-theme'
});

module.exports = stores;

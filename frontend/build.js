// get the webpack compiler
const compiler = require('./libs/compiler');
const { getStore, getAllStores } = require('./stores');

// get the mode arg from `npm run xxx` script defined in package.json
const [mode, storeId] = process.argv.slice(2);
const stores = !!storeId ? [getStore(storeId)] : getAllStores();

const { getAppSettings } = require('./settings');

// get the webpack configuration associated with the provided mode
const getConfiguration = require(`./configs/${mode}`);

const configurationPromises = stores
    .map(store => getAppSettings(store))
    .map(appSettings => getConfiguration(appSettings))

// build the project
Promise.all(configurationPromises)
    .then(configs => compiler.multiCompile(configs))
    .catch(error => console.error('An error occur while creating configuration', error));

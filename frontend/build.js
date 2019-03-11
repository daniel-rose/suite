// get the webpack compiler
const compiler = require('./libs/compiler');
const { getStoresByNames } = require('./stores');
const { getAppSettings } = require('./settings');

// get the mode arg from
// `npm run mode [storeName1 storeName2... storeNameN]`
// defined in package.json as script
const [mode, ...storeNames] = process.argv.slice(2);

// get the webpack configuration associated with the provided mode
const getConfiguration = require(`./configs/${mode}`);

// get the promise for each store webpack configuration
const configurationPromises = getStoresByNames(storeNames)
    .map(getAppSettings)
    .map(getConfiguration);

// build the project
Promise.all(configurationPromises)
    .then(configs => compiler.multiCompile(configs))
    .catch(error => console.error('An error occur while creating configuration', error));

const path = require('path');
const glob = require('fast-glob');

// define the default glob settings for fast-glob
const defaultGlobSettings = {
    followSymlinkedDirectories: false,
    absolute: true,
    onlyFiles: true,
    onlyDirectories: false
}

// perform a search in a list of directories
// matching provided patterns
// using provided glob settings
async function globAsync(patterns, rootConfiguration) {
    try {
        return await glob(patterns, rootConfiguration);
    } catch(error) {
        console.error('An error occurred while globbing the system for entry points.', error);
    }
}

async function find(globDirs, globPatterns, globSettings = {}) {
    return await globDirs.reduce(async (resultsPromise, dir) => {
        const rootConfiguration = {
            ...defaultGlobSettings,
            ...globSettings,
            cwd: dir
        };

        const results = await resultsPromise;
        const globPath = await globAsync(globPatterns, rootConfiguration);

        return results.concat(globPath);
    }, Promise.resolve([]));
}

// find components entry points
async function findEntryPoints(settings, description = '') {
    const files = await find(settings.dirs, settings.patterns, settings.globSettings);

    const entryPoints = Object.values(files.reduce((map, file) => {
        const dir = path.dirname(file);
        const name = path.basename(dir);
        const type = path.basename(path.dirname(dir));
        map[`${type}/${name}`] = file;
        return map;
    }, {}));

    console.log(`${description} entry points: ${entryPoints.length}`);
    return entryPoints;
}

// find component styles
async function findStyles(settings, description = '') {
    const styles = await find(settings.dirs, settings.patterns, settings.globSettings);

    console.log(`${description} styles: ${styles.length}`);
    return styles;
}

module.exports = {
    findEntryPoints,
    findStyles
}

const { join } = require('path');

// define the current context (root)
const context = process.cwd();

function getAppSettings(store) {
    // define the applicatin name
    const name = `yves_${store.name}`;

    // define the default theme
    const defaultTheme = 'default';

    // define the search pattern for glob
    const themePattern = `(${defaultTheme}|${store.theme})`;

    // define project relative paths to context
    const paths = {
        // locate the typescript configuration json file
        tsConfig: './tsconfig.json',

        // assets folder
        assets: join('./frontend/assets', store.theme),

        // public folder
        public: join('./public/Yves/assets', store.theme),

        // core folders
        core: {
            // all modules
            modules: './vendor/spryker-shop',
            // ShopUi source folder
            shopUiModule: `./vendor/spryker-shop/shop-ui/src/SprykerShop/Yves/ShopUi/Theme/${defaultTheme}`
        },

        // eco folders
        eco: {
            // all modules
            modules: './vendor/spryker-eco'
        },

        // project folders
        project: {
            // all modules
            modules: './src/Pyz/Yves',
            // base ShopUi source folder
            shopUiModule: `./src/Pyz/Yves/ShopUi/Theme/${defaultTheme}`,
            // store ShopUi source folder
            shopUiStoreModule: `./src/Pyz/Yves/ShopUi${store.name}/Theme/${store.theme}`
        }
    };

    // define relative urls to site host (/)
    const urls = {
        // assets base url
        assets: join('/assets', store.theme)
    };

    // return settings
    return {
        name,
        theme: store.theme,
        context,
        paths,
        urls,

        // define settings for suite-frontend-builder finder
        find: {
            // webpack entry points (components) finder settings
            componentEntryPoints: {
                // absolute dirs in which look for
                dirs: [
                    join(context, paths.core.modules),
                    join(context, paths.eco.modules),
                    join(context, paths.project.modules)
                ],
                // files/dirs patterns
                patterns: [
                    `**/Theme/${themePattern}/components/atoms/*/index.ts`,
                    `**/Theme/${themePattern}/components/molecules/*/index.ts`,
                    `**/Theme/${themePattern}/components/organisms/*/index.ts`,
                    `**/Theme/${themePattern}/templates/*/index.ts`,
                    `**/Theme/${themePattern}/views/*/index.ts`,
                    '!config',
                    '!data',
                    '!deploy',
                    '!node_modules',
                    '!public',
                    '!test'
                ]
            },

            // core component styles finder settings
            // important: this part is used in shared scss environment
            // do not change unless necessary
            componentStyles: {
                // absolute dirs in which look for
                dirs: [
                    join(context, paths.core.modules),
                    join(context, paths.project.modules)
                ],
                // files/dirs patterns
                patterns: [
                    `**/Theme/${defaultTheme}/components/atoms/*/*.scss`,
                    `**/Theme/${defaultTheme}/components/molecules/*/*.scss`,
                    `**/Theme/${defaultTheme}/components/organisms/*/*.scss`,
                    `**/Theme/${defaultTheme}/templates/*/*.scss`,
                    `**/Theme/${defaultTheme}/views/*/*.scss`,
                    `!**/Theme/${defaultTheme}/**/style.scss`,
                    '!config',
                    '!data',
                    '!deploy',
                    '!node_modules',
                    '!public',
                    '!test'
                ]
            }
        }
    }
}

module.exports = {
    getAppSettings
}

const mix = require('laravel-mix');
const glob = require('glob');
const themePath = `.`;
const ressourcesPath = `assets`;
const buildPath = `build`;

//mix.autoload({
//    jquery: ['$', 'window.jQuery', 'jQuery']
//});

mix.webpackConfig({
    devtool: 'source-map',
    resolve: {
        alias: {
            'vue$': mix.inProduction() ? 'vue/dist/vue.min.js' : 'vue/dist/vue.js'
        }
    }
});

mix.options({
    autoprefixer: { remove: false }
});

mix.setPublicPath(`${buildPath}`);

mix.copy(`${ressourcesPath}/images/`, `${buildPath}/images`, false);
mix.copy(`${ressourcesPath}/fonts/`, `${buildPath}/fonts`, false);

mix.sourceMaps();

if (mix.inProduction()) {
    mix.version();
} else {
    mix.browserSync({
        proxy: "localhost",
        files: [
            `${themePath}/**/*.php`,
            `${themePath}/**/*.twig`,
            `${buildPath}/**/*.js`,
            `${buildPath}/**/*.css`
        ],
        reloadDebounce: 2000,
        cors: true,
        open: false,
        tunnel: false,
        online: false,
        ghostMode: false,
        xip: true
    });
}

glob.sync(`${ressourcesPath}/styles/**/[^_]*.scss`).forEach((sassFile) => {
    mix.sass(sassFile, `${buildPath}/styles`).options({
        processCssUrls: false
    });
});

glob.sync(`${ressourcesPath}/scripts/**/[^_]*.js`).forEach((jsFile) => {
    mix.js(jsFile, `${buildPath}/scripts`);
});

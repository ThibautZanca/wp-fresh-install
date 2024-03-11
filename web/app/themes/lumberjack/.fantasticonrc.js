module.exports = {
    name: 'icons', //nom des fichiers générés
    inputDir: './assets/fonts/icons/svg', // (obligatoire) dossiers sources
    outputDir: './assets/fonts/icons', // (obligatoire) dossier de destination
    fontTypes: ['ttf', 'woff', 'woff2'], //format des fonts
    assetTypes: ['scss'], //fichiers de sorties, généralment uniquement 'scss' est suffisant
    normalize: true, //pour gérer le centrage
    descent: 45, //pour gérer le centrage
    fontsUrl: '../fonts/icons', //définit le chemin de @fontface
};

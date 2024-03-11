import AOS from 'aos';

$(window).on('load', function () {

    const loader = document.querySelector('[js-loader]');
    loader.classList.add('loaded');

    document.body.classList.add('ready');

    if (loader.classList.contains('loaded')) {
        setTimeout(function () {

            AOS.init({
                disable: function () {
                    return window.matchMedia('(max-width:960px)').matches;
                },
                duration: 400,
                once: true
            });

        }, 500);
    }
});

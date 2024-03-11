const arrowUp = document.querySelector('[js-arrow-up]');

if(arrowUp){

    arrowUp.addEventListener('click', () => {
        smoothscroll();
    });

    function smoothscroll(){
        let currentScroll = document.documentElement.scrollTop || document.body.scrollTop;
        if (currentScroll > 0) {
            window.requestAnimationFrame(smoothscroll);
            window.scrollTo (0,currentScroll - (currentScroll/5));
        }
    }

}

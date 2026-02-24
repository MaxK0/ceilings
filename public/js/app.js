document.addEventListener('DOMContentLoaded', function() {
    let lastScrollTop = 0;
    const header = document.querySelector('.header');
    const delta = 5;
    const headerHeight = header.offsetHeight;

    window.addEventListener('scroll', function() {
        const st = window.pageYOffset || document.documentElement.scrollTop;

        if (Math.abs(lastScrollTop - st) <= delta) return;

        if (st > lastScrollTop && st > headerHeight) {
            // Скрываем header
            header.classList.add('header-hidden');
        } else {
            // Если прокручиваем вверх, показываем header
            if (st + window.innerHeight < document.body.scrollHeight) {
                header.classList.remove('header-hidden');
            }
        }

        lastScrollTop = st;
    });
});

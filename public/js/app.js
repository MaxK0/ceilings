const isTouchDevice = () => {
    return 'ontouchstart' in window || navigator.maxTouchPoints > 0 || navigator.msMaxTouchPoints > 0;
};

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


    const calculatorButton = document.querySelector('.calculator-button');
    const calculatorTooltip = document.querySelector('.calculator-tooltip');
    const calculatorContainer = document.querySelector('.calculator-button-container');

    if (calculatorButton && calculatorTooltip) {
        // Для сенсорных устройств
        if (isTouchDevice()) {
            let tooltipVisible = false;

            // При клике на кнопку переключаем видимость подсказки
            calculatorButton.addEventListener('click', function(e) {
                e.stopPropagation();
                tooltipVisible = !tooltipVisible;

                if (tooltipVisible) {
                    calculatorTooltip.style.opacity = '1';
                    calculatorTooltip.style.transform = 'translateX(0)';
                } else {
                    calculatorTooltip.style.opacity = '0';
                    calculatorTooltip.style.transform = 'translateX(-10px)';
                }
            });

            // При клике вне кнопки скрываем подсказку
            document.addEventListener('click', function(e) {
                if (tooltipVisible && !calculatorContainer.contains(e.target)) {
                    tooltipVisible = false;
                    calculatorTooltip.style.opacity = '0';
                    calculatorTooltip.style.transform = 'translateX(-10px)';
                }
            });
        }
        // Для устройств с мышью
        else {
            // При клике на кнопку скрываем подсказку
            calculatorButton.addEventListener('click', function() {
                calculatorTooltip.style.opacity = '0';
                calculatorTooltip.style.transform = 'translateX(-10px)';
            });

            // При наведении на контейнер показываем подсказку
            calculatorContainer.addEventListener('mouseenter', function() {
                calculatorTooltip.style.opacity = '1';
                calculatorTooltip.style.transform = 'translateX(0)';
            });

            // При уходе курсора с контейнера скрываем подсказку
            calculatorContainer.addEventListener('mouseleave', function() {
                calculatorTooltip.style.opacity = '0';
                calculatorTooltip.style.transform = 'translateX(-10px)';
            });
        }
    }
});

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="icon" href="{{ asset('img/logo.svg') }}">
</head>
<body>
<div id="site">
    <header class="header">
        <div class="container header__container">
            <nav class="header__nav">
                <div class="header__title">
                    <a href="{{ route('home') }}" class="link-nav link-title">
                        Потолки
                    </a>
                </div>
                <i id="header__menu" class="fa-solid fa-bars"></i>
                <ul class="header__ul">
                    <li>
                        <a href="{{ route('home') }}"
                           class="link-nav {{ request()->routeIs('home') ? 'active' : '' }}">
                            Главная
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}"
                           class="link-nav {{ request()->routeIs('about') ? 'active' : '' }}">
                            О нас
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container footer__container">
            <div class="footer__blocks">
                <div class="footer__info">
                    <div class="footer__info__block">
                        <i class="fa-solid fa-house"></i>
                        <p>Проспект Октября, 1</p>
                    </div>
                    <div class="footer__info__block">
                        <i class="fa-solid fa-clock"></i>
                        <p>10.00 - 22.00 ч.</p>
                    </div>
                    <div class="footer__info__block">
                        <i class="fa-solid fa-phone"></i>
                        <a href="tel:+79872425251" class="link-nav">+7 (999) 999 99-99</a>
                    </div>
                </div>
                <div class="footer__social">
                    <a href="https://vk.com/" class="link-nav">
                        <i class="fa-brands fa-vk"></i>
                    </a>
                    <a href="https://web.telegram.org/" class="link-nav">
                        <i class="fa-brands fa-telegram"></i>
                    </a>
                </div>
            </div>
            <p class="footer__copyright">© Ceilings Company</p>
        </div>
    </footer>
</div>
<div id="back-to-top" class="back-to-top">
    <i class="fa-solid fa-arrow-up"></i>
</div>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>

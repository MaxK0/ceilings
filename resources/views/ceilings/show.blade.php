@extends('layout')

@section('title', $ceiling->name)

@section('content')
    <section class="ceiling-detail">
        <div class="container">
            <div class="detail-grid">
                <div class="gallery">
                    <div class="swiper main-slider">
                        <div class="swiper-wrapper">
                            @forelse($ceiling->images as $image)
                                <div class="swiper-slide">
                                    <img
                                        src="{{ Storage::url($image->image_path) }}"
                                        alt="{{ $ceiling->name }}"
                                        loading="lazy"
                                    >
                                </div>
                            @empty
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/no-image.jpg') }}" alt="Нет фото">
                                </div>
                            @endforelse
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>

                <div class="info">
                    <div class="info__title">
                        <h1>{{ $ceiling->name }}</h1>
                        <p class="price">{{ number_format($ceiling->price, 0, ',', ' ') }} ₽/м²</p>
                    </div>

                    <ul class="specs">
                        <li><strong>Категория:</strong> {{ $ceiling->category->name }}</li>
                        <li><strong>Производитель:</strong> {{ $ceiling->manufacturer->name }}</li>
                        <li><strong>Толщина полотна:</strong> {{ $ceiling->thickness }} мм</li>
                        <li><strong>Макс. ширина:</strong> {{ $ceiling->width }} м</li>
                    </ul>

                    <div class="description">
                        <h2>Описание</h2>
                        <div class="description-content">
                            {!! $ceiling->description !!} {{-- Без nl2br и e(), так как RichEditor уже форматирует HTML --}}
                        </div>
                    </div>

                    <!-- Калькулятор -->
                    <div class="calculator">
                        <h2>Калькулятор стоимости</h2>
                        <div class="calc-row">
                            <label for="area">Площадь (м²):</label>
                            <input type="number" id="area" min="1" step="0.1" value="10">
                        </div>
                        <div class="calc-row">
                            <span>Итого:</span>
                            <strong id="total-price">{{ number_format($ceiling->price * 10, 0, ',', ' ') }} ₽</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Функция инициализации слайдера
            function initSwiper() {
                new Swiper('.main-slider', {
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    observer: true,
                    observeParents: true,
                    watchOverflow: true,
                    autoHeight: false,
                    spaceBetween: 0,
                    slidesPerView: 1,
                    on: {
                        init: function () {
                            setTimeout(() => {
                                this.update();
                            }, 100);
                        }
                    }
                });
            }

            // Инициализация после полной загрузки
            if (document.readyState === 'complete') {
                setTimeout(initSwiper, 100);
            } else {
                window.addEventListener('load', function() {
                    setTimeout(initSwiper, 100);
                });
            }

            // Калькулятор
            const areaInput = document.getElementById('area');
            const totalSpan = document.getElementById('total-price');
            const pricePerM2 = {{ $ceiling->price }};

            function updateTotal() {
                let area = parseFloat(areaInput.value) || 0;
                let total = area * pricePerM2;
                totalSpan.textContent = total.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ' ') + ' ₽';
            }

            areaInput.addEventListener('input', updateTotal);
            updateTotal();

            // Обновление слайдера при изменении ориентации
            window.addEventListener('orientationchange', function() {
                setTimeout(() => {
                    const swiperInstance = document.querySelector('.main-slider')?.swiper;
                    if (swiperInstance) {
                        swiperInstance.update();
                    }
                }, 200);
            });
        });
    </script>
@endpush

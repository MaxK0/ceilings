@extends('layout')

@section('title', 'Каталог потолков')

@section('content')
    <section class="catalog__title">
        <div class="container title__container">
            <h1>Наши потолки</h1>

            <!-- Поиск -->
            <form method="GET" action="{{ route('home') }}" class="search-form">
                <input type="text" name="search" placeholder="Найти..." value="{{ request('search') }}">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </section>

    <!-- О категориях -->
    <section class="about__categories">
        <div class="container about__categories__container">
            <h2>Реализуем любой вид натяжного потолка</h2>

            <!-- Кнопки категорий -->
            <div class="about__categories__btns">
                @foreach($categories as $category)
                    <button class="btn-main {{ $selectedCategory && $selectedCategory->id == $category->id ? 'active' : '' }}"
                            data-category-id="{{ $category->id }}"
                            data-category-name="{{ $category->name }}"
                            data-category-description="{{ $category->description }}"
                            data-category-image="{{ Storage::url($category->image) }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>

            <!-- Информация о категории -->
            <div class="about__categories-inf">
                <div class="about__categories-text">
                    @if($selectedCategory)
                        {!! $selectedCategory->description !!}
                    @endif
                </div>
                <div class="about__categories__inf__more">
                    @if($selectedCategory)
                        <img src="{{ Storage::url($selectedCategory->image) }}" alt="{{ $selectedCategory->name }}">
                        <a class="btn-main"
                           href="{{ route('home', ['category' => $selectedCategory->id]) }}">Подробнее</a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Фильтры -->
    <section class="cards__section">
        <div class="container filters__container">
            <div class="filters">
                <form method="GET" action="{{ route('home') }}">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                        <select name="category" onchange="this.form.submit()">
                            <option value="">Все категории</option>
                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                    <select name="manufacturer" onchange="this.form.submit()">
                        <option value="">Все производители</option>
                        @foreach($manufacturers as $manufacturer)
                            <option
                                value="{{ $manufacturer->id }}" {{ request('manufacturer') == $manufacturer->id ? 'selected' : '' }}>
                                {{ $manufacturer->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="thickness" onchange="this.form.submit()">
                        <option value="">Любая толщина</option>
                        @foreach($thicknesses as $th)
                            <option value="{{ $th }}" {{ request('thickness') == $th ? 'selected' : '' }}">
                            {{ $th }} мм
                            </option>
                        @endforeach
                    </select>

                    <select name="width" onchange="this.form.submit()">
                        <option value="">Любая ширина</option>
                        @foreach($widths as $w)
                            <option value="{{ $w }}" {{ request('width') == $w ? 'selected' : '' }}">
                            до {{ $w }} м
                            </option>
                        @endforeach
                    </select>

                    <select name="sort" onchange="this.form.submit()">
                        <option value="">Цена</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                            Цена: по возрастанию
                        </option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                            Цена: по убыванию
                        </option>
                    </select>
                </form>
            </div>

            <!-- Карточки товаров -->
            <div class="cards-grid">
                @forelse($ceilings as $ceiling)
                    <a href="{{ route('ceiling.show', $ceiling->id) }}" class="card-link">
                        <div class="card">
                            <!-- Слайдер изображений (Swiper) -->
                            <div class="swiper card-slider">
                                <div class="swiper-wrapper">
                                    @forelse($ceiling->images as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ Storage::url($image->image_path) }}"
                                                 alt="{{ $ceiling->name }}">
                                        </div>
                                    @empty
                                        <div class="swiper-slide">
                                            <img src="{{ asset('img/no-image.jpg') }}" alt="Нет фото">
                                        </div>
                                    @endforelse
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>

                            <div class="card-content">
                                <h3>{{ $ceiling->name }}</h3>
                                <div class="price">{{ number_format($ceiling->price, 0, ',', ' ') }} ₽/м²</div>
                                <ul class="characteristics">
                                    <li>Производитель: {{ $ceiling->manufacturer->name }}</li>
                                    <li>Толщина: {{ $ceiling->thickness }} мм</li>
                                    <li>Ширина: до {{ $ceiling->width }} м</li>
                                </ul>
                            </div>
                        </div>
                    </a>
                @empty
                    <p>Потолки не найдены.</p>
                @endforelse

                {{ $ceilings->links() }}
            </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Инициализация слайдера карточек
            document.querySelectorAll('.card-slider').forEach(slider => {
                const slidesCount = slider.querySelectorAll('.swiper-slide').length;

                new Swiper(slider, {
                    loop: slidesCount > 1, // Включаем loop только если больше одного слайда
                    pagination: {el: '.swiper-pagination', clickable: true},
                });
            });

            // Обработка переключения категорий
            const categoryButtons = document.querySelectorAll('.about__categories__btns .btn-main');
            const categoryDescription = document.querySelector('.about__categories-text');
            const categoryImage = document.querySelector('.about__categories__inf__more img');
            const categoryLink = document.querySelector('.about__categories__inf__more a');

            categoryButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Убираем активный класс у всех кнопок
                    categoryButtons.forEach(btn => btn.classList.remove('active'));
                    // Добавляем активный класс текущей кнопке
                    this.classList.add('active');

                    // Обновляем информацию о категории
                    categoryDescription.innerHTML = this.dataset.categoryDescription;
                    categoryImage.src = this.dataset.categoryImage;
                    categoryImage.alt = this.dataset.categoryName;
                    categoryLink.href = `{{ route('home') }}?category=${this.dataset.categoryId}`;
                });
            });
        });
    </script>
@endpush

@extends('layout')

@section('title', 'Каталог потолков')

@section('content')
    <section class="catalog">
        <div class="container">
            <div class="catalog__title">
                <h1>Наши потолки</h1>

                <!-- Поиск -->
                <form method="GET" action="{{ route('home') }}" class="search-form">
                    <input type="text" name="search" placeholder="Найти..." value="{{ request('search') }}">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>

            <!-- Фильтры -->
            <div class="filters">
                <form method="GET" action="{{ route('home') }}">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <select name="category" onchange="this.form.submit()">
                        <option value="">Все категории</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="manufacturer" onchange="this.form.submit()">
                        <option value="">Все производители</option>
                        @foreach($manufacturers as $manufacturer)
                            <option value="{{ $manufacturer->id }}" {{ request('manufacturer') == $manufacturer->id ? 'selected' : '' }}>
                                {{ $manufacturer->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="thickness" onchange="this.form.submit()">
                        <option value="">Любая толщина</option>
                        @foreach($thicknesses as $th)
                            <option value="{{ $th }}" {{ request('thickness') == $th ? 'selected' : '' }}>
                                {{ $th }} мм
                            </option>
                        @endforeach
                    </select>

                    <select name="width" onchange="this.form.submit()">
                        <option value="">Любая ширина</option>
                        @foreach($widths as $w)
                            <option value="{{ $w }}" {{ request('width') == $w ? 'selected' : '' }}>
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
                                            <img src="{{ Storage::url($image->image_path) }}" alt="{{ $ceiling->name }}">
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
            </div>

            {{ $ceilings->links() }}
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Swiper('.card-slider', {
                loop: true,
                pagination: { el: '.swiper-pagination', clickable: true },
            });
        });
    </script>
@endpush

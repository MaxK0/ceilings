@extends('layout')

@section('title', $manufacturer->name)

@section('content')
    <section class="show__inf about__manufacturers">
        <div class="container about__manufacturers__container">
            <h2>{{ $manufacturer->name }}</h2>

            <!-- Информация о категории -->
            <div class="about__manufacturers-inf">
                <div class="about__manufacturers-text">
                    {!! $manufacturer->description !!}
                </div>
                <div class="about__manufacturers__inf__more">
                    <img src="{{ Storage::url($manufacturer->image) }}" alt="{{ $manufacturer->name }}">
                </div>
            </div>
        </div>
    </section>

    <!-- Фильтры -->
    <section class="cards__section">
        <div class="container filters__container">
            <div class="filters">
                <form method="GET" action="{{ route('manufacturers.show', $manufacturer->id) }}">

                    <select name="category" onchange="this.form.submit()">
                        <option value="">Все категории</option>
                        @foreach($categories as $category)
                            <option
                                value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
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
                                    <li>Категория: {{ $ceiling->category->name }}</li>
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
                    loop: slidesCount > 1,
                    pagination: {el: '.swiper-pagination', clickable: true},
                });
            });
        });
    </script>
@endpush

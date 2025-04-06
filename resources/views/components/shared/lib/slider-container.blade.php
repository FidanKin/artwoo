{{-- Слайдер изображений slick --}}
{{-- Подключаем слик --}}
@once
    <style>
        .slick-arrow.slick-next::before,
        .slick-arrow.slick-prev::before {
            color: black;
        }
        .slick-slider .slick-track {
            display: flex;
        }
        .slick-slider .slick-track .slick-slide {
            display: flex;
            height: auto;
        }
        .slick-slider .slick-track .slick-slide img {
            height: 100%;
            object-fit: contain;
            object-position: center;
            background-color: #fff;
        }
    </style>
@endonce
<div class="images slider my-4" data-content="slider"
    data-slick='{"slidesToShow": 3, "slidesToScroll": 1, "dots": false, "arrows": true}'>
    {{ $slot }}
</div>
@once
    @vite('resources/js/pages/artwork.js')
@endonce

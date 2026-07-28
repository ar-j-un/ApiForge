<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Slideshow</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body {
            margin: 0;
            overflow: hidden;
            background: #000;
        }
        .slideshow-carousel,
        .slideshow-carousel .carousel-inner,
        .slideshow-carousel .carousel-item {
            height: 100vh;
        }
        .slideshow-carousel .carousel-item img {
            width: 100%;
            height: 100vh;
            object-fit: cover;
        }
        .slideshow-close {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            z-index: 1080;
        }
    </style>
</head>
<body>
    <button type="button" class="btn btn-light rounded-circle slideshow-close" style="width: 3rem; height: 3rem; display: flex; align-items: center; justify-content: center;" aria-label="Close slideshow" onclick="window.location.href='{{ url('/') }}'">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20">
            <path fill="currentColor" d="m289.94 256 95-95A24 24 0 0 0 351 127l-95 95-95-95a24 24 0 0 0-34 34l95 95-95 95a24 24 0 1 0 34 34l95-95 95 95a24 24 0 0 0 34-34Z"/>
        </svg>
    </button>

    <div id="apiSlideshow" class="carousel slide slideshow-carousel" data-coreui-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-coreui-target="#apiSlideshow" data-coreui-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-coreui-target="#apiSlideshow" data-coreui-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-coreui-target="#apiSlideshow" data-coreui-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://picsum.photos/id/1015/1600/900" alt="Slide 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Build Fast</h5>
                    <p>Ship your API integrations with confidence.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://picsum.photos/id/1016/1600/900" alt="Slide 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Scale Reliably</h5>
                    <p>Designed to handle growth without breaking a sweat.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://picsum.photos/id/1018/1600/900" alt="Slide 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Stay in Control</h5>
                    <p>Full visibility into every request and response.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-coreui-target="#apiSlideshow" data-coreui-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-coreui-target="#apiSlideshow" data-coreui-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</body>
</html>
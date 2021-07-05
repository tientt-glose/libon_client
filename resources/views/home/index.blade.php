@extends('index')
@section('title', "Trang chủ")
@section('before-theme-styles-end')
<!-- toastr -->
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection

@section ('before-styles-end')
<!-- custom -->
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('script')
<!-- toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

@if($errors->any())
@foreach ($errors->all() as $error)
<script>
    toastr.error('{{ $error }}')
</script>
@endforeach
@endif

@if (session()->has('success'))
<script>
    toastr.success('{{ session()->get('success') }}')
</script>
@endif
@endsection

@section('content')
<!--=================================
        Hero Area
        ===================================== -->
<section class="hero-area hero-slider-2">
    <div class="container">
        <div class="row align-items-lg-center">
            <div class="col-12">
                <div class="sb-slick-slider" data-slick-setting='{
                                                                "autoplay": true,
                                                                "autoplaySpeed": 8000,
                                                                "slidesToShow": 1,
                                                                "dots":true
                                                                }'>
                    <div class="single-slide bg-image" data-bg="{{ asset('img/bg-images/home-2-slider-2.jpg') }}">
                        <div class="home-content pl--30">
                            <div class="row">
                                <div class="col-lg-7">
                                    <span class="title-mid">LibOn</span>
                                    <h2 class="h2-v2">Kho sách
                                        <br>khổng lồ</h2>
                                    <p>"Mỗi cuốn sách là một bức tranh kì diệu
                                        <br>về cuộc sống"</p>
                                    <a href="#" class="btn btn-outlined--primary">
                                        Pickup Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="single-slide bg-image" data-bg="{{ asset('img/bg-images/home-2-slider-1-1.jpg') }}">
                        <div class="home-content pl--30">
                            <div class="row">
                                <div class="col-lg-7">
                                    <span class="title-mid">Sách hay</span>
                                    <h2 class="h2-v2">Tin học
                                        <br>đại cương</h2>
                                    <p>Giới thiệu kiến thức nền tảng
                                        <br>về tin học và công nghệ thông tin</p>
                                    <a href="{{ route('book.detail', 5) }}" class="btn btn-outlined--primary">
                                        Mượn ngay
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--=================================
        Home Features Section
        ===================================== -->
{{-- <section class="mb--30">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-md-6 mt--30">
                        <div class="feature-box h-100">
                            <div class="icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div class="text">
                                <h5>Free Shipping Item</h5>
                                <p> Orders over $500</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mt--30">
                        <div class="feature-box h-100">
                            <div class="icon">
                                <i class="fas fa-redo-alt"></i>
                            </div>
                            <div class="text">
                                <h5>Money Back Guarantee</h5>
                                <p>100% money back</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mt--30">
                        <div class="feature-box h-100">
                            <div class="icon">
                                <i class="fas fa-piggy-bank"></i>
                            </div>
                            <div class="text">
                                <h5>Cash On Delivery</h5>
                                <p>Lorem ipsum dolor amet</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mt--30">
                        <div class="feature-box h-100">
                            <div class="icon">
                                <i class="fas fa-life-ring"></i>
                            </div>
                            <div class="text">
                                <h5>Help & Support</h5>
                                <p>Call us : + 0123.4567.89</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
<!--=================================
        Home Slider Tab
        ===================================== -->
<section class="section-padding">
    <h2 class="sr-only">Home Tab Slider Section</h2>
    <div class="container">
        <div class="sb-custom-tab mt--30">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="shop-tab" data-toggle="tab" href="#shop" role="tab"
                        aria-controls="shop" aria-selected="true">
                        Toàn bộ sách
                    </a>
                    <span class="arrow-icon"></span>
                </li>
                {{-- <li class="nav-item">
                            <a class="nav-link" id="men-tab" data-toggle="tab" href="#men" role="tab"
                                aria-controls="men" aria-selected="true">
                                New Arrivals
                            </a>
                            <span class="arrow-icon"></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="woman-tab" data-toggle="tab" href="#woman" role="tab"
                                aria-controls="woman" aria-selected="false">
                                Most view products
                            </a>
                            <span class="arrow-icon"></span>
                        </li> --}}
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane show active" id="shop" role="tabpanel" aria-labelledby="shop-tab">
                    <div class="product-slider multiple-row  slider-border-multiple-row  sb-slick-slider"
                        data-slick-setting='{
                            "autoplay": true,
                            "autoplaySpeed": 8000,
                            "slidesToShow": 5,
                            "rows":2,
                            "dots":true
                        }' data-slick-responsive='[
                            {"breakpoint":1200, "settings": {"slidesToShow": 3} },
                            {"breakpoint":768, "settings": {"slidesToShow": 2} },
                            {"breakpoint":480, "settings": {"slidesToShow": 1} },
                            {"breakpoint":320, "settings": {"slidesToShow": 1} }
                        ]'>
                        @foreach ($books as $book )
                        <div class="single-slide">
                            <div class="product-card" id="book_home">
                                <div class="product-card--body">
                                    <div class="card-image" style="text-align: center">
                                        <img src="{{ $book->pic1 != null ? $book->pic1 : url('img/default--book--2.png') }}"
                                            alt="">
                                        <div class="hover-contents">
                                            <a href="{{ route('book.detail', ['id' => $book->id]) }}"
                                                class="hover-image">
                                                <img src="{{ $book->pic1 != null ? $book->pic1 : url('img/default--book--2.png') }}"
                                                    alt="">
                                            </a>
                                            <div class="hover-btns">
                                                {{-- <a href="#" class="single-btn">
                                                        <i class="fas fa-shopping-basket"></i>
                                                    </a> --}}
                                                <a href="{{ route('book.detail', ['id' => $book->id]) }}"
                                                    class="single-btn">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-header mt--5">
                                    <h3><a href="{{ route('book.detail', ['id' => $book->id]) }}">{{ $book->name }}</a>
                                    </h3>
                                    <a href="{{ route('book.detail', ['id' => $book->id]) }}" class="author">
                                        {{ $book->author }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--=================================
        CATEGORY’S BOOKS SECTION
        ===================================== -->
<section class="section-margin">
    <div class="container">
        <div class="section-title section-title--bordered">
            <h2>Sách giáo trình</h2>
        </div>
        <div class="product-slider product-list-slider slider-border-single-row sb-slick-slider" data-slick-setting='{
                                            "autoplay": true,
                                            "autoplaySpeed": 8000,
                                            "slidesToShow":3,
                                            "dots":true
                                        }' data-slick-responsive='[
                                            {"breakpoint":1200, "settings": {"slidesToShow": 2} },
                                            {"breakpoint":992, "settings": {"slidesToShow": 2} },
                                            {"breakpoint":575, "settings": {"slidesToShow": 1} },
                                            {"breakpoint":490, "settings": {"slidesToShow": 1} }
                                        ]'>
            @foreach ($theories as $theory)
            <div class="single-slide">
                <div class="product-card card-style-list">
                    <div class="card-image">
                        <img style="width: 140px"
                            src="{{ $theory->pic1 != null ? $theory->pic1 : url('img/default--book--2.png') }}" alt="">
                    </div>
                    <div class="product-card--body">
                        <div class="product-header">
                            <h3><a href="{{ route('book.detail', ['id' => $theory->id]) }}">{{ $theory->name }}</a>
                            </h3>
                            <a href="{{ route('book.detail', ['id' => $theory->id]) }}" class="author">
                                {{ $theory->author }}
                            </a>
                        </div>
                        {{-- <div class="price-block">
                            <span class="price">£51.20</span>
                            <del class="price-old">£51.20</del>
                            <span class="price-discount">20%</span>
                        </div> --}}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<section class="section-margin">
    <div class="container">
        <div class="section-title section-title--bordered">
            <h2>Sách công nghệ thông tin</h2>
        </div>
        <div class="product-slider product-list-slider slider-border-single-row sb-slick-slider" data-slick-setting='{
                                            "autoplay": true,
                                            "autoplaySpeed": 8000,
                                            "slidesToShow":3,
                                            "dots":true
                                        }' data-slick-responsive='[
                                            {"breakpoint":1200, "settings": {"slidesToShow": 2} },
                                            {"breakpoint":992, "settings": {"slidesToShow": 2} },
                                            {"breakpoint":575, "settings": {"slidesToShow": 1} },
                                            {"breakpoint":490, "settings": {"slidesToShow": 1} }
                                        ]'>
            @foreach ($ITs as $IT)
            <div class="single-slide">
                <div class="product-card card-style-list">
                    <div class="card-image">
                        <img style="width: 140px"
                            src="{{ $IT->pic1 != null ? $IT->pic1 : url('img/default--book--2.png') }}" alt="">
                    </div>
                    <div class="product-card--body">
                        <div class="product-header">
                            <h3><a href="{{ route('book.detail', ['id' => $IT->id]) }}">{{ $IT->name }}</a>
                            </h3>
                            <a href="{{ route('book.detail', ['id' => $IT->id]) }}" class="author">
                                {{ $IT->author }}
                            </a>
                        </div>
                        {{-- <div class="price-block">
                            <span class="price">£51.20</span>
                            <del class="price-old">£51.20</del>
                            <span class="price-discount">20%</span>
                        </div> --}}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!--=================================
        Promotion Section Two
        ===================================== -->
<section class="section-margin">
    <h2 class="sr-only">Promotion Section</h2>
    <div class="container">
        <div class="promo-wrapper promo-type-four">
            <a href="#" class="promo-image promo-overlay bg-image"
                data-bg="{{ asset('img/bg-images/promo-banner-full.jpg') }}">
                <!-- <img src="{{ asset('img/bg-images/promo-banner-full.jpg') }}" alt="" class="w-100 h-100"> -->
            </a>
            <div class="promo-text w-100 justify-content-center justify-content-md-left">
                <div class="row w-100">
                    <div class="col-lg-6">
                        <div class="promo-text-inner">
                            <h2>LibOn</h2>
                            <h3>"Luôn tận tâm mang lại giá trị cho cộng đồng"</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

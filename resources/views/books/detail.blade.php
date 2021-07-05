@extends('index')
@section('title', "Chi tiết sách")
@section('before-theme-styles-end')
<!-- toastr -->
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection

{{-- @section ('before-styles-end')
<!-- custom -->
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection --}}

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

<script>
    $('#add-cart-button').click(function () {
            var result = true
            $('#change-item-cart .cross-btn').each(function () {
                if ($(this).data('id') == {{ $book->id }}) {
                    result = false
                    toastr.error('Sách đã được thêm vào giỏ, mỗi sách chỉ được mượn 1 quyển')
                    return result
                }
            })

            if (result == false) {
                return result
            }
            // console.log(1);

            $.ajax({
                data: {
                    book_name: '{{ $book->name }}',
                    book_id: '{{ $book->id }}',
                    pic: '{{ $book->pic_link[0] }}',
                    csrf: '{{ csrf_token() }}'
                },
                url: '{{ route('cart.add_to_cart') }}',
                type: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function (data) {
                    // console.log(data);
                    if(data.result == 0){
                        toastr.error(data.message)
                    }else{
                        $('#change-item-cart').empty();
                        $('#change-item-cart').html(data.html)
                        $('#change-item-cart-2').empty();
                        $('#change-item-cart-2').html(data.html)
                        $('#outer-count-2').text(data.quantity)
                        $('#outer-count').text(data.quantity)
                        toastr.success(data.message)
                    }
                }
            })
        })
</script>
@endsection

@section('content')
<section class="breadcrumb-section">
    <h2 class="sr-only">Site Breadcrumb</h2>
    <div class="container">
        <div class="breadcrumb-contents">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Thông tin chi tiết sách</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<main class="inner-page-sec-padding-bottom">
    <div class="container">
        {{-- @if($errors->any())
        @foreach ($errors->getMessageBag()->toArray() as $error)
        <div class="alert alert-danger" role="alert">
            {{ $error[0] }}
    </div>
    @endforeach
    @endif --}}
    <div class="row mb--60">
        <div class="col-sm-3 col-md-3 col-lg-3 col-xs-3">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach ($book->pic_link as $key => $pic)
                    @if ($pic != null)
                    @if ($key == 0)
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}" class="active"></li>
                    @else
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}"></li>
                    @endif
                    @endif
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach ($book->pic_link as $key => $pic)
                    @if ($pic != null)
                    @if ($key == 0)
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="{{ $pic }}">
                    </div>
                    @else
                    <div class="carousel-item">
                        <img class="d-block w-100" src="{{ $pic }}">
                    </div>
                    @endif
                    @endif
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        {{-- <div class="col-lg-4 mb--30">
                <!-- Product Details Slider Big Image-->
                <div class="product-details-slider sb-slick-slider arrow-type-two" id="book-slider" data-slick-setting='{
              "slidesToShow": 1,
              "arrows": false,
              "fade": true,
              "draggable": false,
              "swipe": false,
              "asNavFor": ".product-slider-nav"
              }'>
                    @foreach ($book->pic_link as $pic)
                    @if ($pic != null)
                    <div class="single-slide">
                        <img src="{{ $pic }}" alt="">
    </div>
    @endif
    @endforeach
    </div>
    <!-- Product Details Slider Nav -->
    <div class="mt--30 product-slider-nav sb-slick-slider arrow-type-two" data-slick-setting='{
            "infinite":false,
              "autoplay": true,
              "autoplaySpeed": 8000,
              "slidesToShow": 4,
              "arrows": true,
              "prevArrow":{"buttonClass": "slick-prev","iconClass":"fa fa-chevron-left"},
              "nextArrow":{"buttonClass": "slick-next","iconClass":"fa fa-chevron-right"},
              "asNavFor": ".product-details-slider",
              "focusOnSelect": true
              }'>
        @foreach ($book->pic_link as $pic)
        @if ($pic != null)
        <div class="single-slide">
            <img src="{{ $pic }}" alt="">
        </div>
        @endif
        @endforeach
    </div>
    </div> --}}
    <div class="col-sm-9 col-md-9 col-lg-9 col-xs-9">
        <div class="product-details-info pl-lg--30 ">
            <p class="tag-block">Thể loại:
                {{-- <a href="#">Movado</a>, <a href="#">Omega</a> --}}
            </p>
            <h3 class="product-title">{{ $book->name }}</h3>
            <ul class="list-unstyled">
                <li>Nhà xuất bản: <a href="#" class="list-value font-weight-bold">{{ $book->publisher_id }}</a>
                </li>
                <li>Tác giả: <span class="list-value">{{ $book->author }}</span></li>
                <li>Số trang: <span class="list-value">{{ $book->page_number }}</span> tr</li>
            </ul>
            {{-- <div class="rating-widget">
								<div class="rating-block">
									<span class="fas fa-star star_on"></span>
									<span class="fas fa-star star_on"></span>
									<span class="fas fa-star star_on"></span>
									<span class="fas fa-star star_on"></span>
									<span class="fas fa-star "></span>
								</div>
								<div class="review-widget">
									<a href="#">(1 Reviews)</a> <span>|</span>
									<a href="#">Write a review</a>
								</div>
							</div> --}}
            <article class="product-details-article">
                <h4 class="sr-only">Book Summary</h4>
                <p>{{ $book->content_summary }}</p>
            </article>
            <div class="add-to-cart-row">
                <!-- <div class="count-input-block">
                <span class="widget-label">Qty</span>
                <input type="number" class="form-control text-center" value="1">
            </div> -->
                <div class="add-cart-btn">
                    <button type="button" class="btn btn-outlined--primary btn-dis" id="add-cart-button"
                        aria-disabled="true"
                        {{$book->can_borrow == 0 || $book->can_borrow == 2 ? 'disabled' : '' }}>Thêm sách vào
                        giỏ</button>
                    {{-- <a href="#" class="btn btn-outlined--primary btn-dis" id="add-cart-button" aria-disabled="true">Thêm sách vào giỏ</a> --}}
                </div>
            </div>
            @if ($book->can_borrow == 0)
            <div class="compare-wishlist-row">
                <span class="add-link" style="color: red"><i class="fas fa-info-circle"></i>Sách đang hết, không thể
                    mượn</span>
            </div>
            @endif
            @if ($book->can_borrow == 2)
            <div class="compare-wishlist-row">
                <span class="add-link" style="color: red"><i class="fas fa-info-circle"></i>Sách đang trong hàng đợi
                    mượn của các đơn phía trước, vui lòng quay lại sau</span>
            </div>
            @endif
        </div>
    </div>
    </div>
    {{-- <div class="sb-custom-tab review-tab section-padding">
            <ul class="nav nav-tabs nav-style-2" id="myTab2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tab1" data-toggle="tab" href="#tab-1" role="tab"
                        aria-controls="tab-1" aria-selected="true">
                        TÓM TẮT
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab2" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2"
                        aria-selected="true">
                        REVIEWS
                    </a>
                </li>
            </ul>
            <div class="tab-content space-db--20" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="tab1">
                    <article class="review-article">
                        <h1 class="sr-only">Tab Description</h1>
                        <p>{{ $book->content_summary }}</p>
    </article>
    </div>
    <div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="tab2">
        <div class="review-wrapper">
            <h2 class="title-lg mb--20">1 REVIEW FOR AUCTOR GRAVIDA ENIM</h2>
            <div class="review-comment mb--20">
                <div class="avatar">
                    <img src="{{ asset('img/icon/author-logo.png') }}" alt="">
                </div>
                <div class="text">
                    <div class="rating-block mb--15">
                        <span class="ion-android-star-outline star_on"></span>
                        <span class="ion-android-star-outline star_on"></span>
                        <span class="ion-android-star-outline star_on"></span>
                        <span class="ion-android-star-outline"></span>
                        <span class="ion-android-star-outline"></span>
                    </div>
                    <h6 class="author">ADMIN – <span class="font-weight-400">March 23, 2015</span>
                    </h6>
                    <p>Lorem et placerat vestibulum, metus nisi posuere nisl, in accumsan elit odio
                        quis mi.</p>
                </div>
            </div>
            <h2 class="title-lg mb--20 pt--15">ADD A REVIEW</h2>
            <div class="rating-row pt-2">
                <p class="d-block">Your Rating</p>
                <span class="rating-widget-block">
                    <input type="radio" name="star" id="star1">
                    <label for="star1"></label>
                    <input type="radio" name="star" id="star2">
                    <label for="star2"></label>
                    <input type="radio" name="star" id="star3">
                    <label for="star3"></label>
                    <input type="radio" name="star" id="star4">
                    <label for="star4"></label>
                    <input type="radio" name="star" id="star5">
                    <label for="star5"></label>
                </span>
                <form action="https://demo.hasthemes.com/pustok-preview/pustok/" class="mt--15 site-form ">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="message">Comment</label>
                                <textarea name="message" id="message" cols="30" rows="10"
                                    class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="name">Name *</label>
                                <input type="text" id="name" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="text" id="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="website">Website</label>
                                <input type="text" id="website" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="submit-btn">
                                <a href="#" class="btn btn-black">Post Comment</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div> --}}
    </div>
    <!--=================================
    RELATED PRODUCTS BOOKS
===================================== -->
    {{-- <section class="">
        <div class="container">
            <div class="section-title section-title--bordered">
                <h2>RELATED PRODUCTS</h2>
            </div>
            <div class="product-slider sb-slick-slider slider-border-single-row" data-slick-setting='{
                "autoplay": true,
                "autoplaySpeed": 8000,
                "slidesToShow": 4,
                "dots":true
            }' data-slick-responsive='[
                {"breakpoint":1200, "settings": {"slidesToShow": 4} },
                {"breakpoint":992, "settings": {"slidesToShow": 3} },
                {"breakpoint":768, "settings": {"slidesToShow": 2} },
                {"breakpoint":480, "settings": {"slidesToShow": 1} }
            ]'>
                <div class="single-slide">
                    <div class="product-card">
                        <div class="product-header">
                            <a href="#" class="author">
                                Lpple
                            </a>
                            <h3><a href="product-details.html">Revolutionize Your BOOK With These Easy-peasy
                                    Tips</a></h3>
                        </div>
                        <div class="product-card--body">
                            <div class="card-image">
                                <img src="{{ asset('img/products/product-10.jpg') }}" alt="">
    <div class="hover-contents">
        <a href="product-details.html" class="hover-image">
            <img src="{{ asset('img/products/product-1.jpg') }}" alt="">
        </a>
        <div class="hover-btns">
            <a href="cart.html" class="single-btn">
                <i class="fas fa-shopping-basket"></i>
            </a>
            <a href="wishlist.html" class="single-btn">
                <i class="fas fa-heart"></i>
            </a>
            <a href="compare.html" class="single-btn">
                <i class="fas fa-random"></i>
            </a>
            <a href="#" data-toggle="modal" data-target="#quickModal" class="single-btn">
                <i class="fas fa-eye"></i>
            </a>
        </div>
    </div>
    </div>
    <div class="price-block">
        <span class="price">£51.20</span>
        <del class="price-old">£51.20</del>
        <span class="price-discount">20%</span>
    </div>
    </div>
    </div>
    </div>
    <div class="single-slide">
        <div class="product-card">
            <div class="product-header">
                <a href="#" class="author">
                    Jpple
                </a>
                <h3><a href="product-details.html">Turn Your BOOK Into High Machine</a></h3>
            </div>
            <div class="product-card--body">
                <div class="card-image">
                    <img src="{{ asset('img/products/product-2.jpg') }}" alt="">
                    <div class="hover-contents">
                        <a href="product-details.html" class="hover-image">
                            <img src="{{ asset('img/products/product-1.jpg') }}" alt="">
                        </a>
                        <div class="hover-btns">
                            <a href="cart.html" class="single-btn">
                                <i class="fas fa-shopping-basket"></i>
                            </a>
                            <a href="wishlist.html" class="single-btn">
                                <i class="fas fa-heart"></i>
                            </a>
                            <a href="compare.html" class="single-btn">
                                <i class="fas fa-random"></i>
                            </a>
                            <a href="#" data-toggle="modal" data-target="#quickModal" class="single-btn">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="price-block">
                    <span class="price">£51.20</span>
                    <del class="price-old">£51.20</del>
                    <span class="price-discount">20%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="single-slide">
        <div class="product-card">
            <div class="product-header">
                <a href="#" class="author">
                    Wpple
                </a>
                <h3><a href="product-details.html">3 Ways Create Better BOOK With</a></h3>
            </div>
            <div class="product-card--body">
                <div class="card-image">
                    <img src="{{ asset('img/products/product-3.jpg') }}" alt="">
                    <div class="hover-contents">
                        <a href="product-details.html" class="hover-image">
                            <img src="{{ asset('img/products/product-2.jpg') }}" alt="">
                        </a>
                        <div class="hover-btns">
                            <a href="cart.html" class="single-btn">
                                <i class="fas fa-shopping-basket"></i>
                            </a>
                            <a href="wishlist.html" class="single-btn">
                                <i class="fas fa-heart"></i>
                            </a>
                            <a href="compare.html" class="single-btn">
                                <i class="fas fa-random"></i>
                            </a>
                            <a href="#" data-toggle="modal" data-target="#quickModal" class="single-btn">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="price-block">
                    <span class="price">£51.20</span>
                    <del class="price-old">£51.20</del>
                    <span class="price-discount">20%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="single-slide">
        <div class="product-card">
            <div class="product-header">
                <a href="#" class="author">
                    Epple
                </a>
                <h3><a href="product-details.html">What You Can Learn From Bill Gates</a></h3>
            </div>
            <div class="product-card--body">
                <div class="card-image">
                    <img src="{{ asset('img/products/product-5.jpg') }}" alt="">
                    <div class="hover-contents">
                        <a href="product-details.html" class="hover-image">
                            <img src="{{ asset('img/products/product-4.jpg') }}" alt="">
                        </a>
                        <div class="hover-btns">
                            <a href="cart.html" class="single-btn">
                                <i class="fas fa-shopping-basket"></i>
                            </a>
                            <a href="wishlist.html" class="single-btn">
                                <i class="fas fa-heart"></i>
                            </a>
                            <a href="compare.html" class="single-btn">
                                <i class="fas fa-random"></i>
                            </a>
                            <a href="#" data-toggle="modal" data-target="#quickModal" class="single-btn">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="price-block">
                    <span class="price">£51.20</span>
                    <del class="price-old">£51.20</del>
                    <span class="price-discount">20%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="single-slide">
        <div class="product-card">
            <div class="product-header">
                <a href="#" class="author">
                    Hpple
                </a>
                <h3><a href="product-details.html">Simple Things You To Save BOOK</a></h3>
            </div>
            <div class="product-card--body">
                <div class="card-image">
                    <img src="{{ asset('img/products/product-6.jpg') }}" alt="">
                    <div class="hover-contents">
                        <a href="product-details.html" class="hover-image">
                            <img src="{{ asset('img/products/product-4.jpg') }}" alt="">
                        </a>
                        <div class="hover-btns">
                            <a href="cart.html" class="single-btn">
                                <i class="fas fa-shopping-basket"></i>
                            </a>
                            <a href="wishlist.html" class="single-btn">
                                <i class="fas fa-heart"></i>
                            </a>
                            <a href="compare.html" class="single-btn">
                                <i class="fas fa-random"></i>
                            </a>
                            <a href="#" data-toggle="modal" data-target="#quickModal" class="single-btn">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="price-block">
                    <span class="price">£51.20</span>
                    <del class="price-old">£51.20</del>
                    <span class="price-discount">20%</span>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </section> --}}
    <!-- Modal -->
    <div class="modal fade modal-quick-view" id="quickModal" tabindex="-1" role="dialog" aria-labelledby="quickModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close modal-close-btn ml-auto" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="product-details-modal">
                    <form class="row" method="POST" action="{{ route('cart.borrow_book') }}">
                        @csrf
                        <input type="hidden" id="book_id" name="book_id" value="{{ $book->id }}">
                        <div id="billing-form" class="mb-40">
                            <h4 class="checkout-title">Vui lòng nhập thông tin cá nhân</h4>
                            <div class="row">
                                <div class="col-12 mb--20">
                                    <label for="name">Họ & Tên</label>
                                    <input type="text" id="name" name="name">
                                </div>
                                <div class="col-12 mb--20">
                                    <label for="card_id">Số CMT/CCCD/Mã số SV/Mã cán bộ</label>
                                    <input type="number" id="card_id" name="card_id">
                                </div>
                                <div class="col-12 mb--20">
                                    <label for="phone_number">Số điện thoại</label>
                                    <input type="number" id="phone_number" name="phone_number">
                                </div>
                            </div>
                            <div class="header-search-block">
                                <button type="submit">Xác nhận</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

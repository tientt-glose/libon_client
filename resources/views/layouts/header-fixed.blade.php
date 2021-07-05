<div class="sticky-init fixed-header common-sticky">
    <div class="container d-none d-lg-block">
        <div class="row align-items-center">
            <div class="col-lg-4">
                <a href="{{ route('home.index') }}" class="site-brand">
                    <img src="{{ asset('img/logo.png') }}" alt="">
                </a>
            </div>
            <div class="col-lg-6">
                <div class="main-navigation flex-lg-right">
                    <ul class="main-menu menu-right ">
                        <li class="menu-item">
                            <a href="{{ route('home.index') }}">Trang chủ</a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('home.index') }}">Sách mượn</a>
                        </li>
                        <li class="menu-item">
                            <a href="#">Về chúng tôi</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="main-navigation flex-lg-right">
                    <div class="cart-widget">
                        <div class="cart-block">
                            <div class="cart-total">
                                <span class="text-number" id="outer-count-2">
                                    {{ Session::get('cart') ? Session::get('cart')->totalQuantity : 0 }}
                                </span>
                                <span class="text-item">
                                    Giỏ sách
                                </span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="cart-dropdown-block">
                                <div id="change-item-cart-2">
                                    @if (Session::has('cart'))
                                    @foreach (Session::get('cart')->books as $id => $book)
                                    <div class="single-cart-block">
                                        <div class="cart-product">
                                            <a href="{{ route('book.detail', $id) }}" target="_blank" class="image">
                                                <img src="{{ $book['pic'] }}" alt="">
                                            </a>
                                            <div class="content">
                                                <h3 class="title"><a href="{{ route('book.detail', $id) }}"
                                                        target="_blank">{{ $book['book_name'] }}</a>
                                                </h3>
                                                {{-- <p class="price"><span class="qty">1 ×</span> £87.34</p> --}}
                                                <button class="cross-btn" data-id="{{ $id }}"><i
                                                        class="fas fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="single-cart-block">
                                        <div class="cart-product">
                                            <div class="content">
                                                <span class="font-weight-bold"> Tổng số sách:</span>
                                                <span class="price">{{ Session::get('cart')->totalQuantity }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="single-cart-block">
                                        <div class="cart-product">
                                            <div class="content">

                                                <span class="title pl--40">
                                                    Không có sách nào được thêm vào giỏ
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class=" single-cart-block ">
                                    <div class="btn-block">
                                        {{-- <a href="cart.html" class="btn">View Cart <i
                                                class="fas fa-chevron-right"></i></a> --}}
                                        <a href="{{ route('cart.show') }}" class="btn btn--primary">Xem giỏ</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- @php
    dd($newCart->books)
@endphp --}}

@foreach ($newCart->books as $id => $book)
<div class="single-cart-block">
    <div class="cart-product">
        <a href="{{ route('book.detail', $id) }}" target="_blank" class="image">
            <img src="{{ $book['pic'] }}" alt="">
        </a>
        <div class="content">
            <h3 class="title"><a href="{{ route('book.detail', $id) }}" target="_blank">{{ $book['book_name'] }}</a>
            </h3>
            {{-- <p class="price"><span class="qty">1 ×</span> £87.34</p> --}}
            <button class="cross-btn" data-id="{{ $id }}"><i class="fas fa-times"></i></button>
        </div>
    </div>
</div>
@endforeach
<div class="single-cart-block">
    <div class="cart-product">
        <div class="content">
            <span class="font-weight-bold">Tổng số sách:</span>
            <span class="price">{{ $newCart->totalQuantity }}</span>
        </div>
    </div>
</div>

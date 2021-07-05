@extends('index')
@section('title', "Chi tiết giỏ sách")
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
    function deleteBookInCart(_this) {
        // console.log($(_this).data('id'))
        $.ajax({
            data: {
                book_id: $(_this).data('id'),
                // delivery: $('#delivery option:selected').val(),
                // address: $('#address').val(),
                csrf: '{{ csrf_token() }}'
            },
            url: '{{ route('cart.delete_to_cart') }}',
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
                    $('#outer-count').text(data.quantity)
                    $('#outer-count-2').text(data.quantity)
                    $('#cart-table').empty();
                    $('#cart-table').html(data.table)

                    if(data.quantity == 0 && !document.getElementById('borrow-button').hasAttribute('disabled')){
                        $('#borrow-button').attr('disabled', true);
                    }

                    toastr.success(data.message)
                }
            }
        })
    }
</script>

<script>
    var $backupAddress = $('#address').val()
    $('#delivery').change(function() {
        if ($('#delivery option:selected').val() == 2 && document.getElementById('address').hasAttribute('disabled')) {
            $('#address').removeAttr('disabled');
            $('#address').attr('placeholder', 'Nhập địa chỉ nhận sách');
            $('#address').val($backupAddress);
        }

        if ($('#delivery option:selected').val() == 1 && !document.getElementById('address').hasAttribute('disabled')) {
            // $('#address').attr('disabled', true);
            $backupAddress = $('#address').val();
            $('#address').val('');
            $('#address').attr({
                'placeholder': 'Không khả dụng',
                'disabled' : true,
            });
        }
    });
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
                    <li class="breadcrumb-item active">Chi tiết giỏ sách</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<main class="cart-page-main-block inner-page-sec-padding-bottom">
    <div class="cart_area cart-area-padding  ">
        <div class="container">
            <div class="page-section-title">
                <h1>Chi tiết giỏ sách</h1>
            </div>
            <form action="{{ route('cart.borrow_book') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="cart-table table-responsive mb--40">
                            <table class="table">
                                <!-- Head Row -->
                                <thead>
                                    <tr>
                                        <th class="pro-thumbnail">Bìa</th>
                                        <th class="pro-title">Sách</th>
                                        <th class="pro-remove">Action</th>
                                    </tr>
                                </thead>
                                @if (Session::has('cart'))
                                <input type="hidden" name="user_id"
                                    value="{{ Session::has('userId') ? Session::get('userId') : null}}" />
                                <tbody id="cart-table">
                                    <!-- Product Row -->
                                    @foreach (Session::get('cart')->books as $id => $book)
                                    <tr>
                                        <input type="hidden" name="{{'books[' . $id . ']' }}"
                                            value="{{ $book['book_name'] }}" />
                                        <td class="pro-thumbnail"><a href="{{ route('book.detail', $id) }}"
                                                target="_blank"><img src="{{ $book['pic'] }}" alt="Product"></a></td>
                                        <td class="pro-title"><a href="{{ route('book.detail', $id) }}"
                                                target="_blank">{{ $book['book_name'] }}</a></td>
                                        <td class="pro-remove"><a><i class="far fa-trash-alt" data-id="{{ $id }}"
                                                    onclick="deleteBookInCart($(this))"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3" class="actions">
                                            <div class="coupon-block">
                                                <div class="coupon-text">
                                                    <label for="coupon_code">Tổng số lượng:</label>
                                                    <span
                                                        class="quantity">{{ Session::has('cart') ? Session::get('cart')->totalQuantity : 0 }}</span>
                                                </div>
                                                {{-- <div class="coupon-btn">
                                                    <button type="submit" class="btn btn-outlined">Mượn sách</button>
                                                </div> --}}
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                @else
                                <tbody id="cart-table">
                                    <tr>
                                        <td colspan="6" class="actions">
                                            <h4> Không có sách trong giỏ </h4>
                                        </td>
                                    </tr>
                                </tbody>
                                @endif
                            </table>
                        </div>
                        <!-- Cart Table -->
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold">Hình thức lấy sách</label>
                        <select class="form-control" aria-placeholder="Lựa chọn hình thức lấy sách" id="delivery"
                            name="delivery">
                            <option value="1">Tự đến lấy</option>
                            <option value="2">Sử dụng đơn vị vận chuyển</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold">Địa chỉ nhận sách</label>
                        <input class="form-control" type="text" id="address" name="address" placeholder="Không khả dụng"
                            disabled required>
                        <div class="mt--20" style="text-align: right">
                            <button type="submit" class="btn btn-outlined" id="borrow-button"
                                {{ Session::has('authenticated') && Session::has('cart') ? '' : 'disabled' }}>Mượn sách</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

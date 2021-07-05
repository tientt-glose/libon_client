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
@endsection

@section('content')
<section class="breadcrumb-section">
    <h2 class="sr-only">Site Breadcrumb</h2>
    <div class="container">
        <div class="breadcrumb-contents">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Thông tin đơn mượn</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<section class="order-complete inner-page-sec-padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="order-complete-message text-center">
                    <h1>Thank you !</h1>
                    <p>Đơn mượn đã tạo thành công.</p>
                </div>
                <p>Vui lòng cho chúng tôi ý kiến đóng góp tại <a href="https://sal.vn/libon_3rd" target="_blank"
                        class="font-weight-bold">đây</a>.</p>
                <ul class="order-details-list">
                    <li>Mã đơn mượn: <strong>{{ $result->orderId }}</strong></li>
                    <li>Ngày tạo: <strong>{{ date('d-m-Y H:i', strtotime($result->createdAt)) }}</strong></li>
                </ul>
                <h3 class="order-table-title">Chi tiết đơn mượn</h3>
                <div class="table-responsive">
                    <table class="table order-details-table">
                        <tbody>
                            <tr>
                                <td>Tên sách:</td>
                                <td>{{ $result->bookName }}</td>
                            </tr>
                            <tr>
                                <td>Tổng số sách:</td>
                                <td>{{ $result->quantity }}</td>
                            </tr>
                            <tr>
                                <td>Hình thức lấy sách:</td>
                                <td>
                                    @switch($result->delivery)
                                    @case(1)
                                    Tự đến lấy
                                    @break
                                    @case(2)
                                    Vận chuyển
                                    @break
                                    @default
                                    {{ $result->delivery }}
                                    @break
                                    @endswitch
                                </td>
                            </tr>
                            <tr>
                                <td>Địa chỉ nhận sách:</td>
                                <td>{{ $result->address ? $result->address : 'Không khả dụng' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

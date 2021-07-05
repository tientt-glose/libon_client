@extends('index')
@section('title', "Danh sách đơn mượn")
@section('before-theme-styles-end')
<!-- toastr -->
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection

@section ('before-styles-end')
<!-- custom -->
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
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
<section class="breadcrumb-section">
    <h2 class="sr-only">Site Breadcrumb</h2>
    <div class="container">
        <div class="breadcrumb-contents">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Danh sách đơn mượn</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<main class="cart-page-main-block inner-page-sec-padding-bottom">
    <div class="cart_area cart-area-padding  ">
        <div class="container">
            <div class="page-section-title">
                <h1>Danh sách đơn mượn</h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="cart-table table-responsive mb--40">
                        <table class="table">
                            <!-- Head Row -->
                            <thead>
                                <tr>
                                    <th>Mã đơn</th>
                                    <th class="pro-title">Tên sách</th>
                                    <th>Tổng</th>
                                    <th>Trạng thái</th>
                                    <th>Hình thức lấy sách</th>
                                    <th>Địa chỉ nhận sách</th>
                                    <th>Hạn trả</th>
                                    <th>Ngày tạo</th>
                                    <th>Ngày đến lấy</th>
                                    <th>Ngày trả</th>
                                </tr>
                            </thead>
                            @if ($data->orders)
                            <tbody id="order-table">
                                <!-- Product Row -->
                                @foreach ($data->orders as $id => $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td class="pro-title">{{ $order->book_name }}</td>
                                    <td>{{ $order->quantity }}</td>
                                    @switch($order->status)
                                    {{-- cancel --}}
                                    @case(0)
                                    <td><span class="badge badge-danger"><i class="fas fa-times"></i>&nbsp;Bị hủy</span>
                                    </td>
                                    @break
                                    {{-- BORROW_ORDER_CREATED_STATUS --}}
                                    @case(1)
                                    <td><span class="badge badge-info"><i class="fas fa-plus"></i>&nbsp;Tạo thành
                                            công</span></td>
                                    @break
                                    {{-- BORROWING --}}
                                    @case(2)
                                    <td><span class="badge badge-success"><i
                                                class="fas fa-sync-alt fa-spin"></i>&nbsp;&nbsp;Đang mượn</span></td>
                                    @break
                                    {{-- DEADLINE_IS_COMMING --}}
                                    @case(3)
                                    <td><span class="badge badge-warning"><i class="fas fa-clock"></i>&nbsp;Sắp tới hạn
                                            trả</span></td>
                                    @break
                                    {{-- OVERDUE --}}
                                    @case(4)
                                    <td><span class="badge badge-danger"><i class="fas fa-clock"></i>&nbsp;Quá
                                            hạn</span></td>
                                    @break
                                    @case(5)
                                    {{-- RESTORED --}}
                                    <td><span class="badge badge-success"><i class="fas fa-check"></i>&nbsp;Đã
                                            trả</span></td>
                                    @break
                                    @default
                                    <td>{{ $order->status }}</td>
                                    @break
                                    @endswitch
                                    <td>
                                        @switch($order->delivery)
                                        @case(1)
                                        Tự đến lấy
                                        @break
                                        @case(2)
                                        Vận chuyển
                                        @break
                                        @default
                                        {{ $order->delivery }}
                                        @break
                                        @endswitch
                                    </td>
                                    <td>{{ $order->address }}</td>
                                    <td style="color: red">{{ $order->restore_deadline }}</td>
                                    <td>{{ date('d-m-Y H:i', strtotime($order->created_at)) }}</td>
                                    <td>{{ $order->pick_time }}</td>
                                    <td>{{ $order->restore_time }}</td>
                                </tr>
                                @endforeach
                                <!-- Discount Row  -->
                            </tbody>
                            @else
                            <tbody id="order-table">
                                <tr>
                                    <td colspan="8" class="actions">
                                        <h4> Không có đơn mượn nào </h4>
                                    </td>
                                </tr>
                            </tbody>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@extends('index')
@section('title', "Đăng ký")

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
<section class="breadcrumb-section">
    <h2 class="sr-only">Site Breadcrumb</h2>
    <div class="container">
        <div class="breadcrumb-contents">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Đăng kí</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<main class="page-section inner-page-sec-padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
                <form method="post" action="{{route('user.signup')}}" id="form-input">
                    @csrf
                    <div class="login-form">
                        <h4 class="login-title">Đăng kí</h4>
                        <div class="row">
                            <div class="col-md-12 col-12 mb--15">
                                <label for="fullname">Họ và tên</label>
                                <input class="mb-0 form-control" type="text" id="fullname" name="fullname"
                                    value="{{ old('fullname') }}" required placeholder="Nhập đầy đủ tên của bạn">
                            </div>
                            <div class="col-md-12 col-12 mb--20">
                                <label for="email">Địa chỉ email</label>
                                <input class="mb-0 form-control" type="email" id="email" name="email"
                                    value="{{ old('email') }}" placeholder="Nhập địa chỉ email của bạn" required>
                            </div>
                            <div class="col-lg-6 mb--20">
                                <label for="password">Mật khẩu</label>
                                <input class="mb-0 form-control" type="password" id="password" name="password"
                                    placeholder="Nhập mật khẩu của bạn" required>
                            </div>
                            <div class="col-lg-6 mb--20">
                                <label for="repeat-password">Xác nhận nhập khẩu</label>
                                <input class="mb-0 form-control" type="password" id="repeat-password"
                                    name="password_confirmation" required placeholder="Nhập lại mật khẩu của bạn">
                            </div>
                            <div class="col-12 mb--20">
                                <label for="phone">Số điện thoại</label>
                                <input class="mb-0 form-control" type="number" id="phone" name="phone"
                                    value="{{ old('phone') }}" required placeholder="Nhập số điện thoại của bạn">
                            </div>
                            <div class="col-12 mb--20">
                                <label for="card">Số Chứng minh thư, căn cước công dân</label>
                                <input class="mb-0 form-control" type="number" id="card" name="card"
                                    value="{{ old('card') }}" required
                                    placeholder="Nhập số Chứng minh thư, căn cước công dân của bạn">
                            </div>
                            <div class="col-12 mb--20">
                                <label for="organ">Đơn vị, tổ chức trực thuộc</label>
                                <select class="custom-select mb-0" id="organ" name="organ" required>
                                    <option hidden value="">Chọn đơn vị, tổ chức trực thuộc</option>
                                    @foreach ($organs as $organ)
                                    <option value="{{ $organ->id }}">{{ $organ->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mb--20">
                                <label for="career">Nghề nghiệp</label>
                                <select class="custom-select mb-0" id="career" name="career" required>
                                    <option hidden value="">Chọn nghề nghiệp</option>
                                    <option value="1">Sinh viên</option>
                                    <option value="2">Giáo viên</option>
                                    <option value="3">Chuyên viên</option>
                                    <option value="4">Khác</option>
                                </select>
                            </div>
                            <div class="col-12 mb--20">
                                <label for="code"> Mã số sinh viên, mã cán bộ</label>
                                <input class="mb-0 form-control" type="number" id="code" name="code"
                                    value="{{ old('code') }}" placeholder="Nhập mã số sinh viên hoặc mã số cán bộ"
                                    required>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-outlined">Đăng ký</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

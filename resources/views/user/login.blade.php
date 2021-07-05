@extends('index')
@section('title', "Đăng nhập")

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
                    <li class="breadcrumb-item active">Đăng nhập</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<main class="page-section inner-page-sec-padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
                <form method="post" action="{{route('user.login')}}" id="form-input">
                    @csrf
                    <div class="login-form">
                        <h4 class="login-title">Đăng nhập</h4>
                        <div class="row">
                            <div class="col-md-12 col-12 mb--15">
                                <label for="email">Địa chỉ email</label>
                                <input class="mb-0 form-control" type="email" id="email" name="email"
                                    placeholder="Nhập địa chỉ email của bạn" required>
                            </div>
                            <div class="col-12 mb--20">
                                <label for="password">Mật khẩu</label>
                                <input class="mb-0 form-control" type="password" id="login-password" name="password"
                                    placeholder="Nhập mật khẩu của bạn" required>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-outlined">Đăng nhập</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

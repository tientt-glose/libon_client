<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title') | {{ env('APP_NAME') }} </title>

    <!-- bootstrap v4.3.1 -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/plugins.css') }}" />

    @yield('before-theme-styles-end')

    <!-- css -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/main.css') }}" />

    <!-- Custom css -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @yield('before-styles-end')

    <!-- favicons -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/logo--mini.png') }}"/>
    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}"> --}}
</head>

<body>
    <!-- Preloader -->
    {{-- todo --}}
    <main>
        <div class="site-wrapper" id="top">
            <!-- Header -->
            @include('layouts.header')

            <!-- Header for mobile -->
            @include('layouts.header-mobile')

            <!-- Fixed header when scroll -->
            @include('layouts.header-fixed')

            @yield('content')

        </div>

        <!-- Footer -->
        <div class="site-footer">
            @include('layouts.footer')
        </div>
    </main>

    <!-- popper -->
    <script src="{{ asset('plugins/popper/popper.min.js') }}"></script>
    <!-- jQuery Scripts -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/ajax-mail.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <script>
        $('#change-item-cart, #change-item-cart-2').on('click', '.cross-btn', function () {
            // console.log($(this).data('id'))
            $.ajax({
                data: {
                    book_id: $(this).data('id'),
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
                        toastr.success(data.message)
                    }
                }
            })
        })
    </script>
    @yield('script')
</body>

</html>

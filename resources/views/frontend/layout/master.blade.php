<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="author" content="">
    <title>@yield('title', 'Trang Chủ')</title>
    <script>
      if(screen.width <= 736){
          document.getElementById("viewport").setAttribute("content", "width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no");
      }
  </script>
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('rate/css/common.css') }}" rel="stylesheet">
    <link href="{{ asset('rate/css/drawer.min.css') }}" rel="stylesheet">
    <link href="{{ asset('rate/css/rate.css') }}" rel="stylesheet">
    <link href="{{ asset('rate/css/smart.css') }}" rel="stylesheet">
    <link href="{{ asset('rate/css/style-pc.css') }}" rel="stylesheet">
    <link href="{{ asset('rate/css/style.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{ asset('frontend/js/html5shiv.js') }}"></script>
    <script src="{{ asset('frontend/js/respond.min.js') }}"></script>
    <![endif]-->
    
    <link rel="shortcut icon" href="{{ asset('frontend/images/ico/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('frontend/images/ico/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('frontend/images/ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('frontend/images/ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('frontend/images/ico/apple-touch-icon-57-precomposed.png') }}">
    <style>
  .blog-post-area .single-blog-post a img {
    border: 1px solid #f7f7f0;
    width: 100%;
    margin-bottom: 30px;
    height: 400px;
    object-fit: cover;
    image-rendering: crisp-edges;
  }
  h2.title {
    color: #FE980F;
    font-family: 'Roboto', sans-serif;
    font-size: 18px;
    font-weight: 700;
    margin-top: -23px;
    text-transform: uppercase;
    position: relative;
}

    </style>

</head>
<body>

    @include('frontend.layout.header') <!-- Gọi file header.blade.php -->
    <section>
        <div class="container">
            <div class="row">
            @include('frontend.layout.menu-left');
            <div class="col-sm-9 padding-right">
              @yield('content')
            </div>
           
            </div>     <!-- Phần nội dung sẽ được thay thế từ file con -->
        </div>
    </section> 
    @include('frontend.layout.footer')<!-- Gọi file footer.blade.php -->
    <script src="{{ asset('frontend/js/price-range.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>

</body>
</html>

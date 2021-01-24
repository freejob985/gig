
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>
        {{get_static_option('site_'.get_user_lang().'_title')}} -
        @if(request()->path() == 'admin-home')
            {{get_static_option('site_'.get_user_lang().'_tag_line')}}
        @else
            @yield('site-title')
        @endif
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $site_favicon = get_attachment_image_by_id(get_static_option('site_favicon'),"full",false);
    @endphp
    @if (!empty($site_favicon))
        <link rel="icon" href="{{$site_favicon['img_url']}}" type="image/png">
    @endif
    <link rel="stylesheet" href="{{asset('assets/common/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/metisMenu.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/slicknav.min.css')}}">
    <!-- others css -->
    <link rel="stylesheet" href="{{asset('assets/backend/css/typography.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/default-css.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/fontawesome-iconpicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/custom-style.css')}}">
    @yield('style')
    @if(!empty(get_static_option('site_admin_dark_mode')))
    <link rel="stylesheet" href="{{asset('assets/backend/css/dark-mode.css')}}">
    @endif
    <!-- modernizr css -->
    <script src="{{asset('assets/common/vendor/modernizr-2.8.3.min.js')}}"></script>
</head>

<body>

<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<div id="preloader">
    <div class="loader"></div>
</div>
<div class="page-container">
    @if($license_status != 'verified' && env('APP_ENV') != 'development')
        <div class="license-alert-box">
            <div class="alert alert-info">{{$license_message}}</div>
        </div>
    @endif
    @include('backend/partials/sidebar')
    <div class="main-content">
        <!-- header area start -->
        <div class="header-area">
            <div class="row align-items-center">
                <!-- nav and search button -->
                <div class="col-md-6 col-sm-8 clearfix">
                    <div class="nav-btn pull-left">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="search-box pull-left">
                        <form action="#">
                            <input type="text" name="search" placeholder="Search..." required>
                            <i class="ti-search"></i>
                        </form>
                    </div>
                </div>
                <!-- profile info & task notification -->
                <div class="col-md-6 col-sm-4 clearfix">
                    <ul class="notification-area pull-right">
                        <li id="full-view"><i class="ti-fullscreen"></i></li>
                        <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                        <li><a class="btn btn-primary" target="_blank" href="{{url('/')}}">{{__('View Site')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-title-area">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="breadcrumbs-area clearfix">
                        <h4 class="page-title pull-left">@yield('site-title')</h4>
                        <ul class="breadcrumbs pull-left">
                            <li><a href="{{route('admin.home')}}">{{__('Home')}}</a></li>
                            <li><span>@yield('site-title')</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 clearfix">
                    <div class="user-profile pull-right">
                        @php
                        $profile_img = get_attachment_image_by_id(auth()->user()->image,null,true);
                        @endphp
                        @if (!empty($profile_img))
                            <img class="avatar user-thumb" src="{{$profile_img['img_url']}}" alt="{{auth()->user()->name}}">
                        @endif

                        <h4 class="user-name dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name }} <i class="fa fa-angle-down"></i></h4>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{route('admin.profile.update')}}">{{__('Edit Profile')}}</a>
                            <a class="dropdown-item" href="{{route('admin.password.change')}}">{{__('Password Change')}}</a>
                            <a class="dropdown-item" href="{{ route('admin.logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @yield('content')
    </div>

    <footer>
        <div class="footer-area">
            <p>
            @php
            $footer_copyright_text = get_static_option('site_'.get_user_lang().'_footer_copyright');
            $footer_copyright_text = str_replace('{copy}','&copy;',$footer_copyright_text);
            $footer_copyright_text = str_replace('{year}',date('Y'),$footer_copyright_text);
            @endphp
                {!! $footer_copyright_text !!}
            </p>
        </div>
    </footer>

</div>
<script src="{{asset('assets/common/vendor/jquery-2.2.4.min.js')}}"></script>
<script src="{{asset('assets/common/js/popper.min.js')}}"></script>
<script src="{{asset('assets/common/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/backend/js/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/backend/js/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('assets/backend/js/jquery.slicknav.min.js')}}"></script>
<script src="{{asset('assets/backend/js/fontawesome-iconpicker.min.js')}}"></script>
@yield('script')
<script src="{{asset('assets/backend/js/plugins.js')}}"></script>
<script src="{{asset('assets/backend/js/scripts.js')}}"></script>

</body>

</html>

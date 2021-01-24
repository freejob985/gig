<!DOCTYPE html>
<html lang="{{get_default_language()}}"  dir="{{get_user_lang_direction()}}">
<head>
@if(!empty(get_static_option('site_google_analytics')))
    <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{get_static_option('site_google_analytics')}}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', "{{get_static_option('site_google_analytics')}}");
        </script>
    @endif
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('page-meta-data')
    @php
        $site_favicon = get_attachment_image_by_id(get_static_option('site_favicon'),"full",false);
    @endphp
    @if (!empty($site_favicon))
        <link rel="icon" href="{{$site_favicon['img_url']}}" type="image/png">
    @endif
    <!-- load fonts dynamically -->
    {!! load_google_fonts() !!}
<!-- all stylesheets -->
    <link rel="stylesheet" href="{{asset('assets/frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/dynamic-style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/jquery.ihavecookies.css')}}">
    <style>
        :root {
            --main-color-one: {{get_static_option('site_color')}};
            --secondary-color: {{get_static_option('site_main_color_two')}};
            --heading-color: {{get_static_option('site_heading_color')}};
            --paragraph-color: {{get_static_option('site_paragraph_color')}};
            @php $heading_font_family = !empty(get_static_option('heading_font')) ? get_static_option('heading_font_family') :  get_static_option('body_font_family') @endphp
            --heading-font: "{{$heading_font_family}}",sans-serif;
            --body-font:"{{get_static_option('body_font_family')}}",sans-serif;
        }
    </style>
    @yield('style')
    @if(!empty(get_static_option('site_rtl_enabled')) || get_user_lang_direction() == 'rtl')
        <link rel="stylesheet" href="{{asset('assets/frontend/css/rtl.css')}}">
    @endif
    @if(request()->is('blog/*') || request()->is('work/*') || request()->is('service/*'))
        @yield('og-meta')
        <title>@yield('site-title')</title>
    @elseif(request()->is('about') || request()->is('service') || request()->is('work') || request()->is('team') || request()->is('faq') || request()->is('blog') || request()->is('contact') || request()->is('p/*') || request()->is('blog/*') || request()->is('services/*') ||  request()->is('price-plan'))
        <title>@yield('site-title') - {{get_static_option('site_'.get_user_lang().'_title')}} </title>
    @else
        <title>{{get_static_option('site_'.get_user_lang().'_title')}} - {{get_static_option('site_'.get_user_lang().'_tag_line')}}</title>
    @endif
</head>
<body>

@php $inner_page_navbar = get_static_option('site_header_type') ? get_static_option('site_header_type') : 'navbar'; @endphp
@include('frontend.partials.'.$inner_page_navbar)
<section class="breadcrumb-area breadcrumb-bg {{$inner_page_navbar}}"
@php
    $site_breadcrumb_bg = get_attachment_image_by_id(get_static_option('site_breadcrumb_bg'),"full",false);
@endphp
@if (!empty($site_breadcrumb_bg))
style="background-image: url({{$site_breadcrumb_bg['img_url']}});"
@endif
>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner">
                    <h1 class="page-title">@yield('page-title')</h1>
                    <ul class="page-list">
                        <li><a href="{{url('/')}}">{{__('Home')}}</a></li>
                        <li>@yield('page-title')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@yield('content')

@include('frontend.partials.footer')
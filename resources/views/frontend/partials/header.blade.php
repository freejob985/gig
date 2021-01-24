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
    <meta name="description" content="{{get_static_option('site_meta_description')}}">
    <meta name="tags" content="{{get_static_option('site_meta_tags')}}">
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
    
    .info-bar-inner .logo-wrapper .logo {
    margin-top: -6px;
    display: block;
    width: 141px;
}.info-bar-inner {
    padding: 15px 0 5px 0;
}.topbar-inner {
    padding: 5px 0;
}
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
    @elseif(request()->is('about') || request()->is('service') || request()->is('work') || request()->is('team') || request()->is('faq') || request()->is('blog') || request()->is('contact') || request()->is('p/*') || request()->is('blog/*') || request()->is('services/*'))
    <title>@yield('site-title') - {{get_static_option('site_'.get_user_lang().'_title')}} </title>
    @else
    <title>{{get_static_option('site_'.get_user_lang().'_title')}} - {{get_static_option('site_'.get_user_lang().'_tag_line')}}</title>
    @endif
    
    
    <style> .cta-area-one.cta-bg-one:after {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgb(79, 49, 105,0.7);
    content: '';
    z-index: -1;
}.single-work-item .thumb img {
    width: 100%;
    height: 249px;}.owl-carousel .owl-item .single-blog-grid-01 img {
    display: block;
    width: 100%;
    height: 277px;}.single-testimonial-item-02 .thumb img {
    max-width: 80px;
    height: 80px;}
   
.counterup-area.counterup-bg:after {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
   background-color: rgb(79, 49, 105,0.7);
    content: '';
    z-index: -1;
}
.copyright-area {
    background-color: #3f1e5b;
}.bg-image {
    BACKGROUND: #FAFAFA;}
.footer-top {
    background-color: var(--secondary-color);
}.content-block-with-sign {
    background-color: #4f3169;}
.info-bar-inner .logo-wrapper .logo {
    margin-top: -6px;
    display: block;
    width: 141px;
}.info-bar-inner {
    padding: 15px 0 5px 0;
}.topbar-inner {
    padding: 5px 0;
}.img-block-width-counterup .hover {

    background-color: #4f3169c4;}
.header-area {
    padding: 173px 0 86px;
    position: relative;
    z-index: 0;
    overflow: hidden;
}.back-to-top {
    position: fixed;
    right: 20px;}
.mobile-logo a img{width:120px;}
.footer-top {
    background-color: #0f0f10;
}
.newsletter-area{    background-color: var(--secondary-color);
}.newsletter-area .title{color:#fff;}.newsletter-area p {
    color: #fff;
}
/* Feature Section */

.feature-section {
	position: relative;
}

.feature-section .wrapper-box {
	position: relative;
	margin-top:16px;
	z-index: 9;
}

.feature-block-one {
	position: relative;
}
.feature-block-one .inner-box {
    position: relative;
    background: #fff;
    padding: 4px 20px;}
.feature-block-one .inner-box {
	position: relative;
	background: #fff;
	padding: 34px 20px;
	-webkit-box-shadow: 0px 8px 16px 0px rgba(40, 40, 40, 0.1);
	box-shadow: 0px 8px 16px 0px rgba(40, 40, 40, 0.1);
	text-align: center;
	-webkit-transition: .5s;
	-o-transition: .5s;
	transition: .5s;
	margin: 0 auto;
	margin-bottom: 30px;
	max-width: 170px;
}
.aboutus-content-block {
    background-color: transparent;

}
.feature-block-one .inner-box:hover {
	border-radius: 50%;
}

.feature-block-one .icon {
	position: relative;
	font-size: 70px;
	line-height: 70px;
	margin-bottom: 15px;
}
.info-bar-inner .right-content .request-quote {
    margin-left: 20px;
}.breadcrumb-area:before {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    content: '';
    background-color: rgba(0, 0, 0, 0.1);
    z-index: -1;
}
.feature-block-one h5 {
	font-size: 14px;
	font-weight: 700;
}
.feature-block-one .inner-box {
    position: relative;
    background: #fff;
    padding: 14px 22px;}
</style>
</head>
<body>


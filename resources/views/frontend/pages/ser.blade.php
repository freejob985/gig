@extends('frontend.frontend-page-master')
@section('site-title')
{{get_static_option('service_page_'.get_user_lang().'_name')}}
@endsection
@section('page-title')
{{get_static_option('service_page_'.get_user_lang().'_name')}}
@endsection
<style>
    .service-block h4 {
        text-align: center;
    }

    .row1 {
        padding-bottom: 50px;
    }

    .service-block .inner-box {
        position: relative;
        padding: 40px 30px;
        background-color: #ffffff;
        border: 1px solid #eeeeee;
        box-shadow: 0 30px 40px rgba(0, 0, 0, 0.10);
        -webkit-transition: all 800ms ease;
        -moz-transition: all 800ms ease;
        -ms-transition: all 800ms ease;
        -o-transition: all 800ms ease;
        transition: all 800ms ease;
        text-align: center;
        overflow: hidden;
    }

    .service-block .inner-box:hover {
        box-shadow: none;
    }

    .service-block .icon-box {
        position: relative;
        display: block;
        margin-bottom: 30px;
    }

    .service-block .icon-box .icon {
        position: relative;
        display: inline-block;
        font-size: 70px;
        line-height: 1em;
        color: #40cbb4;
        -webkit-transition: all 800ms ease;
        -moz-transition: all 800ms ease;
        -ms-transition: all 800ms ease;
        -o-transition: all 800ms ease;
        transition: all 800ms ease;
    }

    .service-block:nth-child(3n + 2) h4 a:hover,
    .service-block:nth-child(3n + 2) .icon-box .icon {
        color: #db45f9;
    }

    .service-block:nth-child(3n + 3) h4 a:hover,
    .service-block:nth-child(3n + 3) .icon-box .icon {
        color: #db45f9;
    }

    .service-block .inner-box:hover .icon-box .icon {
        -webkit-transform: scale(-1) rotate(180deg);
        -moz-transform: scale(-1) rotate(180deg);
        -ms-transform: scale(-1) rotate(180deg);
        -o-transform: scale(-1) rotate(180deg);
        transform: scale(-1) rotate(180deg);
    }

    .service-block h4 {
        position: relative;
        display: block;
        font-size: 22px;
        line-height: 1.2em;
        color: #12114a;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .service-block h4 a {
        color: #12114a;
        display: inline-block;
        -webkit-transition: all 800ms ease;
        -moz-transition: all 800ms ease;
        -ms-transition: all 800ms ease;
        -o-transition: all 800ms ease;
        transition: all 800ms ease;
    }

    .service-block h4 a:hover {
        color: #db45f9;
    }
</style>
@section('content')
<section class="service-area service-page padding-120">
    <div class="container-fluid">
        <div class="row row1">




            @if (count($service_categories)>0)
            @foreach ($service_categories as $item_service_categories)
            @php
            if(!empty($item_service_categories->a2)){
            $img= asset('assets/files').$item_service_categories->a2;
            }else{  
            $img="http://via.placeholder.com/250x250"; 
             }
            @endphp
            <div class="service-block col-lg-2 col-md-6 col-sm-12">

                <div class="inner-box">

                    <div class="icon-box">
                        <figure class="image icon"><img src="{{ $img }}" alt=""></figure>
                    </div>

                    <h4><a href=""> {{ $item_service_categories->name}}</a> </h4>

                </div>
            </div>
            @endforeach
            @endif




        </div>

    

    </div>
</section>
@endsection
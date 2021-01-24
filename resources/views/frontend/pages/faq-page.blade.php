@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('faq_page_'.get_user_lang().'_name')}}
@endsection
@section('page-title')
    {{get_static_option('faq_page_'.get_user_lang().'_name')}}
@endsection
@section('content')
    <div class="faq-page-content-area padding-120">
        <div class="container">
            <div class="row">
                @foreach($all_faqs->chunk(5) as $chunked_faq)
                <div class="col-lg-6">
                    <div class="accordion-wrapper">
                        @php $rand_number = rand(9999,99999999); @endphp
                        <div id="accordion_{{$rand_number}}">
                            @foreach($chunked_faq as $key => $data)
                                @php
                                    $aria_expanded = 'false';
                                    if($data->is_open == 'on'){ $aria_expanded = 'true'; }
                                @endphp
                                <div class="card">
                                    <div class="card-header" id="headingOne_{{$key}}">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" data-target="#collapseOne_{{$key}}" role="button"
                                               aria-expanded="{{$aria_expanded}}" aria-controls="collapseOne_{{$key}}">
                                                {{$data->title}}
                                            </a>
                                        </h5>
                                    </div>

                                    <div id="collapseOne_{{$key}}" class="collapse @if($data->is_open == 'on') show @endif "
                                         aria-labelledby="headingOne_{{$key}}" data-parent="#accordion_{{$rand_number}}">
                                        <div class="card-body">
                                            {{$data->description}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <section class="cta-area-one cta-bg-one padding-top-95 padding-bottom-100"
             @if(file_exists('assets/uploads/'.get_static_option('home_page_01_'.get_user_lang().'_cta_background_image')))
             style="background-image: url({{asset('assets/uploads/'.get_static_option('home_page_01_'.get_user_lang().'_cta_background_image'))}})"
            @endif
    >
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="left-content-area">
                        <h3 class="title">{{get_static_option('home_page_01_'.get_user_lang().'_cta_area_title')}}</h3>
                        <p>{{get_static_option('home_page_01_'.get_user_lang().'_cta_area_description')}}</p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="right-content-area">
                        <div class="btn-wrapper">
                            <a href="{{get_static_option('home_page_01_'.get_user_lang().'_cta_area_button_url')}}" class="boxed-btn btn-rounded white">{{get_static_option('home_page_01_'.get_user_lang().'_cta_area_button_title')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="brand-logo-area section-bg-1 padding-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="brand-carousel">
                        @foreach($all_brand_logo as $data)
                            <div class="single-carousel">
                                @php
                                    $brand_logo_image = get_attachment_image_by_id($data->image,"full",false);
                                @endphp
                                @if (!empty($brand_logo_image))
                                    @if(!empty($data->url)) <a href="{{$data->url}}"> @endif
                                        <img src="{{$brand_logo_image['img_url']}}" alt="{{__($data->name)}}">
                                        @if(!empty($data->url))</a> @endif
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

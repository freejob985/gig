@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('service_page_'.get_user_lang().'_name')}}
@endsection
@section('page-title')
    {{get_static_option('service_page_'.get_user_lang().'_name')}}
@endsection
@section('content')
    <section class="service-area service-page padding-120">
        <div class="container">
            <div class="row">
                @foreach($all_services as $data)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-work-item-02 margin-bottom-30 gray-bg">
                            <div class="thumb">
                                @php
                                    $service_image = get_attachment_image_by_id($data->image,"grid",false);
                                @endphp
                                @if (!empty($service_image))
                                    <img  src="{{$service_image['img_url']}}" alt="{{__($data->name)}}">
                                @endif
                            </div>
                            <div class="content">
                                <a href="{{route('frontend.services.single',['id' => $data->id,'any' => Str::slug($data->title)])}}"><h4 class="title">{{$data->title}}</h4></a>
                                <div class="post-description">
                                    <p>{{$data->excerpt}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-lg-12">
                    <div class="pagination-wrapper">
                        {{$all_services->links()}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@extends('frontend.frontend-page-master')
@section('page-title')
    {{get_static_option('service_page_'.get_user_lang().'_name')}} {{__('Category:')}} {{$category_name}}
 
@endsection
@section('site-title')
    {{get_static_option('service_page_'.get_user_lang().'_name')}} {{__('Category:')}} {{$category_name}}
 
@endsection
@section('content')
    <section class="blog-content-area padding-100">
        <div class="container">
            <div class="row">
                @if(empty($service_items))
                    <div class="col-lg-12">
                        <div class="alert alert-danger">{{__('No Post Available In This Category')}}</div>
                    </div>
                @endif
                @foreach($service_items as $data)
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
                <nav class="pagination-wrapper" aria-label="Page navigation">
                    {{$service_items->links()}}
                </nav>
            </div>
        </div>
    </section>
@endsection

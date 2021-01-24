@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('blog_page_'.get_user_lang().'_title')}}
@endsection
@section('page-title')
    {{get_static_option('blog_page_'.get_user_lang().'_title')}}
@endsection
@section('content')

    <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        @foreach($all_blogs as $data)
                            <div class="col-lg-6 col-md-6">
                                <div class="single-blog-grid-01 margin-bottom-30">
                                    <div class="thumb">
                                        @php
                                            $blog_image = get_attachment_image_by_id($data->image,"grid",false);
                                        @endphp
                                        @if (!empty($blog_image))
                                            <img src="{{$blog_image['img_url']}}" alt="{{__($data->name)}}">
                                        @endif
                                    </div>
                                    <div class="content">
                                        <h4 class="title"><a href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}">{{$data->title}}</a></h4>
                                        <ul class="post-meta">
                                            <li><a href="#"><i class="fa fa-calendar"></i> {{date_format($data->created_at,'d M y')}}</a></li>
                                            <li><a href="#"><i class="fa fa-user"></i> {{$data->user->username}}</a></li>
                                            <li><div class="cats"><i class="fa fa-calendar"></i><a href="{{route('frontend.blog.category',['id' => $data->category->id,'any' => Str::slug($data->category->name)])}}"> {{$data->category->name}}</a></div></li>
                                        </ul>
                                        <p>{{$data->excerpt}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-lg-12">
                        <nav class="pagination-wrapper" aria-label="Page navigation ">
                           {{$all_blogs->links()}}
                        </nav>
                    </div>
                </div>
                <div class="col-lg-4">
                   @include('frontend.partials.sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('frontend.frontend-page-master')
@section('site-title')
    {{$event->title}}
@endsection
@section('page-title')
    {{$event->title}}
@endsection
@section('content')
    <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="single-event-details">
                        @php
                            $event_image = !empty($event->image) ? get_attachment_image_by_id($event->image,"full",false) : '';
                        @endphp
                        @if (!empty($event_image))
                            <div class="thumb">
                                <img src="{{$event_image['img_url']}}" alt="{{$event->title}}">
                            </div>
                        @endif
                        <div class="content">
                            <div class="top-part">
                                <div class="time-wrap">
                                    <span class="date">{{date('d',strtotime($event->date))}}</span>
                                    <span class="month">{{date('M',strtotime($event->date))}}</span>
                                </div>
                                <div class="title-wrap">
                                    <span class="category">{{$event->category->title}}</span>
                                    <span class="location"><i class="fas fa-map-marker-alt"></i> {{$event->location}}</span>
                                </div>
                            </div>
                            <div class="details-content-area">
                                {!! $event->content !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget-area">
                        <div class="widget widget_search">
                            <form action="{{route('frontend.events.search')}}" method="get" class="search-form">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="search" placeholder="{{__('Search...')}}">
                                </div>
                                <button class="submit-btn" type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <div class="widget widget_nav_menu">
                            <h2 class="widget-title">{{get_static_option('site_events_category_'.get_user_lang().'_title')}}</h2>
                            <ul>
                                @foreach($all_event_category as $data)
                                    <li><a href="{{route('frontend.events.category',['id' => $data->id,'any'=> Str::slug($data->title,'-')])}}">{{ucfirst($data->title)}}</a></li>
                                @endforeach
                            </ul>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

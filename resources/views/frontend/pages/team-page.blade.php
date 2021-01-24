@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('team_page_'.get_user_lang().'_name')}}
@endsection
@section('page-title')
    {{get_static_option('team_page_'.get_user_lang().'_name')}}
@endsection
@section('content')

    <div class="team-member-area gray-bg team-page padding-120">
        <div class="container">
            <div class="row">
                @foreach($all_team_members as $data)
                    <div class="col-lg-3 col-md-6">
                        <div class="single-team-member-one margin-bottom-30 gray-bg">
                            <div class="thumb">
                                @php
                                    $team_member_image = get_attachment_image_by_id($data->image,"grid",false);
                                @endphp
                                @if (!empty($team_member_image))
                                    <img src="{{$team_member_image['img_url']}}" alt="{{__($data->name)}}">
                                @endif
                                <div class="hover">
                                    <ul class="social-icon">
                                        @if(!empty($data->icon_one) && !empty($data->icon_one_url))
                                            <li><a href="{{$data->icon_one_url}}"><i class="{{$data->icon_one}}"></i></a></li>
                                        @endif
                                        @if(!empty($data->icon_two) && !empty($data->icon_two_url))
                                            <li><a href="{{$data->icon_two_url}}"><i class="{{$data->icon_two}}"></i></a></li>
                                        @endif
                                        @if(!empty($data->icon_three) && !empty($data->icon_three_url))
                                            <li><a href="{{$data->icon_three_url}}"><i class="{{$data->icon_three}}"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="content">
                                <h4 class="name">{{$data->name}}</h4>
                                <span class="post">{{$data->designation}}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-lg-12">
                    <div class="pagination-wrapper">
                        {{$all_team_members->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('frontend.frontend-page-master')
@section('site-title')
    {{__('Contact')}}
@endsection
@section('page-title')
    {{__('Contact')}}
@endsection
@section('content')
    <div class="page-content contact-page padding-top-120 padding-bottom-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="left-content-area">
                        <div class="section-title desktop-left margin-bottom-50">
                            <h2 class="title">{{get_static_option('contact_page_'.get_user_lang().'_form_section_title')}}</h2>
                            <p>{{get_static_option('contact_page_'.get_user_lang().'_form_section_description')}}</p>
                        </div>
                        @include('backend.partials.message')
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $message)
                                        <li>{{$message}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{route('frontend.contact.message')}}" method="post" enctype="multipart/form-data" id="contact_form_submit" class="contact-form">
                            @csrf
                            <input type="hidden" name="captcha_token" id="gcaptcha_token">
                            <div class="row">
                                <div class="col-lg-12">
                                    @php
                                        $form_fields = json_decode(get_static_option('contact_page_form_fields'));
                                        $select_index = 0;
                                        $options = [];
                                    @endphp
                                    @foreach($form_fields->field_type as $key => $value)
                                        @if(!empty($value))
                                            @if($value == 'select') @php $options = explode(';',$form_fields->select_options[$select_index]);@endphp @endif
                                            @php $required = isset($form_fields->field_required->$key) ? $form_fields->field_required->$key : '' @endphp
                                            @php $mimes = isset($form_fields->mimes_type->$key) ? $form_fields->mimes_type->$key : '' @endphp
                                            {!! get_field_by_type($value,$form_fields->field_name[$key],$form_fields->field_placeholder[$key],$options,$required,$mimes) !!}
                                            @if($value == 'select') @php $select_index++@endphp @endif
                                        @endif
                                    @endforeach
                                </div>
                                <div class="col-lg-12">
                                    <button class="submit-btn" type="submit">{{__('Send Message')}}</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="right-content-area">
                        <ul class="contact-info-list">
                            @foreach($all_contact_info as $data)
                                <li class="single-contact-info">
                                    <div class="icon">
                                        <i class="{{$data->icon}}"></i>
                                    </div>
                                    <div class="content">
                                        <h4 class="title">{{$data->title}}</h4>
                                        @php $desc = explode(';',$data->description) @endphp
                                        @foreach($desc as $item)
                                            <span class="details">{{$item}}</span>
                                        @endforeach
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @php
                            $map_marker_image = get_attachment_image_by_id(get_static_option('contact_page_map_marker_image'),null,false);
                            $map_marker_image_url = !empty($map_marker_image['img_url']) ? $map_marker_image['img_url'] : '';
                        @endphp
                        <div id="map" data-latitude="{{get_static_option('contact_page_map_section_latitude')}}" data-longitude="{{get_static_option('contact_page_map_section_longitude')}}" data-marker="{{$map_marker_image_url}}" class="margin-top-40"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{get_static_option('site_google_map_api')}}&callback=initMap" async defer></script>
    <script src="{{asset('assets/frontend/js/goolge-map-activate.js')}}"></script>
    <script src="https://www.google.com/recaptcha/api.js?render={{get_static_option('site_google_captcha_v3_site_key')}}"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute("{{get_static_option('site_google_captcha_v3_site_key')}}", {action: 'homepage'}).then(function(token) {
                document.getElementById('gcaptcha_token').value = token;
            });
        });
    </script>
@endsection
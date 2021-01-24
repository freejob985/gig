@extends('frontend.frontend-page-master')
@section('page-title')
    {{__('Order For')}} {{' : '.$order_details->title}}
@endsection
@section('content')
    <section class="order-service-page-content-area padding-100">
        <div class="container">
            <div class="row reorder-xs justify-content-between ">
                <div class="col-lg-6">
                    <div class="order-content-area padding-top-70">
                        <h3 class="order-title">{{get_static_option('order_page_'.get_user_lang().'_form_title')}}</h3>
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
                        @if(env('APP_ENV') == 'development' )
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                You can build this form using admin panel <strong>Drag & Drop Form Builder</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form action="{{route('frontend.order.message')}}" method="post" enctype="multipart/form-data" class="contact-form order-form">
                            @csrf
                            <input type="hidden" name="package" value="{{$order_details->id}}">
                            <input type="hidden" name="captcha_token" id="gcaptcha_token">
                            <div class="row">
                                <div class="col-lg-12">
                                    @php
                                        $form_fields = json_decode(get_static_option('order_page_form_fields'));
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
                                    @if(!empty(get_static_option('site_payment_gateway')))
                                    <div class="payment-gateway-wrapper">
                                        <input type="hidden" name="selected_payment_gateway" value="paypal">
                                        <ul>
                                            @if(!empty(get_static_option('paypal_gateway')))
                                            <li data-gateway="paypal">
                                                <div class="img-select">
                                                    @php
                                                        $paypal_logo = get_attachment_image_by_id(get_static_option('paypal_preview_logo'),"full",false);
                                                    @endphp
                                                    @if (!empty($paypal_logo))
                                                        <img src="{{$paypal_logo['img_url']}}" alt="site logo">
                                                    @endif
                                                </div>
                                            </li>
                                            @endif
                                            @if(!empty(get_static_option('paytm_gateway')))
                                                <li data-gateway="paytm">
                                                    <div class="img-select">
                                                        @php
                                                            $paytm_logo = get_attachment_image_by_id(get_static_option('paytm_preview_logo'),"full",false);
                                                        @endphp
                                                        @if (!empty($paytm_logo))
                                                            <img src="{{$paytm_logo['img_url']}}" alt="site logo">
                                                        @endif
                                                    </div>
                                                </li>
                                            @endif
                                            @if(!empty(get_static_option('manual_payment_gateway')))
                                                <li data-gateway="manual_payment">
                                                    <div class="img-select">
                                                        @php
                                                            $manual_payment_logo = get_attachment_image_by_id(get_static_option('manual_payment_preview_logo'),"full",false);
                                                        @endphp
                                                        @if (!empty($manual_payment_logo))
                                                            <img src="{{$manual_payment_logo['img_url']}}" alt="site logo">
                                                        @endif
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-12">
                                    <button class="submit-btn" type="submit">{{__('Order Package')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="right-content-area">
                        <div class="pricing-table-15">
                            <div class="price-header">
                                <div class="icon"><i class="{{$order_details->icon}}"></i></div>
                                <h3 class="title">{{$order_details->title}}</h3>
                            </div>

                            <div class="price">
                                <span class="dollar"></span>{{$order_details->price}}<span class="month">{{$order_details->type}}</span>
                            </div>
                            <div class="price-body">
                                <ul>
                                    @php
                                        $features = explode(';',$order_details->features);
                                    @endphp
                                    @foreach($features as $item)
                                        <li>{{$item}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="price-footer">
                                @if(!empty($order_details->url_status))
                                    <a class="order-btn" href="{{route('frontend.plan.order',$order_details->id)}}">{{$order_details->btn_text}}</a>
                                @else
                                    <a class="order-btn" href="{{$order_details->btn_url}}">{{$order_details->btn_text}}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="https://www.google.com/recaptcha/api.js?render={{get_static_option('site_google_captcha_v3_site_key')}}"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute("{{get_static_option('site_google_captcha_v3_site_key')}}", {action: 'homepage'}).then(function(token) {
                document.getElementById('gcaptcha_token').value = token;
            });
        });
        $(document).ready(function ($) {
            $('.payment-gateway-wrapper ul > li:first-child').addClass('selected').siblings().removeClass('selected');
            $(document).on('click','.payment-gateway-wrapper > ul > li',function (e) {
                e.preventDefault();
                $(this).addClass('selected').siblings().removeClass('selected');
                $('.payment-gateway-wrapper').find(('input')).val($(this).data('gateway'));
            })
        });
    </script>
@endsection
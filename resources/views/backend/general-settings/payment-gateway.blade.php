@extends('backend.admin-master')
@section('site-title')
    {{__('Payment Settings')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                @include('backend.partials.message')
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__("Payment Gateway Settings")}}</h4>
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger">{{$error}}</div>
                            @endforeach
                        @endif
                        <form action="{{route('admin.general.payment.settings')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="site_global_currency">{{__('Site Global Currency')}}</label>
                                        <select name="site_global_currency" class="form-control" id="site_global_currency">
                                            <option value="USD" @if(get_static_option('site_global_currency') == 'USD') selected @endif>{{__('USD')}}</option>
                                            <option value="INR" @if(get_static_option('site_global_currency') == 'INR') selected @endif>{{__('INR')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group margin-bottom-40" style="display: @if(get_static_option('site_global_currency') == 'USD') block @else none @endif;">
                                        <label for="site_usd_to_nri_exchange_rate">{{__('USD To NRI Exchange Rate')}}</label>
                                        <input type="text" class="form-control" name="site_usd_to_nri_exchange_rate" id="site_usd_to_nri_exchange_rate" value="{{get_static_option('site_usd_to_nri_exchange_rate')}}">
                                        <span class="info-text">{{__('enter USD to NRI exchange rate.')}}</span>
                                    </div>
                                    <div class="accordion-wrapper">
                                        <div id="accordion-payment">
                                            <div class="card">
                                                <div class="card-header" id="paypal_settings">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#paypal_settings_content" aria-expanded="true" >
                                                            <span class="page-title"> {{__('Paypal Settings')}}</span>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="paypal_settings_content" class="collapse show"  data-parent="#accordion-payment">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="paypal_gateway"><strong>{{__('Enable/Disable Paypal')}}</strong></label>
                                                            <label class="switch">
                                                                <input type="checkbox" name="paypal_gateway"  @if(!empty(get_static_option('paypal_gateway'))) checked @endif id="paypal_gateway">
                                                                <span class="slider onff"></span>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="site_logo"><strong>{{__('Paypal Logo')}}</strong></label>
                                                            <div class="media-upload-btn-wrapper">
                                                                <div class="img-wrap">
                                                                    @php
                                                                        $paypal_img = get_attachment_image_by_id(get_static_option('paypal_preview_logo'),null,true);
                                                                        $paypal_image_btn_label = 'Upload Image';
                                                                    @endphp
                                                                    @if (!empty($paypal_img))
                                                                        <div class="attachment-preview">
                                                                            <div class="thumbnail">
                                                                                <div class="centered">
                                                                                    <img class="avatar user-thumb" src="{{$paypal_img['img_url']}}" alt="">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @php  $paypal_image_btn_label = 'Change Image'; @endphp
                                                                    @endif
                                                                </div>
                                                                <input type="hidden" id="paypal_preview_logo" name="paypal_preview_logo" value="{{get_static_option('paypal_preview_logo')}}">
                                                                <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Paypal Image" data-modaltitle="Upload Paypal Image" data-toggle="modal" data-target="#media_upload_modal">
                                                                    {{__($paypal_image_btn_label)}}
                                                                </button>
                                                            </div>
                                                            <small class="form-text text-muted">{{__('allowed image format: jpg,jpeg,png. Recommended image size 160x50')}}</small>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="paypal_business_email">{{__('Paypal Business Email')}}</label>
                                                            <input type="text" name="paypal_business_email" id="paypal_business_email" class="form-control" value="{{get_static_option('paypal_business_email')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="paytm_settings">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#paytm_settings_content" aria-expanded="false" >
                                                            <span class="page-title"> {{__('Paytm Settings')}}</span>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="paytm_settings_content" class="collapse"  data-parent="#accordion-payment">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="paytm_gateway"><strong>{{__('Enable/Disable Paytm')}}</strong></label>
                                                            <label class="switch">
                                                                <input type="checkbox" name="paytm_gateway"  @if(!empty(get_static_option('paytm_gateway'))) checked @endif id="paytm_gateway">
                                                                <span class="slider onff"></span>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="site_logo"><strong>{{__('Paytm Logo')}}</strong></label>
                                                            <div class="media-upload-btn-wrapper">
                                                                <div class="img-wrap">
                                                                    @php
                                                                        $paytm_img = get_attachment_image_by_id(get_static_option('paytm_preview_logo'),null,true);
                                                                        $paytm_image_btn_label = 'Upload Image';
                                                                    @endphp
                                                                    @if (!empty($paytm_img))
                                                                        <div class="attachment-preview">
                                                                            <div class="thumbnail">
                                                                                <div class="centered">
                                                                                    <img class="avatar user-thumb" src="{{$paytm_img['img_url']}}" alt="">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @php  $paytm_image_btn_label = 'Change Image'; @endphp
                                                                    @endif
                                                                </div>
                                                                <input type="hidden" id="paytm_preview_logo" name="paytm_preview_logo" value="{{get_static_option('paytm_preview_logo')}}">
                                                                <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Paytm Image" data-modaltitle="Upload Paytm Image" data-toggle="modal" data-target="#media_upload_modal">
                                                                    {{__($paytm_image_btn_label)}}
                                                                </button>
                                                            </div>
                                                            <small class="form-text text-muted">{{__('allowed image format: jpg,jpeg,png. Recommended image size 160x50')}}</small>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="paytm_merchant_key">{{__('Paytm Merchant Key')}}</label>
                                                            <input type="text" name="paytm_merchant_key" id="paytm_merchant_key" value="{{get_static_option('paytm_merchant_key')}}" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="paytm_merchant_mid">{{__('Paytm Merchant ID')}}</label>
                                                            <input type="text" name="paytm_merchant_mid" id="paytm_merchant_mid"  value="{{get_static_option('paytm_merchant_mid')}}" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="paytm_merchant_website">{{__('Paytm Merchant Website')}}</label>
                                                            <input type="text" name="paytm_merchant_website" id="paytm_merchant_website"  value="{{get_static_option('paytm_merchant_website')}}" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="manual_payment_settings">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#manual_payment_settings_content" aria-expanded="false" >
                                                            <span class="page-title"> {{__('Manual Payment Settings')}}</span>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="manual_payment_settings_content" class="collapse"  data-parent="#accordion-payment">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="manual_payment_gateway"><strong>{{__('Enable/Disable Manual Payment')}}</strong></label>
                                                            <label class="switch">
                                                                <input type="checkbox" name="manual_payment_gateway"  @if(!empty(get_static_option('manual_payment_gateway'))) checked @endif id="manual_payment_gateway">
                                                                <span class="slider onff"></span>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="site_logo"><strong>{{__('Manual Payment Logo')}}</strong></label>
                                                            <div class="media-upload-btn-wrapper">
                                                                <div class="img-wrap">
                                                                    @php
                                                                        $paytm_img = get_attachment_image_by_id(get_static_option('manual_payment_preview_logo'),null,false);
                                                                        $paytm_image_btn_label = 'Upload Image';
                                                                    @endphp
                                                                    @if (!empty($paytm_img))
                                                                        <div class="attachment-preview">
                                                                            <div class="thumbnail">
                                                                                <div class="centered">
                                                                                    <img class="avatar user-thumb" src="{{$paytm_img['img_url']}}" alt="">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @php  $paytm_image_btn_label = 'Change Image'; @endphp
                                                                    @endif
                                                                </div>
                                                                <input type="hidden" id="manual_payment_preview_logo" name="manual_payment_preview_logo" value="{{get_static_option('manual_payment_preview_logo')}}">
                                                                <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Manual Payment Logo Image" data-modaltitle="Upload Manual Payment Logo Image" data-toggle="modal" data-target="#media_upload_modal">
                                                                    {{__($paytm_image_btn_label)}}
                                                                </button>
                                                            </div>
                                                            <small class="form-text text-muted">{{__('allowed image format: jpg,jpeg,png. Recommended image size 160x50')}}</small>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="site_manual_payment_name">{{__('Manual Payment Name')}}</label>
                                                            <input type="text" name="site_manual_payment_name" id="site_manual_payment_name" value="{{get_static_option('site_manual_payment_name')}}" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="site_manual_payment_description">{{__('Manual Payment Description')}}</label>
                                                            <textarea name="site_manual_payment_description" id="site_manual_payment_description" class="form-control" cols="30" rows="10">{{get_static_option('site_manual_payment_description')}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.partials.media-upload.media-upload-markup')
@endsection
@section('script')
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
    <script>
        $(document).ready(function ($) {

            $(document).on('change','#site_global_currency',function (e) {
                e.preventDefault();
                checkCurrency();
            });

            function checkCurrency() {
                var selectedValue = $('#site_global_currency').val();
                if(selectedValue == 'USD'){
                    $('#site_usd_to_nri_exchange_rate').parent().show();
                }else{
                    $('#site_usd_to_nri_exchange_rate').parent().hide();
                }
            }

        });

    </script>
@endsection

@extends('frontend.frontend-page-master')
@section('page-title')
    {{__('Order Confirm')}}
@endsection
@section('content')
    <div class="error-page-content padding-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="order-confirm-area">
                        <h4 class="title">{{__('Order Details')}}</h4>
                        @if($errors->any())
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        @endif
                        <form action="{{route('frontend.order.payment.form')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @php
                            $custom_fields = unserialize( $order_details->custom_fields);
                            $payment_gateway = !empty($custom_fields['selected_payment_gateway']) ? $custom_fields['selected_payment_gateway'] : '';
                            @endphp
                            <input type="hidden" name="order_id" value="{{$order_details->id}}">
                            <input type="hidden" name="payment_gateway" value="{{$payment_gateway}}">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <td>{{__('Your Name')}}</td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="{{__('Enter Your Name')}}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{__('Your Email')}}</td>
                                    <td>
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control" placeholder="{{__('Enter Your Email')}}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{__('Package Name')}}</td>
                                    <td>{{$order_details->package_name}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('Package Price')}}</td>
                                    <td>{{$order_details->package_price}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('Payment Gateway')}}</td>
                                    <td class="text-capitalize">
                                        @if($payment_gateway == 'manual_payment')
                                            {{get_static_option('site_manual_payment_name')}}
                                        @else
                                            {{$payment_gateway}}
                                        @endif
                                    </td>
                                </tr>
                                @if($payment_gateway == 'manual_payment')
                                    <tr>
                                        <td>{{__('Transaction ID')}}</td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="trasaction_id" class="form-control">
                                                <small>{{get_static_option('site_manual_payment_description')}}</small>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="btn-wrapper">
                            <button type="submit" class="submit-btn">{{__('Pay Now')}}</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

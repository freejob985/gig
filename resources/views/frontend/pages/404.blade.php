@extends('frontend.frontend-page-master')
@section('page-title')
    {{__('404')}}
@endsection
@section('content')
    <div class="error-page-content padding-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="error-area">
                       <h1 class="title">{{__('404')}}</h1>
                        <p>{{__('It looks like nothing was found at this location.')}}</p>
                       <div class="btn-wrapper">
                           <a href="{{url('/')}}" class="boxed-btn">{{__('Back To Home')}}</a>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

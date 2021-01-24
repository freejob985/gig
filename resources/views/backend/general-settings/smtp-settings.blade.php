@extends('backend.admin-master')
@section('site-title')
    {{__('SMTP Settings')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                @include('backend.partials.message')
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__("SMTP Settings")}}</h4>
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger">{{$error}}</div>
                             @endforeach
                        @endif
                        <form action="{{route('admin.general.smtp.settings')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="site_smtp_mail_host">{{__('SMTP Mail Host')}}</label>
                                <input type="text" name="site_smtp_mail_host"  class="form-control" value="{{get_static_option('site_smtp_mail_host')}}" id="site_smtp_mail_host">
                            </div>
                            <div class="form-group">
                                <label for="site_smtp_mail_port">{{__('SMTP Mail Port')}}</label>
                                <input type="text" name="site_smtp_mail_port"  class="form-control" value="{{get_static_option('site_smtp_mail_port')}}" id="site_smtp_mail_port">
                            </div>
                            <div class="form-group">
                                <label for="site_smtp_mail_username">{{__('SMTP Mail Username')}}</label>
                                <input type="text" name="site_smtp_mail_username"  class="form-control" value="{{get_static_option('site_smtp_mail_username')}}" id="site_smtp_mail_username">
                            </div>
                            <div class="form-group">
                                <label for="site_smtp_mail_password">{{__('SMTP Mail Password')}}</label>
                                <input type="password" name="site_smtp_mail_password"  class="form-control" value="{{get_static_option('site_smtp_mail_password')}}" id="site_smtp_mail_password">
                            </div>
                            <div class="form-group">
                                <label for="site_smtp_mail_encryption">{{__('SMTP Mail Encryption')}}</label>
                                <input type="text" name="site_smtp_mail_encryption"  class="form-control" value="{{get_static_option('site_smtp_mail_encryption')}}" id="site_smtp_mail_encryption">
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update SMTP Settings')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

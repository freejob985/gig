@extends('backend.admin-master')
@section('site-title')
    {{__('Page Settings')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                @include('backend.partials.message')
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__("Page Name & Slug Settings")}}</h4>
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger">{{$error}}</div>
                             @endforeach
                        @endif
                        <form action="{{route('admin.general.page.settings')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="from-group">
                                        <label for="about_page_slug">{{__('About Page Slug')}}</label>
                                        <input type="text" class="form-control" id="about_page_slug" value="{{get_static_option('about_page_slug')}}" name="about_page_slug" placeholder="{{__('Slug')}}" >
                                        <small>{{__('slug example: about-page')}}</small>
                                    </div>
                                    <div class="from-group">
                                        <label for="service_page_slug">{{__('Service Page Slug')}}</label>
                                        <input type="text" class="form-control" id="service_page_slug" value="{{get_static_option('service_page_slug')}}" name="service_page_slug" placeholder="{{__('Slug')}}" >
                                        <small>{{__('slug example: service-page')}}</small>
                                    </div>
                                    <div class="from-group">
                                        <label for="works_page_slug">{{__('Works Page Slug')}}</label>
                                        <input type="text" class="form-control" id="works_page_slug" value="{{get_static_option('works_page_slug')}}" name="works_page_slug" placeholder="{{__('Slug')}}" >
                                        <small>{{__('slug example: works')}}</small>
                                    </div>
                                    <div class="from-group">
                                        <label for="team_page_slug">{{__('Team Page Slug')}}</label>
                                        <input type="text" class="form-control" id="team_page_slug" value="{{get_static_option('team_page_slug')}}" name="team_page_slug" placeholder="{{__('Slug')}}" >
                                        <small>{{__('slug example: team')}}</small>
                                    </div>
                                    <div class="from-group">
                                        <label for="faq_page_slug">{{__('Faq Page Slug')}}</label>
                                        <input type="text" class="form-control" id="faq_page_slug" value="{{get_static_option('faq_page_slug')}}" name="faq_page_slug" placeholder="{{__('Slug')}}" >
                                        <small>{{__('slug example: faq')}}</small>
                                    </div>
                                    <div class="from-group">
                                        <label for="price_plan_page_slug">{{__('Price Plan Page Slug')}}</label>
                                        <input type="text" class="form-control" id="price_plan_page_slug" value="{{get_static_option('price_plan_page_slug')}}" name="price_plan_page_slug" placeholder="{{__('Slug')}}" >
                                        <small>{{__('slug example: price-plan')}}</small>
                                    </div>
                                    <div class="from-group">
                                        <label for="blog_page_slug">{{__('Blog Page Slug')}}</label>
                                        <input type="text" class="form-control" id="blog_page_slug" value="{{get_static_option('blog_page_slug')}}" name="blog_page_slug" placeholder="{{__('Slug')}}" >
                                        <small>{{__('slug example: blog')}}</small>
                                    </div>
                                    <div class="from-group">
                                        <label for="contact_page_slug">{{__('Contact Page Slug')}}</label>
                                        <input type="text" class="form-control" id="contact_page_slug" value="{{get_static_option('contact_page_slug')}}" name="contact_page_slug" placeholder="{{__('Slug')}}" >
                                        <small>{{__('slug example: contact')}}</small>
                                    </div>
                                    <div class="from-group">
                                        <label for="career_with_us_page_slug">{{__('Career With Us Page Slug')}}</label>
                                        <input type="text" class="form-control" id="career_with_us_page_slug" value="{{get_static_option('career_with_us_page_slug')}}" name="career_with_us_page_slug" placeholder="{{__('Slug')}}" >
                                        <small>{{__('slug example: career')}}</small>
                                    </div>
                                    <div class="from-group">
                                        <label for="events_page_slug">{{__('Events Page Slug')}}</label>
                                        <input type="text" class="form-control" id="events_page_slug" value="{{get_static_option('events_page_slug')}}" name="events_page_slug" placeholder="{{__('Slug')}}" >
                                        <small>{{__('slug example: events')}}</small>
                                    </div>
                                    <div class="from-group">
                                        <label for="knowledgebase_page_slug">{{__('Knowledgebase Page Slug')}}</label>
                                        <input type="text" class="form-control" id="knowledgebase_page_slug" value="{{get_static_option('knowledgebase_page_slug')}}" name="knowledgebase_page_slug" placeholder="{{__('Slug')}}" >
                                        <small>{{__('slug example: knowledgebase')}}</small>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            @foreach($all_languages as $key => $lang)
                                                <a class="nav-item nav-link @if($key == 0) active @endif" id="nav-home-tab" data-toggle="tab" href="#nav-home-{{$lang->slug}}" role="tab" aria-controls="nav-home" aria-selected="true">{{$lang->name}}</a>
                                            @endforeach
                                        </div>
                                    </nav>
                                    <div class="tab-content margin-top-30" id="nav-tabContent">
                                        @foreach($all_languages as $key => $lang)
                                            <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-home-{{$lang->slug}}" role="tabpanel" aria-labelledby="nav-home-tab">
                                                <div class="accordion-wrapper">
                                                    <div id="accordion-{{$lang->slug}}">
                                                        <div class="card">
                                                            <div class="card-header" id="about_page_{{$lang->slug}}">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#about_page_content_{{$lang->slug}}" aria-expanded="true" >
                                                                        <span class="page-title">@if(!empty(get_static_option('about_page_'.$lang->slug.'_name'))) {{get_static_option('about_page_'.$lang->slug.'_name')}} @else {{__('About')}}  @endif</span>
                                                                    </button>
                                                                </h5>
                                                            </div>
                                                            <div id="about_page_content_{{$lang->slug}}" class="collapse show"  data-parent="#accordion-{{$lang->slug}}">
                                                                <div class="card-body">
                                                                    <div class="from-group">
                                                                        <label for="about_page_{{$lang->slug}}_name">{{__('Name')}}</label>
                                                                        <input type="text" class="form-control" name="about_page_{{$lang->slug}}_name" id="about_page_{{$lang->slug}}_name" value="{{get_static_option('about_page_'.$lang->slug.'_name')}}"  placeholder="{{__('Name')}}" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header" id="service_page_{{$lang->slug}}">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#service_page_content_{{$lang->slug}}" aria-expanded="false" >
                                                                        <span class="page-title">@if(!empty(get_static_option('service_page_'.$lang->slug.'_name'))) {{get_static_option('service_page_'.$lang->slug.'_name')}} @else {{__('Service')}}  @endif</span>
                                                                    </button>
                                                                </h5>
                                                            </div>
                                                            <div id="service_page_content_{{$lang->slug}}" class="collapse"  data-parent="#accordion-{{$lang->slug}}">
                                                                <div class="card-body">
                                                                    <div class="from-group">
                                                                        <label for="service_page_{{$lang->slug}}_name">{{__('Name')}}</label>
                                                                        <input type="text" class="form-control" name="service_page_{{$lang->slug}}_name" id="service_page_{{$lang->slug}}_name" value="{{get_static_option('service_page_'.$lang->slug.'_name')}}"  placeholder="{{__('Name')}}" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header" id="work_page_{{$lang->slug}}">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#work_page_content_{{$lang->slug}}" aria-expanded="false" >
                                                                        <span class="page-title">@if(!empty(get_static_option('work_page_'.$lang->slug.'_name'))) {{get_static_option('work_page_'.$lang->slug.'_name')}} @else {{__('Work')}}  @endif</span>
                                                                    </button>
                                                                </h5>
                                                            </div>
                                                            <div id="work_page_content_{{$lang->slug}}" class="collapse"  data-parent="#accordion-{{$lang->slug}}">
                                                                <div class="card-body">
                                                                    <div class="from-group">
                                                                        <label for="work_page_{{$lang->slug}}_name">{{__('Name')}}</label>
                                                                        <input type="text" class="form-control page-name" id="work_page_{{$lang->slug}}_name" value="{{get_static_option('work_page_'.$lang->slug.'_name')}}" name="work_page_{{$lang->slug}}_name" placeholder="{{__('Name')}}" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header" id="team_page_{{$lang->slug}}">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#team_page_content_{{$lang->slug}}" aria-expanded="false" >
                                                                        <span class="page-title">@if(!empty(get_static_option('team_page_'.$lang->slug.'_name'))) {{get_static_option('team_page_'.$lang->slug.'_name')}} @else {{__('Team')}}  @endif</span>
                                                                    </button>
                                                                </h5>
                                                            </div>
                                                            <div id="team_page_content_{{$lang->slug}}" class="collapse"  data-parent="#accordion-{{$lang->slug}}">
                                                                <div class="card-body">
                                                                    <div class="from-group">
                                                                        <label for="team_page_{{$lang->slug}}_name">{{__('Name')}}</label>
                                                                        <input type="text" class="form-control page-name" id="team_page_{{$lang->slug}}_name" value="{{get_static_option('team_page_'.$lang->slug.'_name')}}" name="team_page_{{$lang->slug}}_name" placeholder="{{__('Name')}}" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header" id="faq_page_{{$lang->slug}}">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#faq_page_content_{{$lang->slug}}" aria-expanded="false" >
                                                                        <span class="page-title">@if(!empty(get_static_option('faq_page_'.$lang->slug.'_name'))) {{get_static_option('faq_page_'.$lang->slug.'_name')}} @else {{__('Faq')}}  @endif</span>
                                                                    </button>
                                                                </h5>
                                                            </div>
                                                            <div id="faq_page_content_{{$lang->slug}}" class="collapse"  data-parent="#accordion-{{$lang->slug}}">
                                                                <div class="card-body">
                                                                    <div class="from-group">
                                                                        <label for="faq_page_{{$lang->slug}}_name">{{__('Name')}}</label>
                                                                        <input type="text" class="form-control page-name" id="faq_page_{{$lang->slug}}_name" value="{{get_static_option('faq_page_'.$lang->slug.'_name')}}" name="faq_page_{{$lang->slug}}_name" placeholder="{{__('Name')}}" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header" id="price_plan_page_{{$lang->slug}}">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#price_plan_page_content_{{$lang->slug}}" aria-expanded="false" >
                                                                        <span class="page-title">@if(!empty(get_static_option('price_plan_page_'.$lang->slug.'_name'))) {{get_static_option('price_plan_page_'.$lang->slug.'_name')}} @else {{__('Price Plan')}}  @endif</span>
                                                                    </button>
                                                                </h5>
                                                            </div>
                                                            <div id="price_plan_page_content_{{$lang->slug}}" class="collapse"  data-parent="#accordion-{{$lang->slug}}">
                                                                <div class="card-body">
                                                                    <div class="from-group">
                                                                        <label for="price_plan_page_{{$lang->slug}}_name">{{__('Name')}}</label>
                                                                        <input type="text" class="form-control page-name" id="price_plan_page_{{$lang->slug}}_name" value="{{get_static_option('price_plan_page_'.$lang->slug.'_name')}}" name="price_plan_page_{{$lang->slug}}_name" placeholder="{{__('Name')}}" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header" id="blog_page_{{$lang->slug}}">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#blog_page_content_{{$lang->slug}}" aria-expanded="false" >
                                                                        <span class="page-title">@if(!empty(get_static_option('blog_page_'.$lang->slug.'_name'))) {{get_static_option('blog_page_'.$lang->slug.'_name')}} @else {{__('Blog')}}  @endif</span>
                                                                    </button>
                                                                </h5>
                                                            </div>
                                                            <div id="blog_page_content_{{$lang->slug}}" class="collapse"  data-parent="#accordion-{{$lang->slug}}">
                                                                <div class="card-body">
                                                                    <div class="from-group">
                                                                        <label for="blog_page_{{$lang->slug}}_name">{{__('Name')}}</label>
                                                                        <input type="text" class="form-control page-name" id="blog_page_{{$lang->slug}}_name" value="{{get_static_option('blog_page_'.$lang->slug.'_name')}}" name="blog_page_{{$lang->slug}}_name" placeholder="{{__('Name')}}" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header" id="contact_page_{{$lang->slug}}">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#contact_page_content_{{$lang->slug}}" aria-expanded="false" >
                                                                        <span class="page-title">@if(!empty(get_static_option('contact_page_'.$lang->slug.'_name'))) {{get_static_option('contact_page_'.$lang->slug.'_name')}} @else {{__('Contact')}}  @endif</span>
                                                                    </button>
                                                                </h5>
                                                            </div>
                                                            <div id="contact_page_content_{{$lang->slug}}" class="collapse"  data-parent="#accordion-{{$lang->slug}}">
                                                                <div class="card-body">
                                                                    <div class="from-group">
                                                                        <label for="contact_page_{{$lang->slug}}_name">{{__('Name')}}</label>
                                                                        <input type="text" class="form-control page-name" id="contact_page_{{$lang->slug}}_name" value="{{get_static_option('contact_page_'.$lang->slug.'_name')}}" name="contact_page_{{$lang->slug}}_name" placeholder="{{__('Name')}}" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header" id="career_with_us_page_{{$lang->slug}}">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#career_with_us_page_content_{{$lang->slug}}" aria-expanded="false" >
                                                                        <span class="page-title">@if(!empty(get_static_option('career_with_us_page_'.$lang->slug.'_name'))) {{get_static_option('career_with_us_page_'.$lang->slug.'_name')}} @else {{__('Career With Us')}}  @endif</span>
                                                                    </button>
                                                                </h5>
                                                            </div>
                                                            <div id="career_with_us_page_content_{{$lang->slug}}" class="collapse"  data-parent="#accordion-{{$lang->slug}}">
                                                                <div class="card-body">
                                                                    <div class="from-group">
                                                                        <label for="career_with_us_page_{{$lang->slug}}_name">{{__('Name')}}</label>
                                                                        <input type="text" class="form-control page-name" id="career_with_us_page_{{$lang->slug}}_name" value="{{get_static_option('career_with_us_page_'.$lang->slug.'_name')}}" name="career_with_us_page_{{$lang->slug}}_name" placeholder="{{__('Name')}}" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header" id="events_page_{{$lang->slug}}">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#events_page_content_{{$lang->slug}}" aria-expanded="false" >
                                                                        <span class="page-title">@if(!empty(get_static_option('events_page_'.$lang->slug.'_name'))) {{get_static_option('events_page_'.$lang->slug.'_name')}} @else {{__('Events')}}  @endif</span>
                                                                    </button>
                                                                </h5>
                                                            </div>
                                                            <div id="events_page_content_{{$lang->slug}}" class="collapse"  data-parent="#accordion-{{$lang->slug}}">
                                                                <div class="card-body">
                                                                    <div class="from-group">
                                                                        <label for="events_page_{{$lang->slug}}_name">{{__('Name')}}</label>
                                                                        <input type="text" class="form-control page-name" id="events_page_{{$lang->slug}}_name" value="{{get_static_option('events_page_'.$lang->slug.'_name')}}" name="events_page_{{$lang->slug}}_name" placeholder="{{__('Name')}}" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="card">
                                                            <div class="card-header" id="knowledgebase_page_{{$lang->slug}}">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#knowledgebase_page_content_{{$lang->slug}}" aria-expanded="false" >
                                                                        <span class="page-title">@if(!empty(get_static_option('knowledgebase_page_'.$lang->slug.'_name'))) {{get_static_option('knowledgebase_page_'.$lang->slug.'_name')}} @else {{__('Knowledgebase')}}  @endif</span>
                                                                    </button>
                                                                </h5>
                                                            </div>
                                                            <div id="knowledgebase_page_content_{{$lang->slug}}" class="collapse"  data-parent="#accordion-{{$lang->slug}}">
                                                                <div class="card-body">
                                                                    <div class="from-group">
                                                                        <label for="knowledgebase_page_{{$lang->slug}}_name">{{__('Name')}}</label>
                                                                        <input type="text" class="form-control page-name" id="knowledgebase_page_{{$lang->slug}}_name" value="{{get_static_option('knowledgebase_page_'.$lang->slug.'_name')}}" name="knowledgebase_page_{{$lang->slug}}_name" placeholder="{{__('Name')}}" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
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
@endsection


@section('script')
    <script>
        $(document).ready(function (e) {
            $('.page-name').bind('change paste keyup',function (e) {
                $(this).parent().parent().parent().prev().find('.page-title').text($(this).val());
            })
        })
    </script>
@endsection
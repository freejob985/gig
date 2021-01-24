<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="{{route('admin.home')}}">
                @php
                $logo_type = 'site_logo';
                    if(!empty(get_static_option('site_admin_dark_mode'))){
                        $logo_type = 'site_white_logo';
                    }
                    $site_logo = get_attachment_image_by_id(get_static_option($logo_type),"full",false);
                @endphp
                @if (!empty($site_logo))
                    <img src="{{$site_logo['img_url']}}" alt="{{get_static_option('site_'.get_user_lang().'_title')}}">
                @endif
            </a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <li class="{{active_menu('admin-home')}}">
                        <a href="{{route('admin.home')}}"
                           aria-expanded="true">
                            <i class="ti-dashboard"></i>
                            <span>@lang('dashboard')</span>
                        </a>
                    </li>
                    @if(check_page_permission('admin_role_manage'))
                    <li
                            class="
                        {{active_menu('admin-home/new-user')}}
                            {{active_menu('admin-home/all-user')}}
                            {{active_menu('admin-home/all-user/role')}}
                                    "
                    >
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-user"></i>
                            <span>{{__('Admin Role Manage')}}</span></a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/all-user')}}"><a
                                        href="{{route('admin.all.user')}}">{{__('All Admin')}}</a></li>
                            <li class="{{active_menu('admin-home/new-user')}}"><a
                                        href="{{route('admin.new.user')}}">{{__('Add New Admin')}}</a></li>
                            <li class="{{active_menu('admin-home/all-user/role')}}"><a
                                        href="{{route('admin.all.user.role')}}">{{__('All Admin Role')}}</a></li>
                        </ul>
                    </li>
                    @endif
                    @if(check_page_permission('newsletter_manage'))
                    <li
                            class="
                            {{active_menu('admin-home/newsletter')}}
                            @if(request()->is('admin-home/newsletter/*')) active @endif
                                    "
                    >
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-email"></i>
                            <span>{{__('Newsletter Manage')}}</span></a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/newsletter')}}"><a
                                        href="{{route('admin.newsletter')}}">{{__('All Subscriber')}}</a></li>
                            <li class="{{active_menu('admin-home/newsletter/all')}}"><a
                                        href="{{route('admin.newsletter.mail')}}">{{__('Send Mail To All')}}</a></li>
                        </ul>
                    </li>
                    @endif
                    @if(check_page_permission('quote_manage'))
                        <li class="@if(request()->is('admin-home/quote-manage/*')) active @endif ">
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-quote-left"></i>
                                <span>{{__('Quote Manage')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/quote-manage/all')}}"><a
                                            href="{{route('admin.quote.manage.all')}}">{{__('All Quote')}}</a></li>
                                <li class="{{active_menu('admin-home/quote-manage/pending')}}"><a
                                            href="{{route('admin.quote.manage.pending')}}">{{__('Pending Quote')}}</a></li>
                                <li class="{{active_menu('admin-home/quote-manage/completed')}}"><a
                                            href="{{route('admin.quote.manage.completed')}}">{{__('Complete Quote')}}</a></li>
                            </ul>
                        </li>
                    @endif
                    @if(check_page_permission('order_manage'))
                        <li class="@if(request()->is('admin-home/order-manage/*')) active @endif ">
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-light-bulb"></i>
                                <span>{{__('Order Manage')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/order-manage/all')}}"><a
                                            href="{{route('admin.order.manage.all')}}">{{__('All Order')}}</a></li>
                                <li class="{{active_menu('admin-home/order-manage/pending')}}"><a
                                            href="{{route('admin.order.manage.pending')}}">{{__('Pending Order')}}</a></li>
                                <li class="{{active_menu('admin-home/order-manage/in-progress')}}"><a
                                            href="{{route('admin.order.manage.in.progress')}}">{{__('In Progress Order')}}</a></li>
                                <li class="{{active_menu('admin-home/order-manage/completed')}}"><a
                                            href="{{route('admin.order.manage.completed')}}">{{__('Completed Order')}}</a></li>
                                <li class="{{active_menu('admin-home/order-manage/success-page')}}"><a
                                            href="{{route('admin.order.success.page')}}">{{__('Success Order Page')}}</a></li>
                                <li class="{{active_menu('admin-home/order-manage/cancel-page')}}"><a
                                            href="{{route('admin.order.cancel.page')}}">{{__('Cancel Order Page')}}</a></li>
                            </ul>
                        </li>
                    @endif
                    @if(check_page_permission('all_payment_logs'))
                        <li class="{{active_menu('admin-home/payment-logs')}}">
                            <a href="{{route('admin.payment.logs')}}"
                               aria-expanded="true">
                                <i class="ti-file"></i>
                                <span>{{__('All Payment Logs')}}</span>
                            </a>
                        </li>
                    @endif
                    @if(check_page_permission('pages'))
                        <li
                                class="
                        {{active_menu('admin-home/page')}}
                                {{active_menu('admin-home/new-page')}}
                                @if(request()->is('admin-home/page-edit/*')) active @endif
                                        "
                        >
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                                <span>{{__('Pages')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/page')}}"><a
                                            href="{{route('admin.page')}}">{{__('All Pages')}}</a></li>
                                <li class="{{active_menu('admin-home/new-page')}}"><a
                                            href="{{route('admin.page.new')}}">{{__('Add New Page')}}</a></li>
                            </ul>
                        </li>
                    @endif
                    @if(check_page_permission('menus_manage'))
                        <li
                                class="
                        {{active_menu('admin-home/menu')}}
                                @if(request()->is('admin-home/menu-edit/*')) active @endif
                                        "
                        >
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                                <span>{{__('Menus Manage')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/menu')}}"><a
                                            href="{{route('admin.menu')}}">{{__('All Menus')}}</a></li>
                            </ul>
                        </li>
                    @endif
                    @if(check_page_permission('form_builder'))
                        <li class="@if(request()->is('admin-home/form-builder/*')) active @endif">
                            <a href="javascript:void(0)"
                               aria-expanded="true">
                                <i class="ti-layout"></i>
                                <span>{{__('Form Builder')}}</span>
                            </a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/form-builder/quote-form')}}"><a
                                            href="{{route('admin.form.builder.quote')}}">{{__('Quote Form')}}</a></li>
                                <li class="{{active_menu('admin-home/form-builder/order-form')}}"><a
                                            href="{{route('admin.form.builder.order')}}">{{__('Order Form')}}</a></li>
                                <li class="{{active_menu('admin-home/form-builder/contact-form')}}"><a
                                            href="{{route('admin.form.builder.contact')}}">{{__('Contact Form')}}</a></li>
                                <li class="{{active_menu('admin-home/form-builder/call-back-form')}}"><a
                                            href="{{route('admin.form.builder.call.back')}}">{{__('Request Call Back Form')}}</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if(check_page_permission('blogs'))
                        <li
                                class="
                        {{active_menu('admin-home/blog')}}
                                {{active_menu('admin-home/blog-category')}}
                                {{active_menu('admin-home/new-blog')}}
                                @if(request()->is('admin-home/blog-edit/*')) active @endif
                                        "
                        >
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                                <span>{{__('Blogs')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/blog')}}"><a
                                            href="{{route('admin.blog')}}">{{__('All Blog')}}</a></li>
                                <li class="{{active_menu('admin-home/blog-category')}}"><a
                                            href="{{route('admin.blog.category')}}">{{__('Category')}}</a></li>
                                <li class="{{active_menu('admin-home/new-blog')}}"><a
                                            href="{{route('admin.blog.new')}}">{{__('Add New Post')}}</a></li>
                            </ul>
                        </li>
                    @endif
                    @if(check_page_permission('job_post_manage'))
                    <li
                            class="
                        {{active_menu('admin-home/jobs')}}
                            {{active_menu('admin-home/jobs-category')}}
                            @if(request()->is('admin-home/jobs/*')) active @endif
                                    "
                    >
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                            <span>{{__('Job Post Manage')}}</span></a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/jobs')}}"><a
                                        href="{{route('admin.jobs.all')}}">{{__('All Jobs')}}</a></li>
                            <li class="{{active_menu('admin-home/jobs-category')}}"><a
                                        href="{{route('admin.jobs.category.all')}}">{{__('Category')}}</a></li>
                            <li class="{{active_menu('admin-home/new-jobs')}}"><a
                                        href="{{route('admin.jobs.new')}}">{{__('Add New Job')}}</a></li>
                            <li class="{{active_menu('admin-home/jobs/page-settings')}}"><a
                                        href="{{route('admin.jobs.page.settings')}}">{{__('Job Page Settings')}}</a></li>
                        </ul>
                    </li>
                    @endif
                    @if(check_page_permission('events_manage'))
                    <li class="
                    {{active_menu('admin-home/events')}}
                    @if(request()->is('admin-home/events/*')) active @endif
                    ">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                            <span>{{__('Events Manage')}}</span></a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/events')}}"><a
                                        href="{{route('admin.events.all')}}">{{__('All Events')}}</a></li>
                            <li class="{{active_menu('admin-home/events/category')}}"><a
                                        href="{{route('admin.events.category.all')}}">{{__('Category')}}</a></li>
                            <li class="{{active_menu('admin-home/events/new')}}"><a
                                        href="{{route('admin.events.new')}}">{{__('Add New Event')}}</a></li>
                            <li class="{{active_menu('admin-home/events/page-settings')}}"><a
                                        href="{{route('admin.events.page.settings')}}">{{__('Event Page Settings')}}</a></li>
                        </ul>
                    </li>
                    @endif
                    @if(check_page_permission('knowledgebase'))
                    <li class="{{active_menu('admin-home/knowledge')}} @if(request()->is('admin-home/knowledge/*')) active @endif">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                            <span>{{__('Knowledgebase')}}</span></a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/knowledge')}}"><a
                                        href="{{route('admin.knowledge.all')}}">{{__('All Articles')}}</a></li>
                            <li class="{{active_menu('admin-home/knowledge/category')}}"><a
                                        href="{{route('admin.knowledge.category.all')}}">{{__('Topics')}}</a></li>
                            <li class="{{active_menu('admin-home/new-knowledge')}}"><a
                                        href="{{route('admin.knowledge.new')}}">{{__('Add New Article')}}</a></li>
                            <li class="{{active_menu('admin-home/knowledge/page-settings')}}"><a
                                        href="{{route('admin.knowledge.page.settings')}}">{{__('Knowledgebase Page Settings')}}</a></li>
                        </ul>
                    </li>
                    @endif
                    @if(check_page_permission('home_variant'))
                    <li class="{{active_menu('admin-home/home-variant')}}">
                        <a href="{{route('admin.home.variant')}}"
                           aria-expanded="true">
                            <i class="ti-file"></i>
                            <span>{{__('Home Variant')}}</span>
                        </a>
                    </li>
                    @endif
                    @if(check_page_permission('nabvar_settings'))
                    <li class="{{active_menu('admin-home/navbar-settings')}}">
                        <a href="{{route('admin.navbar.settings')}}"
                           aria-expanded="true">
                            <i class="ti-file"></i>
                            <span>{{__('Nabvar Settings')}}</span>
                        </a>
                    </li>
                    @endif
                    @if(check_page_permission('home_page_manage'))
                    <li class="@if(request()->is('admin-home/home-page-01/*')  ) active @endif
                    {{active_menu('admin-home/header')}}
                    {{active_menu('admin-home/keyfeatures')}}
                            ">
                        <a href="javascript:void(0)"
                           aria-expanded="true">
                            <i class="ti-home"></i>
                            <span>{{__('Home Page Manage')}}</span>
                        </a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/header')}}">
                                <a href="{{route('admin.header')}}">
                                    {{__('Header Area')}}
                                </a>
                            </li>
                            <li class="{{active_menu('admin-home/keyfeatures')}}">
                                <a href="{{route('admin.keyfeatures')}}">{{__('Key Features')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/home-page-01/about-us')}}"><a
                                        href="{{route('admin.homeone.about.us')}}">{{__('About Us Area')}}</a></li>
                            <li class="{{active_menu('admin-home/home-page-01/service-area')}}"><a
                                        href="{{route('admin.homeone.service.area')}}">{{__('Service Area')}}</a></li>
                            <li class="{{active_menu('admin-home/home-page-01/cta-area')}}"><a
                                        href="{{route('admin.homeone.cta.area')}}">{{__('Call To Action Area')}}</a>
                            </li>

                            <li class="{{active_menu('admin-home/home-page-01/recent-work')}}"><a
                                        href="{{route('admin.homeone.recent.work')}}">{{__('Recent Work Area')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/home-page-01/testimonial')}}"><a
                                        href="{{route('admin.homeone.testimonial')}}">{{__('Testimonial Area')}}</a>
                            </li>
                            @if(get_static_option('home_page_variant') == '03')
                                <li class="{{active_menu('admin-home/home-page-01/faq-area')}}"><a
                                            href="{{route('admin.homeone.faq.area')}}">{{__('FAQ Area')}}</a></li>
                            @endif
                            <li class="{{active_menu('admin-home/home-page-01/latest-news')}}"><a
                                        href="{{route('admin.homeone.latest.news')}}">{{__('Latest News Area')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/home-page-01/team-member')}}"><a
                                        href="{{route('admin.homeone.team.member')}}">{{__('Tean Member Area')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/home-page-01/price-plan')}}"><a
                                        href="{{route('admin.homeone.price.plan')}}">{{__('Price Plan Area')}}</a></li>
                            <li class="{{active_menu('admin-home/home-page-01/counterup')}}"><a
                                        href="{{route('admin.homeone.counterup')}}">{{__('Counterup Area')}}</a></li>
                            <li class="{{active_menu('admin-home/home-page-01/newsletter')}}"><a
                                        href="{{route('admin.homeone.newsletter')}}">{{__('Newsletter Area')}}</a></li>
                            <li class="{{active_menu('admin-home/home-page-01/section-manage')}}"><a
                                        href="{{route('admin.homeone.section.manage')}}">{{__('Section Manage')}}</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(check_page_permission('about_page_manage'))
                    <li class="@if(request()->is('admin-home/about-page/*')  ) active @endif ">
                        <a href="javascript:void(0)"
                           aria-expanded="true">
                            <i class="ti-home"></i>
                            <span>{{__('About Page Manage')}}</span>
                        </a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/about-page/about-us')}}"><a
                                        href="{{route('admin.about.page.about')}}">{{__('About Us Section')}}</a></li>
                            <li class="{{active_menu('admin-home/about-page/know-about')}}"><a
                                        href="{{route('admin.about.know')}}">{{__('Know Us Section')}}</a></li>
                            <li class="{{active_menu('admin-home/about-page/section-manage')}}"><a
                                        href="{{route('admin.about.page.section.manage')}}">{{__('Section Manage')}}</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(check_page_permission('contact_page_manage'))
                    <li class="@if(request()->is('admin-home/contact-page/*')  ) active @endif">
                        <a href="javascript:void(0)"
                           aria-expanded="true">
                            <i class="ti-home"></i>
                            <span>{{__('Contact Page Manage')}}</span>
                        </a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/contact-page/contact-info')}}"><a
                                        href="{{route('admin.contact.info')}}">{{__('Contact Info')}}</a></li>
                            <li class="{{active_menu('admin-home/contact-page/form-area')}}"><a
                                        href="{{route('admin.contact.page.form.area')}}">{{__('Form Area')}}</a></li>
                            <li class="{{active_menu('admin-home/contact-page/map')}}"><a
                                        href="{{route('admin.contact.page.map')}}">{{__('Google Map Area')}}</a></li>
                        </ul>
                    </li>
                    @endif
                    @if(check_page_permission('quote_page_manage'))
                    <li class="{{active_menu('admin-home/quote-page')}}">
                        <a href="{{route('admin.quote.page')}}"
                           aria-expanded="true">
                            <i class="ti-dashboard"></i>
                            <span>{{__('Quote Page Manage')}}</span>
                        </a>
                    </li>
                    @endif
                    @if(check_page_permission('order_page_manage'))
                    <li class="{{active_menu('admin-home/order-page')}}">
                        <a href="{{route('admin.order.page')}}"
                           aria-expanded="true">
                            <i class="ti-dashboard"></i>
                            <span>{{__('Order Page Manage')}}</span>
                        </a>
                    </li>
                    @endif
                    @if(check_page_permission('price_plan_page_manage'))
                    <li class="{{active_menu('admin-home/price-plan-page/settings')}}">
                        <a href="{{route('admin.price.plan.page.settings')}}"
                           aria-expanded="true">
                            <i class="ti-dashboard"></i>
                            <span>{{__('Price Plan Page Manage')}}</span>
                        </a>
                    </li>
                    @endif
                    @if(check_page_permission('work_single_page_manage'))
                    <li class="{{active_menu('admin-home/work-single-page/settings')}}">
                        <a href="{{route('admin.work.single.page.settings')}}"
                           aria-expanded="true">
                            <i class="ti-dashboard"></i>
                            <span>{{__('Work Single Page Manage')}}</span>
                        </a>
                    </li>
                    @endif
                    @if(check_page_permission('top_bar_settings'))
                    <li class="{{active_menu('admin-home/topbar')}}">
                        <a href="{{route('admin.topbar')}}"
                           aria-expanded="true">
                            <i class="ti-dashboard"></i>
                            <span>{{__('Top Bar Settings')}}</span>
                        </a>
                    </li>
                    @endif
                    @if(check_page_permission('services'))
                    <li class="
                    @if(request()->is('admin-home/services/*')) active @endif
                    {{active_menu('admin-home/services')}}
                            ">
                        <a href="javascript:void(0)"
                           aria-expanded="true">
                            <i class="ti-layout"></i>
                            <span>{{__('Services')}}</span>
                        </a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/services')}}"><a
                                        href="{{route('admin.services')}}">{{__('New/All Services')}}</a></li>
                            <li class="{{active_menu('admin-home/services/category')}}"><a
                                        href="{{route('admin.service.category')}}">{{__('Category')}}</a></li>
                        </ul>
                    </li>
                    @endif
                    @if(check_page_permission('works'))
                    <li class="
                    @if(request()->is('admin-home/works/*')) active @endif
                    {{active_menu('admin-home/works')}}
                            ">
                        <a href="javascript:void(0)"
                           aria-expanded="true">
                            <i class="ti-layout"></i>
                            <span>{{__('Works')}}</span>
                        </a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/works')}}"><a
                                        href="{{route('admin.work')}}">{{__('New/All Works')}}</a></li>
                            <li class="{{active_menu('admin-home/works/category')}}"><a
                                        href="{{route('admin.work.category')}}">{{__('Category')}}</a></li>
                        </ul>
                    </li>
                    @endif

                    @if(check_page_permission('faq'))
                    <li class="{{active_menu('admin-home/faq')}}">
                        <a href="{{route('admin.faq')}}" aria-expanded="true"><i class="ti-control-forward"></i>
                            <span>{{__('Faq')}}</span></a>
                    </li>
                    @endif
                    @if(check_page_permission('brand_logos'))
                    <li class="{{active_menu('admin-home/brands')}}">
                        <a href="{{route('admin.brands')}}" aria-expanded="true"><i class="ti-control-forward"></i>
                            <span>{{__('Brand Logos')}}</span></a>
                    </li>
                    @endif
                    @if(check_page_permission('price_plan'))
                    <li class="{{active_menu('admin-home/price-plan')}}">
                        <a href="{{route('admin.price.plan')}}" aria-expanded="true"><i class="ti-control-forward"></i>
                            <span>{{__('Price Plan')}}</span></a>
                    </li>
                    @endif
                    @if(check_page_permission('team_members'))
                    <li class="{{active_menu('admin-home/team-member')}}">
                        <a href="{{route('admin.team.member')}}" aria-expanded="true"><i class="ti-control-forward"></i>
                            <span>{{__('Team Members')}}</span></a>
                    </li>
                    @endif
                    @if(check_page_permission('testimonial'))
                    <li class="{{active_menu('admin-home/testimonial')}}">
                        <a href="{{route('admin.testimonial')}}" aria-expanded="true"><i class="ti-control-forward"></i>
                            <span>{{__('Testimonial')}}</span></a>
                    </li>
                    @endif
                    @if(check_page_permission('blog_settings'))
                    <li class="{{active_menu('admin-home/blog-page')}}
                    {{active_menu('admin-home/blog-single-page')}}
                            ">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                            <span>{{__('Blog Settings')}}</span></a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/blog-page')}}"><a
                                        href="{{route('admin.blog')}}">{{__('Blog page')}}</a></li>
                            <li class="{{active_menu('admin-home/blog-single-page')}}"><a
                                        href="{{route('admin.blog.single.page')}}">{{__('Blog Single Page')}}</a></li>
                        </ul>
                    </li>
                    @endif
                    @if(check_page_permission('counterup'))
                    <li class="{{active_menu('admin-home/counterup')}}">
                        <a href="{{route('admin.counterup')}}" aria-expanded="true"><i class="ti-exchange-vertical"></i>
                            <span>{{__('Counterup')}}</span></a>
                    </li>
                    @endif

                    @if(!empty(get_static_option('site_maintenance_mode')))
                        <li class="{{active_menu('admin-home/maintains-page/settings')}}">
                            <a href="{{route('admin.maintains.page.settings')}}"
                               aria-expanded="true">
                                <i class="ti-dashboard"></i>
                                <span>{{__('Maintain Page Manage')}}</span>
                            </a>
                        </li>
                    @endif

                    @if(check_page_permission('footer_area'))
                    <li class="@if(request()->is('admin-home/footer/*')) active @endif">
                        <a href="javascript:void(0)"
                           aria-expanded="true">
                            <i class="ti-layout"></i>
                            <span>{{__('Footer Area')}}</span>
                        </a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/footer/about')}}"><a
                                        href="{{route('admin.footer.about')}}">{{__('About Widget')}}</a></li>
                            <li class="{{active_menu('admin-home/footer/useful-links')}}"><a
                                        href="{{route('admin.footer.useful.link')}}">{{__('Useful Links Widget')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/footer/recent-post')}}"><a
                                        href="{{route('admin.footer.recent.post')}}">{{__('Recent Posts Widget')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/footer/important-links')}}"><a
                                        href="{{route('admin.footer.important.link')}}">{{__('Important Links Widget')}}</a>
                            </li>
                        </ul>
                    </li>
                    @endif


                    @if(check_page_permission('general_settings'))
                    <li class="@if(request()->is('admin-home/general-settings/*')) active @endif">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i>
                            <span>{{__('General Settings')}}</span></a>
                        <ul class="collapse ">
                            <li class="{{active_menu('admin-home/general-settings/site-identity')}}"><a
                                        href="{{route('admin.general.site.identity')}}">{{__('Site Identity')}}</a></li>
                            <li class="{{active_menu('admin-home/general-settings/basic-settings')}}"><a
                                        href="{{route('admin.general.basic.settings')}}">{{__('Basic Settings')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/general-settings/typography-settings')}}"><a
                                        href="{{route('admin.general.typography.settings')}}">{{__('Typography Settings')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/general-settings/seo-settings')}}"><a
                                        href="{{route('admin.general.seo.settings')}}">{{__('SEO Settings')}}</a></li>
                            <li class="{{active_menu('admin-home/general-settings/scripts')}}"><a
                                        href="{{route('admin.general.scripts.settings')}}">{{__('Third Party Scripts')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/general-settings/email-template')}}"><a
                                        href="{{route('admin.general.email.template')}}">{{__('Email Template')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/general-settings/email-settings')}}"><a
                                        href="{{route('admin.general.email.settings')}}">{{__('Email Settings')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/general-settings/smtp-settings')}}"><a
                                        href="{{route('admin.general.smtp.settings')}}">{{__('SMTP Settings')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/general-settings/regenerate-image')}}"><a
                                        href="{{route('admin.general.regenerate.thumbnail')}}">{{__('Regenerate Media Image')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/general-settings/page-settings')}}"><a
                                        href="{{route('admin.general.page.settings')}}">{{__('Page Settings')}}</a></li>
                            @if(!empty(get_static_option('site_payment_gateway')))
                            <li class="{{active_menu('admin-home/general-settings/payment-settings')}}"><a
                                        href="{{route('admin.general.payment.settings')}}">{{__('Payment Gateway Settings')}}</a></li>
                            @endif
                            <li class="{{active_menu('admin-home/general-settings/custom-css')}}"><a
                                        href="{{route('admin.general.custom.css')}}">{{__('Custom CSS')}}</a></li>
                            <li class="{{active_menu('admin-home/general-settings/custom-js')}}"><a
                                        href="{{route('admin.general.custom.js')}}">{{__('Custom JS')}}</a></li>

                            <li class="{{active_menu('admin-home/general-settings/cache-settings')}}"><a
                                        href="{{route('admin.general.cache.settings')}}">{{__('Cache Settings')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/general-settings/gdpr-settings')}}"><a
                                        href="{{route('admin.general.gdpr.settings')}}">{{__('GDPR Compliant Cookies Settings')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/general-settings/backup-settings')}}"><a
                                        href="{{route('admin.general.backup.settings')}}">{{__('Backup Settings')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/general-settings/license-setting')}}"><a
                                        href="{{route('admin.general.license.settings')}}">{{__('Licence Settings')}}</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(check_page_permission('languages'))
                    <li
                            class="@if(request()->is('admin-home/languages/*') || request()->is('admin-home/languages') ) active @endif">
                        <a href="{{route('admin.languages')}}" aria-expanded="true"><i class="ti-signal"></i>
                            <span>{{__('Languages')}}</span></a>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>

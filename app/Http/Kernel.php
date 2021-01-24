<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\SetLang::class,
            \App\Http\Middleware\GlobalVariableMiddleware::class
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'capability' => \App\Http\Middleware\UserRoleCheck::class,
        'setlang' => \App\Http\Middleware\SetLang::class,
        'demo' => \App\Http\Middleware\Demo::class,
        'globalVariable' => \App\Http\Middleware\GlobalVariableMiddleware::class,
        'about_page_manage_check' => \App\Http\Middleware\AboutPageManage::class,
        'admin_role_manage' => \App\Http\Middleware\AdminRoleManage::class,
        'blogs' => \App\Http\Middleware\Blogs::class,
        'blog_settings' => \App\Http\Middleware\BlogSettings::class,
        'brand_logos' => \App\Http\Middleware\BrandLogos::class,
        'counterup' => \App\Http\Middleware\Counterup::class,
        'contact_page_manage' => \App\Http\Middleware\ContactPageManage::class,
        'faq' => \App\Http\Middleware\Faq::class,
        'footer_area' => \App\Http\Middleware\FooterArea::class,
        'form_builder' => \App\Http\Middleware\FormBuilder::class,
        'general_settings' => \App\Http\Middleware\GeneralSettings::class,
        'home_page_manage' => \App\Http\Middleware\HomePageManage::class,
        'home_variant' => \App\Http\Middleware\HomeVariant::class,
        'languages' => \App\Http\Middleware\Languages::class,
        'menus_manage' => \App\Http\Middleware\MenuManage::class,
        'nabvar_settings' => \App\Http\Middleware\NavbarSettings::class,
        'newsletter_manage' => \App\Http\Middleware\NewsletterManage::class,
        'order_page_manage' => \App\Http\Middleware\OrderPageManage::class,
        'pages' => \App\Http\Middleware\Pages::class,
        'price_plan' => \App\Http\Middleware\PricePlan::class,
        'price_plan_page_manage' => \App\Http\Middleware\PricePlanPageManage::class,
        'quote_page_manage' => \App\Http\Middleware\QuotePagemanage::class,
        'services' => \App\Http\Middleware\Services::class,
        'team_members' => \App\Http\Middleware\TeamMembers::class,
        'testimonial' => \App\Http\Middleware\Testimonial::class,
        'top_bar_settings' => \App\Http\Middleware\TopBarSettings::class,
        'works' => \App\Http\Middleware\Works::class,
        'work_single_page_manage' => \App\Http\Middleware\WorkSinglePageManage::class,
        'quote_manage' => \App\Http\Middleware\QuoteManage::class,
        'order_manage' => \App\Http\Middleware\OrderManage::class,
        'all_payment_logs' => \App\Http\Middleware\PaymentLogs::class,
        'job_post_manage' => \App\Http\Middleware\JobPostManage::class,
        'events_manage' => \App\Http\Middleware\EventsManage::class,
        'knowledgebase' => \App\Http\Middleware\Knowledgebase::class,
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Routing\Middleware\ThrottleRequests::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}

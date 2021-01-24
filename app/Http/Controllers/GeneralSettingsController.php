<?php

namespace App\Http\Controllers;

use App\Language;
use App\MediaUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Symfony\Component\Process\Process;

class GeneralSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function smtp_settings(){
        return view('backend.general-settings.smtp-settings');
    }

    public function update_smtp_settings(Request $request){
        $this->validate($request,[
            'site_smtp_mail_host' => 'required|string',
            'site_smtp_mail_port' => 'required|string',
            'site_smtp_mail_username' => 'required|string',
            'site_smtp_mail_password' => 'required|string',
            'site_smtp_mail_encryption' => 'required|string'
        ]);

        set_static_option('site_smtp_mail_host',$request->site_smtp_mail_host);
        set_static_option('site_smtp_mail_port',$request->site_smtp_mail_port);
        set_static_option('site_smtp_mail_username',$request->site_smtp_mail_username);
        set_static_option('site_smtp_mail_password',$request->site_smtp_mail_password);
        set_static_option('site_smtp_mail_encryption',$request->site_smtp_mail_encryption);

        setEnvValue([
            'MAIL_HOST' => $request->site_smtp_mail_host,
            'MAIL_PORT' => $request->site_smtp_mail_port,
            'MAIL_USERNAME' => $request->site_smtp_mail_username,
            'MAIL_PASSWORD' => $request->site_smtp_mail_password,
            'MAIL_ENCRYPTION' => $request->site_smtp_mail_encryption
        ]);

        return redirect()->back()->with(['msg' => 'SMTP Settings Updated...','type' => 'success']);
    }

    public function regenerate_image_settings(){
        return view('backend.general-settings.regenerate-image');
    }

    public function update_regenerate_image_settings (Request $request){
        $all_media_file = MediaUpload::all();
        foreach ($all_media_file as $img){

            if (!file_exists('assets/uploads/media-uploader/'.$img->path)){
                continue;
            }
            $image = 'assets/uploads/media-uploader/'. $img->path;
            $image_dimension = getimagesize($image);;
            $image_width = $image_dimension[0];
            $image_height = $image_dimension[1];

            $image_db = $img->path;
            $image_grid = 'grid-'.$image_db ;
            $image_large = 'large-'. $image_db;
            $image_thumb = 'thumb-'. $image_db;

            $folder_path = 'assets/uploads/media-uploader/';
            $resize_grid_image = Image::make($image)->resize(350, null,function ($constraint) {
                $constraint->aspectRatio();
            });
            $resize_large_image = Image::make($image)->resize(740, null,function ($constraint) {
                $constraint->aspectRatio();
            });
            $resize_thumb_image = Image::make($image)->resize(150, 150);

            if ($image_width > 150){
                $resize_thumb_image->save($folder_path . $image_thumb);
                $resize_grid_image->save($folder_path . $image_grid);
                $resize_large_image->save($folder_path . $image_large);
            }

        }

        return redirect()->back()->with(['msg' => 'Image Regenerate Success...','type' => 'success']);
    }

    public function custom_js_settings(){
        $custom_js = '/* Write Custom js Here */';
        if (file_exists('assets/frontend/js/dynamic-script.js')) {
            $custom_js = file_get_contents('assets/frontend/js/dynamic-script.js');
        }
        return view('backend.general-settings.custom-js')->with(['custom_js' => $custom_js]);
    }

    public function update_custom_js_settings(Request $request)
    {
        file_put_contents('assets/frontend/js/dynamic-script.js', $request->custom_js_area);

        return redirect()->back()->with(['msg' => 'Custom Script Added Success...', 'type' => 'success']);
    }
    public function gdpr_settings()
    {
        $all_languages = Language::all();
        return view('backend.general-settings.gdpr')->with(['all_languages' => $all_languages]);
    }

    public function update_gdpr_cookie_settings(Request $request)
    {

        $this->validate($request, [
            'site_gdpr_cookie_enabled' => 'nullable|string|max:191',
            'site_gdpr_cookie_expire' => 'required|string|max:191',
            'site_gdpr_cookie_delay' => 'required|string|max:191',
        ]);

        $all_language = Language::all();
        foreach ($all_language as $lang) {
            $this->validate($request, [
                "site_gdpr_cookie_" . $lang->slug . "_title" => 'nullable|string',
                "site_gdpr_cookie_" . $lang->slug . "_message" => 'nullable|string',
                "site_gdpr_cookie_" . $lang->slug . "_more_info_label" => 'nullable|string',
                "site_gdpr_cookie_" . $lang->slug . "_more_info_link" => 'nullable|string',
                "site_gdpr_cookie_" . $lang->slug . "_accept_button_label" => 'nullable|string',
            ]);
            $_title = "site_gdpr_cookie_" . $lang->slug . "_title";
            $_message = "site_gdpr_cookie_" . $lang->slug . "_message";
            $_more_info_label = "site_gdpr_cookie_" . $lang->slug . "_more_info_label";
            $_more_info_link = "site_gdpr_cookie_" . $lang->slug . "_more_info_link";
            $_accept_button_label = "site_gdpr_cookie_" . $lang->slug . "_accept_button_label";

            update_static_option($_title,$request->$_title);
            update_static_option($_message,$request->$_message);
            update_static_option($_more_info_label,$request->$_more_info_label);
            update_static_option($_more_info_link,$request->$_more_info_link);
            update_static_option($_accept_button_label,$request->$_accept_button_label);
        }

        update_static_option('site_gdpr_cookie_delay', $request->site_gdpr_cookie_delay);
        update_static_option('site_gdpr_cookie_enabled', $request->site_gdpr_cookie_enabled);
        update_static_option('site_gdpr_cookie_expire', $request->site_gdpr_cookie_expire);

        return redirect()->back()->with(['msg' => 'GDPR Cookie Settings Updated..', 'type' => 'success']);
    }
    public function cache_settings()
    {
        return view('backend.general-settings.cache-settings');
    }

    public function update_cache_settings(Request $request)
    {

        $this->validate($request, [
            'cache_type' => 'required|string'
        ]);

        Artisan::call($request->cache_type . ':clear');

        return redirect()->back()->with(['msg' => 'Cache Cleaned...', 'type' => 'success']);
    }

    public function backup_settings()
    {
        $all_backuped_db = glob('backup/*');
        return view('backend.general-settings.backup')->with(['all_backuped_db' => $all_backuped_db]);
    }

    public function update_backup_settings(Request $request)
    {

        $process = new Process(sprintf(
            'mysqldump -u%s -p%s %s > %s',
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.database'),
            'backup/' . config('database.connections.mysql.database') . '_' . date('j_F_Y_h:m:s') . '.sql'
        ));
        $process->mustRun();
        return redirect()->back()->with(['msg' => 'Database Backup Completed...', 'type' => 'success']);
    }

    public function delete_backup_settings(Request $request)
    {

        if (file_exists($request->db_name)) {
            unlink($request->db_name);
        }

        return redirect()->back()->with(['msg' => 'Database Deleted...', 'type' => 'danger']);
    }

    public function restore_backup_settings(Request $request)
    {
        $process = new Process(sprintf(
            'mysql -u%s -p%s %s < %s',
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.database'),
            'backup/' . $request->db_name
        ));
        $process->mustRun();
        return redirect()->back()->with(['msg' => 'Database Restore Completed...', 'type' => 'success']);
    }

    public function license_settings()
    {
        return view('backend.general-settings.license-settings');
    }

    public function update_license_settings(Request $request)
    {
        $this->validate($request, [
            'item_purchase_key' => 'required|string|max:191'
        ]);
        update_static_option('item_purchase_key', $request->item_purchase_key);

        $data = array(
            'action' => env('XGENIOUS_API_ACTION'),
            'purchase_code' => get_static_option('item_purchase_key'),
            'author' => env('XGENIOUS_API_AUTHOR'),
            'site_url' => url('/'),
            'item_unique_key' => env('XGENIOUS_API_KEY'),
        );
        //item_license_status
        $api_url = env('XGENIOUS_API_URL') . '?' . http_build_query($data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api_url);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result);
        update_static_option('item_license_status', $result->license_status);
        $type = 'verified' == $result->license_status ? 'success' : 'danger';
        $license_info = [
            "item_license_status" => $result->license_status,
            "last_check" => time(),
            "purchase_code" => get_static_option('item_purchase_key'),
            "xgenious_app_key" => env('XGENIOUS_API_KEY'),
            "author" => env('XGENIOUS_API_AUTHOR'),
            "message" => $result->message
        ];
        file_put_contents('@core/license.json', json_encode($license_info));

        return redirect()->back()->with(['msg' => $result->message, 'type' => $type]);
    }

    public function custom_css_settings()
    {
        $custom_css = '/* Write Custom Css Here */';
        if (file_exists('assets/frontend/css/dynamic-style.css')) {
            $custom_css = file_get_contents('assets/frontend/css/dynamic-style.css');
        }
        return view('backend.general-settings.custom-css')->with(['custom_css' => $custom_css]);
    }

    public function update_custom_css_settings(Request $request)
    {
        file_put_contents('assets/frontend/css/dynamic-style.css', $request->custom_css_area);

        return redirect()->back()->with(['msg' => 'Custom Style Added Success...', 'type' => 'success']);
    }

    public function typography_settings()
    {
        $all_google_fonts = file_get_contents('assets/frontend/webfonts/google-fonts.json');
        return view('backend.general-settings.typograhpy')->with(['google_fonts' => json_decode($all_google_fonts)]);
    }

    public function get_single_font_variant(Request $request){
        $all_google_fonts = file_get_contents('assets/frontend/webfonts/google-fonts.json');
        $decoded_fonts = json_decode($all_google_fonts,true);
        return response()->json($decoded_fonts[$request->font_family]);
    }

    public function update_typography_settings(Request $request)
    {
        $this->validate($request, [
            'body_font_family' => 'required|string|max:191',
            'body_font_variant' => 'required',
            'heading_font' => 'nullable|string',
            'heading_font_family' => 'nullable|string|max:191',
            'heading_font_variant' => 'nullable',
        ]);

        $save_data = [
            'body_font_family',
            'heading_font_family',
        ];
        foreach ($save_data as $item) {
            if (empty($request->$item)) {
                continue;
            }
            update_static_option($item, $request->$item);
        }
        update_static_option('heading_font', $request->heading_font);
        update_static_option('body_font_variant', serialize($request->body_font_variant));
        update_static_option('heading_font_variant', serialize($request->heading_font_variant));

        return redirect()->back()->with(['msg' => 'Typography Settings Updated..', 'type' => 'success']);
    }

    public function email_settings()
    {
        $all_languages = Language::all();
        return view('backend.general-settings.email-settings')->with(['all_languages' => $all_languages]);
    }

    public function update_email_settings(Request $request)
    {
        $all_languages = Language::all();
        foreach ($all_languages as $lang) {
            $this->validate($request, [
                'order_mail_' . $lang->slug . '_subject' => 'nullable|string',
                'quote_mail_' . $lang->slug . '_subject' => 'nullable|string',
                'contact_mail_' . $lang->slug . '_subject' => 'nullable|string',
                'request_call_back_mail_' . $lang->slug . '_subject' => 'nullable|string'
            ]);

            $order_mail = 'order_mail_' . $lang->slug . '_subject';
            $quote_mail = 'quote_mail_' . $lang->slug . '_subject';
            $contact_mail = 'contact_mail_' . $lang->slug . '_subject';
            $request_call_back_mail = 'request_call_back_mail_' . $lang->slug . '_subject';

            update_static_option($order_mail, $request->$order_mail);
            update_static_option($quote_mail, $request->$quote_mail);
            update_static_option($contact_mail, $request->$contact_mail);
            update_static_option($request_call_back_mail, $request->$request_call_back_mail);
        }
        return redirect()->back()->with(['msg' => 'Email Settings Updated..', 'type' => 'success']);
    }

    public function page_settings()
    {
        $all_languages = Language::all();
        return view('backend.general-settings.page-settings')->with(['all_languages' => $all_languages]);
    }

    public function update_page_settings(Request $request)
    {
        $this->validate($request,[
            'about_page_slug' => 'required|string|max:191',
            'service_page_slug' => 'required|string|max:191',
            'works_page_slug' => 'required|string|max:191',
            'team_page_slug' => 'required|string|max:191',
            'faq_page_slug' => 'required|string|max:191',
            'price_plan_page_slug' => 'required|string|max:191',
            'blog_page_slug' => 'required|string|max:191',
            'contact_page_slug' => 'required|string|max:191',
            'career_with_us_page_slug' => 'required|string|max:191',
            'events_page_slug' => 'required|string|max:191',
            'knowledgebase_page_slug' => 'required|string|max:191',
        ]);

        update_static_option('about_page_slug',Str::slug($request->about_page_slug));
        update_static_option('service_page_slug',Str::slug($request->service_page_slug));
        update_static_option('works_page_slug',Str::slug($request->works_page_slug));
        update_static_option('team_page_slug',Str::slug($request->team_page_slug));
        update_static_option('faq_page_slug',Str::slug($request->faq_page_slug));
        update_static_option('price_plan_page_slug',Str::slug($request->price_plan_page_slug));
        update_static_option('blog_page_slug',Str::slug($request->blog_page_slug));
        update_static_option('contact_page_slug',Str::slug($request->contact_page_slug));
        update_static_option('career_with_us_page_slug',Str::slug($request->career_with_us_page_slug));
        update_static_option('events_page_slug',Str::slug($request->events_page_slug));
        update_static_option('knowledgebase_page_slug',Str::slug($request->knowledgebase_page_slug));

        $all_languages = Language::all();
        foreach ($all_languages as $lang) {
            $this->validate($request, [
                'about_page_' . $lang->slug . '_name' => 'nullable|string',
                'service_page_' . $lang->slug . '_name' => 'nullable|string',
                'work_page_' . $lang->slug . '_name' => 'nullable|string',
                'team_page_' . $lang->slug . '_name' => 'nullable|string',
                'faq_page_' . $lang->slug . '_name' => 'nullable|string',
                'blog_page_' . $lang->slug . '_name' => 'nullable|string',
                'contact_page_' . $lang->slug . '_name' => 'nullable|string',
                'career_with_us_page_' . $lang->slug . '_name' => 'nullable|string',
                'events_page_' . $lang->slug . '_name' => 'nullable|string',
                'knowledgebase_page_' . $lang->slug . '_name' => 'nullable|string',
            ]);

            $about_name = 'about_page_' . $lang->slug . '_name';
            $service_page = 'service_page_' . $lang->slug . '_name';
            $work_page = 'work_page_' . $lang->slug . '_name';
            $team_page = 'team_page_' . $lang->slug . '_name';
            $faq_page = 'faq_page_' . $lang->slug . '_name';
            $price_plan_page = 'price_plan_page_' . $lang->slug . '_name';
            $blog_page = 'blog_page_' . $lang->slug . '_name';
            $contact_page = 'contact_page_' . $lang->slug . '_name';
            $career_with_us_page = 'career_with_us_page_' . $lang->slug . '_name';
            $events_page = 'events_page_' . $lang->slug . '_name';
            $knowledgebase_page = 'knowledgebase_page_' . $lang->slug . '_name';

            update_static_option($about_name, $request->$about_name);
            update_static_option($service_page, $request->$service_page);
            update_static_option($work_page, $request->$work_page);
            update_static_option($team_page, $request->$team_page);
            update_static_option($faq_page, $request->$faq_page);
            update_static_option($price_plan_page, $request->$price_plan_page);
            update_static_option($blog_page, $request->$blog_page);
            update_static_option($contact_page, $request->$contact_page);
            update_static_option($career_with_us_page, $request->$career_with_us_page);
            update_static_option($events_page, $request->$events_page);
            update_static_option($knowledgebase_page, $request->$knowledgebase_page);

        }

        return redirect()->back()->with(['msg' => 'Page Settings Updated..', 'type' => 'success']);
    }
    public function basic_settings()
    {
        $all_languages = Language::all();
        return view('backend.general-settings.basic')->with(['all_languages' => $all_languages]);
    }

    public function update_basic_settings(Request $request)
    {
        $this->validate($request, [
            'site_color' => 'required|string',
            'site_main_color_two' => 'required|string',
            'site_rtl_enabled' => 'nullable|string',
            'site_admin_dark_mode' => 'nullable|string',
            'site_paragraph_color' => 'nullable|string',
            'site_heading_color' => 'nullable|string',
        ]);

        $all_language = Language::all();

        foreach ($all_language as $lang) {
            $this->validate($request, [
                'site_' . $lang->slug . '_title' => 'nullable|string',
                'site_' . $lang->slug . '_tag_line' => 'nullable|string',
                'site_' . $lang->slug . '_footer_copyright' => 'nullable|string',
            ]);
            $_title = 'site_' . $lang->slug . '_title';
            $_tag_line = 'site_' . $lang->slug . '_tag_line';
            $_footer_copyright = 'site_' . $lang->slug . '_footer_copyright';

            update_static_option($_title, $request->$_title);
            update_static_option($_tag_line, $request->$_tag_line);
            update_static_option($_footer_copyright, $request->$_footer_copyright);
        }

        update_static_option('site_color', $request->site_color);
        update_static_option('site_main_color_two', $request->site_main_color_two);
        update_static_option('site_heading_color', $request->site_heading_color);
        update_static_option('site_paragraph_color', $request->site_paragraph_color);
        update_static_option('site_rtl_enabled', $request->site_rtl_enabled);
        update_static_option('site_admin_dark_mode', $request->site_admin_dark_mode);
        update_static_option('site_maintenance_mode', $request->site_maintenance_mode);
        update_static_option('site_payment_gateway', $request->site_payment_gateway);

        return redirect()->back()->with(['msg' => 'Basic Settings Update Success', 'type' => 'success']);
    }

    public function seo_settings()
    {
        return view('backend.general-settings.seo');
    }

    public function update_seo_settings(Request $request)
    {
        $this->validate($request, [
            'site_meta_tags' => 'required|string',
            'site_meta_description' => 'required|string'
        ]);

        update_static_option('site_meta_tags', $request->site_meta_tags);
        update_static_option('site_meta_description', $request->site_meta_description);

        return redirect()->back()->with(['msg' => 'SEO Settings Update Success', 'type' => 'success']);
    }

    public function scripts_settings()
    {
        return view('backend.general-settings.thid-party');
    }

    public function update_scripts_settings(Request $request)
    {

        $this->validate($request, [
            'site_disqus_key' => 'nullable|string',
            'tawk_api_key' => 'nullable|string',
            'site_google_map_api' => 'nullable|string',
            'site_google_analytics' => 'nullable|string',
            'site_google_captcha_v3_secret_key' => 'nullable|string',
            'site_google_captcha_v3_site_key' => 'nullable|string',
        ]);

        update_static_option('site_disqus_key', $request->site_disqus_key);
        update_static_option('site_google_analytics', $request->site_google_analytics);
        update_static_option('tawk_api_key', $request->tawk_api_key);
        update_static_option('site_google_map_api', $request->site_google_map_api);
        update_static_option('site_google_captcha_v3_site_key', $request->site_google_captcha_v3_site_key);
        update_static_option('site_google_captcha_v3_secret_key', $request->site_google_captcha_v3_secret_key);

        return redirect()->back()->with(['msg' => 'Third Party Scripts Settings Updated..', 'type' => 'success']);
    }

    public function email_template_settings()
    {
        return view('backend.general-settings.email-template');
    }

    public function update_email_template_settings(Request $request)
    {

        $this->validate($request, [
            'site_global_email' => 'required|string',
            'site_global_email_template' => 'required|string',
        ]);

        update_static_option('site_global_email', $request->site_global_email);
        update_static_option('site_global_email_template', $request->site_global_email_template);

        return redirect()->back()->with(['msg' => 'Email Settings Updated..', 'type' => 'success']);
    }
    public function site_identity()
    {
        return view('backend.general-settings.site-identity');
    }

    public function update_site_identity(Request $request)
    {
        $this->validate($request, [
            'site_logo' => 'nullable|string|max:191',
            'site_favicon' => 'nullable|string|max:191',
            'site_breadcrumb_bg' => 'nullable|string|max:191',
            'site_white_logo' => 'nullable|string|max:191',
        ]);
        update_static_option('site_logo', $request->site_logo);
        update_static_option('site_favicon', $request->site_favicon);
        update_static_option('site_breadcrumb_bg', $request->site_breadcrumb_bg);
        update_static_option('site_white_logo', $request->site_white_logo);

        return redirect()->back()->with([
            'msg' => 'Site Identity Has Been Updated..',
            'type' => 'success'
        ]);
    }

    public function payment_settings(){
        return view('backend.general-settings.payment-gateway');
    }

    public function update_payment_settings(Request $request){
        $this->validate($request,[
           'paypal_gateway' => 'nullable|string|max:191',
           'paypal_preview_logo' => 'nullable|string|max:191',
           'paypal_business_email' => 'nullable|string|max:191',
           'paytm_gateway' => 'nullable|string|max:191',
           'paytm_preview_logo' => 'nullable|string|max:191',
           'paytm_merchant_key' => 'nullable|string|max:191',
           'paytm_merchant_mid' => 'nullable|string|max:191',
           'paytm_merchant_website' => 'nullable|string|max:191',
           'site_global_currency' => 'nullable|string|max:191',
           'site_usd_to_nri_exchange_rate' => 'nullable|string|max:191',
           'site_manual_payment_name' => 'nullable|string|max:191',
           'manual_payment_preview_logo' => 'nullable|string|max:191',
           'site_manual_payment_description' => 'nullable|string|max:191',
        ]);
        $save_data = [
            'paypal_preview_logo',
            'paypal_business_email',
            'paytm_preview_logo',
            'paytm_merchant_key',
            'paytm_merchant_mid',
            'paytm_merchant_website',
            'site_global_currency',
            'site_usd_to_nri_exchange_rate',
            'manual_payment_preview_logo',
            'site_manual_payment_name',
            'site_manual_payment_description',
        ];
        foreach ($save_data as $item) {
            if (empty($request->$item)) {
                continue;
            }
            update_static_option($item, $request->$item);
        }

        update_static_option('manual_payment_gateway', $request->manual_payment_gateway);
        update_static_option('paypal_gateway', $request->paypal_gateway);
        update_static_option('paytm_gateway', $request->paytm_gateway);


        return redirect()->back()->with([
            'msg' => 'Payment Settings Updated..',
            'type' => 'success'
        ]);
    }
}

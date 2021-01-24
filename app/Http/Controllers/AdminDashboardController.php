<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Language;
use App\MediaUpload;
use App\Services;
use App\Blog;
use App\ContactInfoItem;
use App\Counterup;
use App\KeyFeatures;
use App\PricePlan;
use App\TeamMember;
use App\Testimonial;
use App\Works;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Symfony\Component\Process\Process;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function adminIndex()
    {
        $default_lang = get_default_language();

        $all_blogs = Blog::where('lang', $default_lang)->count();
        $total_admin = Admin::count();
        $total_testimonial = Testimonial::where('lang', $default_lang)->count();
        $total_team_member = TeamMember::where('lang', $default_lang)->count();
        $total_counterup = Counterup::where('lang', $default_lang)->count();
        $total_price_plan = PricePlan::where('lang', $default_lang)->count();
        $total_services = Services::where('lang', $default_lang)->count();
        $total_key_features = KeyFeatures::where('lang', $default_lang)->count();
        $total_works = Works::where('lang', $default_lang)->count();

        return view('backend.admin-home')->with([
            'blog_count' => $all_blogs,
            'total_admin' => $total_admin,
            'total_testimonial' => $total_testimonial,
            'total_team_member' => $total_team_member,
            'total_counterup' => $total_counterup,
            'total_price_plan' => $total_price_plan,
            'total_works' => $total_works,
            'total_services' => $total_services,
            'total_key_features' => $total_key_features,
        ]);
    }


    public function admin_settings()
    {
        return view('auth.admin.settings');
    }

    public function admin_profile_update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'username' => 'required|string|max:191',
            'image' => 'nullable|string|max:191'
        ]);
        Admin::find(Auth::user()->id)->update(['name' => $request->name, 'email' => $request->email,'username' => str_replace(' ','_',$request->username), 'image' => $request->image]);

        return redirect()->back()->with(['msg' => 'Profile Update Success', 'type' => 'success']);
    }

    public function admin_password_chagne(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = Admin::findOrFail(Auth::id());

        if (Hash::check($request->old_password, $user->password)) {

            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();

            return redirect()->route('admin.login')->with(['msg' => 'Password Changed Successfully', 'type' => 'success']);
        }

        return redirect()->back()->with(['msg' => 'Somethings Going Wrong! Please Try Again or Check Your Old Password', 'type' => 'danger']);
    }

    public function adminLogout()
    {
        Auth::logout();
        return redirect()->route('admin.login')->with(['msg' => 'You Logged Out !!', 'type' => 'danger']);
    }

    public function admin_profile()
    {
        return view('auth.admin.edit-profile');
    }

    public function admin_password()
    {
        return view('auth.admin.change-password');
    }

    public function contact()
    {
        $all_contact_info_items = ContactInfoItem::all();
        return view('backend.pages.contact')->with([
            'all_contact_info_item' => $all_contact_info_items
        ]);
    }

    public function update_contact(Request $request)
    {
        $this->validate($request, [
            'page_title' => 'required|string|max:191',
            'get_title' => 'required|string|max:191',
            'get_description' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        update_static_option('contact_page_title', $request->page_title);
        update_static_option('contact_page_get_title', $request->get_title);
        update_static_option('contact_page_get_description', $request->get_description);
        update_static_option('contact_page_latitude', $request->latitude);
        update_static_option('contact_page_longitude', $request->longitude);

        return redirect()->back()->with(['msg' => 'Contact Page Info Update Success', 'type' => 'success']);
    }


    public function blog_page()
    {
        $all_languages = Language::all();
        return view('backend.pages.blog')->with(['all_languages' => $all_languages]);
    }

    public function blog_page_update(Request $request)
    {
        $all_language = Language::all();
        foreach ($all_language as $lang) {
            $this->validate($request, [
                'blog_page_' . $lang->slug . '_title' => 'nullable',
                'blog_page_' . $lang->slug . '_item' => 'nullable',
                'blog_page_' . $lang->slug . '_category_widget_title' => 'nullable',
                'blog_page_' . $lang->slug . '_recent_post_widget_title' => 'nullable',
                'blog_page_' . $lang->slug . '_recent_post_widget_item' => 'nullable',
            ]);
            $blog_page_title = 'blog_page_' . $lang->slug . '_title';
            $blog_page_item = 'blog_page_' . $lang->slug . '_item';
            $blog_page_category_widget_title = 'blog_page_' . $lang->slug . '_category_widget_title';
            $blog_page_recent_post_widget_title = 'blog_page_' . $lang->slug . '_recent_post_widget_title';
            $blog_page_recent_post_widget_item = 'blog_page_' . $lang->slug . '_recent_post_widget_item';

            update_static_option('blog_page_' . $lang->slug . '_title', $request->$blog_page_title);
            update_static_option('blog_page_' . $lang->slug . '_item', $request->$blog_page_item);
            update_static_option('blog_page_' . $lang->slug . '_category_widget_title', $request->$blog_page_category_widget_title);
            update_static_option('blog_page_' . $lang->slug . '_recent_post_widget_title', $request->$blog_page_recent_post_widget_title);
            update_static_option('blog_page_' . $lang->slug . '_recent_post_widget_item', $request->$blog_page_recent_post_widget_item);
        }


        return redirect()->back()->with(['msg' => 'Blog Settings Update Success', 'type' => 'success']);
    }


    public function home_variant()
    {
        return view('backend.pages.home.home-variant');
    }

    public function update_home_variant(Request $request)
    {
        $this->validate($request, [
            'home_page_variant' => 'required|string'
        ]);
        update_static_option('home_page_variant', $request->home_page_variant);
        return redirect()->back()->with(['msg' => 'Home Variant Settings Updated..', 'type' => 'success']);
    }

    public function navbar_settings()
    {
        return view('backend.pages.navbar-settings');
    }

    public function update_navbar_settings(Request $request)
    {

        $this->validate($request, [
            'navbar_button' => 'nullable|string',
            'navbar_button_custom_url' => 'nullable|string',
            'navbar_button_custom_url_status' => 'nullable|string',
        ]);

        update_static_option('navbar_button', $request->navbar_button);
        update_static_option('navbar_button_custom_url', $request->navbar_button_custom_url);
        update_static_option('navbar_button_custom_url_status', $request->navbar_button_custom_url_status);
        update_static_option('site_header_type', $request->site_header_type);

        $all_lang = Language::all();
        foreach ($all_lang as $lang) {
            $filed_name = 'navbar_' . $lang->slug . '_button_text';
            update_static_option('navbar_' . $lang->slug . '_button_text', $request->$filed_name);
        }



        return redirect()->back()->with(['msg' => 'Navbar Settings Updated..', 'type' => 'success']);
    }


    public function blog_single_page(){
        $all_languages = Language::all();
        return view('backend.pages.blog-single')->with(['all_languages' => $all_languages]);
    }

    public function blog_single_page_update(Request $request){
        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $this->validate($request,[
                "blog_single_page_".$lang->slug."_related_post_title" => 'nullable|string'
            ]);
            $_related_post_title = "blog_single_page_".$lang->slug."_related_post_title";

            update_static_option($_related_post_title,$request->$_related_post_title);
        }

        return redirect()->back()->with(['msg' => 'Blog Single Page Setting Updated...','type' => 'success']);
    }

}



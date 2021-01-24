<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogCategory;
use App\ContactInfoItem;
use App\Counterup;
use App\Faq;
use App\HeaderSlider;
use App\KeyFeatures;
use App\KnowAbout;
use App\Language;
use App\Menu;
use App\Page;
use App\PricePlan;
use App\ServiceCategory;
use App\Services;
use App\SupportInfo;
use App\TeamMember;
use App\Testimonial;
use App\Works;
use App\WorksCategory;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index(){
        $all_lang = Language::all();
        return view('backend.languages.index')->with([
            'all_lang' => $all_lang
        ]);
    }
    public function store(Request $request){
        $this->validate($request,[
            'name' =>  'required|string:max:191',
            'direction' =>  'required|string:max:191',
            'slug' => 'required|string:max:191',
            'status' => 'required|string:max:191',
        ]);
        Language::create([
           'name' => $request->name,
           'direction' => $request->direction,
           'slug' => $request->slug,
           'status' => $request->status,
           'default' => 0
        ]);
        $default_lang_data = file_get_contents(resource_path('lang').'/default.json');
        file_put_contents(resource_path('lang/').$request->slug.'.json',$default_lang_data);
        return redirect()->back()->with([
            'msg' => 'New Language Added Success...',
            'type' => 'success'
        ]);
    }
    public function edit_words($id){
        $all_word = file_get_contents(resource_path('lang/').$id.'.json');
        return view('backend.languages.edit-words')->with([
            'all_word' => json_decode($all_word),
            'lang_slug' => $id
        ]);
    }
    public function update_words(Request $request,$id){
        $lang = Language::where('slug',$id)->first();
        $content = json_encode($request->word);
        if ($content === 'null') {
            return back()->with(['msg' => 'Please fill one minimum one field','type' => 'danger']);
        }
        file_put_contents(resource_path('lang/') . $lang->slug . '.json', $content);
        return back()->with(['msg' => 'Words Change Success','type' => 'success']);
    }
    public function update(Request $request){
        $this->validate($request,[
            'name' =>  'required|string:max:191',
            'direction' =>  'required|string:max:191',
            'status' =>  'required|string:max:191',
            'slug' => 'required|string:max:191'
        ]);
        Language::where('id',$request->id)->update([
            'name' => $request->name,
            'direction' => $request->direction,
            'status' => $request->status,
            'slug' => $request->slug
        ]);
        $default_lang_data = file_get_contents(resource_path('lang').'/'.$request->slug.'.json');
        file_put_contents(resource_path('lang/').$request->slug.'.json',$default_lang_data);
        return redirect()->back()->with([
            'msg' => 'Language Update Success...',
            'type' => 'success'
        ]);
    }
    public function delete(Request $request, $id){
        $lang = Language::find($id);

        $static_options = array(
            'navbar_'.$lang->slug.'_button_text',
            'home_page_01_'.$lang->slug.'_about_us_title',
            'home_page_01_'.$lang->slug.'_about_us_description',
            'home_page_01_'.$lang->slug.'_about_us_button_status',
            'home_page_01_'.$lang->slug.'_about_us_button_title',
            'home_page_01_'.$lang->slug.'_about_us_button_url',
            'home_page_01_'.$lang->slug.'_about_us_signature_text',
            'home_page_01_'.$lang->slug.'_service_area_title',
            'home_page_01_'.$lang->slug.'_service_area_description',
            'home_page_01_'.$lang->slug.'_cta_area_button_url',
            'home_page_01_'.$lang->slug.'_cta_area_button_title',
            'home_page_01_'.$lang->slug.'_cta_area_title',
            'home_page_01_'.$lang->slug.'_cta_area_description',
            'home_page_01_'.$lang->slug.'_cta_area_button_status',
            'home_page_01_'.$lang->slug.'_recent_work_title',
            'home_page_01_'.$lang->slug.'_recent_work_description',
            'home_page_01_'.$lang->slug.'_latest_news_title',
            'home_page_01_'.$lang->slug.'_latest_news_description',
            'home_page_01_'.$lang->slug.'_team_member_section_title',
            'home_page_01_'.$lang->slug.'_team_member_section_description',
            'home_page_01_'.$lang->slug.'_price_plan_section_title',
            'home_page_01_'.$lang->slug.'_price_plan_section_description',
            'home_page_01_'.$lang->slug.'_newsletter_area_title',
            'home_page_01_'.$lang->slug.'_newsletter_area_description',
            'about_page_'.$lang->slug.'_about_section_title',
            'about_page_'.$lang->slug.'_about_section_description',
            'contact_page_'.$lang->slug.'_form_section_title',
            'contact_page_'.$lang->slug.'_form_section_description',
            'quote_page_'.$lang->slug.'_page_title',
            'quote_page_'.$lang->slug.'_form_title',
            'order_page_'.$lang->slug.'_form_title',
            'top_bar_'.$lang->slug.'_right_menu',
            'top_bar_'.$lang->slug.'_button_text',
            'blog_page_'.$lang->slug.'_title',
            'blog_page_'.$lang->slug.'_item',
            'blog_page_'.$lang->slug.'_category_widget_title',
            'blog_page_'.$lang->slug.'_recent_post_widget_title',
            'blog_page_'.$lang->slug.'_recent_post_widget_item',
            'about_widget_'.$lang->slug.'_description',
            'useful_link_'.$lang->slug.'_widget_title',
            'useful_link_'.$lang->slug.'_widget_menu_id',
            'recent_post_'.$lang->slug.'_widget_title',
            'important_link_'.$lang->slug.'_widget_title',
            'important_link_'.$lang->slug.'_widget_menu_id',
            'site_'.$lang->slug.'_title',
            'site_'.$lang->slug.'_tag_line',
            'site_'.$lang->slug.'_footer_copyright'
        );
        foreach ($static_options as $option_name){
            delete_static_option($option_name);
        }

        HeaderSlider::where('lang',$lang->slug)->delete();
        KeyFeatures::where('lang',$lang->slug)->delete();
        KnowAbout::where('lang',$lang->slug)->delete();
        ContactInfoItem::where('lang',$lang->slug)->delete();
        SupportInfo::where('lang',$lang->slug)->delete();
        ServiceCategory::where('lang',$lang->slug)->delete();
        Services::where('lang',$lang->slug)->delete();
        WorksCategory::where('lang',$lang->slug)->delete();
        Works::where('lang',$lang->slug)->delete();
        Faq::where('lang',$lang->slug)->delete();
        PricePlan::where('lang',$lang->slug)->delete();
        TeamMember::where('lang',$lang->slug)->delete();
        Testimonial::where('lang',$lang->slug)->delete();
        Counterup::where('lang',$lang->slug)->delete();
        BlogCategory::where('lang',$lang->slug)->delete();
        Blog::where('lang',$lang->slug)->delete();
        Menu::where('lang',$lang->slug)->delete();
        Page::where('lang',$lang->slug)->delete();

        $lang->delete();

        return redirect()->back()->with([
            'msg' => 'Language Delete Success...',
            'type' => 'danger'
        ]);

    }
    public function make_default(Request $request, $id){
        Language::where('default' ,1)->update(['default' => 0]);
        Language::find($id)->update(['default' => 1]);
        $lang = Language::find($id);
        $lang->default = 1;
        $lang->save();
        session()->put('lang',$lang->slug);
        return redirect()->back()->with([
            'msg' => 'Default Language Set To '.$lang->name,
            'type' => 'success'
        ]);
    }
}

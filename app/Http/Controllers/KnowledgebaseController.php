<?php

namespace App\Http\Controllers;

use App\Knowledgebase;
use App\KnowledgebaseTopic;
use App\Language;
use Illuminate\Http\Request;

class KnowledgebaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function all_knowledgebases(){
        $all_articles = Knowledgebase::all()->groupBy('lang');
        return view('backend.knowledgebase.all-knowledgebase')->with(['all_article' => $all_articles]);
    }

    public function new_knowledgebase(){
        $all_languages = Language::all();
        $all_topics = KnowledgebaseTopic::where(['status' =>'publish','lang' => get_default_language()])->get();

        return view('backend.knowledgebase.new-knowledgebase')->with(['all_languages' => $all_languages,'all_topics' => $all_topics]);
    }

    public function store_knowledgebases(Request $request){
        $this->validate($request,[
           'title' => 'required|string',
           'content' => 'required|string',
           'topic_id' => 'required|string|max:191',
           'status' => 'required|string|max:191',
           'lang' => 'required|string|max:191',
        ]);

        Knowledgebase::create($request->all());

        return redirect()->back()->with(['msg' => 'New Article Added Success...','type' => 'success']);
    }

    public function edit_knowledgebases($id){
        $articles = Knowledgebase::find($id);
        $all_languages = Language::all();
        $all_topics = KnowledgebaseTopic::where(['status' =>'publish','lang' => $articles->lang])->get();

        return view('backend.knowledgebase.edit-knowledgebase')->with(['articles' => $articles,'all_languages' => $all_languages,'all_topics' => $all_topics]);
    }
    public function update_knowledgebases(Request $request){
        $this->validate($request,[
            'title' => 'required|string',
            'content' => 'required|string',
            'topic_id' => 'required|string|max:191',
            'status' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
        ]);

        Knowledgebase::find($request->article_id)->update($request->all());

        return redirect()->back()->with(['msg' => 'Article Update Success...','type' => 'success']);
    }

    public function page_settings(){
        $all_languages = Language::all();
        $all_topics = KnowledgebaseTopic::where(['status' =>'publish','lang' => get_default_language()])->get();
        return view('backend.knowledgebase.knowledgebase-page-settings')->with(['all_languages' => $all_languages,'all_topics' => $all_topics]);
    }

    public function update_page_settings(Request $request){
        $all_language = Language::all();
        foreach ($all_language as $lang) {
            $this->validate($request, [
                'site_knowledgebase_category_' . $lang->slug . '_title' => 'nullable',
                'site_knowledgebase_popular_widget_' . $lang->slug . '_title' => 'nullable',
                'site_knowledgebase_article_topic_' . $lang->slug . '_title' => 'nullable',
            ]);
            $knowledgebase_category = 'site_knowledgebase_category_' . $lang->slug . '_title';
            $knowledgebase_popular = 'site_knowledgebase_popular_widget_' . $lang->slug . '_title';
            $knowledgebase_article = 'site_knowledgebase_article_topic_' . $lang->slug . '_title';

            update_static_option($knowledgebase_category, $request->$knowledgebase_category);
            update_static_option($knowledgebase_popular, $request->$knowledgebase_popular);
            update_static_option($knowledgebase_article, $request->$knowledgebase_article);
        }

        update_static_option('site_knoeledgebase_post_items',$request->site_knoeledgebase_post_items);

        return redirect()->back()->with(['msg' => 'Knowledgebase Page Settings Update Success...','type' => 'success']);
    }
}

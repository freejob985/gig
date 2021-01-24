<?php

namespace App\Http\Controllers;

use App\Events;
use App\EventsCategory;
use App\Language;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function new_event(){
        $all_languages = Language::all();
        $all_categories = EventsCategory::where(['status' => 'publish','lang' => get_default_language()])->get();
        return view('backend.events.new-event')->with(['all_languages' => $all_languages,'all_categories' => $all_categories]);
    }

    public function store_event(Request $request){
        $this->validate($request,[
            'title' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'category_id' => 'required|string|max:191',
            'content' => 'required|string',
            'location' => 'required|string',
            'image' => 'nullable|string',
            'date' => 'required|string',
        ]);

        Events::create($request->all());

        return redirect()->back()->with(['msg' => 'New Event Created Success...','type'=>'success']);
    }

    public function all_events(){
        $all_events = Events::all()->groupBy('lang');
        return view('backend.events.all-events')->with(['all_events' => $all_events]);
    }

    public function edit_event($id){
        $event = Events::find($id);
        $all_languages = Language::all();
        $all_categories = EventsCategory::where(['status' => 'publish','lang' => $event->lang])->get();
        return view('backend.events.edit-event')->with(['all_languages' => $all_languages,'all_categories' => $all_categories,'event' => $event]);
    }

    public function delete_event(Request $request,$id){
        Events::find($id)->delete();
        return redirect()->back()->with(['msg' => 'Event Delete Success...','type'=>'danger']);
    }

    public function update_event(Request $request){
        $this->validate($request,[
            'title' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'category_id' => 'required|string|max:191',
            'content' => 'required|string',
            'location' => 'required|string',
            'image' => 'nullable|string',
            'date' => 'required|string',
        ]);

        Events::find($request->event_id)->update($request->all());

        return redirect()->back()->with(['msg' => 'Event Update Success...','type'=>'success']);
    }

    public function page_settings(){
        $all_languages = Language::all();
        return view('backend.events.event-page-settings')->with(['all_languages' => $all_languages]);
    }

    public function update_page_settings(Request $request){
        $this->validate($request,[
            'site_events_post_items' => 'required|string|max:191'
        ]);
        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $this->validate($request,[
                'site_events_category_'.$lang->slug.'_title'  => 'nullable|string'
            ]);
            $site_events_category_title = 'site_events_category_'.$lang->slug.'_title';
            update_static_option('site_events_category_'.$lang->slug.'_title',$request->$site_events_category_title);
        }
        update_static_option('site_events_post_items',$request->site_events_post_items);
        return redirect()->back()->with(['msg' => 'Events Page Settings Success...','type' => 'success']);
    }
}

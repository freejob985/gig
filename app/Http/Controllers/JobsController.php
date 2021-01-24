<?php

namespace App\Http\Controllers;

use App\Jobs;
use App\JobsCategory;
use App\Language;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function all_jobs(){
        $all_jobs = Jobs::all()->groupBy('lang');
        return view('backend.jobs.all-jobs')->with(['all_jobs' => $all_jobs]);
    }

    public function edit_job($id){

        $job_post = Jobs::find($id);
        $all_category = JobsCategory::where(['status' => 'publish','lang' => $job_post->lang])->get();
        $all_language = Language::all();

        return view('backend.jobs.edit-job')->with([
            'all_languages' => $all_language,
            'all_category' => $all_category,
            'job_post' => $job_post
        ]);
    }

    public function new_job(){
        $all_category = JobsCategory::where(['status' => 'publish','lang' => get_default_language()])->get();
        $all_language = Language::all();
        return view('backend.jobs.new-job')->with(['all_languages' => $all_language,'all_category' => $all_category]);
    }

    public function store_job(Request $request){
        $this->validate($request,[
            'title' => 'required|string',
            'position' => 'required|string|max:191',
            'company_name' => 'required|string|max:191',
            'category_id' => 'required|string|max:191',
            'vacancy' => 'required|string|max:191',
            'job_responsibility' => 'required|string',
            'employment_status' => 'required|string',
            'education_requirement' => 'nullable|string',
            'job_context' => 'nullable|string',
            'experience_requirement' => 'nullable|string',
            'additional_requirement' => 'nullable|string',
            'job_location' => 'required|string',
            'salary' => 'required|string',
            'lang' => 'required|string|max:191',
            'other_benefits' => 'nullable|string',
            'email' => 'required|string|max:191',
            'status' => 'nullable|string|max:191',
            'deadline' => 'required|string|max:191',
        ]);

        Jobs::create($request->all());

        return redirect()->back()->with(['msg' => 'New Job Post Added','type' => 'success']);
    }

    public function update_job(Request $request){
        $this->validate($request,[
            'title' => 'required|string',
            'position' => 'required|string|max:191',
            'company_name' => 'required|string|max:191',
            'category_id' => 'required|string|max:191',
            'vacancy' => 'required|string|max:191',
            'job_responsibility' => 'required|string',
            'employment_status' => 'required|string',
            'education_requirement' => 'nullable|string',
            'experience_requirement' => 'nullable|string',
            'additional_requirement' => 'nullable|string',
            'job_context' => 'nullable|string',
            'job_location' => 'required|string',
            'salary' => 'required|string',
            'lang' => 'required|string|max:191',
            'other_benefits' => 'nullable|string',
            'email' => 'required|string|max:191',
            'status' => 'nullable|string|max:191',
            'deadline' => 'required|string|max:191',
        ]);

        Jobs::find($request->job_id)->update($request->all());

        return redirect()->back()->with(['msg' => 'Job Post Update Success...','type' => 'success']);
    }

    public function delete_job(Request $request,$id){
        Jobs::find($id)->delete();

        return redirect()->back()->with(['msg' => 'Job Post Deleted Success','type' => 'danger']);
    }
    public function page_settings(){
        $all_languages = Language::all();
        return view('backend.jobs.job-page-settings')->with(['all_languages' => $all_languages]);
    }

    public function update_page_settings(Request $request){
        $this->validate($request,[
           'site_job_post_items' => 'required|string|max:191'
        ]);
        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $this->validate($request,[
               'site_jobs_category_'.$lang->slug.'_title'  => 'nullable|string'
            ]);
            $site_jobs_category_title = 'site_jobs_category_'.$lang->slug.'_title';
            update_static_option('site_jobs_category_'.$lang->slug.'_title',$request->$site_jobs_category_title);
        }
        update_static_option('site_job_post_items',$request->site_job_post_items);
        return redirect()->back()->with(['msg' => 'Job Page Settings Success...','type' => 'success']);
    }
}

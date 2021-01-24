<?php

namespace App\Http\Controllers;

use App\Language;
use App\Works;
use App\WorksCategory;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class WorksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $all_works = Works::all()->groupBy('lang');
        $work_category = WorksCategory::where(['status'=> 'publish','lang' => 'en'])->get();
        $all_language = Language::all();
        return view('backend.pages.works.index')->with(['all_works' => $all_works, 'works_category' => $work_category,'all_language' => $all_language]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'start_date' => 'nullable|string|max:191',
            'end_date' => 'nullable|string|max:191',
            'lang' => 'nullable|string|max:191',
            'clients' => 'nullable|string',
            'description' => 'required|string',
            'categories_id' => 'required',
            'image' => 'nullable|string|max:191',
        ]);
        Works::create([
            'title' => $request->title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'lang' => $request->lang,
            'clients' => $request->clients,
            'description' => $request->description,
            'image' => $request->image,
            'categories_id' => serialize($request->categories_id),
        ]);

        return redirect()->back()->with(['msg' => 'New work Added...', 'type' => 'success']);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'start_date' => 'nullable|string|max:191',
            'end_date' => 'nullable|string|max:191',
            'lang' => 'nullable|string|max:191',
            'clients' => 'nullable|string',
            'description' => 'required|string',
            'categories_id' => 'required',
            'image' => 'nullable|string|max:191',
        ]);
        Works::find($request->id)->update(
            [
                'title' => $request->title,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'lang' => $request->lang,
                'clients' => $request->clients,
                'description' => $request->description,
                'image' => $request->image,
                'categories_id' => serialize($request->categories_id),
            ]
        );
        return redirect()->back()->with(['msg' => 'Works Item Updated...', 'type' => 'success']);
    }

    public function delete($id)
    {
        Works::find($id)->delete();
        return redirect()->back()->with(['msg' => 'Delete Success...', 'type' => 'danger']);
    }

    public function category_index()
    {
        $all_category = WorksCategory::all()->groupBy('lang');
        return view('backend.pages.works.category')->with(['all_category' => $all_category]);
    }

    public function category_store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'status' => 'required|string|max:191'
        ]);

        WorksCategory::create($request->all());

        return redirect()->back()->with([
            'msg' => 'New Category Added...',
            'type' => 'success'
        ]);
    }

    public function category_update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'status' => 'required|string|max:191'
        ]);

        WorksCategory::find($request->id)->update([
            'name' => $request->name,
            'status' => $request->status,
            'lang' => $request->lang,
        ]);

        return redirect()->back()->with([
            'msg' => 'Category Update Success...',
            'type' => 'success'
        ]);
    }

    public function category_delete(Request $request, $id)
    {
        if (Works::where('categories_id', $id)->first()) {
            return redirect()->back()->with([
                'msg' => 'You Can Not Delete This Category, It Already Associated With A Works ...',
                'type' => 'danger'
            ]);
        }
        WorksCategory::find($id)->delete();
        return redirect()->back()->with([
            'msg' => 'Category Delete Success...',
            'type' => 'danger'
        ]);
    }

    public function category_by_slug(Request $request){
        $all_category = WorksCategory::where('lang',$request->lang)->get();
        return response()->json($all_category);
    }
}



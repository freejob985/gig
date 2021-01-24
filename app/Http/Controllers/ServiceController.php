<?php

namespace App\Http\Controllers;

use App\ServiceCategory;
use App\Services;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ServiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $all_services = Services::all()->groupBy('lang');
        $service_category = ServiceCategory::where(['status' => 'publish','lang' => 'en'])->get();
        return view('backend.pages.service.index')->with(['all_services' => $all_services,'service_category' => $service_category]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'title' => 'required|string|max:191',
            'icon' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'description' => 'required|string',
            'excerpt' => 'required|string',
            'categories_id' => 'required|string',
            'image' => 'nullable|string|max:191'
        ]);
        Services::create($request->all());

        return redirect()->back()->with(['msg' => 'New service Added...','type' => 'success']);
    }

    public function update(Request $request){

        $this->validate($request,[
            'title' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'icon' => 'required|string|max:191',
            'description' => 'required|string',
            'excerpt' => 'required|string',
            'categories_id' => 'required|string',
            'image' => 'nullable|string|max:191'
        ]);
        Services::find($request->id)->update($request->all());

        return redirect()->back()->with(['msg' => 'Service Item Updated...','type' => 'success']);
    }

    public function delete($id){
        Services::find($id)->delete();

        return redirect()->back()->with(['msg' => 'Delete Success...','type' => 'danger']);
    }

    public function category_index(){
        $all_category = ServiceCategory::all()->groupBy('lang');
        return view('backend.pages.service.category')->with(['all_category' => $all_category]);
    }
    public function category_store(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'status' => 'required|string|max:191'
        ]);

        ServiceCategory::create($request->all());

        return redirect()->back()->with([
            'msg' => 'New Category Added...',
            'type' => 'success'
        ]);
    }

    public function category_update(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'status' => 'required|string|max:191'
        ]);

        ServiceCategory::find($request->id)->update([
            'name' => $request->name,
            'lang' =>  $request->lang,
            'status' => $request->status,
        ]);

        return redirect()->back()->with([
            'msg' => 'Category Update Success...',
            'type' => 'success'
        ]);
    }

    public function category_delete(Request $request,$id){
        if (Services::where('categories_id',$id)->first()){
            return redirect()->back()->with([
                'msg' => 'You Can Not Delete This Category, It Already Associated With A Service...',
                'type' => 'danger'
            ]);
        }
        ServiceCategory::find($id)->delete();
        return redirect()->back()->with([
            'msg' => 'Category Delete Success...',
            'type' => 'danger'
        ]);
    }

    public function category_by_slug(Request $request){
        $service_category = ServiceCategory::where(['status' => 'publish','lang' => $request->lang])->get();
        return response()->json($service_category);
    }
}

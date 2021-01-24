<?php

namespace App\Http\Controllers;

use App\Language;
use App\PricePlan;
use Illuminate\Http\Request;

class PricePlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $all_price_plan = PricePlan::all()->groupBy('lang');
        $all_language = Language::all();
        return view('backend.pages.price-plan')->with(['all_price_plan' => $all_price_plan ,'all_languages' => $all_language]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'title' => 'required|string|max:191',
            'price' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'type' => 'nullable|string|max:191',
            'icon' => 'nullable|string|max:191',
            'btn_text' => 'required|string|max:191',
            'btn_url' => 'nullable|string|max:191',
            'features' => 'required|string',
        ]);
        PricePlan::create($request->all());
        return redirect()->back()->with(['msg' => 'New Price Plan Added...','type' => 'success']);
    }

    public function update(Request $request){

        $this->validate($request,[
            'title' => 'required|string|max:191',
            'price' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'type' => 'nullable|string|max:191',
            'icon' => 'nullable|string|max:191',
            'btn_text' => 'required|string|max:191',
            'btn_url' => 'nullable|string|max:191',
            'features' => 'required|string',
        ]);

        PricePlan::find($request->id)->update($request->all());

        return redirect()->back()->with(['msg' => 'Price Plan Updated...','type' => 'success']);
    }

    public function delete($id){
        PricePlan::find($id)->delete();
        return redirect()->back()->with(['msg' => 'Delete Success...','type' => 'danger']);
    }
}

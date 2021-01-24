<?php

namespace App\Http\Controllers;

use App\Mail\QuoteReply;
use App\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class QuoteManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function all_quotes(){
        $all_quotes = Quote::all();
        return view('backend.quote-manage.quote-manage-all')->with(['all_quotes' => $all_quotes]);
    }

    public function pending_quotes(){
        $all_quotes = Quote::where('status','pending')->get();
        return view('backend.quote-manage.quote-manage-pending')->with(['all_quotes' => $all_quotes]);
    }

    public function completed_quotes(){
        $all_quotes = Quote::where('status','completed')->get();
        return view('backend.quote-manage.quote-manage-completed')->with(['all_quotes' => $all_quotes]);
    }

    public function quote_delete(Request $request,$id){
        Quote::find($id)->delete();
        return redirect()->back()->with(['msg' => 'Quote Status Deleted Success...','type' => 'danger']);
    }

    public function change_status(Request $request){
        $this->validate($request,[
           'quote_status' => 'required|string|max:191',
            'quote_id' => 'required|string|max:191'
        ]);
        Quote::find($request->quote_id)->update(['status' => $request->quote_status]);

        return redirect()->back()->with(['msg' => 'Quote Status Update Success...','type' => 'success']);
    }

    public function send_mail(Request $request){
        $this->validate($request,[
           'email' => 'required|string|max:191',
           'name' => 'required|string|max:191',
           'subject' => 'required|string',
           'message' => 'required|string',
        ]);
        $data = [
            'name' => $request->name,
            'message' => $request->message,
            'subject' => str_replace('{site}',get_static_option('site_'.get_default_language().'_title'),$request->subject)
        ];
        Mail::to($request->email)->send(new QuoteReply($data));
        return redirect()->back()->with(['msg' => 'Quote Reply Mail Send Success...','type' => 'success']);
    }
}

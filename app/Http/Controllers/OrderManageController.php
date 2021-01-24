<?php

namespace App\Http\Controllers;

use App\Language;
use App\Mail\OrderReply;
use App\Mail\PaymentSuccess;
use App\Mail\QuoteReply;
use App\Order;
use App\PaymentLogs;
use App\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function all_orders(){
        $all_orders = Order::all();
        return view('backend.order-manage.order-manage-all')->with(['all_orders' => $all_orders]);
    }

    public function pending_orders(){
        $all_orders = Order::where('status','pending')->get();
        return view('backend.order-manage.order-manage-all')->with(['all_orders' => $all_orders]);
    }

    public function completed_orders(){
        $all_orders = Order::where('status','completed')->get();
        return view('backend.order-manage.order-manage-all')->with(['all_orders' => $all_orders]);
    }
    public function in_progress_orders(){
        $all_orders = Order::where('status','in_progress')->get();
        return view('backend.order-manage.order-manage-in-progress')->with(['all_orders' => $all_orders]);
    }

    public function change_status(Request $request){
        $this->validate($request,[
            'order_status' => 'required|string|max:191',
            'order_id' => 'required|string|max:191'
        ]);
        Order::find($request->order_id)->update(['status' => $request->order_status]);

        return redirect()->back()->with(['msg' => 'Order Status Update Success...','type' => 'success']);
    }

    public function order_delete(Request $request,$id){
        Order::find($id)->delete();
        return redirect()->back()->with(['msg' => 'Order Status Deleted Success...','type' => 'danger']);
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
        Mail::to($request->email)->send(new OrderReply($data));
        return redirect()->back()->with(['msg' => 'Order Reply Mail Send Success...','type' => 'success']);
    }

    public function all_payment_logs(){
        $paymeng_logs = PaymentLogs::all();
        return view('backend.payment-logs.payment-logs-all')->with(['payment_logs' => $paymeng_logs]);
    }

    public function payment_logs_delete(Request $request,$id){
        PaymentLogs::find($id)->delete();
        return redirect()->back()->with(['msg' => 'Payment Log Delete Success...','type' => 'danger']);
    }

    public function payment_logs_approve(Request $request,$id){
        $payment_logs = PaymentLogs::find($id);
        $payment_logs->status = 'complete';
        $payment_logs->save();

        Order::where('id',$payment_logs->order_id)->update(['payment_status' => 'complete']);

        Mail::to($payment_logs->email)->send(new PaymentSuccess($payment_logs));

        return redirect()->back()->with(['msg' => 'Manual Payment Accept Success','type' => 'success']);
    }

    public function order_success_payment(){
        $all_languages = Language::all();
        return view('backend.order-manage.order-success-page')->with(['all_languages' => $all_languages]);
    }

    public function update_order_success_payment(Request $request){

        $all_language = Language::all();
        foreach ($all_language as $lang) {
            $this->validate($request, [
                'site_order_success_page_' . $lang->slug . '_title' => 'nullable',
                'site_order_success_page_' . $lang->slug . '_subtitle' => 'nullable',
                'site_order_success_page_' . $lang->slug . '_description' => 'nullable',
            ]);
            $title = 'site_order_success_page_' . $lang->slug . '_title';
            $subtitle = 'site_order_success_page_' . $lang->slug . '_subtitle';
            $description = 'site_order_success_page_' . $lang->slug . '_description';

            update_static_option($title, $request->$title);
            update_static_option($subtitle, $request->$subtitle);
            update_static_option($description, $request->$description);
        }
        return redirect()->back()->with(['msg' => 'Order Success Page Update Success...','type' => 'success']);
    }

    public function order_cancel_payment(){
        $all_languages = Language::all();
        return view('backend.order-manage.order-cancel-page')->with(['all_languages' => $all_languages]);
    }

    public function update_order_cancel_payment(Request $request){

        $all_language = Language::all();
        foreach ($all_language as $lang) {
            $this->validate($request, [
                'site_order_cancel_page_' . $lang->slug . '_title' => 'nullable',
                'site_order_cancel_page_' . $lang->slug . '_subtitle' => 'nullable',
                'site_order_cancel_page_' . $lang->slug . '_description' => 'nullable',
            ]);
            $title = 'site_order_cancel_page_' . $lang->slug . '_title';
            $subtitle = 'site_order_cancel_page_' . $lang->slug . '_subtitle';
            $description = 'site_order_cancel_page_' . $lang->slug . '_description';

            update_static_option($title, $request->$title);
            update_static_option($subtitle, $request->$subtitle);
            update_static_option($description, $request->$description);
        }
        return redirect()->back()->with(['msg' => 'Order Cancel Page Update Success...','type' => 'success']);
    }
}

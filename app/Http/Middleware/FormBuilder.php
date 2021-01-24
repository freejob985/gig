<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class FormBuilder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $id = auth()->user()->id;
            $role_id = \App\Admin::where('id',$id)->first();
            $user_role = \App\AdminRole::where('id', $role_id->role)->first();
            $all_permission = json_decode($user_role->permission);
            if (in_array('form_builder', $all_permission)) {
                return $next($request);
            }
        }
        return redirect()->route('admin.home');
    }
}

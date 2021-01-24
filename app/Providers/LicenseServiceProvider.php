<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LicenseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $license_info = [
            "item_license_status"=>  "not_verified",
            "license_message" => "Please License the product to stay secure",
        ];

        if (!file_exists('@core/license.json')){
            if (request()->is('admin-home')){
                licnese_cheker();
                $license_info_form_json = file_get_contents('@core/license.json');
                $license_info_form_json = json_decode($license_info_form_json);

                $license_info = [
                    "item_license_status"=>  $license_info_form_json->item_license_status,
                    "license_message" => $license_info_form_json->message,
                ];
            }

        }else{
            $weekInYearNumber = (int)date('W');
            $weekDayNumber = (int)date('w');
            if ($weekDayNumber === 1 && $weekInYearNumber % 2 == 0) {
                licnese_cheker();
            }
            $license_info = file_get_contents('@core/license.json');
            $license_info_form_json = json_decode($license_info);
            $license_info = [
                "item_license_status"=>  $license_info_form_json->item_license_status,
                "license_message" => $license_info_form_json->message,
            ];
        }

        view::share([
            'license_status' => $license_info['item_license_status'],
            'license_message' => $license_info['license_message']
        ]);
    }
}

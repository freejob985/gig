<?php

use App\Language;
use App\StaticOption;
use App\WorksCategory;
use App\Works;
use Illuminate\Support\Facades\Auth;
use App\MediaUpload;

function active_menu($url)
{

    return $url == request()->path() ? 'active' : '';
}

function active_menu_frontend($url)
{

    return $url == request()->path() ? 'current-menu-item' : '';
}


function check_image_extension($file)
{
    $extension = strtolower($file->getClientOriginalExtension());
    if ($extension != 'jpg' && $extension != 'jpeg' && $extension != 'png' && $extension = 'gif') {
        return false;
    }
    return true;
}

function sendSubscriberEmail($to, $subject, $message, $from = '')
{

    $from = get_static_option('site_global_email');
    $headers = "From: " . $from . " \r\n";
    $headers .= "Reply-To: <$from> \r\n";
    $headers .= "Return-Path: " . ($from) . "\r\n";;
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $headers .= "X-Priority: 2\nX-MSmail-Priority: high";;
    $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";

    if (mail($to, $subject, $message, $headers)) {
        return true;
    }

}

function sendEmail($to, $name, $subject, $message, $from = '')
{
    $template = get_static_option('site_global_email_template');
    $from = get_static_option('site_global_email');

    $headers = "From: " . $from . " \r\n";
    $headers .= "Reply-To: <$from> \r\n";
    $headers .= "Return-Path: " . ($from) . "\r\n";;
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $headers .= "X-Priority: 2\nX-MSmail-Priority: high";;
    $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";

    $mm = str_replace("@username", $name, $template);
    $message = str_replace("@message", $message, $mm);
    $message = str_replace("@company", get_static_option('site_title'), $message);

    if (mail($to, $subject, $message, $headers)) {
        return true;
    }

}

function sendPlanEmail($to, $name, $subject, $message, $from)
{

    $headers = "From: " . $from . " \r\n";
    $headers .= "Reply-To: <$from> \r\n";
    $headers .= "Return-Path: " . ($from) . "\r\n";;
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $headers .= "X-Priority: 2\nX-MSmail-Priority: high";;
    $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";
    $message = "\nThis mail send by " . $name;
    if (mail($to, $subject, $message, $headers)) {
        return true;
    }
}


function set_static_option($key, $value)
{
    if (!StaticOption::where('option_name', $key)->first()) {
        StaticOption::create([
            'option_name' => $key,
            'option_value' => $value
        ]);
        return true;
    }
    return false;
}

function get_static_option($key)
{
    if (StaticOption::where('option_name', $key)->first()) {
        $return_val = StaticOption::where('option_name', $key)->first();
        return $return_val->option_value;
    }
    return null;
}

function update_static_option($key, $value)
{
    if (!StaticOption::where('option_name', $key)->first()) {
        StaticOption::create([
            'option_name' => $key,
            'option_value' => $value
        ]);
        return true;
    } else {
        StaticOption::where('option_name', $key)->update([
            'option_name' => $key,
            'option_value' => $value
        ]);
        return true;
    }
    return false;
}

function delete_static_option($key)
{
    StaticOption::where('option_name', $key)->delete();
    return true;
}

function single_post_share($url, $title, $img_url)
{
    $output = '';
    //get current page url
    $encoded_url = urlencode($url);
    //get current page title
    $post_title = str_replace(' ', '%20', $title);

    //all social share link generate
    $facebook_share_link = 'https://www.facebook.com/sharer/sharer.php?u=' . $encoded_url;
    $twitter_share_link = 'https://twitter.com/intent/tweet?text=' . $post_title . '&amp;url=' . $encoded_url . '&amp;via=' . get_static_option('site_' . get_default_language() . '_title');
    $linkedin_share_link = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $encoded_url . '&amp;title=' . $post_title;
    $pinterest_share_link = 'https://pinterest.com/pin/create/button/?url=' . $encoded_url . '&amp;media=' . $img_url . '&amp;description=' . $post_title;

    $output .= '<li><a class="facebook" href="' . $facebook_share_link . '"><i class="fab fa-facebook-f"></i></a></li>';
    $output .= '<li><a class="twitter" href="' . $twitter_share_link . '"><i class="fab fa-twitter"></i></a></li>';
    $output .= '<li><a class="linkedin" href="' . $linkedin_share_link . '"><i class="fab fa-linkedin-in"></i></a></li>';
    $output .= '<li><a class="pinterest" href="' . $pinterest_share_link . '"><i class="fab fa-pinterest-p"></i></a></li>';

    return $output;
}


function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('', 'KB', 'MB', 'GB', 'TB');

    return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
}


function licnese_cheker()
{
    $data = array(
        'action' => env('XGENIOUS_API_ACTION'),
        'purchase_code' => get_static_option('item_purchase_key'),
        'author' => env('XGENIOUS_API_AUTHOR'),
        'site_url' => url('/'),
        'item_unique_key' => env('XGENIOUS_API_KEY'),
    );
    //item_license_status
    $api_url = env('XGENIOUS_API_URL') . '?' . http_build_query($data);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $api_url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($result);
    update_static_option('item_license_status', $result->license_status);
    $type = 'verified' == $result->license_status ? 'success' : 'danger';
    $license_info = [
        "item_license_status" => $result->license_status,
        "last_check" => time(),
        "purchase_code" => get_static_option('item_purchase_key'),
        "xgenious_app_key" => env('XGENIOUS_API_KEY'),
        "author" => env('XGENIOUS_API_AUTHOR'),
        "message" => $result->message
    ];
    file_put_contents('core/license.json', json_encode($license_info));
}

function get_work_category_by_id($id, $output = 'array')
{
    $category_id = Works::find($id)->categories_id;
    $cat_list = [];
    $cat_list_string = '';
    $cat_list_slug = '';

    foreach ($category_id as $key => $data) {
        $separator = $key != 0 ? ', ' : '';
        $cat_item = WorksCategory::find($data);
        $cat_list[$cat_item->id] = $cat_item->name;
        $cat_list_string .= $separator . $cat_item->name;
        $cat_list_slug .= Str::slug($cat_item->name) . ' ';
    }
    switch ($output) {
        case ("string"):
            return $cat_list_string;
            break;
        case ("slug"):
            return $cat_list_slug;
            break;
        default:
            return $cat_list;
            break;
    }

}

function get_child_menu_count($menu_content, $parent_id)
{
    $return_val = 0;
    foreach ($menu_content as $data) {
        if ($parent_id == $data->parent_id) {
            $return_val++;
        }
    }
    return $return_val;
}

function minify_css_lines($css)
{
    // some of the following functions to minimize the css-output are directly taken
    // from the awesome CSS JS Booster: https://github.com/Schepp/CSS-JS-Booster
    // all credits to Christian Schaefer: http://twitter.com/derSchepp
    // remove comments
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    // backup values within single or double quotes
    preg_match_all('/(\'[^\']*?\'|"[^"]*?")/ims', $css, $hit, PREG_PATTERN_ORDER);
    for ($i = 0; $i < count($hit[1]); $i++) {
        $css = str_replace($hit[1][$i], '##########' . $i . '##########', $css);
    }
    // remove traling semicolon of selector's last property
    $css = preg_replace('/;[\s\r\n\t]*?}[\s\r\n\t]*/ims', "}\r\n", $css);
    // remove any whitespace between semicolon and property-name
    $css = preg_replace('/;[\s\r\n\t]*?([\r\n]?[^\s\r\n\t])/ims', ';$1', $css);
    // remove any whitespace surrounding property-colon
    $css = preg_replace('/[\s\r\n\t]*:[\s\r\n\t]*?([^\s\r\n\t])/ims', ':$1', $css);
    // remove any whitespace surrounding selector-comma
    $css = preg_replace('/[\s\r\n\t]*,[\s\r\n\t]*?([^\s\r\n\t])/ims', ',$1', $css);
    // remove any whitespace surrounding opening parenthesis
    $css = preg_replace('/[\s\r\n\t]*{[\s\r\n\t]*?([^\s\r\n\t])/ims', '{$1', $css);
    // remove any whitespace between numbers and units
    $css = preg_replace('/([\d\.]+)[\s\r\n\t]+(px|em|pt|%)/ims', '$1$2', $css);
    // shorten zero-values
    $css = preg_replace('/([^\d\.]0)(px|em|pt|%)/ims', '$1', $css);
    // constrain multiple whitespaces
    $css = preg_replace('/\p{Zs}+/ims', ' ', $css);
    // remove newlines
    $css = str_replace(array("\r\n", "\r", "\n"), '', $css);
    // Restore backupped values within single or double quotes
    for ($i = 0; $i < count($hit[1]); $i++) {
        $css = str_replace('##########' . $i . '##########', $hit[1][$i], $css);
    }

    return $css;
}

function google_captcha_check($token)
{
    $captha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $captha_url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('secret' => get_static_option('site_google_captcha_v3_secret_key'), 'response' => $token)));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

    $response = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($response, true);
    return $result;
}

function load_google_fonts()
{
    //google fonts link;
    $fonts_url = 'https://fonts.googleapis.com/css?family=';

    //body fonts
    $body_font_family = !empty(get_static_option('body_font_family')) ? get_static_option('body_font_family') : 'Open Sans';
    $heading_font_family = !empty(get_static_option('heading_font_family')) ? get_static_option('heading_font_family') : 'Montserrat';

    $load_body_font_family = str_replace(' ', '+', $body_font_family);
    $body_font_variant_selected_arr = !empty(get_static_option('body_font_variant')) ? unserialize(get_static_option('body_font_variant')) : ['regular'];
    $load_body_font_variant = implode(',', $body_font_variant_selected_arr);
    $fonts_url .= $load_body_font_family . ':' . $load_body_font_variant;
    $load_heading_font_family = str_replace(' ', '+', $heading_font_family);
    $heading_font_variant_selected_arr = !empty(get_static_option('heading_font_variant')) ? unserialize(get_static_option('heading_font_variant')) : ['regular'];
    $load_heading_font_variant = implode(',', $heading_font_variant_selected_arr);

    if (!empty(get_static_option('heading_font')) && $heading_font_family != $body_font_family) {
        $fonts_url .= '|' . $load_heading_font_family . ':' . $load_heading_font_variant;
    }

    return sprintf(' <link href="%1$s&display=swap" rel="stylesheet">', $fonts_url);
}

function get_language_by_slug($slug)
{
    $lang_details = \App\Language::where('slug', $slug)->first();
    return !empty($lang_details) ? $lang_details->name : '';
}

function get_default_language()
{
    $defaultLang = Language::where('default', 1)->first();
    return $defaultLang->slug;
}

function get_all_language()
{
    $all_lang = Language::orderBy('default', 'DESC')->get();
    return $all_lang;
}

function get_user_lang()
{
    $default = Language::where('default', 1)->first();
    return !empty(session()->get('lang')) ? session()->get('lang') : $default->slug;
}

function get_user_lang_direction()
{
    $default = Language::where('default', 1)->first();
    $user_direction = Language::where('slug', session()->get('lang'))->first();
    return !empty(session()->get('lang')) ? $user_direction->direction : $default->direction;
}

function get_field_by_type($type, $name, $placeholder, $options = [], $requried = null, $mimes = null)
{
    $markup = '';
    $required_markup_html = 'required="required"';
    switch ($type) {
        case('email'):
            $required_markup = !empty($requried) ? $required_markup_html : '';
            $markup = ' <div class="form-group"> <input type="email" id="' . $name . '" name="' . $name . '" class="form-control" placeholder="' . __($placeholder) . '" ' . $required_markup . '></div>';
            break;
        case('tel'):
            $required_markup = !empty($requried) ? $required_markup_html : '';
            $markup = ' <div class="form-group"> <input type="tel" id="' . $name . '" name="' . $name . '" class="form-control" placeholder="' . __($placeholder) . '" ' . $required_markup . '></div>';
            break;
        case('url'):
            $required_markup = !empty($requried) ? $required_markup_html : '';
            $markup = ' <div class="form-group"> <input type="url" id="' . $name . '" name="' . $name . '" class="form-control" placeholder="' . __($placeholder) . '" ' . $required_markup . '></div>';
            break;
        case('textarea'):
            $required_markup = !empty($requried) ? $required_markup_html : '';
            $markup = ' <div class="form-group textarea"><textarea name="' . $name . '" id="' . $name . '" cols="30" rows="10" class="form-control" placeholder="' . __($placeholder) . '" ' . $required_markup . '></textarea></div>';
            break;
        case('file'):
            $required_markup = !empty($requried) ? $required_markup_html : '';
            $mimes_type_markup = str_replace('mimes:', __('Accept File Type:') . ' ', $mimes);
            $markup = ' <div class="form-group file"> <label for="' . $name . '">' . $placeholder . '</label> <input type="file" id="' . $name . '" name="' . $name . '" ' . $required_markup . ' class="form-control" > <span class="help-info">' . $mimes_type_markup . '</span></div>';
            break;
        case('checkbox'):
            $required_markup = !empty($requried) ? $required_markup_html : '';
            $markup = ' <div class="form-group checkbox">  <input type="checkbox" id="' . $name . '" name="' . $name . '" class="form-control" ' . $required_markup . '> <label for="' . $name . '">' . __($placeholder) . '</label></div>';
            break;
        case('select'):
            $option_markup = '';
            $required_markup = !empty($requried) ? $required_markup_html : '';
            foreach ($options as $opt) {
                $option_markup .= '<option value="' . Str::slug($opt) . '">' . $opt . '</option>';
            }
            $markup = ' <div class="form-group select"> <label for="' . $name . '">' . __($placeholder) . '</label> <select id="' . $name . '" name="' . $name . '" class="form-control" ' . $required_markup . '>' . $option_markup . '</select></div>';
            break;
        default:
            $required_markup = !empty($requried) ? $required_markup_html : '';
            $markup = ' <div class="form-group"> <input type="text" id="' . $name . '" name="' . $name . '" class="form-control" placeholder="' . __($placeholder) . '" ' . $required_markup . '></div>';
            break;
    }

    return $markup;
}

function check_page_permission($page)
{
    if (Auth::check()) {
        $id = auth()->user()->id;
        $role_id = \App\Admin::where('id', $id)->first();
        $user_role = \App\AdminRole::where('id', $role_id->role)->first();
        $all_permission = json_decode($user_role->permission);
        if (in_array($page, $all_permission)) {
            return true;
        }
    }
    return false;
}


function get_user_role_name_by_id($id)
{
    $name = \App\AdminRole::where('id', $id)->first();
    return $name->name;
}
function get_topic_name_by_id($id)
{
    $name = \App\KnowledgebaseTopic::where('id', $id)->first();
    return $name->title;
}

/*
 * php delete function that deals with directories recursively
 */
function delete_dir_with_file($target)
{
    if (is_dir($target)) {
        $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned

        foreach ($files as $file) {
            delete_dir_with_file($file);
        }

        if (file_exists($target)) {
            rmdir($target);
        }
    } elseif (is_file($target)) {
        unlink($target);
    }
}

function chmod_r($path)
{
    if (is_dir($path)) {
        $files = glob($path . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned

        foreach ($files as $file) {
            chmod($file, 0777);
        }

    } elseif (is_file($path)) {
        chmod($path, 0777);
    }
}

function chmod_file_folder($dir)
{
    $dh = @opendir($dir);
    chmod($dir, 0777);
    if ($dh) {

        while (false !== ($file = readdir($dh))) {

            if ($file != "." && $file != "..") {

                $fullpath = $dir . '/' . $file;
                if (!is_dir($fullpath)) {
                    chmod($fullpath, 0777);
                } else {
                    if (chmod($fullpath, 0777)) {
                        chmod_file_folder($fullpath);
                    }
                }
            }
        }
        closedir($dh);
    }
}

function copy_dir_with_files($src, $dst)
{

    // open the source directory
    $dir = opendir($src);

    // Make the destination directory if not exist
    @mkdir($dst);

    // Loop through the files in source directory
    while ($file = readdir($dir)) {

        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {

                // Recursively calling custom copy function
                // for sub directory
                custom_copy($src . '/' . $file, $dst . '/' . $file);

            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }

    closedir($dir);
}

function get_attachment_image_by_id($id, $size = null, $default = false)
{
    $image_details = MediaUpload::find($id);
    $return_val = [];
    $image_url = '';

    switch ($size) {
        case "large":
            if (file_exists('assets/uploads/media-uploader/large-' . $image_details->path)) {
                $image_url = asset('assets/uploads/media-uploader/large-' . $image_details->path);
            }
            break;
        case "grid":
            if (file_exists('assets/uploads/media-uploader/grid-' . $image_details->path)) {
                $image_url = asset('assets/uploads/media-uploader/grid-' . $image_details->path);
            }
            break;
        case "thumb":
            if (file_exists('assets/uploads/media-uploader/thumb-' . $image_details->path)) {
                $image_url = asset('assets/uploads/media-uploader/thumb-' . $image_details->path);
            }
            break;
        default:
            if (is_numeric($id) && file_exists('assets/uploads/media-uploader/' . $image_details->path )) {
                $image_url = asset('assets/uploads/media-uploader/' . $image_details->path);
            }
            break;
    }
    if (!empty($image_details)){
        $return_val['image_id'] = $image_details->id;
        $return_val['path'] = $image_details->path;
        $return_val['img_url'] = $image_url;
    }elseif (empty($image_details) && $default){
        $return_val['img_url'] = asset('assets/uploads/no-image.png');
    }

    return $return_val;
}

function setEnvValue(array $values)
{

    $envFile = app()->environmentFilePath();
    $str = file_get_contents($envFile);

    if (count($values) > 0) {
        foreach ($values as $envKey => $envValue) {

            $str .= "\n"; // In case the searched variable is in the last line without \n
            $keyPosition = strpos($str, "{$envKey}=");
            $endOfLinePosition = strpos($str, "\n", $keyPosition);
            $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

            // If key does not exist, add it
            if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                $str .= "{$envKey}={$envValue}\n";
            } else {
                $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
            }

        }
    }

    $str = substr($str, 0, -1);
    if (!file_put_contents($envFile, $str)) return false;
    return true;

}

function getJson($url) {
    // cache files are created like cache/abcdef123456...
    $cacheFile = 'cache' . DIRECTORY_SEPARATOR . md5($url);

    if (file_exists($cacheFile)) {
        $fh = fopen($cacheFile, 'r');
        $cacheTime = trim(fgets($fh));

        // if data was cached recently, return cached data
        if ($cacheTime > strtotime('-60 minutes')) {
            return fread($fh);
        }

        // else delete cache file
        fclose($fh);
        unlink($cacheFile);
    }

    $json = file_get_contents($url);

    $fh = fopen($cacheFile, 'w');
    fwrite($fh, time() . "\n");
    fwrite($fh, $json);
    fclose($fh);

    return $json;
}
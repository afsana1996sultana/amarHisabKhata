<?php
use App\Models\Setting;
if (!function_exists('get_setting')) {
    function get_setting($name)
    {
        return Setting::where('site_name', $name)->first();
    }
}

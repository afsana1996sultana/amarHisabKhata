<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{

    public function index()
    {
        $data['setting'] = Setting::first();
        // return $data;
        return view('admin.setting.index', $data);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $setting = Setting::first();
            $setting->site_name = $request->site_name;
            $setting->site_title = $request->site_title;
            $setting->contact_number = $request->contact_number;
            $setting->email = $request->email;
            $setting->address = $request->address;
            $setting->fax = $request->fax;
            $setting->prefix = $request->prefix;

            if ($request->hasFile('header_logo')) {

                if ($setting->header_logo) {
                    File::delete($setting->header_logo);
                }

                $file = $request->file('header_logo');
                $ext = $file->getClientOriginalExtension();
                $fileName = time() . '.' . $ext;
                $file->move('images/setting/', $fileName);
                $setting->header_logo = 'images/setting/' . $fileName;
            }
            if ($request->hasFile('footer_logo')) {

                if ($setting->footer_logo) {
                    File::delete($setting->footer_logo);
                }

                $file = $request->file('footer_logo');
                $ext = $file->getClientOriginalExtension();
                $fileName = time() . '.' . $ext;
                $file->move('images/setting/', $fileName);
                $setting->footer_logo = 'images/setting/' . $fileName;
            }
            if ($request->hasFile('fav_icon')) {

                if ($setting->fav_icon) {
                    File::delete($setting->fav_icon);
                }

                $file = $request->file('fav_icon');
                $ext = $file->getClientOriginalExtension();
                $fileName = time() . '.' . $ext;
                $file->move('images/setting/', $fileName);
                $setting->fav_icon = 'images/setting/' . $fileName;
            }

            $setting->save();
            DB::commit();
            return redirect()->back()->with('success', 'Setting Updated Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Sorry Something went to wrong');
        }
    }
}

<?php

namespace App\Http\Controllers;
use Session;
use App\Models\Setting;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit(Setting $setting)
    {
        $setting = Setting::first();
        
        return view('admin.setting.edit', compact('setting'));
    }

    
    public function update(Request $request)
    {
        
        $this->validate($request, [
            'name' => 'required',
            'copyright' => 'required',
        ]);

        $setting = Setting::first();
        $setting->update($request->all());

        if($request->hasFile('site_logo')){
            $image = $request->site_logo;
            $image_new_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move('storage/setting/', $image_new_name);
            $setting->site_logo = '/storage/setting/' . $image_new_name;
            $setting->save();
        }

        Session::flash('success', 'Setting updated successfully');
        return redirect()->back();
    }
}

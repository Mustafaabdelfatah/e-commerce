<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Model\Setting;
use Storage;
use Up;
class Settings extends Controller {

	public function setting() {

        return view('admin.settings', ['title' => trans('admin.settings')]);

	}
	public function setting_save() {

        $data = $this->validate(request(),
        ['logo'                     => v_image(),
        'icon'                      => v_image(),
        'status'                    =>'',
        'description'               =>'',
        'keywords'                  =>'',
        'main_lang'                 =>'',
        'message_maintenance'       =>'',
        'email'                     =>'',
        'sitename_en'               =>'',
        'sitename_ar'               =>'',
        ],

        [],
        ['logo'=>trans('admin.logo'),'icon'=>trans('admin.icon')]);

        //$data = request()->except(['_token', '_method']);
        if(request()->hasFile('logo')){

            // store('settings') كده الداتا هتتخزن ف فولدر اسمه سيتنجس هيتم انشائه
            $data['logo'] = up()->upload([
                //'new_name'          => '',
                'file'              =>'logo',
                'path'              =>'countries',
                'upload_type'       =>'single',
                'delete_file'       =>setting()->logo,

            ]);
        }

        if(request()->hasFile('icon')){

            $data['icon'] = up()->upload([
                //'new_name'          => '',
                'file'              =>'icon',
                'path'              =>'settings',
                'upload_type'       =>'single',
                'delete_file'       =>setting()->icon,

            ]);

        }
		Setting::orderBy('id', 'desc')->update($data);
		session()->flash('success', trans('admin.updated_record'));
		return redirect(aurl('settings'));
	}
}

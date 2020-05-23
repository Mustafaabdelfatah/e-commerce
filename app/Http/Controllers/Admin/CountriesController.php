<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use  App\DataTables\CountryDatatable;

use Illuminate\Http\Request;
use Storage;
use App\Model\Country;


class CountriesController extends Controller
{

    public function index(CountryDatatable $country)
    {
        return $country->render('admin.countries.index',['title'=> trans('admin.countries')]);
    }


    public function create()
    {
        return view('admin.countries.create',['title' => trans('admin.create_countries')]);
    }


    public function store()
    {
        $data = $this->validate(request(),[
            'country_name_ar'              => 'required',
            'country_name_en'              => 'required',
            'mob'                          => 'required',
            'code'                         => 'required',
            'logo'                         => 'sometimes|nullable|'.v_image(),

        ],[],[

            'country_name_ar'              => trans('admin.country_name_ar'),
            'country_name_en'             => trans('admin.country_name_en'),
            'mob'          => trans('admin.mob'),
            'code'          => trans('admin.code'),
            'logo'          => trans('admin.logo'),
        ]);

        if(request()->hasFile('logo')){

            // store('settings') كده الداتا هتتخزن ف فولدر اسمه سيتنجس هيتم انشائه
            $data['logo'] = up()->upload([
                //'new_name'          => '',
                'file'              =>'logo',
                'path'              =>'countries',
                'upload_type'       =>'single',
                'delete_file'       =>'',

            ]);
        }


        Country::create($data);
        session()->flash('success', trans('admin.record_added'));
        return redirect(aurl('countries'));
    }


    public function show($id)
    {

    }

    public function edit($id)
    {
        $country = Country::find($id);
        $title = trans('admin.edit');

        return view('admin.countries.edit',compact('country' , 'title'));
    }


    public function update(Request $request, $id)
    {
        $data = $this->validate(request(),[
            'country_name_ar'              => 'required',
            'country_name_en'              => 'required',
            'mob'                          => 'required',
            'code'                         => 'required',
            'logo'                         => 'sometimes|nullable|'.v_image(),

        ],[],[

            'country_name_ar'               => trans('admin.country_name_ar'),
            'country_name_en'               => trans('admin.country_name_en'),
            'mob'                           => trans('admin.mob'),
            'code'                          => trans('admin.code'),
            'logo'                          => trans('admin.logo'),
        ]);

        if(request()->hasFile('logo')){

            // store('settings') كده الداتا هتتخزن ف فولدر اسمه سيتنجس هيتم انشائه
            $data['logo'] = up()->upload([
                //'new_name'          => '',
                'file'              =>'logo',
                'path'              =>'countries',
                'upload_type'       =>'single',
                'delete_file'       =>Country::find($id)->logo,

            ]);
        }


        Country::where('id',$id)->update($data);
        session()->flash('success', trans('admin.updated_record'));
        return redirect(aurl('countries'));
    }


    public function destroy($id)
    {
        $countries = Country::find($id);
        Storage::delete($countries->logo);
        $countries->delete();
        session()->flash('success', trans('admin.deleted_record'));
        return redirect(aurl('countries'));
    }

    public function multi_delete()
    {
        if(is_array(request('item')))
        {
            foreach(request('item') as $id)
            {
                $countries = Country::find($id);
                Storage::delete($countries->logo);
                $countries->delete();
            }
        }else{
            $countries = Country::find(request('item'));
            Storage::delete($countries->logo);
            $countries->delete();
        }

        session()->flash('success', trans('admin.record_deleted'));
        return redirect(aurl('countries'));
    }
}

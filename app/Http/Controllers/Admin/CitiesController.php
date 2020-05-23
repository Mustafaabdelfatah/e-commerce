<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use  App\DataTables\CityDatatable;

use Illuminate\Http\Request;
use Storage;
use App\Model\City;


class CitiesController extends Controller
{

    public function index(CityDatatable $city)
    {
        return $city->render('admin.cities.index',['title'=> trans('admin.countries')]);
    }


    public function create()
    {
        return view('admin.cities.create',['title' => trans('admin.create_cities')]);
    }


    public function store()
    {
        $data = $this->validate(request(),[
            'city_name_ar'              => 'required',
            'city_name_en'              => 'required',
            'country_id'                => 'required|numeric',
        ],[],[

            'city_name_ar'              => trans('admin.city_name_ar'),
            'city_name_en'              => trans('admin.city_name_en'),
            'country_id'                => trans('admin.country_id'),
        ]);

        City::create($data);
        session()->flash('success', trans('admin.record_added'));
        return redirect(aurl('cities'));
    }


    public function show($id)
    {

    }

    public function edit($id)
    {
        $city = City::find($id);
        $title = trans('admin.edit');

        return view('admin.cities.edit',compact('city' , 'title'));
    }


    public function update(Request $request, $id)
    {
        $data = $this->validate(request(),[
            'city_name_ar'              => 'required',
            'city_name_en'              => 'required',
            'country_id'                => 'required|numeric',
        ],[],[

            'city_name_ar'               => trans('admin.city_name_ar'),
            'city_name_en'               => trans('admin.city_name_en'),
            'country_id'                 => trans('admin.country_id'),
        ]);

        City::where('id',$id)->update($data);
        session()->flash('success', trans('admin.updated_record'));
        return redirect(aurl('cities'));
    }

    public function destroy($id)
    {
        $cities = City::find($id);
        Storage::delete($cities->logo);
        $cities->delete();
        session()->flash('success', trans('admin.deleted_record'));
        return redirect(aurl('cities'));
    }

    public function multi_delete()
    {
        if(is_array(request('item')))
        {
            foreach(request('item') as $id)
            {
                $cities = City::find($id);
                Storage::delete($cities->logo);
                $cities->delete();
            }
        }else{
            $cities = City::find(request('item'));
            Storage::delete($cities->logo);
            $cities->delete();
        }

        session()->flash('success', trans('admin.record_deleted'));
        return redirect(aurl('cities'));
    }
}

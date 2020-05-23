<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use  App\DataTables\StateDatatable;

use Illuminate\Http\Request;
use Storage;
use App\Model\State;
use App\Model\City;

use Form;

class StatesController extends Controller
{

    public function index(StateDatatable $state)
    {
        return $state->render('admin.states.index',['title'=> trans('admin.states')]);
    }


    public function create()
    {

        if(request()->ajax()){
            if(request()->has('country_id')){

                $select=request()->has('select')?request('select'):'';

                return  Form::select('city_id',City::where('country_id',request('country_id'))->pluck('city_name_'.session('lang'),'id')
                ,$select,
                    ['class'=>'form-control','placeholder'=>'.........']);
            }
        }
        return view('admin.states.create',['title' => trans('admin.create_states')]);
    }


    public function store()
    {
        $data = $this->validate(request(),[
            'state_name_ar'              => 'required',
            'state_name_en'              => 'required',
            'country_id'                 => 'required|numeric',
            'city_id'                    => 'required|numeric',
        ],[],[

            'state_name_ar'              => trans('admin.state_name_ar'),
            'state_name_en'              => trans('admin.state_name_en'),
            'country_id'                => trans('admin.country_id'),
        ]);

        State::create($data);
        session()->flash('success', trans('admin.record_added'));
        return redirect(aurl('states'));
    }


    public function show($id)
    {

    }

    public function edit($id)
    {
        $state = State::find($id);
        $title = trans('admin.edit');

        return view('admin.states.edit',compact('state' , 'title'));
    }


    public function update(Request $request, $id)
    {
        $data = $this->validate(request(),[
            'state_name_ar'              => 'required',
            'state_name_en'              => 'required',
            'country_id'                => 'required|numeric',
        ],[],[

            'state_name_ar'               => trans('admin.state_name_ar'),
            'state_name_en'               => trans('admin.state_name_en'),
            'country_id'                 => trans('admin.country_id'),
            'city_id'                    => 'required|numeric',
        ]);

        State::where('id',$id)->update($data);
        session()->flash('success', trans('admin.updated_record'));
        return redirect(aurl('states'));
    }

    public function destroy($id)
    {
        $state = State::find($id);
        Storage::delete($state->logo);
        $states->delete();
        session()->flash('success', trans('admin.deleted_record'));
        return redirect(aurl('states'));
    }

    public function multi_delete()
    {
        if(is_array(request('item')))
        {
            foreach(request('item') as $id)
            {
                $state = State::find($id);
                Storage::delete($state->logo);
                $state->delete();
            }
        }else{
            $state = State::find(request('item'));
            Storage::delete($state->logo);
            $state->delete();
        }

        session()->flash('success', trans('admin.record_deleted'));
        return redirect(aurl('states'));
    }
}

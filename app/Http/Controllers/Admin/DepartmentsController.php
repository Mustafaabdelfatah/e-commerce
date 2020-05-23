<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use App\Model\Department;


class DepartmentsController extends Controller
{

    public function index()
    {
        return view('admin.departments.index',['title' => trans('admin.departments')]);
    }
    public function create()
    {
        return view('admin.departments.create',['title' => trans('admin.add')]);
    }


    public function store()
    {
        $data = $this->validate(request(),[
            'dep_name-ar'               => 'required',
            'dep_name-en'               => 'required',
            'parent_id'                 => 'sometimes|nullable|numeric',
            'icon'                      => 'sometimes|nullable',
            'description'               => 'sometimes|nullable',
            'keyword'                   => 'sometimes|nullable',
        ],[],[

            'dep_name-ar'               => trans('admin.dep_name_ar'),
            'dep_name-en'               => trans('admin.dep_name_en'),
            'parent_id'                 => trans('admin.parent_id'),
            'icon'                      => trans('admin.icon'),
            'description'               => trans('admin.description'),
            'keyword'                   => trans('admin.keyword'),
        ]);

        Department::create($data);
        session()->flash('success', trans('admin.record_added'));
        return redirect(aurl('departments'));
    }


    public function show($id)
    {

    }

    public function edit($id)
    {
        $city = Department::find($id);
        $title = trans('admin.edit');

        return view('admin.departments.edit',compact('city' , 'title'));
    }


    public function update(Request $request, $id)
    {
        $data = $this->validate(request(),[
            'dep_name-ar'               => 'required',
            'dep_name-en'               => 'required',
            'parent_id'                 => 'sometimes|nullable|numeric',
            'icon'                      => 'sometimes|nullable',
            'description'               => 'sometimes|nullable',
            'keyword'                   => 'sometimes|nullable',
        ],[],[

            'dep_name-ar'               => trans('admin.dep_name_ar'),
            'dep_name-en'               => trans('admin.dep_name_en'),
            'parent_id'                 => trans('admin.parent_id'),
            'icon'                      => trans('admin.icon'),
            'description'               => trans('admin.description'),
            'keyword'                   => trans('admin.keyword'),
        ]);

        Department::where('id',$id)->update($data);
        session()->flash('success', trans('admin.updated_record'));
        return redirect(aurl('departments'));
    }

    public function destroy($id)
    {
        $departments = Department::find($id);
        Storage::delete($departments->logo);
        $departments->delete();
        session()->flash('success', trans('admin.deleted_record'));
        return redirect(aurl('departments'));
    }

    public function multi_delete()
    {
        if(is_array(request('item')))
        {
            foreach(request('item') as $id)
            {
                $departments = Department::find($id);
                Storage::delete($departments->logo);
                $departments->delete();
            }
        }else{
            $departments = Department::find(request('item'));
            Storage::delete($departments->logo);
            $departments->delete();
        }

        session()->flash('success', trans('admin.record_deleted'));
        return redirect(aurl('departments'));
    }
}

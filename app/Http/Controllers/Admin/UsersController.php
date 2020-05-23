<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use  App\DataTables\UsersDatatable;

use Illuminate\Http\Request;

use App\User;


class UsersController extends Controller
{

    public function index(UsersDatatable $admin)
    {
        return $admin->render('admin.users.index',['title'=> trans('admin.users')]);
    }


    public function create()
    {
        return view('admin.users.create',['title' => trans('admin.add')]);
    }


    public function store()
    {
        $data = $this->validate(request(),[
            'name'              => 'required',
            'email'             => 'required|unique:users',
            'password'          => 'required|min:6',
            'level'             => 'required|in:user,company,vendor',

        ],[],[

            'name'              => trans('admin.name'),
            'email'             => trans('admin.email'),
            'password'          => trans('admin.password'),
            'level'             => trans('admin.level'),
        ]);

        $data['password'] = bcrypt(request('password'));

        User::create($data);
        session()->flash('success', trans('admin.record_added'));
        return redirect(aurl('users'));
    }


    public function show($id)
    {

    }

    public function edit($id)
    {
        $user = User::find($id);
        $title = trans('admin.edit');

        return view('admin.users.edit',compact('user' , 'title'));
    }


    public function update(Request $request, $id)
    {
        $data = $this->validate(request(),[
            'name'              => 'required',
            'email'             => 'required|unique:users,email,'.$id,
            'password'          => 'sometimes|nullable|min:6',
            'level'             => 'required',

        ],[],[

            'name'              => trans('admin.name'),
            'email'             => trans('admin.email'),
            'password'          => trans('admin.password'),
            'level'             => trans('admin.level'),
        ]);

        if(request()->has('password')){

            $data['password'] = bcrypt(request('password'));
        }

        User::where('id',$id)->update($data);
        session()->flash('success', trans('admin.record_updated'));
        return redirect(aurl('users'));
    }


    public function destroy($id)
    {
        $del = User::find($id);
        $del->delete();
        session()->flash('success', trans('admin.record_deleted'));
        return redirect(aurl('users'));
    }

    public function multi_delete()
    {
        if(is_array(request('item')))
        {
            User::destroy(request('item'));
        }else{
            User::find(request('item'))->delete() ;
        }

        session()->flash('success', trans('admin.record_deleted'));
        return redirect(aurl('admin'));
    }
}

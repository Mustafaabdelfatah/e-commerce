<?php

namespace App\Http\Controllers;

use Storage;

//use Illuminate\Http\Request;
/*
        'name',
        'size',
        'file',
        'path',
        'full_file',
        'mime_type',
        'file_type',
        'relation_id'
        $request,$path,$upload_type='single',$delete_file=null,$new_name = null,$crud_type=[]
*/
class Upload extends Controller {

    public function upload($data=[]){

        if(in_array('new_name',$data))
        {
            $new_name = $data['new_name'] === null ? time() : $new_name;
        }

        if(request()->hasFile($data['file']) && $data['upload_type'] == 'single'){
            Storage::has($data['delete_file'])?Storage::delete($data['delete_file']):'';
            return request()->file($data['file'])->store($data['path']);
        }
    }

}

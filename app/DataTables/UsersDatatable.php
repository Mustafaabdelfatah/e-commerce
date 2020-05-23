<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Services\DataTable;

class UsersDatatable extends DataTable
{

    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('edit', 'admin.users.btn.edit')
            ->addColumn('checkbox', 'admin.users.btn.checkbox')
            ->addColumn('delete', 'admin.users.btn.delete')
            ->addColumn('level', 'admin.users.btn.level')
            ->rawColumns([
                'edit',
                'delete',
                'checkbox',
                'levels',
            ]);
    }


    public function query(){

       return User::query()->where(function($query){
        if(request()->has('level'))
        {
            //dd($q);
            //return $query()->where('level' , request('level'));
        }

       });
    }

    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->addAction(['width' => '80px'])
                    //->parameters($this->getBuilderParameters());
                    ->parameters([
                        'dom' => 'Blfrtip',
                        'lengthMenu'    =>[[10,25,50,100],[10,25,50, trans('admin.all_record')]],
                        'buttons'       =>[
                            [
                                'text' => '<i class="fa fa-plus"></i> '.trans('admin.add'),
                                'className'=>'btn btn-info', 'action' => "function(){
                                    window.location.href = '".\URL::CURRENT()."/create'
                                }"
                            ],
                            ['extend'=>'print','className'=>'btn btn-primary','text'=>'<i class="fa fa-print"></i> '.trans('admin.print')],
                            ['extend'=>'csv','className'=>'btn btn-info','text'=>'<i class="fa fa-file"></i > '.trans('admin.ex_csv')],
                            ['extend'=>'excel','className'=>'btn btn-success','text'=>'<i class="fa fa-file"></i> '.trans('admin.ex_excel')],
                            ['extend'=>'reload','className'=>'btn btn-default','text'=>'<i class="fa fa-refresh"></i>'],
                            ['text'  => '<i class="fa fa-trash"></i> '.trans('admin.delete_all'),'className'=>'btn btn-danger delBtn'],

                        ],


                        'initComplete' => ' function () {
                            this.api().columns([2,3]).every(function () {
                                var column = this;
                                var input = document.createElement("input");
                                $(input).appendTo($(column.footer()).empty())
                                .on(\'keyup\', function () {
                                    column.search($(this).val(), false, false, true).draw();
                                });
                            });
                        }',

                        'language' => datatable_lang(),

                    ]);
    }


    protected function getColumns()
    {
        return [
            [
                'name'  => 'checkbox',
                'data'  => 'checkbox',
                'title' => '<input type="checkbox" class="check_all" onclick="check_all()" />',
                'expostable'    => false,
                'printable'    => false,
                'orderable'    => false,
                'searchable'    => false,
            ],
            [
                'name'  => 'id',
                'data'  => 'id',
                'title' => '#',
            ],
            [
                'name'  => 'name',
                'data'  => 'name',
                'title' =>  trans('admin.name'),

            ],
            [
                'name'  => 'email',
                'data'  => 'email',
                'title' =>  trans('admin.email'),

            ],
            [
                'name'  => 'level',
                'data'  => 'level',
                'title' =>  trans('admin.level'),

            ],
            [
                'name'  => 'created_at',
                'data'  => 'created_at',
                'title' =>  trans('admin.created_at'),
            ],
            [
                'name'  => 'updated_at',
                'data'  => 'updated_at',
                'title' =>  trans('admin.updated_at'),
            ],
            [
                'name'          => 'edit',
                'data'          => 'edit',
                'title'         => trans('admin.edit'),
                'expostable'    => false,
                'printable'    => false,
                'orderable'    => false,
                'searchable'    => false,
            ],
            [
                'name'          => 'delete',
                'data'          => 'delete',
                'title'         => trans('admin.delete'),
                'expostable'    => false,
                'printable'    => false,
                'orderable'    => false,
                'searchable'    => false,
            ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Users_' . date('YmdHis');
    }
}

<?php

namespace App\DataTables;

use App\Admin;
use Yajra\DataTables\Services\DataTable;

class AdminDatatable extends DataTable
{

    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('edit', 'admin.admins.btn.edit')
            ->addColumn('checkbox', 'admin.admins.btn.checkbox')
            ->addColumn('delete', 'admin.admins.btn.delete')
            ->rawColumns([
                'edit',
                'delete',
                'checkbox'
            ]);
    }


    public function query()
    {
       return Admin::query();
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
                                'text' => '<i class="fa fa-plus"></i> '.trans('admin.create_admin'),
                                'className'=>'btn btn-info', 'action' => "function(){
                                    window.location.href = '".\URL::CURRENT()."/create'
                                }"
                            ],
                            ['extend'=>'print','className'=>'btn btn-primary','text'=>'<i class="fa fa-print"></i> '.trans('admin.print')],
                            ['extend'=>'csv','className'=>'btn btn-info','text'=>'<i class="fa fa-file"></i > '.trans('admin.export_csv')],
                            ['extend'=>'excel','className'=>'btn btn-success','text'=>'<i class="fa fa-file"></i> '.trans('admin.export_excel')],
                            ['extend'=>'reload','className'=>'btn btn-default','text'=>'<i class="fa fa-refresh"></i>'],
                            ['text'  => '<i class="fa fa-trash"></i> '.trans('admin.delete_all'),'className'=>'btn btn-danger delBtn'],

                        ],


                        'initComplete' => ' function () {
                            this.api().columns([2,3,4]).every(function () {
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
                'title' =>   trans('admin.admin_name'),

            ],
            [
                'name'  => 'email',
                'data'  => 'email',
                'title' =>   trans('admin.admin_email'),

            ],
            [
                'name'  => 'created_at',
                'data'  => 'created_at',
                'title' =>   trans('admin.created_at'),
            ],
            [
                'name'  => 'updated_at',
                'data'  => 'updated_at',
                'title' =>   trans('admin.updated_at'),
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
        return 'Admin_' . date('YmdHis');
    }
}

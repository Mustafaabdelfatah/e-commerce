@extends('admin.index')
@section('content')
<div class="box">
    <div class="box-header">
        <h3 class="box-title">{{ $title }}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    {!! Form::open(['id'=>'form_data','url'=>aurl('countries/destroy/all'),'method' => 'delete']) !!}
        {!! $dataTable->table(['class'=>'dataTable table table-striped table-bordered table-hover'], true) !!}
    {!! Form::close()!!}
    </div>
    <!-- /.box-body -->
</div>

<div class="modal fade" id="multipleDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ trans('admin.delete_all')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger">
            <div class="empty_record hidden">
                <h3>{{ trans('admin.please_check_some_records') }}</h3>
            </div>
            <div class="no_empty_record hidden">
                <h3>{{ trans('admin.ask_delete_item') }} <span class="record_count"></span> ? </h3>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="empty_record hidden">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin.close') }}</button>
        </div>
        <div class="no_empty_record hidden">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin.no') }}</button>
            <input type="submit" name="del_all" value="{{ trans('admin.yes') }}" class="btn btn-danger del_all" onsubmit="">
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<!--
<div class="modal fade" id="multipleDelete" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times</button>
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             </div>
        </div>
    </div>
</div>
-->
@push('js')
<script>
    delete_all();

</script>
{!! $dataTable->scripts() !!}
@endpush

@endsection

<!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#del_admin{{ $id }}">
  <i class="fa fa-trash"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="del_admin{{ $id }}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle">{{ trans('admin.delete') }}</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        {!! Form::open(['route' => ['cities.destroy',$id], 'method' => 'delete']) !!}
            <div class="modal-body">
            <h4> {{ trans('admin.delete_this',['name' => session('lang') == 'ar'?$city_name_ar:$city_name_en])}} </h4>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('admin.close')}}</button>
            <input type="submit" value="{{ trans('admin.yes') }}" class="btn btn-danger" onsubmit="">
            </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>

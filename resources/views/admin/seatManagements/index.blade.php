@extends('layouts.admin', ['adminIndexTitle' => trans('cruds.seatManagement.title'), 'adminIndexCount' => count($seatManagements)])

@section('indexActions')
@can('seat_management_create')
    <a class="btn index-add" href="{{ route('admin.seat-managements.create') }}">
        <i class="fas fa-plus" aria-hidden="true"></i>
        {{ trans('global.add') }} {{ trans('cruds.seatManagement.title_singular') }}
    </a>
    <button type="button" class="btn index-import" data-toggle="modal" data-target="#csvImportModal">
        <i class="fas fa-file-upload" aria-hidden="true"></i>
        {{ trans('global.app_csvImport') }}
    </button>
    @include('csvImport.modal', ['model' => 'SeatManagement', 'route' => 'admin.seat-managements.parseCsvImport'])
@endcan
@endsection

@section('content')
            <table class="table table-hover datatable datatable-SeatManagement">
                <thead>
                    <tr>
                        <th scope="col" class="index-selection"><span class="sr-only">Select rows</span></th>
                        <th scope="col">
                            {{ trans('cruds.seatManagement.fields.id') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.seatManagement.fields.venue') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.seatManagement.fields.name') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.seatManagement.fields.rows') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.seatManagement.fields.columns') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.seatManagement.fields.status') }}
                        </th>
                        <th scope="col" class="index-row-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seatManagements as $key => $seatManagement)
                        <tr data-entry-id="{{ $seatManagement->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $seatManagement->id ?? '' }}
                            </td>
                            <td>
                                {{ $seatManagement->venue->name ?? '' }}
                            </td>
                            <td>
                                {{ $seatManagement->name ?? '' }}
                            </td>
                            <td>
                                {{ $seatManagement->rows ?? '' }}
                            </td>
                            <td>
                                {{ $seatManagement->columns ?? '' }}
                            </td>
                            <td>
                                <span class="index-status" data-status="{{ $seatManagement->status }}">{{ App\Models\SeatManagement::STATUS_SELECT[$seatManagement->status] ?? '?' }}</span>
                            </td>
                            <td class="index-row-actions">
                                @can('seat_management_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.seat-managements.show', $seatManagement->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('seat_management_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.seat-managements.edit', $seatManagement->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('seat_management_delete')
                                    <form action="{{ route('admin.seat-managements.destroy', $seatManagement->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
@endsection

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('seat_management_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.seat-managements.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-SeatManagement:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
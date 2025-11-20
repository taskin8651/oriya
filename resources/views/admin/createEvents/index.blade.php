@extends('layouts.admin')
@section('content')
@can('create_event_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.create-events.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.createEvent.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'CreateEvent', 'route' => 'admin.create-events.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.createEvent.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-CreateEvent">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.createEvent.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.createEvent.fields.venue') }}
                        </th>
                        <th>
                            {{ trans('cruds.createEvent.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.createEvent.fields.poster') }}
                        </th>
                        <th>
                            {{ trans('cruds.createEvent.fields.duration') }}
                        </th>
                        <th>
                            {{ trans('cruds.createEvent.fields.language') }}
                        </th>
                        <th>
                            {{ trans('cruds.createEvent.fields.age') }}
                        </th>
                        <th>
                            {{ trans('cruds.createEvent.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.createEvent.fields.seat') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($createEvents as $key => $createEvent)
                        <tr data-entry-id="{{ $createEvent->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $createEvent->id ?? '' }}
                            </td>
                            <td>
                                {{ $createEvent->venue->name ?? '' }}
                            </td>
                            <td>
                                {{ $createEvent->title ?? '' }}
                            </td>
                            <td>
                                @if($createEvent->poster)
                                    <a href="{{ $createEvent->poster->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $createEvent->poster->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $createEvent->duration ?? '' }}
                            </td>
                            <td>
                                {{ $createEvent->language ?? '' }}
                            </td>
                            <td>
                                {{ $createEvent->age ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\CreateEvent::STATUS_SELECT[$createEvent->status] ?? '' }}
                            </td>
                            <td>
                                {{ $createEvent->seat->name ?? '' }}
                            </td>
                            <td>
                                @can('create_event_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.create-events.show', $createEvent->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('create_event_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.create-events.edit', $createEvent->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('create_event_delete')
                                    <form action="{{ route('admin.create-events.destroy', $createEvent->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('create_event_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.create-events.massDestroy') }}",
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
  let table = $('.datatable-CreateEvent:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
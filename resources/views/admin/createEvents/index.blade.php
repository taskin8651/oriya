@extends('layouts.admin', ['adminIndexTitle' => trans('cruds.createEvent.title'), 'adminIndexCount' => count($createEvents)])

@section('indexActions')
@can('create_event_create')
    <a class="btn index-add" href="{{ route('admin.create-events.create') }}">
        <i class="fas fa-plus" aria-hidden="true"></i>
        {{ trans('global.add') }} {{ trans('cruds.createEvent.title_singular') }}
    </a>
    <button type="button" class="btn index-import" data-toggle="modal" data-target="#csvImportModal">
        <i class="fas fa-file-upload" aria-hidden="true"></i>
        {{ trans('global.app_csvImport') }}
    </button>
    @include('csvImport.modal', ['model' => 'CreateEvent', 'route' => 'admin.create-events.parseCsvImport'])
@endcan
@endsection

@section('content')
            <table class="table table-hover datatable datatable-CreateEvent">
                <thead>
                    <tr>
                        <th scope="col" class="index-selection"><span class="sr-only">Select rows</span></th>
                        <th scope="col">
                            {{ trans('cruds.createEvent.fields.id') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.createEvent.fields.venue') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.createEvent.fields.title') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.createEvent.fields.poster') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.createEvent.fields.duration') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.createEvent.fields.language') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.createEvent.fields.age') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.createEvent.fields.status') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.createEvent.fields.seat') }}
                        </th>
                        <th scope="col" class="index-row-actions">Actions</th>
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
                                <span class="index-status" data-status="{{ $createEvent->status }}">{{ App\Models\CreateEvent::STATUS_SELECT[$createEvent->status] ?? '?' }}</span>
                            </td>
                            <td>
                                {{ $createEvent->seat->name ?? '' }}
                            </td>
                            <td class="index-row-actions">
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
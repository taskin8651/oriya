@extends('layouts.admin', ['adminIndexTitle' => trans('cruds.venue.title'), 'adminIndexCount' => count($venues)])

@section('indexActions')
@can('venue_create')
    <a class="btn index-add" href="{{ route('admin.venues.create') }}">
        <i class="fas fa-plus" aria-hidden="true"></i>
        {{ trans('global.add') }} {{ trans('cruds.venue.title_singular') }}
    </a>
    <button type="button" class="btn index-import" data-toggle="modal" data-target="#csvImportModal">
        <i class="fas fa-file-upload" aria-hidden="true"></i>
        {{ trans('global.app_csvImport') }}
    </button>
    @include('csvImport.modal', ['model' => 'Venue', 'route' => 'admin.venues.parseCsvImport'])
@endcan
@endsection

@section('content')
            <table class="table table-hover datatable datatable-Venue">
                <thead>
                    <tr>
                        <th scope="col" class="index-selection"><span class="sr-only">Select rows</span></th>
                        <th scope="col">
                            {{ trans('cruds.venue.fields.id') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.venue.fields.name') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.venue.fields.address') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.venue.fields.city') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.venue.fields.state') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.venue.fields.pincode') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.venue.fields.status') }}
                        </th>
                        <th scope="col" class="index-row-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($venues as $key => $venue)
                        <tr data-entry-id="{{ $venue->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $venue->id ?? '' }}
                            </td>
                            <td>
                                {{ $venue->name ?? '' }}
                            </td>
                            <td>
                                {{ $venue->address ?? '' }}
                            </td>
                            <td>
                                {{ $venue->city ?? '' }}
                            </td>
                            <td>
                                {{ $venue->state ?? '' }}
                            </td>
                            <td>
                                {{ $venue->pincode ?? '' }}
                            </td>
                            <td>
                                <span class="index-status" data-status="{{ $venue->status }}">{{ App\Models\Venue::STATUS_SELECT[$venue->status] ?? '?' }}</span>
                            </td>
                            <td class="index-row-actions">
                                @can('venue_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.venues.show', $venue->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('venue_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.venues.edit', $venue->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('venue_delete')
                                    <form action="{{ route('admin.venues.destroy', $venue->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('venue_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.venues.massDestroy') }}",
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
  let table = $('.datatable-Venue:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
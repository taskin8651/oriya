@extends('layouts.admin', ['adminIndexTitle' => trans('cruds.epaper.title'), 'adminIndexCount' => count($epapers)])

@section('indexActions')
@can('epaper_create')
    <a class="btn index-add" href="{{ route('admin.epapers.create') }}">
        <i class="fas fa-plus" aria-hidden="true"></i>
        {{ trans('global.add') }} {{ trans('cruds.epaper.title_singular') }}
    </a>
    <button type="button" class="btn index-import" data-toggle="modal" data-target="#csvImportModal">
        <i class="fas fa-file-upload" aria-hidden="true"></i>
        {{ trans('global.app_csvImport') }}
    </button>
    @include('csvImport.modal', ['model' => 'Epaper', 'route' => 'admin.epapers.parseCsvImport'])
@endcan
@endsection

@section('content')
            <table class="table table-hover datatable datatable-Epaper">
                <thead>
                    <tr>
                        <th scope="col" class="index-selection"><span class="sr-only">Select rows</span></th>
                        <th scope="col">
                            {{ trans('cruds.epaper.fields.id') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.epaper.fields.title') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.epaper.fields.description') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.epaper.fields.publication_date') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.epaper.fields.pdf_file') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.epaper.fields.cover_image') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.epaper.fields.edition') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.epaper.fields.url') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.epaper.fields.status') }}
                        </th>
                        <th scope="col" class="index-row-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($epapers as $key => $epaper)
                        <tr data-entry-id="{{ $epaper->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $epaper->id ?? '' }}
                            </td>
                            <td>
                                {{ $epaper->title ?? '' }}
                            </td>
                            <td>
                                {{ $epaper->description ?? '' }}
                            </td>
                            <td>
                                {{ $epaper->publication_date ?? '' }}
                            </td>
                            <td>
                                @if($epaper->pdf_file)
                                    <a href="{{ $epaper->pdf_file->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($epaper->cover_image)
                                    <a href="{{ $epaper->cover_image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $epaper->cover_image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $epaper->edition ?? '' }}
                            </td>
                            <td>
                                {{ $epaper->url ?? '' }}
                            </td>
                            <td>
                                <span class="index-status" data-status="{{ $epaper->status }}">{{ App\Models\Epaper::STATUS_SELECT[$epaper->status] ?? '?' }}</span>
                            </td>
                            <td class="index-row-actions">
                                @can('epaper_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.epapers.show', $epaper->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('epaper_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.epapers.edit', $epaper->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('epaper_delete')
                                    <form action="{{ route('admin.epapers.destroy', $epaper->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('epaper_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.epapers.massDestroy') }}",
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
  let table = $('.datatable-Epaper:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
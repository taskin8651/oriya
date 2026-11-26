@extends('layouts.admin', ['adminIndexTitle' => trans('cruds.gallery.title'), 'adminIndexCount' => count($galleries)])

@section('indexActions')
@can('gallery_create')
    <a class="btn index-add" href="{{ route('admin.galleries.create') }}">
        <i class="fas fa-plus" aria-hidden="true"></i>
        {{ trans('global.add') }} {{ trans('cruds.gallery.title_singular') }}
    </a>
    <button type="button" class="btn index-import" data-toggle="modal" data-target="#csvImportModal">
        <i class="fas fa-file-upload" aria-hidden="true"></i>
        {{ trans('global.app_csvImport') }}
    </button>
    @include('csvImport.modal', ['model' => 'Gallery', 'route' => 'admin.galleries.parseCsvImport'])
@endcan
@endsection

@section('content')
            <table class="table table-hover datatable datatable-Gallery">
                <thead>
                    <tr>
                        <th scope="col" class="index-selection"><span class="sr-only">Select rows</span></th>
                        <th scope="col">
                            {{ trans('cruds.gallery.fields.id') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.gallery.fields.title') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.gallery.fields.upload_file') }}
                        </th>
                        <th scope="col" class="index-row-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($galleries as $key => $gallery)
                        <tr data-entry-id="{{ $gallery->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $gallery->id ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Gallery::TITLE_SELECT[$gallery->title] ?? '' }}
                            </td>
                            <td>
                                @if($gallery->upload_file)
                                    <a href="{{ $gallery->upload_file->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td class="index-row-actions">
                                @can('gallery_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.galleries.show', $gallery->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('gallery_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.galleries.edit', $gallery->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('gallery_delete')
                                    <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('gallery_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.galleries.massDestroy') }}",
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
  let table = $('.datatable-Gallery:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
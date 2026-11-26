@extends('layouts.admin', ['adminIndexTitle' => trans('cruds.headerLogo.title'), 'adminIndexCount' => count($headerLogos)])

@section('indexActions')
@can('header_logo_create')
    <a class="btn index-add" href="{{ route('admin.header-logos.create') }}">
        <i class="fas fa-plus" aria-hidden="true"></i>
        {{ trans('global.add') }} {{ trans('cruds.headerLogo.title_singular') }}
    </a>
    <button type="button" class="btn index-import" data-toggle="modal" data-target="#csvImportModal">
        <i class="fas fa-file-upload" aria-hidden="true"></i>
        {{ trans('global.app_csvImport') }}
    </button>
    @include('csvImport.modal', ['model' => 'HeaderLogo', 'route' => 'admin.header-logos.parseCsvImport'])
@endcan
@endsection

@section('content')
            <table class="table table-hover datatable datatable-HeaderLogo">
                <thead>
                    <tr>
                        <th scope="col" class="index-selection"><span class="sr-only">Select rows</span></th>
                        <th scope="col">
                            {{ trans('cruds.headerLogo.fields.id') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.headerLogo.fields.title') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.headerLogo.fields.upload_image') }}
                        </th>
                        <th scope="col" class="index-row-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($headerLogos as $key => $headerLogo)
                        <tr data-entry-id="{{ $headerLogo->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $headerLogo->id ?? '' }}
                            </td>
                            <td>
                                {{ $headerLogo->title ?? '' }}
                            </td>
                            <td>
                                @if($headerLogo->upload_image)
                                    <a href="{{ $headerLogo->upload_image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $headerLogo->upload_image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td class="index-row-actions">
                                @can('header_logo_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.header-logos.show', $headerLogo->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('header_logo_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.header-logos.edit', $headerLogo->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('header_logo_delete')
                                    <form action="{{ route('admin.header-logos.destroy', $headerLogo->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('header_logo_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.header-logos.massDestroy') }}",
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
  let table = $('.datatable-HeaderLogo:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
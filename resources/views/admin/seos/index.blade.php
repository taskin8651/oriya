@extends('layouts.admin', ['adminIndexTitle' => trans('cruds.seo.title'), 'adminIndexCount' => count($seos)])

@section('indexActions')
@can('seo_create')
    <a class="btn index-add" href="{{ route('admin.seos.create') }}">
        <i class="fas fa-plus" aria-hidden="true"></i>
        {{ trans('global.add') }} {{ trans('cruds.seo.title_singular') }}
    </a>
    <button type="button" class="btn index-import" data-toggle="modal" data-target="#csvImportModal">
        <i class="fas fa-file-upload" aria-hidden="true"></i>
        {{ trans('global.app_csvImport') }}
    </button>
    @include('csvImport.modal', ['model' => 'Seo', 'route' => 'admin.seos.parseCsvImport'])
@endcan
@endsection

@section('content')
            <table class="table table-hover datatable datatable-Seo">
                <thead>
                    <tr>
                        <th scope="col" class="index-selection"><span class="sr-only">Select rows</span></th>
                        <th scope="col">
                            {{ trans('cruds.seo.fields.id') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.seo.fields.meta_tags') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.seo.fields.keywords') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.seo.fields.social_share_image') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.seo.fields.description') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.seo.fields.seo_title') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.seo.fields.og_type') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.seo.fields.canonical_url') }}
                        </th>
                        <th scope="col" class="index-row-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seos as $key => $seo)
                        <tr data-entry-id="{{ $seo->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $seo->id ?? '' }}
                            </td>
                            <td>
                                {{ $seo->meta_tags ?? '' }}
                            </td>
                            <td>
                                {{ $seo->keywords ?? '' }}
                            </td>
                            <td>
                                @if($seo->social_share_image)
                                    <a href="{{ $seo->social_share_image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $seo->social_share_image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $seo->description ?? '' }}
                            </td>
                            <td>
                                {{ $seo->seo_title ?? '' }}
                            </td>
                            <td>
                                {{ $seo->og_type ?? '' }}
                            </td>
                            <td>
                                {{ $seo->canonical_url ?? '' }}
                            </td>
                            <td class="index-row-actions">
                                @can('seo_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.seos.show', $seo->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('seo_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.seos.edit', $seo->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('seo_delete')
                                    <form action="{{ route('admin.seos.destroy', $seo->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('seo_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.seos.massDestroy') }}",
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
  let table = $('.datatable-Seo:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
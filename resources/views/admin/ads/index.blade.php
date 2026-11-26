@extends('layouts.admin', ['adminIndexTitle' => trans('cruds.ad.title'), 'adminIndexCount' => count($ads)])

@section('indexActions')
@can('ad_create')
    <a class="btn index-add" href="{{ route('admin.ads.create') }}">
        <i class="fas fa-plus" aria-hidden="true"></i>
        {{ trans('global.add') }} {{ trans('cruds.ad.title_singular') }}
    </a>
    <button type="button" class="btn index-import" data-toggle="modal" data-target="#csvImportModal">
        <i class="fas fa-file-upload" aria-hidden="true"></i>
        {{ trans('global.app_csvImport') }}
    </button>
    @include('csvImport.modal', ['model' => 'Ad', 'route' => 'admin.ads.parseCsvImport'])
@endcan
@endsection

@section('content')
            <table class="table table-hover datatable datatable-Ad">
                <thead>
                    <tr>
                        <th scope="col" class="index-selection"><span class="sr-only">Select rows</span></th>
                        <th scope="col">
                            {{ trans('cruds.ad.fields.id') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.ad.fields.banner') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.ad.fields.link') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.ad.fields.type') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.ad.fields.start_date') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.ad.fields.end_date') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.ad.fields.status') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.ad.fields.impressions') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.ad.fields.clicks') }}
                        </th>
                        <th scope="col" class="index-row-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ads as $key => $ad)
                        <tr data-entry-id="{{ $ad->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $ad->id ?? '' }}
                            </td>
                            <td>
                                @if($ad->banner)
                                    <a href="{{ $ad->banner->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $ad->banner->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $ad->link ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Ad::TYPE_SELECT[$ad->type] ?? '' }}
                            </td>
                            <td>
                                {{ $ad->start_date ?? '' }}
                            </td>
                            <td>
                                {{ $ad->end_date ?? '' }}
                            </td>
                            <td>
                                <span class="index-status" data-status="{{ $ad->status }}">{{ App\Models\Ad::STATUS_SELECT[$ad->status] ?? '?' }}</span>
                            </td>
                            <td>
                                {{ $ad->impressions ?? '' }}
                            </td>
                            <td>
                                {{ $ad->clicks ?? '' }}
                            </td>
                            <td class="index-row-actions">
                                @can('ad_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.ads.show', $ad->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('ad_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.ads.edit', $ad->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('ad_delete')
                                    <form action="{{ route('admin.ads.destroy', $ad->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('ad_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.ads.massDestroy') }}",
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
  let table = $('.datatable-Ad:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
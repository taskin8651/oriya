@extends('layouts.admin', ['adminIndexTitle' => trans('cruds.breakingNews.title'), 'adminIndexCount' => count($breakingNewss)])

@section('indexActions')
@can('breaking_news_create')
    <a class="btn index-add" href="{{ route('admin.breaking-newss.create') }}">
        <i class="fas fa-plus" aria-hidden="true"></i>
        {{ trans('global.add') }} {{ trans('cruds.breakingNews.title_singular') }}
    </a>
    <button type="button" class="btn index-import" data-toggle="modal" data-target="#csvImportModal">
        <i class="fas fa-file-upload" aria-hidden="true"></i>
        {{ trans('global.app_csvImport') }}
    </button>
    @include('csvImport.modal', ['model' => 'BreakingNews', 'route' => 'admin.breaking-newss.parseCsvImport'])
@endcan
@endsection

@section('content')
            <table class="table table-hover datatable datatable-BreakingNews">
                <thead>
                    <tr>
                        <th scope="col" class="index-selection"><span class="sr-only">Select rows</span></th>
                        <th scope="col">
                            {{ trans('cruds.breakingNews.fields.id') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.breakingNews.fields.title') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.breakingNews.fields.status') }}
                        </th>
                        <th scope="col" class="index-row-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($breakingNewss as $key => $breakingNews)
                        <tr data-entry-id="{{ $breakingNews->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $breakingNews->id ?? '' }}
                            </td>
                            <td>
                                {{ $breakingNews->title ?? '' }}
                            </td>
                            <td>
                                <span class="index-status" data-status="{{ $breakingNews->status }}">{{ App\Models\BreakingNews::STATUS_SELECT[$breakingNews->status] ?? '?' }}</span>
                            </td>
                            <td class="index-row-actions">
                                @can('breaking_news_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.breaking-newss.show', $breakingNews->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('breaking_news_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.breaking-newss.edit', $breakingNews->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('breaking_news_delete')
                                    <form action="{{ route('admin.breaking-newss.destroy', $breakingNews->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('breaking_news_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.breaking-newss.massDestroy') }}",
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
  let table = $('.datatable-BreakingNews:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
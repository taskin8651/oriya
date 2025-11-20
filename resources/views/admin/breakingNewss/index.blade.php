@extends('layouts.admin')
@section('content')
@can('breaking_news_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.breaking-newss.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.breakingNews.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'BreakingNews', 'route' => 'admin.breaking-newss.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.breakingNews.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-BreakingNews">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.breakingNews.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.breakingNews.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.breakingNews.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
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
                                {{ App\Models\BreakingNews::STATUS_SELECT[$breakingNews->status] ?? '' }}
                            </td>
                            <td>
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
        </div>
    </div>
</div>



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
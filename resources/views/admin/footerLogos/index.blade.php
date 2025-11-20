@extends('layouts.admin')
@section('content')
@can('footer_logo_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.footer-logos.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.footerLogo.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'FooterLogo', 'route' => 'admin.footer-logos.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.footerLogo.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-FooterLogo">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.footerLogo.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.footerLogo.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.footerLogo.fields.upload_image') }}
                        </th>
                        <th>
                            {{ trans('cruds.footerLogo.fields.description') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($footerLogos as $key => $footerLogo)
                        <tr data-entry-id="{{ $footerLogo->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $footerLogo->id ?? '' }}
                            </td>
                            <td>
                                {{ $footerLogo->title ?? '' }}
                            </td>
                            <td>
                                @if($footerLogo->upload_image)
                                    <a href="{{ $footerLogo->upload_image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $footerLogo->upload_image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $footerLogo->description ?? '' }}
                            </td>
                            <td>
                                @can('footer_logo_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.footer-logos.show', $footerLogo->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('footer_logo_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.footer-logos.edit', $footerLogo->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('footer_logo_delete')
                                    <form action="{{ route('admin.footer-logos.destroy', $footerLogo->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('footer_logo_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.footer-logos.massDestroy') }}",
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
  let table = $('.datatable-FooterLogo:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
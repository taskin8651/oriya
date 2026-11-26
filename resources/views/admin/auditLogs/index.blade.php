@extends('layouts.admin', ['adminIndexTitle' => trans('cruds.auditLog.title'), 'adminIndexCount' => count($auditLogs)])

@section('content')
            <table class="table table-hover datatable datatable-AuditLog">
                <thead>
                    <tr>
                        <th scope="col" class="index-selection"><span class="sr-only">Select rows</span></th>
                        <th scope="col">
                            {{ trans('cruds.auditLog.fields.id') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.auditLog.fields.description') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.auditLog.fields.subject_id') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.auditLog.fields.subject_type') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.auditLog.fields.user_id') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.auditLog.fields.host') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.auditLog.fields.created_at') }}
                        </th>
                        <th scope="col" class="index-row-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($auditLogs as $key => $auditLog)
                        <tr data-entry-id="{{ $auditLog->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $auditLog->id ?? '' }}
                            </td>
                            <td>
                                {{ $auditLog->description ?? '' }}
                            </td>
                            <td>
                                {{ $auditLog->subject_id ?? '' }}
                            </td>
                            <td>
                                {{ $auditLog->subject_type ?? '' }}
                            </td>
                            <td>
                                {{ $auditLog->user_id ?? '' }}
                            </td>
                            <td>
                                {{ $auditLog->host ?? '' }}
                            </td>
                            <td>
                                {{ $auditLog->created_at ?? '' }}
                            </td>
                            <td class="index-row-actions">
                                @can('audit_log_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.audit-logs.show', $auditLog->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
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
  
  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-AuditLog:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
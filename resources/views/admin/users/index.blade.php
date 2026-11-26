@extends('layouts.admin', ['adminIndexTitle' => trans('cruds.user.title'), 'adminIndexCount' => count($users)])

@section('indexActions')
@can('user_create')
    <a class="btn index-add" href="{{ route('admin.users.create') }}">
        <i class="fas fa-plus" aria-hidden="true"></i>
        {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
    </a>
    <button type="button" class="btn index-import" data-toggle="modal" data-target="#csvImportModal">
        <i class="fas fa-file-upload" aria-hidden="true"></i>
        {{ trans('global.app_csvImport') }}
    </button>
    @include('csvImport.modal', ['model' => 'User', 'route' => 'admin.users.parseCsvImport'])
@endcan
@endsection

@section('content')
            <table class="table table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th scope="col" class="index-selection"><span class="sr-only">Select rows</span></th>
                        <th scope="col">
                            {{ trans('cruds.user.fields.id') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.user.fields.email_verified_at') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.user.fields.roles') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.user.fields.profile') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.user.fields.number') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.user.fields.bio') }}
                        </th>
                        <th scope="col" class="index-row-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                        <tr data-entry-id="{{ $user->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $user->id ?? '' }}
                            </td>
                            <td>
                                {{ $user->name ?? '' }}
                            </td>
                            <td>
                                {{ $user->email ?? '' }}
                            </td>
                            <td>
                                {{ $user->email_verified_at ?? '' }}
                            </td>
                            <td>
                                @foreach($user->roles as $key => $item)
                                    <span class="badge badge-info">{{ $item->title }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if($user->profile)
                                    <a href="{{ $user->profile->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $user->profile->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $user->number ?? '' }}
                            </td>
                            <td>
                                {{ $user->bio ?? '' }}
                            </td>
                            <td class="index-row-actions">
                                @can('user_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.users.show', $user->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('user_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.users.edit', $user->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('user_delete')
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.users.massDestroy') }}",
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
  let table = $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
@extends('layouts.admin', ['adminIndexTitle' => trans('cruds.post.title'), 'adminIndexCount' => count($posts)])

@section('indexActions')
@can('post_create')
    <a class="btn index-add" href="{{ route('admin.posts.create') }}">
        <i class="fas fa-plus" aria-hidden="true"></i>
        {{ trans('global.add') }} {{ trans('cruds.post.title_singular') }}
    </a>
    <button type="button" class="btn index-import" data-toggle="modal" data-target="#csvImportModal">
        <i class="fas fa-file-upload" aria-hidden="true"></i>
        {{ trans('global.app_csvImport') }}
    </button>
    @include('csvImport.modal', ['model' => 'Post', 'route' => 'admin.posts.parseCsvImport'])
@endcan
@endsection

@section('content')
            <table class="table table-hover datatable datatable-Post">
                <thead>
                    <tr>
                        <th scope="col" class="index-selection"><span class="sr-only">Select rows</span></th>
                        <th scope="col">
                            {{ trans('cruds.post.fields.id') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.post.fields.title') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.post.fields.slug') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.post.fields.short_description') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.post.fields.image') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.post.fields.category') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.post.fields.author') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.post.fields.tag') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.post.fields.status') }}
                        </th>
                        <th scope="col">
                            {{ trans('cruds.post.fields.view') }}
                        </th>
                        <th scope="col" class="index-row-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $key => $post)
                        <tr data-entry-id="{{ $post->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $post->id ?? '' }}
                            </td>
                            <td>
                                {{ $post->title ?? '' }}
                            </td>
                            <td>
                                {{ $post->slug ?? '' }}
                            </td>
                            <td>
                                {{ $post->short_description ?? '' }}
                            </td>
                            <td>
                                @if($post->image)
                                    <a href="{{ $post->image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $post->image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $post->category->name ?? '' }}
                            </td>
                            <td>
                                {{ $post->author->name ?? '' }}
                            </td>
                            <td>
                                @foreach($post->tags as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <span class="index-status" data-status="{{ $post->status }}">{{ App\Models\Post::STATUS_SELECT[$post->status] ?? '?' }}</span>
                            </td>
                            <td>
                                {{ $post->view ?? '' }}
                            </td>
                            <td class="index-row-actions">
                                @can('post_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.posts.show', $post->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('post_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.posts.edit', $post->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('post_delete')
                                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('post_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.posts.massDestroy') }}",
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
  let table = $('.datatable-Post:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
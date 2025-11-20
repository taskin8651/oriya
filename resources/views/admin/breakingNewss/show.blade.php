@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.breakingNews.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.breaking-newss.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.breakingNews.fields.id') }}
                        </th>
                        <td>
                            {{ $breakingNews->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.breakingNews.fields.title') }}
                        </th>
                        <td>
                            {{ $breakingNews->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.breakingNews.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\BreakingNews::STATUS_SELECT[$breakingNews->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.breaking-newss.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
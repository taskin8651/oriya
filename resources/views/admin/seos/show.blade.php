@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.seo.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.seos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.seo.fields.id') }}
                        </th>
                        <td>
                            {{ $seo->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seo.fields.meta_tags') }}
                        </th>
                        <td>
                            {{ $seo->meta_tags }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seo.fields.keywords') }}
                        </th>
                        <td>
                            {{ $seo->keywords }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seo.fields.social_share_image') }}
                        </th>
                        <td>
                            @if($seo->social_share_image)
                                <a href="{{ $seo->social_share_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $seo->social_share_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seo.fields.description') }}
                        </th>
                        <td>
                            {{ $seo->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seo.fields.seo_title') }}
                        </th>
                        <td>
                            {{ $seo->seo_title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seo.fields.og_type') }}
                        </th>
                        <td>
                            {{ $seo->og_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seo.fields.canonical_url') }}
                        </th>
                        <td>
                            {{ $seo->canonical_url }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.seos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.headerLogo.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.header-logos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.headerLogo.fields.id') }}
                        </th>
                        <td>
                            {{ $headerLogo->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.headerLogo.fields.title') }}
                        </th>
                        <td>
                            {{ $headerLogo->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.headerLogo.fields.upload_image') }}
                        </th>
                        <td>
                            @if($headerLogo->upload_image)
                                <a href="{{ $headerLogo->upload_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $headerLogo->upload_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.header-logos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
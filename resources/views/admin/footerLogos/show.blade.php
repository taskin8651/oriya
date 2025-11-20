@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.footerLogo.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.footer-logos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.footerLogo.fields.id') }}
                        </th>
                        <td>
                            {{ $footerLogo->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.footerLogo.fields.title') }}
                        </th>
                        <td>
                            {{ $footerLogo->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.footerLogo.fields.upload_image') }}
                        </th>
                        <td>
                            @if($footerLogo->upload_image)
                                <a href="{{ $footerLogo->upload_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $footerLogo->upload_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.footerLogo.fields.description') }}
                        </th>
                        <td>
                            {{ $footerLogo->description }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.footer-logos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
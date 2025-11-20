@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.epaper.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.epapers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.epaper.fields.id') }}
                        </th>
                        <td>
                            {{ $epaper->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.epaper.fields.title') }}
                        </th>
                        <td>
                            {{ $epaper->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.epaper.fields.description') }}
                        </th>
                        <td>
                            {{ $epaper->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.epaper.fields.publication_date') }}
                        </th>
                        <td>
                            {{ $epaper->publication_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.epaper.fields.pdf_file') }}
                        </th>
                        <td>
                            @if($epaper->pdf_file)
                                <a href="{{ $epaper->pdf_file->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.epaper.fields.cover_image') }}
                        </th>
                        <td>
                            @if($epaper->cover_image)
                                <a href="{{ $epaper->cover_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $epaper->cover_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.epaper.fields.edition') }}
                        </th>
                        <td>
                            {{ $epaper->edition }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.epaper.fields.url') }}
                        </th>
                        <td>
                            {{ $epaper->url }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.epaper.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Epaper::STATUS_SELECT[$epaper->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.epapers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
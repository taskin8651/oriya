@extends('layouts.admin')

@php
    $listRoute = 'admin.tags.index';
    $adminForm = [
        'title' => trans('global.edit') . ' ' . trans('cruds.tag.title_singular'),
        'listLabel' => trans('cruds.tag.title'),
        'listRoute' => $listRoute,
        'listUrl' => Gate::allows('tag_access') ? route($listRoute) : null,
    ];
@endphp

@section('content')
        <form class="admin-record-form" method="POST" action="{{ route("admin.tags.update", [$tag->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.tag.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $tag->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.tag.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="slug">{{ trans('cruds.tag.fields.slug') }}</label>
                <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', $tag->slug) }}">
                @if($errors->has('slug'))
                    <div class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.tag.fields.slug_helper') }}</span>
            </div>
            @include('partials.admin-form-actions')
        </form>
@endsection
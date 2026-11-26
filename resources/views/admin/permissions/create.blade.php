@extends('layouts.admin')

@php
    $listRoute = 'admin.permissions.index';
    $adminForm = [
        'title' => trans('global.create') . ' ' . trans('cruds.permission.title_singular'),
        'listLabel' => trans('cruds.permission.title'),
        'listRoute' => $listRoute,
        'listUrl' => Gate::allows('permission_access') ? route($listRoute) : null,
    ];
@endphp

@section('content')
        <form class="admin-record-form" method="POST" action="{{ route("admin.permissions.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.permission.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.permission.fields.title_helper') }}</span>
            </div>
            @include('partials.admin-form-actions')
        </form>
@endsection
@extends('layouts.admin')

@php
    $listRoute = 'admin.roles.index';
    $adminForm = [
        'title' => trans('global.create') . ' ' . trans('cruds.role.title_singular'),
        'listLabel' => trans('cruds.role.title'),
        'listRoute' => $listRoute,
        'listUrl' => Gate::allows('role_access') ? route($listRoute) : null,
    ];
@endphp

@section('content')
        <form class="admin-record-form" method="POST" action="{{ route("admin.roles.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.role.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.role.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="permissions">{{ trans('cruds.role.fields.permissions') }}</label>
                <div style="padding-bottom: 4px">
                    <button type="button" class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</button>
                    <button type="button" class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</button>
                </div>
                <select class="form-control select2 {{ $errors->has('permissions') ? 'is-invalid' : '' }}" name="permissions[]" id="permissions" multiple required>
                    @foreach($permissions as $id => $permission)
                        <option value="{{ $id }}" {{ in_array($id, old('permissions', [])) ? 'selected' : '' }}>{{ $permission }}</option>
                    @endforeach
                </select>
                @if($errors->has('permissions'))
                    <div class="invalid-feedback">
                        {{ $errors->first('permissions') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.role.fields.permissions_helper') }}</span>
            </div>
            @include('partials.admin-form-actions')
        </form>
@endsection
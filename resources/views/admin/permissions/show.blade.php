@extends('layouts.admin-show', ['resource' => 'permission', 'listRoute' => 'admin.permissions.index', 'record' => $permission, 'recordTitle' => $permission->title])

@section('content')
    <x-admin.detail-field :label="trans('cruds.permission.fields.id')">
        {{ $permission->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.permission.fields.title')">
        {{ $permission->title }}
    </x-admin.detail-field>
@endsection

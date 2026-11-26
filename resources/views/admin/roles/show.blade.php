@extends('layouts.admin-show', ['resource' => 'role', 'listRoute' => 'admin.roles.index', 'record' => $role, 'recordTitle' => $role->title])

@section('content')
    <x-admin.detail-field :label="trans('cruds.role.fields.id')">
        {{ $role->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.role.fields.title')">
        {{ $role->title }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.role.fields.permissions')" wide>
        @foreach($role->permissions as $key => $permissions)
            <span class="detail-chip">{{ $permissions->title }}</span>
        @endforeach
    </x-admin.detail-field>
@endsection

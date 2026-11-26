@extends('layouts.admin-show', ['resource' => 'user', 'listRoute' => 'admin.users.index', 'record' => $user, 'recordTitle' => $user->name])

@section('content')
    <x-admin.detail-field :label="trans('cruds.user.fields.id')">
        {{ $user->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.user.fields.name')">
        {{ $user->name }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.user.fields.email')">
        {{ $user->email }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.user.fields.email_verified_at')">
        {{ $user->email_verified_at }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.user.fields.roles')">
        @foreach($user->roles as $key => $roles)
            <span class="detail-chip">{{ $roles->title }}</span>
        @endforeach
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.user.fields.profile')">
        <x-admin.detail-image :media="$user->profile" :label="trans('cruds.user.fields.profile')" />
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.user.fields.number')">
        {{ $user->number }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.user.fields.bio')" wide>
        {{ $user->bio }}
    </x-admin.detail-field>
@endsection

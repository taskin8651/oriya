@extends('layouts.admin-show', ['resource' => 'headerLogo', 'listRoute' => 'admin.header-logos.index', 'record' => $headerLogo, 'recordTitle' => $headerLogo->title])

@section('content')
    <x-admin.detail-field :label="trans('cruds.headerLogo.fields.id')">
        {{ $headerLogo->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.headerLogo.fields.title')">
        {{ $headerLogo->title }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.headerLogo.fields.upload_image')" wide>
        <x-admin.detail-image :media="$headerLogo->upload_image" :label="trans('cruds.headerLogo.fields.upload_image')" />
    </x-admin.detail-field>
@endsection

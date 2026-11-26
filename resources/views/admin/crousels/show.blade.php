@extends('layouts.admin-show', ['resource' => 'crousel', 'listRoute' => 'admin.crousels.index', 'record' => $crousel, 'recordTitle' => $crousel->title])

@section('content')
    <x-admin.detail-field :label="trans('cruds.crousel.fields.id')">
        {{ $crousel->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.crousel.fields.upload_image')" wide>
        <x-admin.detail-image :media="$crousel->upload_image" :label="trans('cruds.crousel.fields.upload_image')" />
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.crousel.fields.title')">
        {{ $crousel->title }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.crousel.fields.description')" wide>
        {{ $crousel->description }}
    </x-admin.detail-field>
@endsection

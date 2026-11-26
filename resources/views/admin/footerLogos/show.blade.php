@extends('layouts.admin-show', ['resource' => 'footerLogo', 'listRoute' => 'admin.footer-logos.index', 'record' => $footerLogo, 'recordTitle' => $footerLogo->title])

@section('content')
    <x-admin.detail-field :label="trans('cruds.footerLogo.fields.id')">
        {{ $footerLogo->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.footerLogo.fields.title')">
        {{ $footerLogo->title }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.footerLogo.fields.upload_image')" wide>
        <x-admin.detail-image :media="$footerLogo->upload_image" :label="trans('cruds.footerLogo.fields.upload_image')" />
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.footerLogo.fields.description')" wide>
        {{ $footerLogo->description }}
    </x-admin.detail-field>
@endsection

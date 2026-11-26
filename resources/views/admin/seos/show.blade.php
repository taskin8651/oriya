@extends('layouts.admin-show', ['resource' => 'seo', 'listRoute' => 'admin.seos.index', 'record' => $seo, 'recordTitle' => $seo->seo_title])

@section('content')
    <x-admin.detail-field :label="trans('cruds.seo.fields.id')">
        {{ $seo->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.seo.fields.meta_tags')" wide>
        {{ $seo->meta_tags }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.seo.fields.keywords')">
        {{ $seo->keywords }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.seo.fields.social_share_image')" wide>
        <x-admin.detail-image :media="$seo->social_share_image" :label="trans('cruds.seo.fields.social_share_image')" />
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.seo.fields.description')" wide>
        {{ $seo->description }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.seo.fields.seo_title')">
        {{ $seo->seo_title }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.seo.fields.og_type')">
        {{ $seo->og_type }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.seo.fields.canonical_url')">
        {{ $seo->canonical_url }}
    </x-admin.detail-field>
@endsection

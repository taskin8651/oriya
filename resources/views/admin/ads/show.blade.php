@extends('layouts.admin-show', ['resource' => 'ad', 'listRoute' => 'admin.ads.index', 'record' => $ad])

@section('content')
    <x-admin.detail-field :label="trans('cruds.ad.fields.id')">
        {{ $ad->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.ad.fields.banner')" wide>
        <x-admin.detail-image :media="$ad->banner" :label="trans('cruds.ad.fields.banner')" />
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.ad.fields.link')">
        {{ $ad->link }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.ad.fields.type')">
        {{ App\Models\Ad::TYPE_SELECT[$ad->type] ?? '' }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.ad.fields.start_date')">
        {{ $ad->start_date }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.ad.fields.end_date')">
        {{ $ad->end_date }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.ad.fields.status')">
        @if(isset(App\Models\Ad::STATUS_SELECT[$ad->status]))
            <span class="detail-status" data-status="{{ $ad->status }}">{{ App\Models\Ad::STATUS_SELECT[$ad->status] }}</span>
        @endif
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.ad.fields.impressions')">
        {{ $ad->impressions }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.ad.fields.clicks')">
        {{ $ad->clicks }}
    </x-admin.detail-field>
@endsection

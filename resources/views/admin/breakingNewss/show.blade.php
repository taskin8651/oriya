@extends('layouts.admin-show', ['resource' => 'breakingNews', 'listRoute' => 'admin.breaking-newss.index', 'record' => $breakingNews, 'recordTitle' => $breakingNews->title])

@section('content')
    <x-admin.detail-field :label="trans('cruds.breakingNews.fields.id')">
        {{ $breakingNews->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.breakingNews.fields.title')">
        {{ $breakingNews->title }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.breakingNews.fields.status')">
        @if(isset(App\Models\BreakingNews::STATUS_SELECT[$breakingNews->status]))
            <span class="detail-status" data-status="{{ $breakingNews->status }}">{{ App\Models\BreakingNews::STATUS_SELECT[$breakingNews->status] }}</span>
        @endif
    </x-admin.detail-field>
@endsection

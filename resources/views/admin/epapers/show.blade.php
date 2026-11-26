@extends('layouts.admin-show', ['resource' => 'epaper', 'listRoute' => 'admin.epapers.index', 'record' => $epaper, 'recordTitle' => $epaper->title])

@section('content')
    <x-admin.detail-field :label="trans('cruds.epaper.fields.id')">
        {{ $epaper->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.epaper.fields.title')">
        {{ $epaper->title }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.epaper.fields.description')" wide>
        {{ $epaper->description }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.epaper.fields.publication_date')">
        {{ $epaper->publication_date }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.epaper.fields.pdf_file')">
        @if($epaper->pdf_file)
            <a href="{{ $epaper->pdf_file->getUrl() }}" class="detail-file" target="_blank" rel="noopener">
                <i class="far fa-file" aria-hidden="true"></i> {{ trans('global.view_file') }}
            </a>
        @endif
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.epaper.fields.cover_image')" wide>
        <x-admin.detail-image :media="$epaper->cover_image" :label="trans('cruds.epaper.fields.cover_image')" />
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.epaper.fields.edition')">
        {{ $epaper->edition }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.epaper.fields.url')">
        {{ $epaper->url }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.epaper.fields.status')">
        @if(isset(App\Models\Epaper::STATUS_SELECT[$epaper->status]))
            <span class="detail-status" data-status="{{ $epaper->status }}">{{ App\Models\Epaper::STATUS_SELECT[$epaper->status] }}</span>
        @endif
    </x-admin.detail-field>
@endsection

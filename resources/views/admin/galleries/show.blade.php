@extends('layouts.admin-show', ['resource' => 'gallery', 'listRoute' => 'admin.galleries.index', 'record' => $gallery, 'recordTitle' => App\Models\Gallery::TITLE_SELECT[$gallery->title] ?? null])

@section('content')
    <x-admin.detail-field :label="trans('cruds.gallery.fields.id')">
        {{ $gallery->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.gallery.fields.title')">
        {{ App\Models\Gallery::TITLE_SELECT[$gallery->title] ?? '' }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.gallery.fields.description')" wide prose>
        {!! $gallery->description !!}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.gallery.fields.upload_file')">
        @if($gallery->upload_file)
            <a href="{{ $gallery->upload_file->getUrl() }}" class="detail-file" target="_blank" rel="noopener">
                <i class="far fa-file" aria-hidden="true"></i> {{ trans('global.view_file') }}
            </a>
        @endif
    </x-admin.detail-field>
@endsection

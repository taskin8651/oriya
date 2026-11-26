@extends('layouts.admin-show', ['resource' => 'tag', 'listRoute' => 'admin.tags.index', 'record' => $tag, 'recordTitle' => $tag->name])

@section('content')
    <x-admin.detail-field :label="trans('cruds.tag.fields.id')">
        {{ $tag->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.tag.fields.name')">
        {{ $tag->name }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.tag.fields.slug')">
        {{ $tag->slug }}
    </x-admin.detail-field>
@endsection

@extends('layouts.admin-show', ['resource' => 'category', 'listRoute' => 'admin.categories.index', 'record' => $category, 'recordTitle' => $category->name])

@section('content')
    <x-admin.detail-field :label="trans('cruds.category.fields.id')">
        {{ $category->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.category.fields.name')">
        {{ $category->name }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.category.fields.slug')">
        {{ $category->slug }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.category.fields.description')" wide>
        {{ $category->description }}
    </x-admin.detail-field>
@endsection

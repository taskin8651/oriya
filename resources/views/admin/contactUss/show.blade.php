@extends('layouts.admin-show', ['resource' => 'contactUs', 'listRoute' => 'admin.contact-uss.index', 'record' => $contactUs, 'recordTitle' => $contactUs->name])

@section('content')
    <x-admin.detail-field :label="trans('cruds.contactUs.fields.id')">
        {{ $contactUs->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.contactUs.fields.name')">
        {{ $contactUs->name }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.contactUs.fields.email')">
        {{ $contactUs->email }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.contactUs.fields.number')">
        {{ $contactUs->number }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.contactUs.fields.degination')">
        {{ $contactUs->degination }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.contactUs.fields.message')" wide prose>
        {!! $contactUs->message !!}
    </x-admin.detail-field>
@endsection

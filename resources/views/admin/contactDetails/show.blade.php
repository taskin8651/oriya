@extends('layouts.admin-show', ['resource' => 'contactDetail', 'listRoute' => 'admin.contact-details.index', 'record' => $contactDetail])

@section('content')
    <x-admin.detail-field :label="trans('cruds.contactDetail.fields.id')">
        {{ $contactDetail->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.contactDetail.fields.number')">
        {{ $contactDetail->number }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.contactDetail.fields.email')">
        {{ $contactDetail->email }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.contactDetail.fields.address')" wide>
        {{ $contactDetail->address }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.contactDetail.fields.location_url')">
        {{ $contactDetail->location_url }}
    </x-admin.detail-field>
@endsection

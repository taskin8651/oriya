@extends('layouts.admin-show', ['resource' => 'newsletter', 'listRoute' => 'admin.newsletters.index', 'record' => $newsletter, 'recordTitle' => $newsletter->email])

@section('content')
    <x-admin.detail-field :label="trans('cruds.newsletter.fields.id')">
        {{ $newsletter->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.newsletter.fields.email')">
        {{ $newsletter->email }}
    </x-admin.detail-field>
@endsection

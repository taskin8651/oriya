@extends('layouts.admin-show', ['resource' => 'auditLog', 'listRoute' => 'admin.audit-logs.index', 'record' => $auditLog])

@section('content')
    <x-admin.detail-field :label="trans('cruds.auditLog.fields.id')">
        {{ $auditLog->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.auditLog.fields.description')" wide>
        {{ $auditLog->description }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.auditLog.fields.subject_id')">
        {{ $auditLog->subject_id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.auditLog.fields.subject_type')">
        {{ $auditLog->subject_type }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.auditLog.fields.user_id')">
        {{ $auditLog->user_id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.auditLog.fields.properties')" wide>
        @if($auditLog->properties?->isNotEmpty())
            <pre class="detail-json">{{ $auditLog->properties->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        @endif
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.auditLog.fields.host')">
        {{ $auditLog->host }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.auditLog.fields.created_at')">
        {{ $auditLog->created_at }}
    </x-admin.detail-field>
@endsection

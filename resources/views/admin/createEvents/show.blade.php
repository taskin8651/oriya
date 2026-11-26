@extends('layouts.admin-show', ['resource' => 'createEvent', 'listRoute' => 'admin.create-events.index', 'record' => $createEvent, 'recordTitle' => $createEvent->title])

@section('content')
    <x-admin.detail-field :label="trans('cruds.createEvent.fields.id')">
        {{ $createEvent->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.createEvent.fields.venue')">
        {{ $createEvent->venue->name ?? '' }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.createEvent.fields.title')">
        {{ $createEvent->title }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.createEvent.fields.poster')" wide>
        <x-admin.detail-image :media="$createEvent->poster" :label="trans('cruds.createEvent.fields.poster')" />
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.createEvent.fields.description')" wide prose>
        {!! $createEvent->description !!}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.createEvent.fields.duration')">
        {{ $createEvent->duration }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.createEvent.fields.language')">
        {{ $createEvent->language }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.createEvent.fields.age')">
        {{ $createEvent->age }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.createEvent.fields.status')">
        @if(isset(App\Models\CreateEvent::STATUS_SELECT[$createEvent->status]))
            <span class="detail-status" data-status="{{ $createEvent->status }}">{{ App\Models\CreateEvent::STATUS_SELECT[$createEvent->status] }}</span>
        @endif
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.createEvent.fields.seat')">
        {{ $createEvent->seat->name ?? '' }}
    </x-admin.detail-field>
@endsection

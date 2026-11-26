@extends('layouts.admin-show', ['resource' => 'venue', 'listRoute' => 'admin.venues.index', 'record' => $venue, 'recordTitle' => $venue->name])

@section('content')
    <x-admin.detail-field :label="trans('cruds.venue.fields.id')">
        {{ $venue->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.venue.fields.name')">
        {{ $venue->name }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.venue.fields.address')" wide>
        {{ $venue->address }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.venue.fields.city')">
        {{ $venue->city }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.venue.fields.state')">
        {{ $venue->state }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.venue.fields.pincode')">
        {{ $venue->pincode }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.venue.fields.status')">
        @if(isset(App\Models\Venue::STATUS_SELECT[$venue->status]))
            <span class="detail-status" data-status="{{ $venue->status }}">{{ App\Models\Venue::STATUS_SELECT[$venue->status] }}</span>
        @endif
    </x-admin.detail-field>
@endsection

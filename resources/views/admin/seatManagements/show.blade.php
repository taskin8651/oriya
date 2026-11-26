@extends('layouts.admin-show', ['resource' => 'seatManagement', 'listRoute' => 'admin.seat-managements.index', 'record' => $seatManagement, 'recordTitle' => $seatManagement->name])

@section('content')
    <x-admin.detail-field :label="trans('cruds.seatManagement.fields.id')">
        {{ $seatManagement->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.seatManagement.fields.venue')">
        {{ $seatManagement->venue->name ?? '' }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.seatManagement.fields.name')">
        {{ $seatManagement->name }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.seatManagement.fields.rows')">
        {{ $seatManagement->rows }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.seatManagement.fields.columns')">
        {{ $seatManagement->columns }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.seatManagement.fields.status')">
        @if(isset(App\Models\SeatManagement::STATUS_SELECT[$seatManagement->status]))
            <span class="detail-status" data-status="{{ $seatManagement->status }}">{{ App\Models\SeatManagement::STATUS_SELECT[$seatManagement->status] }}</span>
        @endif
    </x-admin.detail-field>
@endsection

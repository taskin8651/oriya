@extends('layouts.admin-show', ['resource' => 'bookinSeat', 'listRoute' => 'admin.bookin-seats.index', 'record' => $bookinSeat])

@section('content')
    <x-admin.detail-field :label="trans('cruds.bookinSeat.fields.id')">
        {{ $bookinSeat->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.bookinSeat.fields.hall')">
        {{ $bookinSeat->hall->name ?? '' }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.bookinSeat.fields.user')">
        {{ $bookinSeat->user->name ?? '' }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.bookinSeat.fields.seat_code')">
        {{ $bookinSeat->seat_code }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.bookinSeat.fields.row')">
        {{ $bookinSeat->row }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.bookinSeat.fields.column')">
        {{ $bookinSeat->column }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.bookinSeat.fields.price')">
        {{ $bookinSeat->price }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.bookinSeat.fields.status')">
        @if(isset(App\Models\BookinSeat::STATUS_SELECT[$bookinSeat->status]))
            <span class="detail-status" data-status="{{ $bookinSeat->status }}">{{ App\Models\BookinSeat::STATUS_SELECT[$bookinSeat->status] }}</span>
        @endif
    </x-admin.detail-field>
@endsection

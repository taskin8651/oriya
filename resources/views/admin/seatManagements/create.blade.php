@extends('layouts.admin')

@php
    $listRoute = 'admin.seat-managements.index';
    $adminForm = [
        'title' => trans('global.create') . ' ' . trans('cruds.seatManagement.title_singular'),
        'listLabel' => trans('cruds.seatManagement.title'),
        'listRoute' => $listRoute,
        'listUrl' => Gate::allows('seat_management_access') ? route($listRoute) : null,
    ];
@endphp

@section('content')
        <form class="admin-record-form" method="POST" action="{{ route("admin.seat-managements.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="venue_id">{{ trans('cruds.seatManagement.fields.venue') }}</label>
                <select class="form-control select2 {{ $errors->has('venue') ? 'is-invalid' : '' }}" name="venue_id" id="venue_id">
                    @foreach($venues as $id => $entry)
                        <option value="{{ $id }}" {{ old('venue_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('venue'))
                    <div class="invalid-feedback">
                        {{ $errors->first('venue') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seatManagement.fields.venue_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('cruds.seatManagement.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seatManagement.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rows">{{ trans('cruds.seatManagement.fields.rows') }}</label>
                <input class="form-control {{ $errors->has('rows') ? 'is-invalid' : '' }}" type="text" name="rows" id="rows" value="{{ old('rows', '') }}">
                @if($errors->has('rows'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rows') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seatManagement.fields.rows_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="columns">{{ trans('cruds.seatManagement.fields.columns') }}</label>
                <input class="form-control {{ $errors->has('columns') ? 'is-invalid' : '' }}" type="text" name="columns" id="columns" value="{{ old('columns', '') }}">
                @if($errors->has('columns'))
                    <div class="invalid-feedback">
                        {{ $errors->first('columns') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seatManagement.fields.columns_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status">{{ trans('cruds.seatManagement.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\SeatManagement::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seatManagement.fields.status_helper') }}</span>
            </div>
            @include('partials.admin-form-actions')
        </form>
@endsection
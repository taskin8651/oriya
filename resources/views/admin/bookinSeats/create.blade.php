@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.bookinSeat.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bookin-seats.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="hall_id">{{ trans('cruds.bookinSeat.fields.hall') }}</label>
                <select class="form-control select2 {{ $errors->has('hall') ? 'is-invalid' : '' }}" name="hall_id" id="hall_id">
                    @foreach($halls as $id => $entry)
                        <option value="{{ $id }}" {{ old('hall_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('hall'))
                    <div class="invalid-feedback">
                        {{ $errors->first('hall') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bookinSeat.fields.hall_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.bookinSeat.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bookinSeat.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="seat_code">{{ trans('cruds.bookinSeat.fields.seat_code') }}</label>
                <input class="form-control {{ $errors->has('seat_code') ? 'is-invalid' : '' }}" type="text" name="seat_code" id="seat_code" value="{{ old('seat_code', '') }}">
                @if($errors->has('seat_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('seat_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bookinSeat.fields.seat_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="row">{{ trans('cruds.bookinSeat.fields.row') }}</label>
                <input class="form-control {{ $errors->has('row') ? 'is-invalid' : '' }}" type="text" name="row" id="row" value="{{ old('row', '') }}">
                @if($errors->has('row'))
                    <div class="invalid-feedback">
                        {{ $errors->first('row') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bookinSeat.fields.row_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="column">{{ trans('cruds.bookinSeat.fields.column') }}</label>
                <input class="form-control {{ $errors->has('column') ? 'is-invalid' : '' }}" type="text" name="column" id="column" value="{{ old('column', '') }}">
                @if($errors->has('column'))
                    <div class="invalid-feedback">
                        {{ $errors->first('column') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bookinSeat.fields.column_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="price">{{ trans('cruds.bookinSeat.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="text" name="price" id="price" value="{{ old('price', '') }}">
                @if($errors->has('price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bookinSeat.fields.price_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.bookinSeat.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\BookinSeat::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bookinSeat.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
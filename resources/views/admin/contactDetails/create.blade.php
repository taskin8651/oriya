@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.contactDetail.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.contact-details.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="number">{{ trans('cruds.contactDetail.fields.number') }}</label>
                <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="text" name="number" id="number" value="{{ old('number', '') }}">
                @if($errors->has('number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contactDetail.fields.number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.contactDetail.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', '') }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contactDetail.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.contactDetail.fields.address') }}</label>
                <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" id="address">{{ old('address') }}</textarea>
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contactDetail.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="location_url">{{ trans('cruds.contactDetail.fields.location_url') }}</label>
                <textarea class="form-control {{ $errors->has('location_url') ? 'is-invalid' : '' }}" name="location_url" id="location_url">{{ old('location_url') }}</textarea>
                @if($errors->has('location_url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('location_url') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contactDetail.fields.location_url_helper') }}</span>
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
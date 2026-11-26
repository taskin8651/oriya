@extends('layouts.admin')

@php
    $listRoute = 'admin.newsletters.index';
    $adminForm = [
        'title' => trans('global.edit') . ' ' . trans('cruds.newsletter.title_singular'),
        'listLabel' => trans('cruds.newsletter.title'),
        'listRoute' => $listRoute,
        'listUrl' => Gate::allows('newsletter_access') ? route($listRoute) : null,
    ];
@endphp

@section('content')
        <form class="admin-record-form" method="POST" action="{{ route("admin.newsletters.update", [$newsletter->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="email">{{ trans('cruds.newsletter.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', $newsletter->email) }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.newsletter.fields.email_helper') }}</span>
            </div>
            @include('partials.admin-form-actions')
        </form>
@endsection
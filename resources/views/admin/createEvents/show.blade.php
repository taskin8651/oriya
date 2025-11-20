@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.createEvent.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.create-events.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.createEvent.fields.id') }}
                        </th>
                        <td>
                            {{ $createEvent->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.createEvent.fields.venue') }}
                        </th>
                        <td>
                            {{ $createEvent->venue->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.createEvent.fields.title') }}
                        </th>
                        <td>
                            {{ $createEvent->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.createEvent.fields.poster') }}
                        </th>
                        <td>
                            @if($createEvent->poster)
                                <a href="{{ $createEvent->poster->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $createEvent->poster->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.createEvent.fields.description') }}
                        </th>
                        <td>
                            {!! $createEvent->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.createEvent.fields.duration') }}
                        </th>
                        <td>
                            {{ $createEvent->duration }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.createEvent.fields.language') }}
                        </th>
                        <td>
                            {{ $createEvent->language }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.createEvent.fields.age') }}
                        </th>
                        <td>
                            {{ $createEvent->age }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.createEvent.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\CreateEvent::STATUS_SELECT[$createEvent->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.createEvent.fields.seat') }}
                        </th>
                        <td>
                            {{ $createEvent->seat->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.create-events.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
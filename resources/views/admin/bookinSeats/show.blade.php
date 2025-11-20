@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.bookinSeat.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.bookin-seats.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.bookinSeat.fields.id') }}
                        </th>
                        <td>
                            {{ $bookinSeat->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bookinSeat.fields.hall') }}
                        </th>
                        <td>
                            {{ $bookinSeat->hall->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bookinSeat.fields.user') }}
                        </th>
                        <td>
                            {{ $bookinSeat->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bookinSeat.fields.seat_code') }}
                        </th>
                        <td>
                            {{ $bookinSeat->seat_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bookinSeat.fields.row') }}
                        </th>
                        <td>
                            {{ $bookinSeat->row }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bookinSeat.fields.column') }}
                        </th>
                        <td>
                            {{ $bookinSeat->column }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bookinSeat.fields.price') }}
                        </th>
                        <td>
                            {{ $bookinSeat->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bookinSeat.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\BookinSeat::STATUS_SELECT[$bookinSeat->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.bookin-seats.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
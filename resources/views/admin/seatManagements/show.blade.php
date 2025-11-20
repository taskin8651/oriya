@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.seatManagement.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.seat-managements.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.seatManagement.fields.id') }}
                        </th>
                        <td>
                            {{ $seatManagement->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seatManagement.fields.venue') }}
                        </th>
                        <td>
                            {{ $seatManagement->venue->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seatManagement.fields.name') }}
                        </th>
                        <td>
                            {{ $seatManagement->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seatManagement.fields.rows') }}
                        </th>
                        <td>
                            {{ $seatManagement->rows }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seatManagement.fields.columns') }}
                        </th>
                        <td>
                            {{ $seatManagement->columns }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seatManagement.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\SeatManagement::STATUS_SELECT[$seatManagement->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.seat-managements.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
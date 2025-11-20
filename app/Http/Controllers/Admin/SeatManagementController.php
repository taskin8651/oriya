<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySeatManagementRequest;
use App\Http\Requests\StoreSeatManagementRequest;
use App\Http\Requests\UpdateSeatManagementRequest;
use App\Models\SeatManagement;
use App\Models\Venue;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeatManagementController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('seat_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seatManagements = SeatManagement::with(['venue'])->get();

        return view('admin.seatManagements.index', compact('seatManagements'));
    }

    public function create()
    {
        abort_if(Gate::denies('seat_management_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $venues = Venue::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.seatManagements.create', compact('venues'));
    }

    public function store(StoreSeatManagementRequest $request)
    {
        $seatManagement = SeatManagement::create($request->all());

        return redirect()->route('admin.seat-managements.index');
    }

    public function edit(SeatManagement $seatManagement)
    {
        abort_if(Gate::denies('seat_management_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $venues = Venue::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $seatManagement->load('venue');

        return view('admin.seatManagements.edit', compact('seatManagement', 'venues'));
    }

    public function update(UpdateSeatManagementRequest $request, SeatManagement $seatManagement)
    {
        $seatManagement->update($request->all());

        return redirect()->route('admin.seat-managements.index');
    }

    public function show(SeatManagement $seatManagement)
    {
        abort_if(Gate::denies('seat_management_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seatManagement->load('venue');

        return view('admin.seatManagements.show', compact('seatManagement'));
    }

    public function destroy(SeatManagement $seatManagement)
    {
        abort_if(Gate::denies('seat_management_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seatManagement->delete();

        return back();
    }

    public function massDestroy(MassDestroySeatManagementRequest $request)
    {
        $seatManagements = SeatManagement::find(request('ids'));

        foreach ($seatManagements as $seatManagement) {
            $seatManagement->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

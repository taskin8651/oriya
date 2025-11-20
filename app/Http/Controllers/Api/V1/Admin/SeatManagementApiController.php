<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSeatManagementRequest;
use App\Http\Requests\UpdateSeatManagementRequest;
use App\Http\Resources\Admin\SeatManagementResource;
use App\Models\SeatManagement;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeatManagementApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('seat_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SeatManagementResource(SeatManagement::with(['venue'])->get());
    }

    public function store(StoreSeatManagementRequest $request)
    {
        $seatManagement = SeatManagement::create($request->all());

        return (new SeatManagementResource($seatManagement))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SeatManagement $seatManagement)
    {
        abort_if(Gate::denies('seat_management_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SeatManagementResource($seatManagement->load(['venue']));
    }

    public function update(UpdateSeatManagementRequest $request, SeatManagement $seatManagement)
    {
        $seatManagement->update($request->all());

        return (new SeatManagementResource($seatManagement))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SeatManagement $seatManagement)
    {
        abort_if(Gate::denies('seat_management_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seatManagement->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

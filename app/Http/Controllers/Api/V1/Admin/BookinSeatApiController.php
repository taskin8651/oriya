<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookinSeatRequest;
use App\Http\Requests\UpdateBookinSeatRequest;
use App\Http\Resources\Admin\BookinSeatResource;
use App\Models\BookinSeat;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookinSeatApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('bookin_seat_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BookinSeatResource(BookinSeat::with(['hall', 'user'])->get());
    }

    public function store(StoreBookinSeatRequest $request)
    {
        $bookinSeat = BookinSeat::create($request->all());

        return (new BookinSeatResource($bookinSeat))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(BookinSeat $bookinSeat)
    {
        abort_if(Gate::denies('bookin_seat_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BookinSeatResource($bookinSeat->load(['hall', 'user']));
    }

    public function update(UpdateBookinSeatRequest $request, BookinSeat $bookinSeat)
    {
        $bookinSeat->update($request->all());

        return (new BookinSeatResource($bookinSeat))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(BookinSeat $bookinSeat)
    {
        abort_if(Gate::denies('bookin_seat_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookinSeat->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

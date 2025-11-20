<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBookinSeatRequest;
use App\Http\Requests\StoreBookinSeatRequest;
use App\Http\Requests\UpdateBookinSeatRequest;
use App\Models\BookinSeat;
use App\Models\User;
use App\Models\Venue;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookinSeatController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('bookin_seat_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookinSeats = BookinSeat::with(['hall', 'user'])->get();

        return view('admin.bookinSeats.index', compact('bookinSeats'));
    }

    public function create()
    {
        abort_if(Gate::denies('bookin_seat_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $halls = Venue::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.bookinSeats.create', compact('halls', 'users'));
    }

    public function store(StoreBookinSeatRequest $request)
    {
        $bookinSeat = BookinSeat::create($request->all());

        return redirect()->route('admin.bookin-seats.index');
    }

    public function edit(BookinSeat $bookinSeat)
    {
        abort_if(Gate::denies('bookin_seat_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $halls = Venue::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $bookinSeat->load('hall', 'user');

        return view('admin.bookinSeats.edit', compact('bookinSeat', 'halls', 'users'));
    }

    public function update(UpdateBookinSeatRequest $request, BookinSeat $bookinSeat)
    {
        $bookinSeat->update($request->all());

        return redirect()->route('admin.bookin-seats.index');
    }

    public function show(BookinSeat $bookinSeat)
    {
        abort_if(Gate::denies('bookin_seat_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookinSeat->load('hall', 'user');

        return view('admin.bookinSeats.show', compact('bookinSeat'));
    }

    public function destroy(BookinSeat $bookinSeat)
    {
        abort_if(Gate::denies('bookin_seat_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookinSeat->delete();

        return back();
    }

    public function massDestroy(MassDestroyBookinSeatRequest $request)
    {
        $bookinSeats = BookinSeat::find(request('ids'));

        foreach ($bookinSeats as $bookinSeat) {
            $bookinSeat->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

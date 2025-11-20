<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCreateEventRequest;
use App\Http\Requests\StoreCreateEventRequest;
use App\Http\Requests\UpdateCreateEventRequest;
use App\Models\CreateEvent;
use App\Models\SeatManagement;
use App\Models\Venue;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class CreateEventController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('create_event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $createEvents = CreateEvent::with(['venue', 'seat', 'media'])->get();

        return view('admin.createEvents.index', compact('createEvents'));
    }

    public function create()
    {
        abort_if(Gate::denies('create_event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $venues = Venue::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $seats = SeatManagement::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.createEvents.create', compact('seats', 'venues'));
    }

    public function store(StoreCreateEventRequest $request)
    {
        $createEvent = CreateEvent::create($request->all());

        if ($request->input('poster', false)) {
            $createEvent->addMedia(storage_path('tmp/uploads/' . basename($request->input('poster'))))->toMediaCollection('poster');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $createEvent->id]);
        }

        return redirect()->route('admin.create-events.index');
    }

    public function edit(CreateEvent $createEvent)
    {
        abort_if(Gate::denies('create_event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $venues = Venue::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $seats = SeatManagement::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $createEvent->load('venue', 'seat');

        return view('admin.createEvents.edit', compact('createEvent', 'seats', 'venues'));
    }

    public function update(UpdateCreateEventRequest $request, CreateEvent $createEvent)
    {
        $createEvent->update($request->all());

        if ($request->input('poster', false)) {
            if (! $createEvent->poster || $request->input('poster') !== $createEvent->poster->file_name) {
                if ($createEvent->poster) {
                    $createEvent->poster->delete();
                }
                $createEvent->addMedia(storage_path('tmp/uploads/' . basename($request->input('poster'))))->toMediaCollection('poster');
            }
        } elseif ($createEvent->poster) {
            $createEvent->poster->delete();
        }

        return redirect()->route('admin.create-events.index');
    }

    public function show(CreateEvent $createEvent)
    {
        abort_if(Gate::denies('create_event_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $createEvent->load('venue', 'seat');

        return view('admin.createEvents.show', compact('createEvent'));
    }

    public function destroy(CreateEvent $createEvent)
    {
        abort_if(Gate::denies('create_event_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $createEvent->delete();

        return back();
    }

    public function massDestroy(MassDestroyCreateEventRequest $request)
    {
        $createEvents = CreateEvent::find(request('ids'));

        foreach ($createEvents as $createEvent) {
            $createEvent->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('create_event_create') && Gate::denies('create_event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CreateEvent();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}

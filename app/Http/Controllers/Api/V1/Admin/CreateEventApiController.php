<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCreateEventRequest;
use App\Http\Requests\UpdateCreateEventRequest;
use App\Http\Resources\Admin\CreateEventResource;
use App\Models\CreateEvent;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateEventApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('create_event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CreateEventResource(CreateEvent::with(['venue', 'seat'])->get());
    }

    public function store(StoreCreateEventRequest $request)
    {
        $createEvent = CreateEvent::create($request->all());

        if ($request->input('poster', false)) {
            $createEvent->addMedia(storage_path('tmp/uploads/' . basename($request->input('poster'))))->toMediaCollection('poster');
        }

        return (new CreateEventResource($createEvent))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CreateEvent $createEvent)
    {
        abort_if(Gate::denies('create_event_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CreateEventResource($createEvent->load(['venue', 'seat']));
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

        return (new CreateEventResource($createEvent))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CreateEvent $createEvent)
    {
        abort_if(Gate::denies('create_event_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $createEvent->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreHeaderLogoRequest;
use App\Http\Requests\UpdateHeaderLogoRequest;
use App\Http\Resources\Admin\HeaderLogoResource;
use App\Models\HeaderLogo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HeaderLogoApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('header_logo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new HeaderLogoResource(HeaderLogo::all());
    }

    public function store(StoreHeaderLogoRequest $request)
    {
        $headerLogo = HeaderLogo::create($request->all());

        if ($request->input('upload_image', false)) {
            $headerLogo->addMedia(storage_path('tmp/uploads/' . basename($request->input('upload_image'))))->toMediaCollection('upload_image');
        }

        return (new HeaderLogoResource($headerLogo))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(HeaderLogo $headerLogo)
    {
        abort_if(Gate::denies('header_logo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new HeaderLogoResource($headerLogo);
    }

    public function update(UpdateHeaderLogoRequest $request, HeaderLogo $headerLogo)
    {
        $headerLogo->update($request->all());

        if ($request->input('upload_image', false)) {
            if (! $headerLogo->upload_image || $request->input('upload_image') !== $headerLogo->upload_image->file_name) {
                if ($headerLogo->upload_image) {
                    $headerLogo->upload_image->delete();
                }
                $headerLogo->addMedia(storage_path('tmp/uploads/' . basename($request->input('upload_image'))))->toMediaCollection('upload_image');
            }
        } elseif ($headerLogo->upload_image) {
            $headerLogo->upload_image->delete();
        }

        return (new HeaderLogoResource($headerLogo))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(HeaderLogo $headerLogo)
    {
        abort_if(Gate::denies('header_logo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $headerLogo->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

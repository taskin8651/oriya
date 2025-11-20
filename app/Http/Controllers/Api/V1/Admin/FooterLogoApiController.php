<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreFooterLogoRequest;
use App\Http\Requests\UpdateFooterLogoRequest;
use App\Http\Resources\Admin\FooterLogoResource;
use App\Models\FooterLogo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FooterLogoApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('footer_logo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FooterLogoResource(FooterLogo::all());
    }

    public function store(StoreFooterLogoRequest $request)
    {
        $footerLogo = FooterLogo::create($request->all());

        if ($request->input('upload_image', false)) {
            $footerLogo->addMedia(storage_path('tmp/uploads/' . basename($request->input('upload_image'))))->toMediaCollection('upload_image');
        }

        return (new FooterLogoResource($footerLogo))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(FooterLogo $footerLogo)
    {
        abort_if(Gate::denies('footer_logo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FooterLogoResource($footerLogo);
    }

    public function update(UpdateFooterLogoRequest $request, FooterLogo $footerLogo)
    {
        $footerLogo->update($request->all());

        if ($request->input('upload_image', false)) {
            if (! $footerLogo->upload_image || $request->input('upload_image') !== $footerLogo->upload_image->file_name) {
                if ($footerLogo->upload_image) {
                    $footerLogo->upload_image->delete();
                }
                $footerLogo->addMedia(storage_path('tmp/uploads/' . basename($request->input('upload_image'))))->toMediaCollection('upload_image');
            }
        } elseif ($footerLogo->upload_image) {
            $footerLogo->upload_image->delete();
        }

        return (new FooterLogoResource($footerLogo))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(FooterLogo $footerLogo)
    {
        abort_if(Gate::denies('footer_logo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $footerLogo->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

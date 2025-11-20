<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreSeoRequest;
use App\Http\Requests\UpdateSeoRequest;
use App\Http\Resources\Admin\SeoResource;
use App\Models\Seo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeoApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('seo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SeoResource(Seo::all());
    }

    public function store(StoreSeoRequest $request)
    {
        $seo = Seo::create($request->all());

        if ($request->input('social_share_image', false)) {
            $seo->addMedia(storage_path('tmp/uploads/' . basename($request->input('social_share_image'))))->toMediaCollection('social_share_image');
        }

        return (new SeoResource($seo))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Seo $seo)
    {
        abort_if(Gate::denies('seo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SeoResource($seo);
    }

    public function update(UpdateSeoRequest $request, Seo $seo)
    {
        $seo->update($request->all());

        if ($request->input('social_share_image', false)) {
            if (! $seo->social_share_image || $request->input('social_share_image') !== $seo->social_share_image->file_name) {
                if ($seo->social_share_image) {
                    $seo->social_share_image->delete();
                }
                $seo->addMedia(storage_path('tmp/uploads/' . basename($request->input('social_share_image'))))->toMediaCollection('social_share_image');
            }
        } elseif ($seo->social_share_image) {
            $seo->social_share_image->delete();
        }

        return (new SeoResource($seo))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Seo $seo)
    {
        abort_if(Gate::denies('seo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seo->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
